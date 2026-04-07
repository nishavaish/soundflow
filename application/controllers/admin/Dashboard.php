<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/admin/AdminBase.php');
class Dashboard extends AdminBase {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/AdminDashboard_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['stats'] = $this->AdminDashboard_model->stats();
        $data['latest_singles'] = $this->AdminDashboard_model->latest_singles();
        $data['latest_albums']  = $this->AdminDashboard_model->latest_albums();
        $data['view'] = 'admin/dashboard';

        $this->load->view('admin/layout/layout', $data);
    }
}


?>