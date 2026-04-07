<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function get_user_streaming_summary($user_id)
    {
        return $this->db
            ->select('
                SUM(h.streams) as total_streams,
                SUM(h.downloads) as total_downloads,
                SUM(h.revenue) as total_revenue
            ')
            ->from('track_streaming_history h')
            ->join('releases r', 'r.id = h.track_id')
            ->where('r.user_id', $user_id)
            ->get()
            ->row();
    }
	
	
	public function get_user_streams_trend($user_id)
{
    return $this->db
        ->select('
            DATE_FORMAT(h.report_month, "%Y-%m") as month,
            SUM(h.streams) as streams
        ')
        ->from('track_streaming_history h')
        ->join('releases r', 'r.id = h.track_id')
        ->where('r.user_id', $user_id)
        ->group_by('month')
        ->order_by('month DESC')
        ->limit(6)
        ->get()
        ->result();
}


public function get_top_track($user_id)
{
    return $this->db
        ->select('
            r.title,
            r.primary_artist,
            SUM(h.streams) as streams
        ')
        ->from('track_streaming_history h')
        ->join('releases r', 'r.id = h.track_id')
        ->where('r.user_id', $user_id)
        ->group_by('r.id')
        ->order_by('streams DESC')
        ->limit(1)
        ->get()
        ->row();
}


public function get_month_comparison($user_id)
{
    return $this->db
        ->select('
            DATE_FORMAT(h.report_month, "%Y-%m") as month,
            SUM(h.streams) as streams,
            SUM(h.revenue) as revenue
        ')
        ->from('track_streaming_history h')
        ->join('releases r', 'r.id = h.track_id')
        ->where('r.user_id', $user_id)
        ->group_by('month')
        ->order_by('month DESC')
        ->limit(2)
        ->get()
        ->result();
}



	
	
}
