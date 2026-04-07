<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function landing() {
        $this->data['title'] = 'Landing';
        $this->render('landing');
    }

    public function pricing() {
        $this->data['title'] = 'Pricing';
        $this->render('pricing');
    }
}
