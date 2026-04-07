<?php
class AdminDashboard_model extends CI_Model {

    public function stats()
    {
        return [
            'users'    => $this->db->count_all('users'),
            'singles'  => $this->db->count_all('releases'),
            'albums'   => $this->db->count_all('albums'),
            'links'    => $this->db->count_all('streaming_links'),
        ];
    }

    public function latest_singles($limit = 5)
    {
        return $this->db
            ->select('releases.id, releases.title, users.name, releases.created_at')
            ->from('releases')
            ->join('users', 'users.id = releases.user_id')
            ->order_by('releases.id', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function latest_albums($limit = 5)
    {
        return $this->db
            ->select('albums.id, albums.album_title, users.name, albums.created_at')
            ->from('albums')
            ->join('users', 'users.id = albums.user_id')
            ->order_by('albums.id', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}


?>