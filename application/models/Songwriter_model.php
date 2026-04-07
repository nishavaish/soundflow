<?php

class Songwriter_model extends CI_Model
{
	 public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }
    
	
	public function delete_by_track($track_id) {
		$this->db->where('track_id', $track_id);
		$this->db->delete('track_songwriters'); // or track_artists, track_producers respectively
	}
	
	public function get_by_track($track_id) {
    return $this->db->get_where('track_songwriters', ['track_id' => $track_id])->result();
}



public function insert_batch($track_id, $names = []) {
    if (empty($names)) return;
    $rows = [];
    foreach ($names as $n) {
        if ($n === '') continue;
        $rows[] = ['track_id' => $track_id, 'name' => $n];
    }
    return !empty($rows) ? $this->db->insert_batch('track_songwriters', $rows) : null;
}


}


?>