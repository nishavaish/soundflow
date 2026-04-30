<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sampling extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sampling_model');
		$this->load->helper(['url', 'form']);
		$this->load->library('S3Uploader');
      
    }
	
	public function index() {
		
	if (!$this->session->userdata('user_id')) {
		redirect('login');
	} 
		
    $user_id = $this->session->userdata('user_id');

    $data['songs'] = $this->db
        ->where('user_id', $user_id)
        ->order_by('id', 'DESC')
        ->get('sampling')
        ->result();

    $this->load->view('sampling_manage', $data);
}

    // 🎵 Upload Form
    public function upload() {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} 
        $this->load->view('upload');
    }

    // 📤 Handle Upload
    
	public function save__old() {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} 
		// Artwork validation
		$config['upload_path'] = './uploads/artwork/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048; // 2MB
		
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('artwork')) {
			die($this->upload->display_errors());
		}
		$artwork = $this->upload->data();
		
		
		// Audio validation
		$config['upload_path'] = './uploads/audio/';
		$config['allowed_types'] = 'mp3';
		$config['max_size'] = 10240; // 10MB
		
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('audio')) {
			die($this->upload->display_errors());
		}
		$audio = $this->upload->data();

		$slug = bin2hex(random_bytes(6));

		$data = [
			'user_id' => $this->session->userdata('user_id'),
			'song_name' => $this->input->post('song_name'),
			'artist_name' => $this->input->post('artist_name'),
			'artwork_path' => 'uploads/artwork/' . $artwork['file_name'],
			'audio_path' => 'uploads/audio/' . $audio['file_name'],
			'unique_slug' => $slug
		];

		$this->db->insert('sampling', $data);
		
		$this->session->set_flashdata('success', 'Song uploaded successfully!');
		redirect('Sampling');
	}
	
	public function save__before_AWS() {
	if (!$this->session->userdata('user_id')) {
		redirect('login');
	} 
    header('Content-Type: application/json');

    // ARTWORK
    $config['upload_path'] = './uploads/artwork/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 2048;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('artwork')) {
        echo json_encode([
            'status' => 'error',
            'message' => strip_tags($this->upload->display_errors())
        ]);
        return;
    }

    $artwork = $this->upload->data();

    // AUDIO
    $config['upload_path'] = './uploads/audio/';
    $config['allowed_types'] = 'mp3';
    $config['max_size'] = 10240;

    $this->upload->initialize($config);

    if (!$this->upload->do_upload('audio')) {
        echo json_encode([
            'status' => 'error',
            'message' => strip_tags($this->upload->display_errors())
        ]);
        return;
    }

    $audio = $this->upload->data();

    $slug = bin2hex(random_bytes(6));

    $data = [
        'user_id' => $this->session->userdata('user_id'),
        'song_name' => $this->input->post('song_name'),
        'artist_name' => $this->input->post('artist_name'),
        'artwork_path' => 'uploads/artwork/' . $artwork['file_name'],
        'audio_path' => 'uploads/audio/' . $audio['file_name'],
        'unique_slug' => $slug
    ];

    $this->db->insert('sampling', $data);

    echo json_encode([
        'status' => 'success',
        'message' => 'Song uploaded successfully!'
    ]);
}
	
	public function save() {
	if (!$this->session->userdata('user_id')) {
		redirect('login');
	} 
    header('Content-Type: application/json');

   
	$artwork = str_replace(AWS_ACCESS_URL, '', $this->input->post('artwork_url'));
	$audio   = str_replace(AWS_ACCESS_URL, '', $this->input->post('audio_url'));

    $slug = bin2hex(random_bytes(6));

    $data = [
        'user_id' => $this->session->userdata('user_id'),
        'song_name' => $this->input->post('song_name'),
        'artist_name' => $this->input->post('artist_name'),
        'artwork_path' => $artwork,
        'audio_path' => $audio,
        'unique_slug' => $slug
    ];

    $this->db->insert('sampling', $data);

    echo json_encode([
        'status' => 'success',
        'message' => 'Song uploaded successfully!'
    ]);
}
	// 🔗 Share Page
 

   
	public function update() {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} 
		$id = $this->input->post('id');

		$data = [
			'song_name' => $this->input->post('song_name'),
			'artist_name' => $this->input->post('artist_name')
		];

		$this->db->where('id', $id)->update('sampling', $data);
		$this->session->set_flashdata('success', 'Song updated successfully!');
		redirect('Sampling');
	}
	
	
	public function delete__local_files() {
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} 
		$id = $this->input->post('id');
		$user_id = $this->session->userdata('user_id');

		$song = $this->db->get_where('sampling', [
			'id' => $id,
			'user_id' => $user_id
		])->row();

		if(!$song){
			show_error('Unauthorized action');
		}

		// Delete files
		if(file_exists(FCPATH . $song->artwork_path)){
			unlink(FCPATH . $song->artwork_path);
		}

		if(file_exists(FCPATH . $song->audio_path)){
			unlink(FCPATH . $song->audio_path);
		}

		// Delete DB record
		$this->db->delete('sampling', ['id' => $id]);
		$this->session->set_flashdata('success', 'Song deleted successfully!');
		redirect('Sampling');
	}
	
	public function delete(){
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$id = $this->input->post('id');
		$user_id = $this->session->userdata('user_id');

		$song = $this->db->get_where('sampling', [
			'id' => $id,
			'user_id' => $user_id
		])->row();

		if (!$song) {
			show_error('Unauthorized action');
		}

		// ✅ Collect both files (audio + artwork)
		$filePaths = [];

		if (!empty($song->audio_path)) {
			$filePaths[] = $song->audio_path;
		}

		if (!empty($song->artwork_path)) {
			$filePaths[] = $song->artwork_path;
		}
		

		// ✅ Delete from S3 (bulk)
		if (!empty($filePaths)) {
			$result = $this->s3uploader->deleteMultipleObjects($filePaths);

			// Optional debug (remove in production)
			if ($result['status'] !== 'success') {
				// You can log or inspect errors
				// print_r($result); exit;
			}
		}

		// ✅ Delete DB record
		$this->db->delete('sampling', ['id' => $id]);

		$this->session->set_flashdata('success', 'Song deleted successfully!');
		redirect('Sampling');
	}


	 public function song($slug) {
		
		//echo $slug; die;
		$song = $this->Sampling_model->getBySlug($slug);

        if (!$song) show_404();

        $this->Sampling_model->trackClick($song->id);
		
		
		 $artwork = $this->s3uploader->getSignedGetUrl($song->artwork_path, 300);
		$audio   = $this->s3uploader->getSignedGetUrl($song->audio_path, 300);
		//die;
        $this->load->view('player', ['song' => $song, 'artwork'=>$artwork, "audio"=>$audio]);
		
		
    }
	
	
	
    // 🔊 Stream Audio (NO direct download)
    public function stream($id) {
	
        $song = $this->db->get_where('sampling', ['id' => $id])->row();

        if (!$song) exit;

        $file = FCPATH . $song->audio_path;

        if (!file_exists($file)) exit;

        header('Content-Type: audio/mpeg');
        header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');

        readfile($file);

        $this->Sampling_model->trackPlay($id);
        exit;
    }
	
	
	public function getSignedUrl(){
		$key = $this->input->post('key');
		
		$url = $this->s3uploader->getSignedGetUrl($key, 3600);

		echo json_encode([
			'url' => $url
		]);
	}
	
	public function getBulkSignedUrls(){
		header('Content-Type: application/json');

		if (!$this->session->userdata('user_id')) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Unauthorized'
			]);
			exit;
		}

		$input = json_decode(file_get_contents('php://input'), true);

		$keys = $input['keys'] ?? [];

		if (empty($keys)) {
			echo json_encode(['status' => 'error', 'message' => 'No keys']);
			exit;
		}

		$result = [];

		foreach ($keys as $key) {
			$result[$key] = $this->s3uploader->getSignedGetUrl($key, 3600);
		}

		echo json_encode([
			'status' => 'success',
			'data' => $result
		]);

		exit;
	}
		
}
	
?>