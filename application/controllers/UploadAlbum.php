<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadAlbum extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Album_model');
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
		
		 $this->load->config('streaming_platforms');
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
		
		
		$data['platforms']    = $this->config->item('streaming_platforms');
        $this->load->view('album/step2', $data);
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
		
		$num_tracks = $this->session->userdata('album_step1')['num_tracks'];

		$data['num_tracks'] = $num_tracks;
        $this->load->view('album/step3', $data);
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
       UTILITY — LOAD ALBUM FOR EDIT MODE
    ============================================================ */
    private function load_album_data($album_id)
    {
        $album = $this->Album_model->get_album($album_id);
        $tracks = $this->Album_model->get_album_tracks($album_id);
        $stores = $this->Album_model->get_album_stores($album_id);
        $social = $this->Album_model->get_album_social($album_id);

        if (!$album) show_404();

        return [
            'album'  => $album,
            'tracks' => $tracks,
            'stores' => $stores,
            'social' => $social
        ];
    }

    /* ============================================================
       ENTRY POINT FOR EDIT MODE
       URL: my-albums/edit/step-1/{id}
    ============================================================ */
    public function edit($step, $album_id)
    {
        // Store album_id globally in session for edit mode
        $this->session->set_userdata('edit_album_id', $album_id);
		//echo $album_id; die;
        return redirect("UploadAlbum/edit_step{$step}");
    }


/* ============================================================
   STEP 1 — ALBUM DETAILS (CREATE + EDIT)
============================================================ */
public function edit_step1()
{
     $album_id = $this->session->userdata('edit_album_id');
  
	$editMode = $album_id ? TRUE : FALSE;

    $data = [];

    if ($editMode) {
	
        $album = $this->Album_model->get_album($album_id);
        if (!$album) show_404();
        $data['album'] = $album;
        $data['album_id'] = $album_id;
		// echo  $album_id; die;
	
    }

    if ($this->input->post()) {

        $this->form_validation->set_rules('album_title', 'Album Title', 'required');
        $this->form_validation->set_rules('artist', 'Primary Artist', 'required');

        if ($this->form_validation->run()) {

            $step1 = [
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
            return redirect('UploadAlbum/edit_step2');
        }
    }

    $this->load->view('album/step1', $data);
}

/* ============================================================
   STEP 2 — STORES & SOCIAL (CREATE + EDIT)
============================================================ */
public function edit_step2()
{
    $album_id = $this->session->userdata('edit_album_id');
    $editMode = $album_id ? TRUE : FALSE;

    $data = [];

    if ($editMode) {
        $info = $this->load_album_data($album_id);
        $data['album_id'] = $album_id;
        $data['stores'] = array_column($info['stores'], 'store_name');
        $data['social'] = array_column($info['social'], 'platform');
    }

    if ($this->input->post()) {
        $step2 = [
            'stores' => $this->input->post('stores') ?? [],
            'social' => $this->input->post('social') ?? [],
        ];
        $this->session->set_userdata('album_step2', $step2);
        return redirect('UploadAlbum/edit_step3');
    }

	$data['platforms']    = $this->config->item('streaming_platforms');
    $this->load->view('album/step2', $data);
}

/* ============================================================
   STEP 3 — TRACKS (DRAG + DROP, ADD, DELETE, EDIT)
============================================================ */
public function edit_step3__old()
{
    $album_id = $this->session->userdata('edit_album_id');
    $editMode = $album_id ? TRUE : FALSE;

    $data = [];

    if ($editMode) {
        $info = $this->load_album_data($album_id);
        $data['tracks'] = $info['tracks'];
    }

    if ($this->input->post()) {
		
		//echo "<pre>"; print_r($_FILES); //die;

        $posted_tracks = json_decode($this->input->post('track_data_json'), true);
        $this->session->set_userdata('album_step3', $posted_tracks);
		//echo "<pre>"; print_r($posted_tracks); die;

        return redirect('UploadAlbum/edit_step4');
    }

    $this->load->view('album/step3', $data);
}

public function edit_step3()
{
    $user_id = $this->session->userdata('user_id');
	$album_id = $this->session->userdata('edit_album_id');
    if (!$user_id) return redirect('login');

    // Detect edit mode
    $editMode = $album_id ? true : false;

    $data = [];
    $data['editMode'] = $editMode;
    $data['album_id'] = $album_id;

    /* ============================================================
        EDIT MODE: Load existing tracks 
    ============================================================ */
    if ($editMode) {

        $this->load->model('Album_model');
        $album = $this->Album_model->get_album($album_id);
        if (!$album) show_error("Album not found.");

        $tracks = $this->Album_model->get_album_tracks($album_id);
        $data['tracks'] = $tracks;
        $data['num_tracks'] = count($tracks);

    } 
    /* ============================================================
        CREATE MODE
    ============================================================ */
    else {

        $step1 = $this->session->userdata('album_step1');
        if (!$step1) return redirect('UploadAlbum/step1');

        $data['tracks'] = []; // no existing
        $data['num_tracks'] = $step1['num_tracks'];
    }

	//echo "<pre>"; print_r($data); die;

    /* ============================================================
        FORM SUBMISSION
    ============================================================ */
    if ($this->input->post()) {

        $posted_tracks = json_decode($this->input->post('track_data_json'), true);
        $existing_audio = $this->input->post('existing_audio_file') ?: [];

        if (!is_array($posted_tracks)) {
            show_error("Track metadata missing or corrupted.");
        }

        $finalTracks = [];

        foreach ($posted_tracks as $idx => $meta) {

            $oldAudio = $existing_audio[$idx] ?? null;
            $newAudio = null;

            /* =============================================
               AUDIO HANDLING
            ============================================= */
            if (!empty($_FILES['audio_file']['name'][$idx])) {

                $_FILES['single_audio']['name']     = $_FILES['audio_file']['name'][$idx];
                $_FILES['single_audio']['type']     = $_FILES['audio_file']['type'][$idx];
                $_FILES['single_audio']['tmp_name'] = $_FILES['audio_file']['tmp_name'][$idx];
                $_FILES['single_audio']['error']    = $_FILES['audio_file']['error'][$idx];
                $_FILES['single_audio']['size']     = $_FILES['audio_file']['size'][$idx];

                $config['upload_path']   = './uploads/audio/';
                $config['allowed_types'] = 'mp3|wav|flac|ogg';
                $config['max_size']      = 50000;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('single_audio')) {

                    $file = $this->upload->data('file_name');
                    $newAudio = 'uploads/audio/' . $file;

                    // Delete old audio on replace
                    if ($editMode && $oldAudio && file_exists(FCPATH . $oldAudio)) {
                        @unlink(FCPATH . $oldAudio);
                    }

                } else {
                    $data['upload_error'] = $this->upload->display_errors();
                    return $this->load->view('album/step3', $data);
                }
            } else if (!$editMode) {
                // NEW TRACKS – Audio is required
                $data['upload_error'] = "Audio file is required for all new tracks.";
                return $this->load->view('album/step3', $data);
            }

            /* =============================================
                FINAL TRACK OBJECT
            ============================================= */
            $finalTracks[] = [
                'track_title'  => $meta['track_title'],
                'artists'      => $meta['artists'],
                'songwriters'  => $meta['songwriters'],
                'producers'    => $meta['producers'],
                'is_explicit'  => $meta['is_explicit'],
                'audio_file'   => $newAudio ?: $oldAudio
            ];
        }

        /* SAVE TO SESSION */
        $this->session->set_userdata('album_step3', $finalTracks);

        /* REDIRECT FLOW */
        if ($editMode) {
            return redirect("UploadAlbum/edit_step4");
        } else {
            return redirect("UploadAlbum/step4");
        }
    }

    /* LOAD VIEW */
    $this->load->view('album/step3', $data);
}

/* ============================================================
   STEP 4 — ARTWORK
============================================================ */
public function edit_step4()
{
    $album_id = $this->session->userdata('edit_album_id');
    $editMode = $album_id ? TRUE : FALSE;

    $data = [];

    if ($editMode) {
        $album = $this->Album_model->get_album($album_id);
        $data['album_id'] = $album_id;
        $data['album'] = $album;
    }

    if ($this->input->post()) {

        $config['upload_path']   = './uploads/covers/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 20000;

        $this->upload->initialize($config);

        if (!empty($_FILES['cover_art']['name'])) {

            if (!$this->upload->do_upload('cover_art')) {
                $data['upload_error'] = $this->upload->display_errors();
                return $this->load->view('album/step4', $data);
            }

            $file = $this->upload->data('file_name');

            $step4 = [
                'cover_art' => 'uploads/covers/' . $file,
                'template'  => $this->input->post('template')
            ];
        } else {

            // Keep old cover
            $step4 = [
                'cover_art' => $this->input->post('old_cover_art'),
                'template'  => $this->input->post('template')
            ];
        }

        $this->session->set_userdata('album_step4', $step4);
        return redirect('UploadAlbum/review');
    }

    $this->load->view('album/step4', $data);
}

/* ============================================================
   REVIEW PAGE
============================================================ */
public function review()
{
    $data['step1'] = $this->session->userdata('album_step1');
    $data['step2'] = $this->session->userdata('album_step2');
    $data['step3'] = $this->session->userdata('album_step3');
    $data['step4'] = $this->session->userdata('album_step4');

    $data['edit_album_id'] = $this->session->userdata('edit_album_id') ?? null;

    $this->load->view('album/review', $data);
}

/* ============================================================
   SUBMIT — CREATE OR UPDATE
============================================================ */
public function submit()
{
    $album_id = $this->session->userdata('edit_album_id');
    $editMode = $album_id ? TRUE : FALSE;

    $sessionData = [
        'step1' => $this->session->userdata('album_step1'),
        'step2' => $this->session->userdata('album_step2'),
        'step3' => $this->session->userdata('album_step3'),
        'step4' => $this->session->userdata('album_step4'),
    ];
	
	//echo "<pre>"; print_r($sessionData); echo "</pre>"; die;

    if ($editMode) {
		
        $updated_id = $this->Album_model->update_album($album_id, $sessionData);
		$this->clear_album_session();
        return redirect('my-albums/view/' . $album_id);
    }

    // CREATE MODE
    $new_id = $this->Album_model->persist_album($sessionData);
	 // CLEAR ALL SESSION DATA
      $this->clear_album_session();

	
    return redirect('UploadAlbum/success/' . $new_id);
}

/* ============================================================
   SUCCESS PAGE
============================================================ */
public function success($album_id)
{
    $data['album_id'] = $album_id;
    $this->load->view('album/success', $data);
}

private function clear_album_session()
{
    $this->session->unset_userdata('album_step1');
    $this->session->unset_userdata('album_step2');
    $this->session->unset_userdata('album_step3');
    $this->session->unset_userdata('album_step4');
    $this->session->unset_userdata('edit_album_id');
}



/* ============================================================
   AJAX — DELETE ALBUM
============================================================ */
public function delete($id)
{
    $this->output->set_content_type('application/json');

    if ($this->Album_model->delete_album($id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed']);
    }
}

/* ============================================================
   AJAX — DELETE TRACK (Used in Step 3)
============================================================ */
public function delete_track__old($track_id)
{
    $this->output->set_content_type('application/json');

    if ($this->Album_model->delete_track($track_id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

public function delete_track($track_id)
{
    $this->db->where('id', $track_id);
    $track = $this->db->get('album_tracks')->row();

    if (!$track) {
        echo json_encode(['success' => false]); 
        return;
    }

    // Remove audio file
    if ($track->audio_file && file_exists(FCPATH . $track->audio_file)) {
        @unlink(FCPATH . $track->audio_file);
    }

    $this->db->where('id', $track_id)->delete('album_tracks');

    echo json_encode(['success' => true]);
}


/* ============================================================
   AJAX — REORDER TRACKS (drag & drop)
============================================================ */
public function reorder_tracks()
{
    $this->output->set_content_type('application/json');

    $order = $this->input->post('order'); // array: [track_id => new_position]

    if (!$order) {
        echo json_encode(['success' => false]);
        return;
    }

    foreach ($order as $track_id => $position) {
        $this->Album_model->update_track_order($track_id, $position);
    }

    echo json_encode(['success' => true]);
}

}
