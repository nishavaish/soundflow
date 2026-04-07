<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAlbum_model extends CI_Model
{

    public function get_albums__old($q = null)
    {
        if ($q) {
            $this->db->group_start()
                ->like('a.album_title', $q)
                ->or_like('u.name', $q)
                ->group_end();
        }

        return $this->db
            ->select('a.id, a.album_title, a.cover_art, a.created_at, a.is_active, a.release_date, u.name,
                      (SELECT COUNT(*) FROM album_tracks t WHERE t.album_id = a.id) AS tracks_count')
            ->from('albums a')
            ->join('users u', 'u.id = a.user_id')
            ->order_by('a.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_albums($q = null)
    {
        if ($q) {
            $this->db->group_start()
                ->like('a.album_title', $q)
                ->or_like('u.name', $q)
                ->group_end();
        }

        return $this->db
            ->select('
            a.id,
            a.album_title,
            a.cover_art,
            a.created_at,
            a.is_active,
            a.release_date,
            u.name,

            COUNT(DISTINCT t.id) AS tracks_count,

            COALESCE(SUM(t.total_streams), 0)   AS total_streams,
            COALESCE(SUM(t.total_downloads), 0) AS total_downloads,
            COALESCE(SUM(total_revenue), 0)   AS total_revenue
        ')
            ->from('albums a')
            ->join('users u', 'u.id = a.user_id', 'left')
            ->join('album_tracks t', 't.album_id = a.id', 'left')
            ->group_by('a.id')
            ->order_by('a.id', 'DESC')
            ->get()
            ->result();
    }


    public function get_album($id)
    {
        return $this->db->where('id', $id)->get('albums')->row();
    }

    public function get_tracks($album_id)
    {
        return $this->db->where('album_id', $album_id)->get('album_tracks')->result();
    }

    public function delete_album($album_id)
    {
        $album = $this->get_album($album_id);
        if (!$album)
            return false;

        // Delete cover art
        if ($album->cover_art && file_exists(FCPATH . $album->cover_art)) {
            @unlink(FCPATH . $album->cover_art);
        }

        // Delete track audio files
        $tracks = $this->get_tracks($album_id);
        foreach ($tracks as $t) {
            if ($t->audio_file && file_exists(FCPATH . $t->audio_file)) {
                @unlink(FCPATH . $t->audio_file);
            }
        }

        // Delete DB records
        $this->db->where('album_id', $album_id)->delete('album_tracks');
        return $this->db->where('id', $album_id)->delete('albums');
    }


    public function toggle($id)
    {
        $album = $this->db->where('id', $id)->get('albums')->row();
        if (!$album)
            return false;

        return $this->db->where('id', $id)->update('albums', ['is_active' => !$album->is_active]);
    }

    public function get_album_tracks_with_stats($album_id)
    {
        return $this->db
            ->select('
            t.id,
            t.track_title,
            t.isrc,
           t.total_streams,
           t.total_revenue,
            t.total_downloads
        ')
            ->from('album_tracks t')
            ->where('t.album_id', $album_id)
            ->group_by('t.id')
            ->get()
            ->result();
    }



    public function check_track_isrc($track_id, $isrc)
    {
        return $this->db->select('*')
            ->from('album_tracks')
            ->where('isrc', $isrc)
            ->where('id !=', $track_id)
            ->get()->num_rows();
    }


    public function update_track_isrc($track_id, $isrc)
    {
        return $this->db
            ->where('id', $track_id)
            ->update('album_tracks', [
                'isrc' => $isrc
            ]);
    }




    public function get_track_full_metadata($track_id)
    {
        return $this->db
            ->select('
			
			r.isrc,
            r.track_title,
            r.artists,
            a.album_title,
            a.genre,
            a.subgenre,
            a.label,
            a.language,
            a.description,
            a.release_date,
            r.is_explicit,
			r.total_streams,
			r.total_downloads,
			r.total_revenue,
			a.cover_art,
            r.audio_file,
           
        ')
            ->from('album_tracks r')
            ->join('albums a', 'a.id = r.album_id')
            ->where('r.id', $track_id)->get()->row();
    }



    public function get_track_by_isrc($isrc)
    {
        return $this->db->where('isrc', $isrc)->get('album_tracks')->row();
    }


    public function insert_streaming_history($data)
    {
        $this->db->insert('album_track_streaming_history', $data);
    }

    public function check_streaming_history_datewise($track_id, $checkPlateform, $date)
    {

        return $this->db->where('track_id', $track_id)
            ->where("DATE_FORMAT(report_month, '%Y-%m-%d') = '$date' ")
            ->where("platform = '$checkPlateform' ")->get('album_track_streaming_history')->row();
    }


    public function recalculate_track_totals($track_id)
    {
        $totals = $this->db->select('SUM(streams) as streams, SUM(revenue) as revenue, SUM(downloads) as downloads')
            ->where('track_id', $track_id)
            ->get('album_track_streaming_history')
            ->row();

        $this->db->where('id', $track_id)
            ->update('album_tracks', [
                'total_streams' => $totals->streams,
                'total_downloads' => $totals->downloads,
                'total_revenue' => $totals->revenue
            ]);
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
            ->from('album_track_streaming_history h')
            ->join('album_tracks t', 't.id = h.track_id')
            ->where('t.id', $release_id)
            ->group_by('h.platform')
            ->order_by('total_streams', 'DESC')
            ->get()
            ->result();
    }

    public function get_single_basic($release_id)
    {
        return $this->db
            ->select('r.track_title , r.artists, r.isrc')
            ->from('album_tracks r')
            ->join('albums t', 't.id = r.album_id')
            ->where('r.id', $release_id)
            ->get()
            ->row();
    }




    public function get_available_months($release_id)
    {
        return $this->db
            ->select('DATE_FORMAT(report_month, "%Y-%m") as month')
            ->from('album_track_streaming_history h')
            ->join('album_tracks t', 't.id = h.track_id')
            ->where('t.id', $release_id)
            ->group_by('month')
            ->order_by('month DESC')
            ->get()
            ->result();
    }

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
            ->from('album_track_streaming_history h')
            ->join('album_tracks t', 't.id = h.track_id')
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

    public function get_platform_streams_by_month($release_id, $month = null)
{
    $this->db
        ->select('
            h.platform,
            SUM(h.streams) as streams,
            SUM(h.downloads) as downloads,
            SUM(h.revenue) as revenue
        ')
        ->from('album_track_streaming_history h')
        ->join('album_tracks t', 't.id = h.track_id')
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





}
