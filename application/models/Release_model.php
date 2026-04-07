<?php 
class Release_model extends CI_Model
{
    protected $table = 'releases';
	public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }
    public function create($data)
    {
        $this->db->insert('releases', $data);
        return $this->db->insert_id();
    }

    public function update_release($id, $data)
    {
        return $this->db->where('id', $id)->update('releases', $data);
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get('releases')->row();
    }
	
	


    // Count (respects soft-delete if column exists)
    public function count_user_releases($user_id, $filters = []) {
        $this->db->where('user_id', $user_id);
        if ($this->db->field_exists('is_deleted', 'releases')) {
            $this->db->where('is_deleted', 0);
        }
        if (!empty($filters['q'])) {
            $this->db->group_start()
                     ->like('title', $filters['q'])
                     ->or_like('primary_artist', $filters['q'])
                     ->group_end();
        }
        if (!empty($filters['genre'])) $this->db->where('genre', $filters['genre']);
        if (!empty($filters['from'])) $this->db->where('release_date >=', $filters['from']);
        if (!empty($filters['to'])) $this->db->where('release_date <=', $filters['to']);
        return $this->db->count_all_results('releases');
    }

    // Get user releases (pagination)
    public function get_user_releases($user_id, $limit, $offset, $filters = [])
{
    $this->db->select('releases.*, release_artwork.file_path');
    $this->db->from('releases');
    $this->db->join('release_artwork', 'release_artwork.release_id = releases.id', 'left');

    $this->db->where('releases.user_id', $user_id);

    if ($this->db->field_exists('is_deleted', 'releases')) {
        $this->db->where('releases.is_deleted', 0);
    }

    if (!empty($filters['q'])) {
        $this->db->group_start()
                 ->like('releases.title', $filters['q'])
                 ->or_like('releases.primary_artist', $filters['q'])
                 ->group_end();
    }

    if (!empty($filters['genre'])) {
        $this->db->where('releases.genre', $filters['genre']);
    }

    if (!empty($filters['from'])) {
        $this->db->where('releases.release_date >=', $filters['from']);
    }

    if (!empty($filters['to'])) {
        $this->db->where('releases.release_date <=', $filters['to']);
    }

    $this->db->order_by('releases.created_at', 'DESC');
    $this->db->limit($limit, $offset);

    return $this->db->get()->result();
}

    // Find (respects is_deleted)
    public function find_by_id($id) {
        $this->db->where('releases.id', $id);
		$this->db->join('release_artwork', 'release_artwork.release_id = releases.id', 'left');

        if ($this->db->field_exists('is_deleted', 'releases')) {
            $this->db->where('is_deleted', 0);
        }
        return $this->db->get('releases')->row();
    }

    // Raw find (ignore is_deleted) - useful for auth checks
    public function find_raw_by_id($id) {
        return $this->db->get_where('releases', ['id' => $id])->row();
    }

    // Update
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('releases', $data);
    }

    // Soft delete: mark and timestamp
    public function soft_delete($id) {
        if ($this->db->field_exists('is_deleted', 'releases')) {
            $data = [
                'is_deleted'  => 1,
                'deleted_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ];
            $this->db->where('id', $id);
            return $this->db->update('releases', $data);
        } else {
            // fallback to hard delete if schema not updated
            return $this->delete($id);
        }
    }

    // Hard delete (fallback)
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('releases');
    }

}

?>
