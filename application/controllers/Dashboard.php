<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        // ensure logged in
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
		
		 $this->load->model('Dashboard_model');
    }

    public function index() {
        $this->data['title'] = 'Dashboard';
        // load any data needed for the dashboard
		$user_id = $this->session->userdata('user_id');
		
		$this->data['stats'] = $this->Dashboard_model->get_user_streaming_summary($user_id);
		$this->data['trend'] = array_reverse($this->Dashboard_model->get_user_streams_trend($user_id));
		$this->data['top_track'] = $this->Dashboard_model->get_top_track($user_id);
		$this->data['month_compare'] = $this->Dashboard_model->get_month_comparison($user_id);

        $this->render('dashboard');
    }
}
