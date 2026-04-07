<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/admin/AdminBase.php');
class Users extends AdminBase {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/AdminUser_model');
    }

    public function index()
    {
        $q = $this->input->get('q');

        $data['title'] = 'Users';
        $data['users'] = $this->AdminUser_model->get_users($q);
        $data['view']  = 'admin/users/list';

        $this->load->view('admin/layout/layout', $data);
    }

    public function view($id)
    {
        $user = $this->AdminUser_model->get_user($id);
        if (!$user) show_404();

        $data['title']   = 'User Details';
        $data['user']    = $user;
        $data['singles'] = $this->AdminUser_model->user_singles($id);
        $data['albums']  = $this->AdminUser_model->user_albums($id);
        $data['view']    = 'admin/users/view';

        $this->load->view('admin/layout/layout', $data);
    }

    public function delete($id)
    {
        $this->AdminUser_model->delete_user($id);
        $this->session->set_flashdata('success', 'User deleted successfully');
        redirect('admin/users');
    }
	
	public function invoices($user_id)
	{
		
		 $data['title']   = 'User Invoices';
        $data['user']    = $this->AdminUser_model->get_user($user_id);
        $data['invoices'] = $this->AdminUser_model->get_user_invoices($user_id);
        $data['view']    = 'admin/users/invoices';

        $this->load->view('admin/layout/layout', $data);
		
	}
	
	public function update_invoice_status()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			show_404();
		}

		$invoice_id = $this->input->post('invoice_id');
		$status     = $this->input->post('status');

		if (!$invoice_id || !in_array($status, ['pending', 'approved', 'paid'])) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid data',
				'csrf_hash' => $this->security->get_csrf_hash()
			]);
			return;
		}

		$this->AdminUser_model->update_invoice_status($invoice_id, $status);

		echo json_encode([
			'status' => 'success',
			'message' => 'Invoice status updated',
			'csrf_hash' => $this->security->get_csrf_hash()
		]);
	}



}

?>