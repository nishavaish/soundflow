<?php

class AdminUser_model extends CI_Model {

    public function get_users($q = null)
    {
        if ($q) {
            $this->db->group_start()
                     ->like('user_name', $q)
                     ->or_like('email', $q)
                     ->group_end();
        }

        return $this->db
            ->select('u.*,
                (SELECT COUNT(*) FROM releases r WHERE r.user_id = u.id) AS singles_count,
                (SELECT COUNT(*) FROM albums a WHERE a.user_id = u.id) AS albums_count')
            ->from('users u')
            ->order_by('u.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_user($id)
    {
        return $this->db->where('id', $id)->get('users')->row();
    }

    public function user_singles($user_id)
    {
        return $this->db->where('user_id', $user_id)
                        ->order_by('id', 'DESC')
                        ->get('releases')
                        ->result();
    }

    public function user_albums($user_id)
    {
        return $this->db->where('user_id', $user_id)
                        ->order_by('id', 'DESC')
                        ->get('albums')
                        ->result();
    }

    public function delete_user($user_id)
    {
        // Delete releases
        $this->db->where('user_id', $user_id)->delete('releases');

        // Delete albums & tracks
        $albums = $this->db->where('user_id', $user_id)->get('albums')->result();
        foreach ($albums as $a) {
            $this->db->where('album_id', $a->id)->delete('album_tracks');
        }
        $this->db->where('user_id', $user_id)->delete('albums');

        // Finally delete user
        return $this->db->where('id', $user_id)->delete('users');
    }
	
	
	// Get invoices by user
public function get_user_invoices($user_id)
{
    return $this->db
        ->where('user_id', $user_id)
        ->order_by('created_at', 'DESC')
        ->get('user_invoices')
        ->result();
}

// Update invoice status
public function update_invoice_status($invoice_id, $status)
{
    return $this->db
        ->where('id', $invoice_id)
        ->update('user_invoices', ['status' => $status]);
}

}

?>
