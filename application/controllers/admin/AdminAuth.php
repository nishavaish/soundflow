<?php
class AdminAuth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Admin_model');
        $this->load->library('session');
        $this->load->helper(['url','form']);
    }

    public function passwordEnc(){
		echo password_hash('admin@123', PASSWORD_BCRYPT);

	}
    public function login()
    {
        if ($this->session->userdata('admin_id')) {
            redirect('admin/dashboard');
        }

        if ($this->input->post()) {

            $admin = $this->Admin_model->login(
                $this->input->post('email'),
                $this->input->post('password')
            );

            if ($admin) {
                $this->session->set_userdata('admin_id', $admin->id);
                $this->session->set_userdata('admin_name', $admin->name);
                redirect('admin/dashboard');
            } else {
                $data['error'] = 'Invalid admin credentials';
            }
        }

        $this->load->view('admin/auth/login', @$data);
    }

    public function logout()
    {
        $this->session->unset_userdata(['admin_id','admin_name']);
        redirect('admin/login');
    }
}


?>