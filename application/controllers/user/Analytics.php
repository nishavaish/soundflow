<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/aws/aws.phar';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;



class Analytics extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // ensure logged in
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }

        $this->load->model('Analytics_model');
    }






    public function index()
    {
        $user_id = $this->session->user_id;

        $data['projects'] = $this->Assets_model->get_projects_with_counts($user_id);

        $this->load->view('analytics/index',$data);
    }



}
?>