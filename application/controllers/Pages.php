<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('Plan_model');
    }

    public function landing() {
        $this->data['title'] = 'Landing';
		
		// to show plans on landing page
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
		
		
        $this->render('landing', $data);
    }

    public function pricing() {
        $this->data['title'] = 'Pricing';
		
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
        $this->render('pricing', $data);
    }
}
