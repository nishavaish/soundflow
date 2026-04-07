<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Invoices extends MY_Controller {

    public function __construct() {
       parent::__construct();

        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
       
        $this->load->model('Invoice_model');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $month = $this->input->get('month');

        $data['selected_month'] = $month;
        $data['invoices'] = $this->Invoice_model->get_all($user_id, $month);

        $this->load->view('invoices/index', $data);
    }
}
