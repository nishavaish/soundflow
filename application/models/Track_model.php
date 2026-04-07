<?php

class Track_model extends CI_Model
{
	 public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }
    public function create($data)
    {
        $this->db->insert('tracks', $data);
        return $this->db->insert_id();
    }
	
	public function update($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('tracks', $data);
	}



    // Get tracks by release
    public function get_by_id($id) {
        return $this->db->get_where('tracks', ['id' => $id])->row();
    }

    // Get tracks by release
    public function get_by_release($release_id) {
        return $this->db->get_where('tracks', ['release_id' => $release_id])->result();
    }

    // Delete all tracks for a release and their child rows
    public function delete_by_release($release_id) {
        // 1) fetch track ids
        $this->db->select('id');
        $q = $this->db->get_where('tracks', ['release_id' => $release_id]);
        $rows = $q->result_array();
        $track_ids = array_column($rows, 'id');

        if (!empty($track_ids)) {
            // 2) delete child rows safely
            $this->db->where_in('track_id', $track_ids);
            $this->db->delete('track_artists');

            $this->db->where_in('track_id', $track_ids);
            $this->db->delete('track_producers');

            $this->db->where_in('track_id', $track_ids);
            $this->db->delete('track_songwriters');

            // Optionally delete any uploaded audio files from disk
            // (If you store file path in `audio_file`, fetch and unlink them)
            $this->db->select('audio_file');
            $this->db->where_in('id', $track_ids);
            $files_q = $this->db->get('tracks');
            foreach ($files_q->result() as $f) {
                if (!empty($f->audio_file) && file_exists(FCPATH . $f->audio_file)) {
                    @unlink(FCPATH . $f->audio_file);
                }
            }
        }

        // 3) delete tracks
        $this->db->where('release_id', $release_id);
        return $this->db->delete('tracks');
    }




}
