<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminStreamingLink_model extends CI_Model {


    public function get_release($id)
    {
        return $this->db->where('id', $id)->get('releases')->row();
    }

    public function get_album_track($id)
    {
        return $this->db->where('id', $id)->get('album_tracks')->row();
    }

    public function get_links($type, $id)
    {
        return $this->db
            ->where('content_type', $type)
            ->where('content_id', $id)
            ->order_by('id', 'DESC')
            ->get('streaming_links')
            ->result();
    }
	
	public function check_link_by_platform($type, $id, $platform)
    {
        return $this->db
            ->where('content_type', $type)
            ->where('content_id', $id)
            ->where('platform', $platform)
            ->order_by('id', 'DESC')
            ->get('streaming_links')
            ->num_rows();
    }

    public function add_link($data)
    {
        return $this->db->insert('streaming_links', $data);
    }

    public function delete_link($id)
    {
        return $this->db->where('id', $id)->delete('streaming_links');
    }

    public function toggle($id)
    {
        $link = $this->db->where('id', $id)->get('streaming_links')->row();
        if (!$link) return false;

        return $this->db->where('id', $id)
                        ->update('streaming_links', [
                            'is_active' => !$link->is_active
                        ]);
    }
}
