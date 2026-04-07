

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminBase extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('admin_id')) {
            redirect('admin/login');
        }
    }
}



?>