<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets_model extends CI_Model
{
    /* ==========================================================
     * STORAGE
     * ======================================================== */

    public function get_storage_used($user_id)
    {
        $this->db->select('SUM(file_size) as total_size');
        $this->db->where('user_id', $user_id);
        $row = $this->db->get('assets')->row();

        // bytes → GB
        return round(($row->total_size ?? 0) / 1024 / 1024 / 1024, 2);
    }

    /* ==========================================================
     * PROJECTS
     * ======================================================== */

    public function get_projects_with_counts($user_id)
    {
        return $this->db
            ->select('p.*, COUNT(a.id) as asset_count')
            ->from('asset_projects p')
            ->join('assets a', 'a.project_id = p.id', 'left')
            ->where('p.user_id', $user_id)
            ->group_by('p.id')
            ->order_by('p.created_at', 'DESC')
            ->get()
            ->result();
    }

    public function get_project($project_id, $user_id)
    {
        return $this->db
            ->where([
                'id'      => $project_id,
                'user_id' => $user_id
            ])
            ->get('asset_projects')
            ->row();
    }

 public function create_project($data)
{
    $this->db->insert('asset_projects', $data);
    return $this->db->insert_id();
}


    /* ==========================================================
     * ASSETS
     * ======================================================== */

    public function get_assets($project_id, $user_id)
    {
        return $this->db
            ->where([
                'project_id' => $project_id,
                'user_id'    => $user_id
            ])
            ->order_by('created_at', 'DESC')
            ->get('assets')
            ->result();
    }

    public function insert_asset($data)
    {
        $this->db->insert('assets', $data);
        return $this->db->insert_id();
    }

    public function get_asset($asset_id, $user_id)
    {
        return $this->db
            ->where([
                'id'      => $asset_id,
                'user_id' => $user_id
            ])
            ->get('assets')
            ->row();
    }

    public function delete_asset($asset_id, $user_id)
    {
        return $this->db
            ->where([
                'id'      => $asset_id,
                'user_id' => $user_id
            ])
            ->delete('assets');
    }
	
	
	public function update_asset($id, $user_id, $data)
	{
		return $this->db
			->where(['id'=>$id,'user_id'=>$user_id])
			->update('assets', $data);
	}

}
