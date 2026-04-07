

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminRelease_model extends CI_Model {

    public function get_releases($q = null)
    {
        if ($q) {
            $this->db->group_start()
                     ->like('r.title', $q)
                     ->or_like('r.isrc', $q)
                     ->or_like('u.name', $q)
                     ->group_end();
        }

        return $this->db
            ->select('r.id, r.title, r.primary_artist, r.isrc, r.stream_count, r.revenue, r.download_count, r.release_date, r.created_at, r.is_active, u.name, aw.file_path')
            ->from('releases r')
            ->join('users u', 'u.id = r.user_id')
            ->join('release_artwork aw', 'aw.release_id = r.id')
            ->order_by('r.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_release($id)
    {
        return $this->db->where('id', $id)->get('releases')->row();
    }
	
    public function delete_release($id)
    {
        $release = $this->get_release($id);
        if (!$release) return false;

        // Delete cover art
        if (!empty($release->cover_art) && file_exists(FCPATH . $release->cover_art)) {
            @unlink(FCPATH . $release->cover_art);
        }

        // Delete audio file if stored on release (adjust if different table)
        if (!empty($release->audio_file) && file_exists(FCPATH . $release->audio_file)) {
            @unlink(FCPATH . $release->audio_file);
        }

        return $this->db->where('id', $id)->delete('releases');
    }
	
	
	 public function toggle($id)
    {
        $release = $this->db->where('id', $id)->get('releases')->row();
        if (!$release) return false;

        return $this->db->where('id', $id)
                        ->update('releases', [
                            'is_active' => !$release->is_active
                        ]);
    }
	
	
	
	public function update_streaming_by_isrc($isrc, $streams, $revenue, $downloads)
{
    $this->db->where('isrc', $isrc);
    $exists = $this->db->get('releases')->row();

    if ($exists) {
        $this->db->where('isrc', $isrc)
                 ->update('releases', [
                     'stream_count' => $streams,
                     'download_count' => $downloads,
                     'revenue'      => $revenue
                 ]);
    }
}


public function check_track_isrc($track_id, $isrc)
{
    return $this->db->select('*')
        ->from('releases')
        ->where('isrc', $isrc)
        ->where('id !=', $track_id)
       ->get()->num_rows();
}


public function update_track_isrc($track_id, $isrc)
{
    return $this->db
        ->where('id', $track_id)
        ->update('releases', [
            'isrc' => $isrc,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
}



public function get_track_by_isrc($isrc)
{
    return $this->db->where('isrc', $isrc)->get('releases')->row();
}

public function insert_streaming_history($data)
{
    $this->db->insert('track_streaming_history', $data);
}

public function check_streaming_history_datewise($track_id, $checkPlateform, $date)
{
   
	 return $this->db->where('track_id', $track_id)
	 ->where("DATE_FORMAT(report_month, '%Y-%m-%d') = '$date' ")
	 ->where("platform = '$checkPlateform' ")->get('track_streaming_history')->row();
}

public function recalculate_track_totals($track_id)
{
    $totals = $this->db->select('SUM(streams) as streams, SUM(revenue) as revenue, SUM(downloads) as downloads')
        ->where('track_id', $track_id)
        ->get('track_streaming_history')
        ->row();

    $this->db->where('id', $track_id)
        ->update('releases', [
            'stream_count' => $totals->streams,
            'download_count' => $totals->downloads,
            'revenue' => $totals->revenue
        ]);
}


public function get_monthly_revenue()
{
    return $this->db->select("DATE_FORMAT(report_month,'%Y-%m') as month, SUM(revenue) as revenue")
        ->group_by('month')
        ->order_by('month', 'ASC')
        ->get('track_streaming_history')
        ->result();
}

public function get_single_full_metadata($release_id)
{
    return $this->db
        ->select('
            r.title,
            r.primary_artist,
            r.featuring,
            r.genre,
            r.subgenre,
            r.language,
            r.description,
            r.release_date,
            r.explicit_content,
			r.isrc,
			r.stream_count,
			r.download_count,
			r.revenue,
			aw.file_path,
            t.audio_file,
            t.lyrics,
            t.lyrics_language,
            t.explicit_lyrics
        ')
        ->from('releases r')
        ->join('tracks t', 't.release_id = r.id')
         ->join('release_artwork aw', 'aw.release_id = r.id')
        ->where('r.id', $release_id)
       ->get()
        ->row();
}

public function get_platform_wise_streams($release_id)
{
    return $this->db
        ->select('
            h.platform,
            SUM(h.streams) as total_streams,
            SUM(h.downloads) as total_downloads,
            SUM(h.revenue) as total_revenue
        ')
        ->from('track_streaming_history h')
        ->join('releases t', 't.id = h.track_id')
        ->where('t.id', $release_id)
        ->group_by('h.platform')
        ->order_by('total_streams', 'DESC')
        ->get()
        ->result();
}

public function get_single_basic($release_id)
{
    return $this->db
        ->select('r.title, r.primary_artist, r.isrc')
        ->from('releases r')
        ->join('tracks t', 't.release_id = r.id')
        ->where('r.id', $release_id)
        ->get()
        ->row();
}



	
public function get_available_months($release_id)
{
    return $this->db
        ->select('DATE_FORMAT(report_month, "%Y-%m") as month')
        ->from('track_streaming_history h')
        ->join('releases t', 't.id = h.track_id')
        ->where('t.id', $release_id)
        ->group_by('month')
        ->order_by('month DESC')
        ->get()
        ->result();
}




public function get_platform_streams_by_month($release_id, $month = null)
{
    $this->db
        ->select('
            h.platform,
            SUM(h.streams) as streams,
            SUM(h.downloads) as downloads,
            SUM(h.revenue) as revenue
        ')
        ->from('track_streaming_history h')
        ->join('releases t', 't.id = h.track_id')
        ->where('t.id', $release_id);

    // ✅ Apply month filter ONLY if month is provided
    if (!empty($month) && $month !='all') {
			$month = date('Y-m', strtotime($month));
         $this->db->where("DATE_FORMAT(h.report_month, '%Y-%m') = '$month' ");
    }

    return $this->db
        ->group_by('h.platform')
        ->order_by('streams', 'DESC')
        ->get()
        ->result();
}


public function get_platform_datewise_streams__old($release_id)
{
    return $this->db
        ->select('
            h.platform,
            DATE_FORMAT(h.report_month, "%Y-%m-%d") as month,
            SUM(h.streams) as streams,
            SUM(h.downloads) as downloads,
            SUM(h.revenue) as revenue
        ')
        ->from('track_streaming_history h')
        ->join('releases t', 't.id = h.track_id')
        ->where('t.id', $release_id)
        ->group_by('h.platform, month')
        ->order_by('month DESC, h.platform ASC')
        ->get()
        ->result();
}

// public function get_platform_datewise_streams($release_id, $month = null)
// {
//     $this->db
//         ->select('
//             h.platform,
//             DATE_FORMAT(h.report_month, "%Y-%m") as month,
//             SUM(h.streams) as streams,
//             SUM(h.downloads) as downloads,
//             SUM(h.revenue) as revenue
//         ')
//         ->from('track_streaming_history h')
//         ->join('releases t', 't.id = h.track_id')
//         ->where('t.id', $release_id);

//      if (!empty($month) && $month !='all') {
// 			$month = date('Y-m', strtotime($month));
//          $this->db->where("DATE_FORMAT(h.report_month, '%Y-%m') = '$month' ");
//     }

//     return $this->db
//         ->group_by('h.platform, month')
//         ->order_by('month DESC')
//         ->get()
//         ->result();
// }

public function get_platform_datewise_streams($release_id, $month = null)
{
    $this->db
        ->select('
            h.platform,
            DATE(h.report_month) as report_date,
            SUM(h.streams) as streams,
            SUM(h.downloads) as downloads,
            SUM(h.revenue) as revenue
        ')
        ->from('track_streaming_history h')
        ->join('releases t', 't.id = h.track_id')
        ->where('t.id', $release_id);

    // Filter by selected month but return EACH DATE
    if (!empty($month) && $month != 'all') {
        $month = date('Y-m', strtotime($month));
        $this->db->where("DATE_FORMAT(h.report_month, '%Y-%m') =", $month);
    }

    return $this->db
        ->group_by('h.platform, report_date')
        ->order_by('report_date DESC')
        ->get()
        ->result();
}


public function get_monthly_platform_trends($release_id)
{
    return $this->db
        ->select('
            DATE_FORMAT(h.report_month, "%Y-%m") as month,
            h.platform,
            SUM(h.streams) as streams,
			 SUM(h.downloads) as downloads,
            SUM(h.revenue) as revenue
        ')
        ->from('track_streaming_history h')
        ->join('releases t', 't.id = h.track_id')
        ->where('t.id', $release_id)
        ->group_by('month, h.platform')
        ->order_by('month ASC')
        ->get()
        ->result();
}


}

?>