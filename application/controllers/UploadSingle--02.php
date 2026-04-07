<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UploadSingle extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'form']);
		
		if (!$this->session->userdata('user_id')) {
            redirect('login');
        }

        $this->load->model([
            'Release_model',
            'Track_model',
            'Songwriter_model',
            'Artist_model',
            'Producer_model',
            'Store_model',
            'Social_model',
            'Artwork_model'
        ]);
    }
	
	public function list($page = 0)
{
    if (!$this->session->userdata('user_id')) {
        redirect('login');
    }

    $user_id = $this->session->userdata('user_id');

    $this->load->model('ReleaseList_model');
    $this->load->library('pagination');

    /* ---------------------------------
     | COUNT FILTERED SINGLE RELEASES
     --------------------------------- */
    $total_rows = $this->ReleaseList_model->count_filtered_singles($user_id);

    /* ---------------------------------
     | PAGINATION CONFIG
     --------------------------------- */
    $config['base_url'] = site_url('UploadSingle/list');
    $config['total_rows'] = $total_rows;
    $config['per_page'] = 10;
    $config['uri_segment'] = 3;

    // UI styling (Tailwind)
    $config['full_tag_open']  = '<div class="pagination flex justify-center gap-2 mt-6">';
    $config['full_tag_close'] = '</div>';
    $config['num_tag_open']   = '<span class="px-3 py-1 bg-zinc-800 text-gray-300 rounded">';
    $config['num_tag_close']  = '</span>';
    $config['cur_tag_open']   = '<span class="px-3 py-1 bg-primary-custom text-black rounded font-semibold">';
    $config['cur_tag_close']  = '</span>';

    $this->pagination->initialize($config);

    /* ---------------------------------
     | FETCH FILTERED + PAGINATED SINGLES
     --------------------------------- */
    $data['singles'] = $this->ReleaseList_model->get_filtered_singles(
        $user_id,
        $config['per_page'],
        $page
    );

    $data['single_pagination_links'] = $this->pagination->create_links();

    /* ---------------------------------
     | ALBUMS FOR THE SAME VIEW
     | without pagination
     --------------------------------- */
    $data['albums'] = $this->ReleaseList_model->get_filtered_albums(
        $user_id,
        50, 0
    );

    $data['album_pagination_links'] = "";

    /* ---------------------------------
     | LOAD VIEW
     --------------------------------- */
    $this->load->view('layouts/auth_header');
    $this->load->view('music/library', $data);
    $this->load->view('layouts/auth_footer');
}

    // ----------------------------------------------------------
    // STEP 1: RELEASE DETAILS
    // ----------------------------------------------------------
    public function step1()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        if ($_POST) {

            $this->form_validation->set_rules('title', 'Track Title', 'required');
            $this->form_validation->set_rules('primary_artist', 'Primary Artist', 'required');
            $this->form_validation->set_rules('genre', 'Genre', 'required');
            $this->form_validation->set_rules('release_date', 'Release Date', 'required');

            if ($this->form_validation->run()) {

                $data = [
                    'title'            => $this->input->post('title'),
                    'primary_artist'   => $this->input->post('primary_artist'),
                    'featuring'        => $this->input->post('featuring'),
                    'genre'            => $this->input->post('genre'),
                    'subgenre'         => $this->input->post('subgenre'),
                    'release_date'     => $this->input->post('release_date'),
                    'language'         => $this->input->post('language'),
                    'isrc'             => $this->input->post('isrc'),
                    'description'      => $this->input->post('description'),
                    'explicit_content' => $this->input->post('explicit_content'),
                ];

                $this->session->set_userdata('step1', $data);

                redirect('UploadSingle/step2');
            }
        }

        $this->load->view('upload/step1');
    }

    // ----------------------------------------------------------
    // STEP 2: STORES + SOCIAL PLATFORMS
    // ----------------------------------------------------------
    public function step2()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        if ($_POST) {
            $stores  = $this->input->post('stores') ?? [];
            $social  = $this->input->post('social') ?? [];

            $this->session->set_userdata('step2_stores', $stores);
            $this->session->set_userdata('step2_social', $social);

            redirect('UploadSingle/step3');
        }

        $this->load->view('upload/step2');
    }

    // ----------------------------------------------------------
    // STEP 3: TRACK DETAILS + ARTISTS + FILE UPLOAD
    // ----------------------------------------------------------
   public function step3()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

		if ($_POST) {
		//echo "<pre>"; print_r($_POST);
		//echo "<pre>"; print_r($_FILES);
			$this->form_validation->set_rules('song_title', 'Song Title', 'required');
		//   $this->form_validation->set_rules('songwriters', 'Songwriters', 'required');

        if ($this->form_validation->run()) {
			//echo " <br> 1"; die;
            // Upload audio file
            $audio_file = null;
            if (!empty($_FILES['audio_file']['name'])) {

                $config['upload_path']   = './uploads/audio/';
                $config['allowed_types'] = 'mp3|wav|flac|aiff';
                $config['max_size']      = 50000;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('audio_file')) {
                    $audio_file = 'uploads/audio/' . $this->upload->data('file_name');
                } else {
				
									// PRINT upload error clearly
					echo "<pre style='color:red;font-size:16px'>";
					echo "UPLOAD ERROR:\n";
					print_r($this->upload->display_errors());
					echo "</pre>";

					//die; // Stop execution so you can see the error

				}
            }


			//echo $audio_file; //die;
            $track_data = [
                'song_title'   => $this->input->post('song_title'),
                'songwriters'  => $this->input->post('songwriters'),
                'main_artist'  => $this->input->post('main_artist_name'),
                'main_artist_role' => $this->input->post('main_artist_role'),
                'performing_artist' => $this->input->post('performing_artist_name'),
                'performing_artist_role' => $this->input->post('performing_artist_role'),
                'producer_name' => $this->input->post('producer_name'),
                'producer_role' => $this->input->post('producer_role'),
                'copyright' => $this->input->post('copyright'),
                'lyrics' => $this->input->post('lyrics'),
                'tiktok_min' => $this->input->post('tiktok_min'),
                'tiktok_sec' => $this->input->post('tiktok_sec'),
                'audio_file' => $audio_file
            ];

            $this->session->set_userdata('step3', $track_data);
			
			//echo "<pre>"; print_r($track_data);

            return redirect('UploadSingle/step4');
        } else {
		
			echo "validation failed ";
		}
    }

    $this->load->view('upload/step3');
}


    // ----------------------------------------------------------
    // STEP 4: ARTWORK UPLOAD / TEMPLATE SELECT
    // ----------------------------------------------------------
    public function step4()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        if ($_POST) {

            $file_path   = null;
            $template_id = $this->input->post('template_id');

            // Upload artwork file
            if (!empty($_FILES['artwork']['name'])) {

                $config['upload_path']   = './uploads/artwork/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size']      = 10000;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('artwork')) {
                    $file_path = 'uploads/artwork/' . $this->upload->data('file_name');
                }
            }

            $data = [
                'file_path'   => $file_path,
                'template_id' => $template_id
            ];

            $this->session->set_userdata('step4', $data);

            redirect('UploadSingle/submit_final');
        }

        $this->load->view('upload/step4');
    }

    // ----------------------------------------------------------
    // FINAL: SAVE ALL DATA TO DATABASE
    // ----------------------------------------------------------
    public function submit_final()
    {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');

        $step1 = $this->session->userdata('step1');
        $step2_stores = $this->session->userdata('step2_stores');
        $step2_social = $this->session->userdata('step2_social');
        $step3 = $this->session->userdata('step3');
        $step4 = $this->session->userdata('step4');

        if (!$step1 || !$step3) {
            redirect('UploadSingle/step1');
            return;
        }

        // ------------------------------------------------------
        // 1. Create Release
        // ------------------------------------------------------
        $release_id = $this->Release_model->create([
            'user_id'          => $user_id, 
            'title'            => $step1['title'],
            'primary_artist'   => $step1['primary_artist'],
            'featuring'        => $step1['featuring'],
            'genre'            => $step1['genre'],
            'subgenre'         => $step1['subgenre'],
            'release_date'     => $step1['release_date'],
            'language'         => $step1['language'],
            'isrc'             => $step1['isrc'],
            'description'      => $step1['description'],
            'explicit_content' => $step1['explicit_content']
        ]);

        // ------------------------------------------------------
        // 2. Save Track
        // ------------------------------------------------------
		
		//echo "<pre>";
		//print_r($step3);die;
        $track_id = $this->Track_model->create([
            'release_id'     => $release_id,
            'title'          => $step3['song_title'],
            'audio_file'     => $step3['audio_file'],
            'lyrics'         => $step3['lyrics'],
            'lyrics_language'=> @$step3['lyrics_lang'],
            'explicit_lyrics'=> @$step3['explicit_lyrics']
        ]);

        // ------------------------------------------------------
        // 3. Save Songwriters
        // ------------------------------------------------------
        $this->Songwriter_model->insert_batch($track_id, $step3['songwriters']);

        // ------------------------------------------------------
        // 4. Save Artists
        // ------------------------------------------------------
        $this->Artist_model->insert_batch(
            $track_id,
            @$step3['artists'],
            @$step3['artists_role']
        );

        // ------------------------------------------------------
        // 5. Save Producers
        // ------------------------------------------------------
        $this->Producer_model->insert_batch(
            $track_id,
            @$step3['producers'],
            @$step3['producers_role']
        );

        // ------------------------------------------------------
        // 6. Save Stores
        // ------------------------------------------------------
        $this->Store_model->insert_batch($release_id, $step2_stores);

        // ------------------------------------------------------
        // 7. Save Social
        // ------------------------------------------------------
        $this->Social_model->insert_batch($release_id, $step2_social);

        // ------------------------------------------------------
        // 8. Save Artwork
        // ------------------------------------------------------
        $this->Artwork_model->save(
            $release_id,
           @ $step4['file_path'],
            @$step4['template_id']
        );

        // Clear session
        $this->session->unset_userdata([
            'step1', 'step2_stores', 'step2_social', 'step3', 'step4'
        ]);

        // Success Page
        $this->load->view('upload/success', [
            'release_id' => $release_id
        ]);
    }
	
	
	
	public function edit($id)
{
    if (!$this->session->userdata('user_id')) redirect('login');

    $this->load->model('Song_model');

    $song = $this->db->where('id', $id)
                     ->where('user_id', $this->session->userdata('user_id'))
                     ->get('songs')
                     ->row();

    if (!$song) show_404();

    if ($this->input->method() === 'post') {

        $data = [
            'song_title' => $this->input->post('song_title'),
            'genre'      => $this->input->post('genre'),
            'duration'   => $this->input->post('duration')
        ];

        $this->db->where('id', $id)->update('songs', $data);

        $this->session->set_flashdata('success', 'Song updated successfully!');
        redirect('my-songs');
    }

    $data['song'] = $song;

    $this->load->view('layouts/auth_header');
    $this->load->view('songs/edit_single', $data);
    $this->load->view('layouts/auth_footer');
}

public function delete($id)
{
    if (!$this->session->userdata('user_id')) redirect('login');

    $song = $this->db->where('id', $id)
                     ->where('user_id', $this->session->userdata('user_id'))
                     ->get('songs')->row();

    if (!$song) show_404();

    // delete audio file
    if (!empty($song->audio_file) && file_exists(FCPATH . 'uploads/singles/' . $song->audio_file)) {
        unlink(FCPATH . 'uploads/singles/' . $song->audio_file);
    }

    $this->db->where('id', $id)->delete('songs');

    $this->session->set_flashdata('success', 'Track deleted successfully!');
    redirect('my-songs');
}


public function ajaxLoadMore($page = 0)
{
    $user_id = $this->session->userdata('user_id');

    $limit = 10;
    $offset = $page * $limit;

    $songs = $this->db->where('user_id', $user_id)
                      ->order_by('created_at', 'DESC')
                      ->limit($limit, $offset)
                      ->get('songs')
                      ->result();

    $this->load->view('songs/ajax_song_rows', ['songs' => $songs]);
}

}
