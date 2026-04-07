

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminRelease_model extends CI_Model {

    public function get_releases($q = null)
    {
        if ($q) {
            $this->db->group_start()
                     ->like('r.title', $q)
                     ->or_like('u.user_name', $q)
                     ->group_end();
        }

        return $this->db
            ->select('r.id, r.title, r.primary_artist, aw.file_path, r.created_at, r.is_active, u.name')
            ->from('releases r')
            ->join('users u', 'u.id = r.user_id')
            ->join('release_artwork aw', 'aw.release_id = r.id')
            ->order_by('r.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_release($id)
    {
        return $this->db->where('id', $id)->get('releases')->row();
    }
	
    public function delete_release($id)
    {
        $release = $this->get_release($id);
        if (!$release) return false;

        // Delete cover art
        if (!empty($release->cover_art) && file_exists(FCPATH . $release->cover_art)) {
            @unlink(FCPATH . $release->cover_art);
        }

        // Delete audio file if stored on release (adjust if different table)
        if (!empty($release->audio_file) && file_exists(FCPATH . $release->audio_file)) {
            @unlink(FCPATH . $release->audio_file);
        }

        return $this->db->where('id', $id)->delete('releases');
    }
	
	
	 public function toggle($id)
    {
        $release = $this->db->where('id', $id)->get('releases')->row();
        if (!$release) return false;

        return $this->db->where('id', $id)
                        ->update('releases', [
                            'is_active' => !$release->is_active
                        ]);
    }
}

?>