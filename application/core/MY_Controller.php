<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $data = array();

    public function __construct() {
        parent::__construct();
        // Load common libraries/helpers if needed
        $this->load->helper(['url','form','security']);
        $this->load->library('session');
    }

    protected function render($view, $vars = []) {
        $this->data = array_merge($this->data, $vars);
        $this->load->view('templates/header', $this->data);
        $this->load->view($view, $this->data);
        $this->load->view('templates/footer', $this->data);
    }
}
