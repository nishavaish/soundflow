<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyAlbums extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Album_model');
        $this->load->library(['session', 'pagination']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    /* ============================================================
       ALBUM LISTING PAGE
       URL: my-albums/list
    ============================================================ */
    public function list()
    {
        $user_id = $this->session->userdata('user_id');

        // Filters
        $search = $this->input->get("q");
        $from   = $this->input->get("from");
        $to     = $this->input->get("to");

        // Pagination
        $config['base_url']   = site_url('my-albums/list');
        $config['total_rows'] = $this->Album_model->count_albums($user_id, $search, $from, $to);
        $config['per_page']   = 12;
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $page = ($this->input->get('per_page')) ?? 0;

        // Fetch albums
        $data['albums'] = $this->Album_model->get_albums(
            $user_id,
            $config['per_page'],
            $page,
            $search,
            $from,
            $to
        );

        // Add filters back to view
        $data['filters'] = [
            'q'    => $search,
            'from' => $from,
            'to'   => $to
        ];

        $data['pagination'] = $this->pagination->create_links();

         // echo "<pre>";
        // print_r($data);
        // die();

        // Load listing view
        $this->load->view('album/listing', $data);
    }

    /* ============================================================
       VIEW ALBUM
       URL: my-albums/view/{id}
    ============================================================ */
    public function view($id)
    {
        $album = $this->Album_model->get_album($id);
        if (!$album) show_404();

        // Ensure the album belongs to this user
        if ($album->user_id != $this->session->userdata('user_id')) {
            show_error("Unauthorized access");
        }

        $data['album']  = $album;
        $data['tracks'] = $this->Album_model->get_album_tracks($id);
        $data['stores'] = $this->Album_model->get_album_stores($id);
        $data['social'] = $this->Album_model->get_album_social($id);

        $this->load->view('album/detail', $data);
    }

    /* ============================================================
       DELETE ALBUM (view page uses UploadAlbum/delete)
       But require extra safety here too
    ============================================================ */
    public function delete($id)
    {
        $user_id = $this->session->userdata('user_id');
        $album = $this->Album_model->get_album($id);

        if (!$album || $album->user_id != $user_id) {
            show_404();
        }

        if ($this->Album_model->delete_album($id)) {
            $this->session->set_flashdata('success', 'Album deleted');
        } else {
            $this->session->set_flashdata('error', 'Could not delete album');
        }

        redirect('my-albums/list');
    }

}
