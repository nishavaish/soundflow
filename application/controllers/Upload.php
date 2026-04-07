<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Upload_model');
         if (!$this->session->userdata('user_id')) {
            redirect('login');
        } 
    }

    public function select() {
        $this->data['title'] = 'Upload - Select';
        $this->render('upload_select');
    }

    public function single() {
        $this->data['title'] = 'Upload - Single';
        if ($this->input->method() === 'post') {
            $config['upload_path'] = FCPATH.'assets/uploads/';
            $config['allowed_types'] = 'mp3|wav|flac|jpg|png|zip';
            $config['max_size'] = 10240; // 10MB adjust as needed
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $data = $this->upload->data();
                $this->Upload_model->save_upload($this->session->user_id, $data);
                $this->data['success'] = 'File uploaded';
            } else {
                $this->data['error'] = $this->upload->display_errors();
            }
        }
        $this->render('upload_single');
    }
	
	
	

    public function stores_platforms_single() {
        $this->data['title'] = 'Upload - Single';
     
        $this->render('single_stores_platforms');
    }
	
	
	

    public function track_details_single() {
        $this->data['title'] = 'Upload - Single';
     
        $this->render('track_details_single');
    }
	
	
    public function art_work_single() {
        $this->data['title'] = 'Upload - Single';
     
        $this->render('art_work_single');
    }
	
	
	

    public function album() {
        $this->data['title'] = 'Upload - Album';
        $this->render('upload_album');
    }
}
