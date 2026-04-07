<?php 
class Social_model extends CI_Model
{
	 public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }
    public function insert_batch($release_id, $platforms)
    {
        $batch = [];
        foreach ($platforms as $p) {
            $batch[] = [
                'release_id'   => $release_id,
                'platform_key' => $p
            ];
        }
        if ($batch) {
            $this->db->insert_batch('release_social', $batch);
        }
    }
	
	
	 // Get art work by release
    public function get_by_release($release_id) {
        return $this->db->get_where('release_social', ['release_id' => $release_id])->result();
    }

    // Delete all artwork for a release and their child rows
    public function delete_by_release($release_id) {
      
        $this->db->where('release_id', $release_id);
        return $this->db->delete('release_social');
    }
}


?>