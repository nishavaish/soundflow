<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_model extends CI_Model
{
    protected $table = 'user_bank_details';

    public function get_by_user($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->get($this->table)
            ->row();
    }

    public function save($data)
    {
        $exists = $this->get_by_user($data['user_id']);

        if ($exists) {
            $this->db->where('user_id', $data['user_id'])->update($this->table, $data);
        } else {
            $this->db->insert($this->table, $data);
        }
    }
}
