<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model {
	
    protected $table = 'uploads';

     public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }

    public function save_upload($user_id, $file_data) {
        $data = [
            'user_id' => $user_id,
            'file_name' => $file_data['file_name'],
            'orig_name' => $file_data['client_name'] ?? $file_data['file_name'],
            'file_path' => 'assets/uploads/'.$file_data['file_name'],
            'file_size' => $file_data['file_size'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
}
