<?php
class Store_model extends CI_Model
{
	 public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }
   
	public function insert_batch($release_id, $items = []) {
		if (empty($items)) return;
		$data = [];
		foreach ($items as $i) {
			$data[] = ['release_id' => $release_id, 'store_key' => $i];
		}
		return $this->db->insert_batch('release_stores', $data);
	}
	
    // Get art work by release
    public function get_by_release($release_id) {
        return $this->db->get_where('release_stores', ['release_id' => $release_id])->result();
    }

    // Delete all artwork for a release and their child rows
    public function delete_by_release($release_id) {
      
        $this->db->where('release_id', $release_id);
        return $this->db->delete('release_stores');
    }
	
	
}


?>