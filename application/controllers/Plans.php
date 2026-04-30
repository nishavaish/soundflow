<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans extends CI_Controller {

    public function __construct(){
        parent::__construct();
		
		// ensure logged in
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
		
        $this->load->model('Plan_model');
    }

    // ✅ FRONTEND: SHOW ACTIVE PLANS
    public function index()
    {
        // get only active plans
        $plans = $this->db
            ->where('status', 'active')
            ->get('plans')
            ->result();

        // attach features
        foreach ($plans as $p) {
            $p->features = $this->db
                ->get_where('plan_features', ['plan_id' => $p->id])
                ->result();
        }

        $data['plans'] = $plans;

        // load your frontend view (dashboard or separate page)
        $this->load->view('plans_list', $data);
    }
}