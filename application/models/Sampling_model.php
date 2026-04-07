<?php
	
class Sampling_model extends CI_Model {

    public function insertSong($data) {
        return $this->db->insert('sampling', $data);
    }

    public function getBySlug($slug) {
        return $this->db->get_where('sampling', ['unique_slug' => $slug])->row();
    }

    public function trackClick($id) {
        $this->db->insert('sampling_clicks', [
            'sampling_id' => $id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);

        $this->db->set('total_clicks', 'total_clicks+1', FALSE)
                 ->where('id', $id)
                 ->update('sampling');
    }

    public function trackPlay($id) {
        $this->db->insert('sampling_plays', [
            'sampling_id' => $id,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);

        $this->db->set('total_plays', 'total_plays+1', FALSE)
                 ->where('id', $id)
                 ->update('sampling');
    }
}

?>