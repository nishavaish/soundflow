<?php

class Analytics_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();   // <-- REQUIRED
    }


    /* ==========================
      MONTH LIST
   ========================== */
    public function get_available_months()
    {
        return $this->db->query("
            SELECT DISTINCT DATE_FORMAT(report_month,'%Y-%m') AS month
            FROM (
                SELECT report_month FROM track_streaming_history
                UNION ALL
                SELECT report_month FROM album_track_streaming_history
            ) t
            ORDER BY month DESC
        ")->result();
    }

    /* ==========================
       COMMON FILTERS
    ========================== */
    // private function apply_filters($range, $from, $to, $platform)
    // {
    //     if ($range === 'week') {
    //         $this->db->where('report_month >=', date('Y-m-d', strtotime('-7 days')));
    //     }

    //     if ($range === 'custom' && $from && $to) {
    //         $this->db->where('report_month >=', $from);
    //         $this->db->where('report_month <=', $to);
    //     }

    //     if ($platform && $platform !== 'all') {
    //         $this->db->where('platform', $platform);
    //     }
    // }

    private function apply_filters($range, $from, $to, $platform)
{
    if ($range === 'week') {
        $this->db->where('report_month >=', date('Y-m-d', strtotime('-7 days')));
    }

    if ($range === 'last30') {
        $this->db->where('report_month >=', date('Y-m-d', strtotime('-30 days')));
    }

    if ($range === 'custom' && $from && $to) {
        $this->db->where('report_month >=', $from);
        $this->db->where('report_month <=', $to);
    }

    if ($platform && $platform !== 'all') {
        $this->db->where('platform', $platform);
    }
}

    /* ==========================
       SINGLES
    ========================== */
    public function singles_data($user_id, $metric, $range, $from, $to, $platform)
    {
        $this->db->select("
        h.report_month,
        SUM(h.streams) AS streams,
        SUM(h.revenue) AS revenue
    ");
        $this->db->from('track_streaming_history h');
        $this->db->join('tracks t', 't.id = h.track_id');
        $this->db->join('releases r', 'r.id = t.release_id');

        $this->db->where('r.user_id', $user_id); // ✅ USER FILTER

        $this->apply_filters($range, $from, $to, $platform);

        return $this->db
            ->group_by('h.report_month')
            ->order_by('h.report_month')
            ->get()
            ->result();
    }



    public function albums_data($user_id, $metric, $range, $from, $to, $platform)
    {
        $this->db->select("
        h.report_month as report_month,
        SUM(h.streams) as streams,
        SUM(h.revenue) as revenue
    ");
        $this->db->from('album_track_streaming_history h');

        // Join to get user_id via albums
        $this->db->join('album_tracks at', 'at.id = h.track_id');
        $this->db->join('albums a', 'a.id = at.album_id');

        // Filter by user
        $this->db->where('a.user_id', $user_id);

        $this->apply_filters($range, $from, $to, $platform);

        // Date filter
        // if ($range === 'week') {
        //     $this->db->where('h.report_month >=', date('Y-m-d', strtotime('-6 days')));
        // } elseif ($range === 'month') {
        //     $this->db->where('MONTH(h.report_month) = MONTH(CURDATE())');
        //     $this->db->where('YEAR(h.report_month) = YEAR(CURDATE())');
        // } elseif ($range === 'custom' && $from && $to) {
        //     $this->db->where('h.report_month >=', $from);
        //     $this->db->where('h.report_month <=', $to);
        // }

        return $this->db
            ->group_by('h.report_month')
            ->order_by('h.report_month')
            ->get()
            ->result();

        // return $rows;
    }

}


?>