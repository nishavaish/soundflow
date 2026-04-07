<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UploadSingle extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
		 $this->load->library(['session', 'form_validation', 'upload', 'pagination']);
        $this->load->helper(['url', 'form', 'text']);

		
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
		
		 $this->load->config('streaming_platforms');
		 $this->load->config('music_genre');
		 $this->load->config('music_languages');
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

		$data['platforms']    = $this->config->item('streaming_platforms');
        $this->load->view('upload/step2', $data);
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
                'crbt_clip_min' => $this->input->post('crbt_clip_min'),
                'crbt_clip_sec' => $this->input->post('crbt_clip_sec'),
                'audio_file' => $audio_file
            ];

            $this->session->set_userdata('step3', $track_data);
			
			//echo "<pre>"; print_r($_POST); //die;
			//echo "<pre>"; print_r($track_data); die;

            return redirect('UploadSingle/step4');
        } else {
		
			//echo "validation failed ";
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
            $template_id = $this->input->post('selected_template');

            // Upload artwork file
            if (!empty($_FILES['artwork']['name'])) {

                $config['upload_path']   = './uploads/artwork/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size']      = 0;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('artwork')) {
                    $file_path = 'uploads/artwork/' . $this->upload->data('file_name');
                } else {
				
				
									// PRINT upload error clearly
					echo "<pre style='color:red;font-size:16px'>";
					echo "UPLOAD ERROR:\n";
					print_r($this->upload->display_errors());
					echo "</pre>";

					//die; // Stop execution so you can see the error

				}
            }

            $data = [
                'file_path'   => $file_path,
                'template_id' => $template_id
            ];
			
			//echo "<pre>"; print_r($data); echo "</pre>"; die;

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
		
		//echo "<pre>";	print_r($step3);	echo "</pre>"; die;

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
            'explicit_lyrics'=> @$step3['explicit_lyrics'],
            'tiktok_minutes'=> @$step3['tiktok_min'],
            'tiktok_seconds'=> @$step3['tiktok_sec'],
            'crbt_clip_min'=> @$step3['crbt_clip_min'],
            'crbt_clip_sec'=> @$step3['crbt_clip_sec']
        ]);

        // ------------------------------------------------------
        // 3. Save Songwriters
        // ------------------------------------------------------
        //$this->Songwriter_model->insert_batch($track_id, $step3['songwriters']);
		$raw_songwriters = $step3['songwriters'];

        if (is_array($raw_songwriters)) {
            // array of names from multiple input fields
            $songwriters = array_filter(array_map('trim', $raw_songwriters));
        } elseif (is_string($raw_songwriters) && $raw_songwriters !== '') {
            // comma separated string
            $songwriters = array_filter(array_map('trim', explode(',', $raw_songwriters)));
        } else {
            $songwriters = [];
        }
		if (!empty($songwriters)) {
            // ensure model expects array of names
            $this->Songwriter_model->insert_batch($track_id, $songwriters);
        }
		
		
        // ------------------------------------------------------
        // 4. Save Artists
        // ------------------------------------------------------
        //$this->Artist_model->insert_batch( $track_id, @$step3['main_artist'], @$step3['main_artist_role']);
		
		// --------------------------
        // Artists: expect arrays: artists[] and main_artist_role[] (or none)
        // --------------------------
        $artists = @$step3['main_artist'] ?? [];
        $artists_role = $step3['main_artist_role'] ?? [];

        // Normalize to arrays of names and roles (trim)
        if (!is_array($artists)) $artists = [$artists];
        if (!is_array($artists_role)) $artists_role = [$artists_role];

        $artists = array_map('trim', $artists);
        $artists_role = array_map('trim', $artists_role);

        if (!empty(array_filter($artists))) {
            $this->Artist_model->insert_batch($track_id, $artists, $artists_role, $type='main');
        }
		
		// --------------------------
        // Performing Artists: expect arrays: artists[] and main_artist_role[] (or none)
        // --------------------------
        $performing_artists = @$step3['performing_artist'] ?? [];
        $performing_artists_role = $step3['performing_artist_role'] ?? [];

        // Normalize to arrays of names and roles (trim)
        if (!is_array($performing_artists)) $performing_artists = [$performing_artists];
        if (!is_array($performing_artists_role)) $performing_artists_role = [$performing_artists_role];

        $performing_artists = array_map('trim', $performing_artists);
        $performing_artists_role = array_map('trim', $performing_artists_role);

        if (!empty(array_filter($performing_artists))) {
            $this->Artist_model->insert_batch($track_id, $performing_artists, $performing_artists_role, $type='performing');
        }


        // ------------------------------------------------------
        // 5. Save Producers
        // ------------------------------------------------------
        //$this->Producer_model->insert_batch( $track_id, @$step3['producer_name'], @$step3['producer_role']);

		// --------------------------
        // Producers: expect arrays: producer_name[] and producer_role[] (or none)
        // --------------------------
        $producers = $step3['producer_name'] ?? $step3['producer_name'] ?? [];
        $producer_role = $step3['producer_role'] ?? $step3['producer_role'] ?? [];

        if (!is_array($producers)) $producers = [$producers];
        if (!is_array($producer_role)) $producer_role = [$producer_role];

        $producers = array_map('trim', $producers);
        $producer_role = array_map('trim', $producer_role);

        if (!empty(array_filter($producers))) {
            $this->Producer_model->insert_batch($track_id, $producers, $producer_role);
        }
		
		
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
	
	  // -----------------------------------------------------------------
    // NEW: LISTING: paginated list of releases + track count
    // URL: /UploadSingle/listing/ or /UploadSingle/listing/2 (page)
    // -----------------------------------------------------------------
    public function listing($page = 1)
    {
        $user_id = $this->session->userdata('user_id');

        // Pagination config
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        // Optional filters (search, genre, date range)
        $filters = [];
        if ($this->input->get('q')) {
            $filters['q'] = $this->input->get('q');
        }
        if ($this->input->get('genre')) {
            $filters['genre'] = $this->input->get('genre');
        }
        if ($this->input->get('from')) {
            $filters['from'] = $this->input->get('from');
        }
        if ($this->input->get('to')) {
            $filters['to'] = $this->input->get('to');
        }

        $total = $this->Release_model->count_user_releases($user_id, $filters);
        $releases = $this->Release_model->get_user_releases($user_id, $per_page, $offset, $filters);

        // Pagination builder
        $config['base_url'] = site_url('my-releases');
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 3;
        // Tailwind-friendly pagination (simple)
        $this->pagination->initialize($config);

        // echo "<pre>";
        // print_r($releases);
        // die();

        $this->load->view('upload/listing', [
            'releases' => $releases,
            'total' => $total,
            'pagination' => $this->pagination->create_links(),
            'filters' => $filters
        ]);
    }

    // -----------------------------------------------------------------
    // VIEW single release (with tracks)
    // URL: /UploadSingle/view/123
    // -----------------------------------------------------------------
    public function view($release_id = null)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$release_id) redirect('my-releases');

        $release = $this->Release_model->find_by_id($release_id);
        if (!$release || $release->user_id != $user_id) {
            show_404();
        }

        $tracks = $this->Track_model->get_by_release($release_id);

         // echo "<pre>";
        // print_r($releases);
        // die();

        

        $this->load->view('upload/view', [
            'release_id' => $release_id,
            'release' => $release,
            'tracks' => $tracks
        ]);
    }

    // -----------------------------------------------------------------
    // EDIT release (basic metadata) and update
    // URL: /UploadSingle/edit/123
    // -----------------------------------------------------------------
    public function edit($release_id = null)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$release_id) redirect('my-releases');

        $release = $this->Release_model->find_by_id($release_id);
        if (!$release || $release->user_id != $user_id) {
            show_404();
        }

        if ($_POST) {
            // validation
            $this->form_validation->set_rules('title', 'Title', 'required|max_length[255]');
            $this->form_validation->set_rules('primary_artist', 'Primary Artist', 'required|max_length[255]');
            $this->form_validation->set_rules('release_date', 'Release Date', 'required');

            if ($this->form_validation->run()) {
                $update = [
                    'title' => $this->input->post('title'),
                    'primary_artist' => $this->input->post('primary_artist'),
                    'featuring' => $this->input->post('featuring'),
                    'genre' => $this->input->post('genre'),
                    'subgenre' => $this->input->post('subgenre'),
                    'release_date' => $this->input->post('release_date'),
                    'language' => $this->input->post('language'),
                    'isrc' => $this->input->post('isrc'),
                    'description' => $this->input->post('description'),
                    'explicit_content' => $this->input->post('explicit_content')
                ];

                $this->Release_model->update($release_id, $update);
                $this->session->set_flashdata('success', 'Release updated successfully.');
                redirect('my-releases/view/' . $release_id);
            }
        }

        $this->load->view('upload/edit', [
            'release' => $release
        ]);
    }

    // -----------------------------------------------------------------
    // DELETE release (soft-delete approach recommended but here's hard-delete)
    // URL: /UploadSingle/delete/123
    // -----------------------------------------------------------------
   
	
	public function delete__old($release_id = null)
    {
        if (!$release_id) redirect('my-releases');

        // Load release
        $release = $this->Release_model->find_raw_by_id($release_id); // raw fetch (even if soft-deleted flag exists)

        // Authorize (owner or admin)
        if (!$this->_authorize_release($release)) {
            show_error('Unauthorized', 403);
            return;
        }

        // Soft-delete release (sets is_deleted=1, deleted_at timestamp)
        $this->Release_model->soft_delete($release_id);

        // Permanently remove dependent rows that should not remain
        // Track_model->delete_by_release deletes tracks and all child rows safely
        $this->Track_model->delete_by_release($release_id);
        $this->Artwork_model->delete_by_release($release_id);
        $this->Store_model->delete_by_release($release_id);
        $this->Social_model->delete_by_release($release_id);

        $this->session->set_flashdata('success', 'Release deleted successfully.');
        redirect('my-releases');
    }
	
	
	public function delete($release_id = null){
		if (!$release_id) {
			echo json_encode(['success' => false, 'message' => 'Invalid release id']);
			return;
		}

		$release = $this->Release_model->find_raw_by_id($release_id);

		if (!$this->_authorize_release($release)) {
			echo json_encode(['success' => false, 'message' => 'Unauthorized']);
			return;
		}

		// soft delete
		$this->Release_model->soft_delete($release_id);

		// delete children
		$this->Track_model->delete_by_release($release_id);
		$this->Artwork_model->delete_by_release($release_id);
		$this->Store_model->delete_by_release($release_id);
		$this->Social_model->delete_by_release($release_id);

		echo json_encode(['success' => true]);
	}

	
	
	 // ---------------------------------------------------------
    // Authorization helper: checks ownership or admin role
    // ---------------------------------------------------------
    private function _authorize_release($release)
    {
        if (!$release) return false;

        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role'); // optional — set role in session on login

        // Owner can access
        if ($release->user_id == $user_id) return true;

        // Admin role can access everything
        if (!empty($role) && $role === 'admin') return true;

        return false;
    }
	
	
	
	// ---------- EDIT FLOW (4 steps) ----------

// ---------- EDIT FLOW (4 steps) ----------
/**
 * Step 1: Edit Release details
 */
  // ---------- EDIT FLOW (4 steps) ----------
    public function edit_step1($release_id = null)
    {
        if (!$this->session->userdata('user_id')) redirect('login');
        if (!$release_id) redirect('my-releases');

        $release = $this->Release_model->find_raw_by_id($release_id);
        if (!$this->_authorize_release($release)) show_error('Unauthorized', 403);

        $this->form_validation->set_rules('title','Track Title','required|trim|max_length[255]');
        $this->form_validation->set_rules('primary_artist','Primary Artist','required|trim|max_length[255]');
        $this->form_validation->set_rules('release_date','Release Date','required');

        if ($this->form_validation->run()) {
            $update = [
                'title' => $this->input->post('title', true),
                'primary_artist' => $this->input->post('primary_artist', true),
                'featuring' => $this->input->post('featuring', true),
                'genre' => $this->input->post('genre', true),
                'subgenre' => $this->input->post('subgenre', true),
                'release_date' => $this->input->post('release_date', true),
                'language' => $this->input->post('language', true),
                'isrc' => $this->input->post('isrc', true),
                'description' => $this->input->post('description', true),
                'explicit_content' => $this->input->post('explicit_content') ? 'yes' : 'no'
            ];

            $this->Release_model->update($release_id, $update);
            $this->session->set_flashdata('success', 'Release details updated.');
            redirect('my-releases/edit/step-2/'.$release_id);
        }
		
        $this->load->view('upload/edit_step1', ['release' => $release]);
    }

    public function edit_step2($release_id = null)
    {
        if (!$this->session->userdata('user_id')) redirect('login');
        if (!$release_id) redirect('my-releases');

        $release = $this->Release_model->find_raw_by_id($release_id);
        if (!$this->_authorize_release($release)) show_error('Unauthorized', 403);

        $existing_stores = $this->Store_model->get_by_release($release_id);
        $existing_social = $this->Social_model->get_by_release($release_id);

        if ($_POST) {
            $stores_post = $this->input->post('stores') ?? [];
            $social_post = $this->input->post('social') ?? [];

            $this->Store_model->delete_by_release($release_id);
            if (!empty($stores_post)) $this->Store_model->insert_batch($release_id, $stores_post);

            $this->Social_model->delete_by_release($release_id);
            if (!empty($social_post)) $this->Social_model->insert_batch($release_id, $social_post);

            $this->session->set_flashdata('success', 'Stores & Social updated.');
            redirect('my-releases/edit/step-3/'.$release_id);
        }
		
		$platforms    = $this->config->item('streaming_platforms');

        $this->load->view('upload/edit_step2', [
            'release' => $release,
            'stores' => $existing_stores,
            'social' => $existing_social,
            'platforms' => $platforms
        ]);
    }

   public function edit_step3($release_id = null)
{
    if (!$this->session->userdata('user_id')) redirect('login');
    if (!$release_id) redirect('my-releases');

    $release = $this->Release_model->find_raw_by_id($release_id);
    if (!$this->_authorize_release($release)) show_error('Unauthorized', 403);

    $tracks = $this->Track_model->get_by_release($release_id);
    $track = !empty($tracks) ? $tracks[0] : null;

    // validation
    $this->form_validation->set_rules('song_title','Song Title','required|trim|max_length[255]');

    if ($this->form_validation->run()) {
        $tdata = [
            'title' => $this->input->post('song_title', true),
            'lyrics' => $this->input->post('lyrics', true),
            'lyrics_language' => $this->input->post('lyrics_lang', true),
            'explicit_lyrics' => $this->input->post('explicit_lyrics') === 'yes' ? 'yes' : 'no',
            'tiktok_minutes' => (int)$this->input->post('tiktok_min'),
            'tiktok_seconds' => (int)$this->input->post('tiktok_sec'),
            'crbt_clip_min' => (int)$this->input->post('crbt_clip_min'),
            'crbt_clip_sec' => (int)$this->input->post('crbt_clip_sec')
        ];
		
		// if user requested to remove current audio
		if ($this->input->post('remove_audio')) {
			if ($track && !empty($track->audio_file) && file_exists(FCPATH . $track->audio_file)) {
				@unlink(FCPATH . $track->audio_file);
			}
			// clear audio_file column for the track in DB
			if ($track) {
				$this->Track_model->update($track->id, ['audio_file' => null]);
				// refresh $track variable so later code sees the updated state if needed
				$track = $this->Track_model->get_by_id($track->id); // implement get_by_id if not exists
			}
		}


        // handle audio replacement (unchanged)
        if (!empty($_FILES['audio_file']['name'])) {
            $config['upload_path'] = './uploads/audio/';
            $config['allowed_types'] = 'mp3|wav|flac|aiff';
            $config['max_size'] = 102400; // 100MB
            $config['encrypt_name'] = TRUE;
            if (!is_dir(FCPATH.'uploads/audio/')) @mkdir(FCPATH.'uploads/audio/',0755,true);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('audio_file')) {
                $u = $this->upload->data();
                $tdata['audio_file'] = 'uploads/audio/'.$u['file_name'];

                // delete old file
                if ($track && !empty($track->audio_file) && file_exists(FCPATH.$track->audio_file)) {
                    @unlink(FCPATH.$track->audio_file);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('my-releases/edit/step-3/'.$release_id);
            }
        }
		
	/* 	print_r($track);
		echo "<br>";
		print_r($tdata); */

        // update or create track
        if ($track) {
            $this->Track_model->update($track->id, $tdata);
            $track_id = $track->id;
        } else {
            $tdata['release_id'] = $release_id;
            $track_id = $this->Track_model->create($tdata);
        }

        // --------------------------
        // Songwriters: accept string (csv) OR array (songwriters[])
        // --------------------------
        $raw_songwriters = $this->input->post('songwriters');

        if (is_array($raw_songwriters)) {
            // array of names from multiple input fields
            $songwriters = array_filter(array_map('trim', $raw_songwriters));
        } elseif (is_string($raw_songwriters) && $raw_songwriters !== '') {
            // comma separated string
            $songwriters = array_filter(array_map('trim', explode(',', $raw_songwriters)));
        } else {
            $songwriters = [];
        }

        // Replace songwriter rows
        $this->Songwriter_model->delete_by_track($track_id);
        if (!empty($songwriters)) {
            // ensure model expects array of names
            $this->Songwriter_model->insert_batch($track_id, $songwriters);
        }

        // --------------------------
        // Artists: expect arrays: artists[] and artists_role[] (or none)
        // --------------------------
        $artists = $this->input->post('artists') ?? [];
        $artists_role = $this->input->post('artists_role') ?? [];

        // Normalize to arrays of names and roles (trim)
        if (!is_array($artists)) $artists = [$artists];
        if (!is_array($artists_role)) $artists_role = [$artists_role];

        $artists = array_map('trim', $artists);
        $artists_role = array_map('trim', $artists_role);

        // Delete existing and reinsert
        $this->Artist_model->delete_by_track($track_id);
        if (!empty(array_filter($artists))) {
            $this->Artist_model->insert_batch($track_id, $artists, $artists_role);
        }

        // --------------------------
        // Producers: expect arrays: producer_name[] and producer_role[] (or none)
        // --------------------------
        $producers = $this->input->post('producer_name') ?? $this->input->post('producers') ?? [];
        $producers_role = $this->input->post('producer_role') ?? $this->input->post('producers_role') ?? [];

        if (!is_array($producers)) $producers = [$producers];
        if (!is_array($producers_role)) $producers_role = [$producers_role];

        $producers = array_map('trim', $producers);
        $producers_role = array_map('trim', $producers_role);

        $this->Producer_model->delete_by_track($track_id);
        if (!empty(array_filter($producers))) {
            $this->Producer_model->insert_batch($track_id, $producers, $producers_role);
        }

        $this->session->set_flashdata('success', 'Track updated.');
        redirect('my-releases/edit/step-4/'.$release_id);
    }
	
	    // --- AFTER saving logic (unchanged) ---

    // Before rendering the view, load existing child rows so the view can prefill fields
    $songwriters_list = [];
    $producers_list   = [];
    $artists_list     = [
        'main' => [],        // rows where role = 'main' (or use your role key)
        'performing' => []   // rows where role = 'performing' (or whatever you use)
    ];

    if ($track && !empty($track->id)) {
        // Songwriters
        if (method_exists($this->Songwriter_model, 'get_by_track')) {
            $sw_rows = $this->Songwriter_model->get_by_track($track->id);
            if (!empty($sw_rows)) {
                foreach ($sw_rows as $r) $songwriters_list[] = $r->name;
            } elseif (!empty($track->songwriters) && is_string($track->songwriters)) {
                // fallback: if songwriters stored as CSV in tracks.songwriters
                $songwriters_list = array_filter(array_map('trim', explode(',', $track->songwriters)));
            }
        } else {
            // fallback: if model doesn't provide method, try reading track->songwriters
            if (!empty($track->songwriters) && is_string($track->songwriters)) {
                $songwriters_list = array_filter(array_map('trim', explode(',', $track->songwriters)));
            }
        }

        // Producers
        if (method_exists($this->Producer_model, 'get_by_track')) {
            $prod_rows = $this->Producer_model->get_by_track($track->id);
            if (!empty($prod_rows)) {
                foreach ($prod_rows as $r) $producers_list[] = ['name' => $r->name, 'role' => $r->role];
            }
        }

        // Artists
        if (method_exists($this->Artist_model, 'get_by_track')) {
            $art_rows = $this->Artist_model->get_by_track($track->id);
            if (!empty($art_rows)) {
                foreach ($art_rows as $r) {
                    // You said you have main_artist and performing_artist — adapt to your role naming
                    $role = strtolower($r->type ?? '');
                    if ($role === 'main' || $role === 'lead' || $role === 'primary') {
                        $artists_list['main'][] = ['name' => $r->name, 'role' => $r->role];
                    } elseif ($role === 'performing' || $role === 'performer') {
                        $artists_list['performing'][] = ['name' => $r->name, 'role' => $r->role];
                    } else {
                        // unknown role: push into performing by default
                        $artists_list['performing'][] = ['name' => $r->name, 'role' => $r->role];
                    }
                }
            }
        }
    }

    // Fallback ensure there's at least one field shown in view
    if (empty($songwriters_list)) $songwriters_list = [''];
    if (empty($producers_list)) $producers_list = [['name'=>'','role'=>'']];
    if (empty($artists_list['main'])) $artists_list['main'] = [['name'=>'','role'=>'lead']];
    if (empty($artists_list['performing'])) $artists_list['performing'] = [['name'=>'','role'=>'performer']];

	/* echo "<pre>";
	print_r($release);
	print_r($track);
	print_r($songwriters_list);
	print_r($producers_list);
	print_r($artists_list);
	echo "</pre>"; */
	//die;

    // pass child arrays to view
    $this->load->view('upload/edit_step3', [
        'release' => $release,
        'track'   => $track,
        'songwriters' => $songwriters_list,
        'producers'   => $producers_list,
        'artists'     => $artists_list
    ]);

	

    // load the edit step view
    //$this->load->view('upload/edit_step3', ['release' => $release, 'track' => $track]);
}

   /**
 * Step 4 — edit artwork / template
 * POST behavior:
 *  - remove_artwork=1 -> deletes artwork record and file
 *  - file upload 'artwork' -> replace existing file (unlink old) and save path
 *  - selected_template -> update template_id on artwork record (create if missing)
 */
public function edit_step4($release_id = null)
{
    if (!$this->session->userdata('user_id')) redirect('login');
    if (!$release_id) redirect('my-releases');

    $release = $this->Release_model->find_raw_by_id($release_id);
    if (!$this->_authorize_release($release)) show_error('Unauthorized', 403);

    // load current artwork (may be null)
    $artwork = $this->Artwork_model->get_by_release($release_id);

    if ($_POST) {
        // handle remove request first
        $remove = $this->input->post('remove_artwork') ? true : false;
        $selected_template = $this->input->post('selected_template') !== null ? $this->input->post('selected_template') : null;
        $uploaded_path = null;

        // 1) Remove artwork if requested
        if ($remove && $artwork) {
            // Artwork model should unlink file; fallback: unlink here
            $this->Artwork_model->delete_by_release($release_id);
            $artwork = null;
        }

        // 2) Handle file upload (replace)
        if (!empty($_FILES['artwork']['name'])) {
            // ensure upload dir exists
            $upload_dir = FCPATH . 'uploads/artwork/';
            if (!is_dir($upload_dir)) @mkdir($upload_dir, 0755, true);

            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 10240; // 10MB
            $config['encrypt_name']  = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('artwork')) {
                $u = $this->upload->data();
                $uploaded_path = 'uploads/artwork/' . $u['file_name'];

                // delete old file if exists
                if ($artwork && !empty($artwork->file_path) && file_exists(FCPATH . $artwork->file_path)) {
                    @unlink(FCPATH . $artwork->file_path);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                return redirect('my-releases/edit/step-4/'.$release_id);
            }
        }

        // 3) Persist artwork record (create or update)
        if ($artwork) {
            $update = [];
            if ($uploaded_path !== null) $update['file_path'] = $uploaded_path;
            if ($selected_template !== null) $update['template_id'] = $selected_template === '' ? null : (int)$selected_template;
            if (!empty($update)) $this->Artwork_model->update_by_release($release_id, $update);

        } else {
            // create only if we have something to save
            if ($uploaded_path !== null || ($selected_template !== null && $selected_template !== '')) {
                $this->Artwork_model->save($release_id, $uploaded_path, $selected_template === '' ? null : (int)$selected_template);
            }
        }

        $this->session->set_flashdata('success', 'Artwork updated successfully.');
        return redirect('my-releases/view/'.$release_id);
    }

    // Render view
    $this->load->view('upload/edit_step4', [
        'release' => $release,
        'artwork' => $artwork
    ]);
}

}
