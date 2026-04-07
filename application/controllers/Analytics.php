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
        $data['months'] = $this->Analytics_model->get_available_months();
        $this->load->view('analytics/index', $data);
    }
     // AJAX
    public function get_data($type, $metric)
{
    $user_id  = $this->session->userdata('user_id'); // ✅ IMPORTANT
    $range    = $this->input->get('range');
    $from     = $this->input->get('from');
    $to       = $this->input->get('to');
    $platform = $this->input->get('platform');

    if ($type === 'singles') {
        $rows = $this->Analytics_model->singles_data(
            $user_id, $metric, $range, $from, $to, $platform
        );
    } else {
        $rows = $this->Analytics_model->albums_data(
            $user_id, $metric, $range, $from, $to, $platform
        );
    }

    echo json_encode([
        'rows' => $rows,
        'totals' => [
            'streams' => array_sum(array_column($rows, 'streams')),
            'revenue' => array_sum(array_column($rows, 'revenue')),
        ]
    ]);
}


}
?>