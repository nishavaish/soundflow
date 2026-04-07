<?php

class Artist_model extends CI_Model
{
	
	 public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }
    public function get_by_track($track_id, $type='') {
		return $this->db->get_where('track_artists', ['track_id' => $track_id])->result();
	}

	public function delete_by_track($track_id) {
		$this->db->where('track_id', $track_id);
		return $this->db->delete('track_artists');
	}

	public function insert_batch($track_id, $names = [], $roles = [], $type) {
		if (empty($names)) return;
		$rows = [];
		foreach ($names as $i => $n) {
			$n = trim($n);
			if ($n === '') continue;
			$rows[] = [
				'track_id' => $track_id,
				'name' => $n,
				'role' => isset($roles[$i]) ? $roles[$i] : null,
				'type' => isset($type) ? $type : null
			];
		}
		return !empty($rows) ? $this->db->insert_batch('track_artists', $rows) : null;
	}


	
	
}


?>