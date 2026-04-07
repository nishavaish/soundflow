<?php
	
	class Sampling extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sampling_model');
        $this->load->helper(['url', 'form']);
		
		if (!$this->session->userdata('user_id')) {
            redirect('login');
        } 
    }
	
	public function index() {
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
        $this->load->view('upload');
    }

    // 📤 Handle Upload
    
	public function save__old() {

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
	
	public function save() {

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
	// 🔗 Share Page
    public function song($slug) {
        $song = $this->Sampling_model->getBySlug($slug);

        if (!$song) show_404();

        $this->Sampling_model->trackClick($song->id);

        $this->load->view('player', ['song' => $song]);
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
	
	public function update() {
		
		$id = $this->input->post('id');

		$data = [
			'song_name' => $this->input->post('song_name'),
			'artist_name' => $this->input->post('artist_name')
		];

		$this->db->where('id', $id)->update('sampling', $data);
		$this->session->set_flashdata('success', 'Song updated successfully!');
		redirect('Sampling');
	}
	
	
	public function delete() {
		
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
	
}
	
?>