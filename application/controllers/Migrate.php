<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load migration library
        $this->load->library('migration');
    }

    public function index()
    {
        // Runs ALL migrations up to the latest version
        if ($this->migration->latest() === FALSE)
        {
            show_error($this->migration->error_string());
        }
        else
        {
            echo "<h2>Migrations executed successfully!</h2>";
        }
    }
}
