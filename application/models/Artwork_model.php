<?php
class Artwork_model extends CI_Model
{
	 public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }
  

public function get_by_release($release_id) {
    return $this->db->get_where('release_artwork', ['release_id' => $release_id])->row();
}

public function update_by_release($release_id, $data) {
    $this->db->where('release_id', $release_id);
    return $this->db->update('release_artwork', $data);
}

public function save($release_id, $file_path = null, $template_id = null) {
    $this->db->insert('release_artwork', [
        'release_id' => $release_id,
        'file_path' => $file_path,
        'template_id' => $template_id
    ]);
    return $this->db->insert_id();
}

public function delete_by_release($release_id) {
    // optional: unlink file first
    $art = $this->get_by_release($release_id);
    if ($art && !empty($art->file_path) && file_exists(FCPATH.$art->file_path)) {
        @unlink(FCPATH.$art->file_path);
    }
    $this->db->where('release_id', $release_id);
    return $this->db->delete('release_artwork');
}


}


?>