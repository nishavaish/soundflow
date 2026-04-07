<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReleaseList_model extends CI_Model {

    private $table = "releases";

    // Common filter function
    private function apply_filters($user_id, $type)
    {
        $q     = $this->input->get('q');
        $genre = $this->input->get('genre');
        $date  = $this->input->get('date');

        $this->db->where('user_id', $user_id);
      //  $this->db->where('type', $type);

        if (!empty($q)) {
            $this->db->like('title', $q);
        }

        if (!empty($genre)) {
            $this->db->where('genre', $genre);
        }

        if (!empty($date)) {
            $this->db->where('DATE(release_date)', $date);
        }
    }

    /* ----------- SINGLES -------------- */

    public function count_filtered_singles($user_id)
    {
        $this->apply_filters($user_id, 'single');
        return $this->db->count_all_results($this->table);
    }

    public function get_filtered_singles($user_id, $limit, $offset)
    {
        $this->apply_filters($user_id, 'single');

        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get($this->table)
            ->result();
    }

    /* ----------- ALBUMS -------------- */

    public function count_filtered_albums($user_id)
    {
        $this->apply_filters($user_id, 'album');
        return $this->db->count_all_results($this->table);
    }

    public function get_filtered_albums($user_id, $limit, $offset)
    {
        $this->apply_filters($user_id, 'album');

        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get($this->table)
            ->result();
    }

}
