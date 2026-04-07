<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model
{
    protected $table = 'user_invoices';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ✅ Last 30 days invoices
    public function get_last_30_days($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    // ✅ All invoices (optional month filter)
    public function get_all($user_id, $month = null)
    {
        $this->db->where('user_id', $user_id);

        if ($month) {
            $this->db->where('invoice_month', $month);
        }

        return $this->db
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get($id, $user_id)
    {
        return $this->db
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->get($this->table)
            ->row();
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
	
	public function update_status($id, $user_id, $status)
{
    return $this->db
        ->where('id', $id)
        ->where('user_id', $user_id)
        ->update($this->table, ['status' => $status]);
}

}

