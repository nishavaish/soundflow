<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/admin/AdminBase.php');

class Releases extends AdminBase {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/AdminRelease_model');
    }

    public function index()
    {
        $q = $this->input->get('q');

        $data['title'] = 'Singles';
        $data['releases'] = $this->AdminRelease_model->get_releases($q);
        $data['view'] = 'admin/releases/list';

        $this->load->view('admin/layout/layout', $data);
    }

    public function delete($id)
    {
        $this->AdminRelease_model->delete_release($id);
        echo json_encode(['success' => true]);
    }
	
	
	public function toggle($id)
    {
        $this->AdminRelease_model->toggle($id);
        echo json_encode(['success' => true]);
    }
}
?>