<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadAlbum extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Album_model');
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper(['url', 'form']);
		
		if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }
	
    /* ============================================================
       STEP 1 — RELEASE DETAILS
    ============================================================ */
    public function step1()
    {
		if (!$this->session->userdata('user_id')) {
				redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

	
        if ($this->input->post()) {

            $this->form_validation->set_rules('album_title', 'Album Title', 'required');
            $this->form_validation->set_rules('artist', 'Primary Artist', 'required');
            $this->form_validation->set_rules('album_type', 'Album Type', 'required');
            $this->form_validation->set_rules('num_tracks', 'Number of Tracks', 'required|integer');
            $this->form_validation->set_rules('genre', 'Genre', 'required');
            $this->form_validation->set_rules('release_date', 'Release Date', 'required');

            if ($this->form_validation->run()) {

                $step1 = [
                    'user_id'      => $user_id,
                    'album_title'  => $this->input->post('album_title'),
                    'artist'       => $this->input->post('artist'),
                    'featuring'    => $this->input->post('featuring'),
                    'album_type'   => $this->input->post('album_type'),
                    'num_tracks'   => $this->input->post('num_tracks'),
                    'genre'        => $this->input->post('genre'),
                    'subgenre'     => $this->input->post('subgenre'),
                    'release_date' => $this->input->post('release_date'),
                    'language'     => $this->input->post('language'),
                    'upc_code'     => $this->input->post('upc_code'),
                    'label'        => $this->input->post('label'),
                    'description'  => $this->input->post('description'),
                    'explicit'     => $this->input->post('explicit'),
                ];

                $this->session->set_userdata('album_step1', $step1);

                redirect('UploadAlbum/step2');
            }
        }

        $this->load->view('album/step1');
    }

    /* ============================================================
       STEP 2 — STORES & SOCIAL
    ============================================================ */
    public function step2()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        if ($this->input->post()) {

            $step2 = [
                'stores' => $this->input->post('stores') ?? [],
                'social' => $this->input->post('social') ?? [],
            ];

            $this->session->set_userdata('album_step2', $step2);

            redirect('UploadAlbum/step3');
        }

        $this->load->view('album/step2');
    }

    /* ============================================================
       STEP 3 — TRACKS
    ============================================================ */
    public function step3()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        if ($this->input->post()) {

            $num_tracks = $this->session->userdata('album_step1')['num_tracks'];

            $track_data = [];

            for ($i = 0; $i < $num_tracks; $i++) {

                // validate required track titles
                if (empty($_POST['track_title'][$i])) {
                    $this->session->set_flashdata('error', "Track title missing for track #" . ($i + 1));
                    redirect('UploadAlbum/step3');
                }

                // Perform upload if file exists
                $audio_file = null;
                if (!empty($_FILES['audio_file']['name'][$i])) {

                    $_FILES['single_audio']['name']     = $_FILES['audio_file']['name'][$i];
                    $_FILES['single_audio']['type']     = $_FILES['audio_file']['type'][$i];
                    $_FILES['single_audio']['tmp_name'] = $_FILES['audio_file']['tmp_name'][$i];
                    $_FILES['single_audio']['error']    = $_FILES['audio_file']['error'][$i];
                    $_FILES['single_audio']['size']     = $_FILES['audio_file']['size'][$i];

                    $config['upload_path']   = './uploads/audio/';
                    $config['allowed_types'] = 'mp3|wav|flac|ogg';
                    $config['max_size']      = 50000;

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('single_audio')) {
                        $this->session->set_flashdata('upload_error', $this->upload->display_errors());
                        redirect('UploadAlbum/step3');
                    }

                    $audio_file = 'uploads/audio/' . $this->upload->data('file_name');
                }

                $track_data[] = [
                    'track_title' => $_POST['track_title'][$i],
                    'songwriters' => $_POST['songwriters'][$i] ?? [],
                    'artists'     => $_POST['artists'][$i] ?? [],
                    'producers'   => $_POST['producers'][$i] ?? [],
                    'audio_file'  => $audio_file,
                    'is_explicit' => $_POST['is_explicit'][$i] ?? 0
                ];
            }

            $this->session->set_userdata('album_step3', $track_data);

            redirect('UploadAlbum/step4');
        }

        $this->load->view('album/step3');
    }

    /* ============================================================
       STEP 4 — ARTWORK UPLOAD
    ============================================================ */
    public function step4()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        if ($this->input->post()) {

            $config['upload_path']   = './uploads/covers/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 20000;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('cover_art')) {

                $data['upload_error'] = $this->upload->display_errors();
				//echo "<pre>"; print_r($data); die;
                return $this->load->view('album/step4', $data);
            }

            $file = $this->upload->data('file_name');

            $step4 = [
                'cover_art' => 'uploads/covers/' . $file,
                'template'  => $this->input->post('template')
            ];

            $this->session->set_userdata('album_step4', $step4);

            redirect('UploadAlbum/review');
        }

        $this->load->view('album/step4');
    }

    /* ============================================================
       FINAL REVIEW PAGE
    ============================================================ */
    public function review()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        $data['step1'] = $this->session->userdata('album_step1');
        $data['step2'] = $this->session->userdata('album_step2');
        $data['step3'] = $this->session->userdata('album_step3');
        $data['step4'] = $this->session->userdata('album_step4');

        $this->load->view('album/review', $data);
    }

    /* ============================================================
       FINAL SUBMIT — SAVE EVERYTHING TO DATABASE
    ============================================================ */
    public function submit()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        $sessionData = [
            'step1' => $this->session->userdata('album_step1'),
            'step2' => $this->session->userdata('album_step2'),
            'step3' => $this->session->userdata('album_step3'),
            'step4' => $this->session->userdata('album_step4'),
        ];

        // SAFETY CHECK
        if (!$sessionData['step1'] || !$sessionData['step4']) {
            show_error("Session expired. Start again.");
        }

        $album_id = $this->Album_model->persist_album($sessionData);

        if ($album_id) {
            // Clear session after success
            $this->session->unset_userdata('album_step1');
            $this->session->unset_userdata('album_step2');
            $this->session->unset_userdata('album_step3');
            $this->session->unset_userdata('album_step4');

            redirect('UploadAlbum/success/' . $album_id);
        } else {
            show_error("Database insert failed.");
        }
    }

    /* ============================================================
       SUCCESS PAGE
    ============================================================ */
    public function success($album_id)
    {
        $data['album_id'] = $album_id;
        $this->load->view('album/success', $data);
    }

}
