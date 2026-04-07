<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       CREATE NEW ALBUM
       Called by UploadAlbum/submit (create mode)
    ============================================================ */
    public function persist_album($sessionData)
    {
        $step1 = $sessionData['step1'];
        $step2 = $sessionData['step2'];
        $step3 = $sessionData['step3'];
        $step4 = $sessionData['step4'];

        $albumData = [
            'user_id'      => $step1['user_id'] ?? $this->session->userdata('user_id'),
            'album_title'  => $step1['album_title'],
            'artist'       => $step1['artist'],
            'featuring'    => $step1['featuring'],
            'album_type'   => $step1['album_type'],
            'num_tracks'   => $step1['num_tracks'],
            'genre'        => $step1['genre'],
            'subgenre'     => $step1['subgenre'],
            'release_date' => $step1['release_date'],
            'language'     => $step1['language'],
            'upc_code'     => $step1['upc_code'],
            'label'        => $step1['label'],
            'description'  => $step1['description'],
            'explicit'     => $step1['explicit'],
            'cover_art'    => $step4['cover_art'],
            'template'     => $step4['template'],
            'created_at'   => date("Y-m-d H:i:s"),
            'updated_at'   => date("Y-m-d H:i:s")
        ];

        // Insert album
        $this->db->insert('albums', $albumData);
        $album_id = $this->db->insert_id();

        if (!$album_id) return false;

        /* ---- STORES ---- */
        if (!empty($step2['stores'])) {
            foreach ($step2['stores'] as $s) {
                $this->db->insert('album_stores', [
                    'album_id' => $album_id,
                    'store_name' => $s,
                    'enabled' => 1
                ]);
            }
        }

        /* ---- SOCIAL ---- */
        if (!empty($step2['social'])) {
            foreach ($step2['social'] as $s) {
                $this->db->insert('album_social', [
                    'album_id' => $album_id,
                    'platform' => $s,
                    'enabled' => 1
                ]);
            }
        }

        /* ---- TRACKS ---- */
        foreach ($step3 as $i => $track) {
            $this->db->insert('album_tracks', [
                'album_id'     => $album_id,
                'track_number' => $i + 1,
                'track_title'  => $track['track_title'],
                'songwriters'  => $track['songwriters'],
                'artists'      => $track['artists'],
                'producers'    => $track['producers'],
                'audio_file'   => $track['audio_file'], // file path
                'is_explicit'  => $track['is_explicit']
            ]);
        }

        return $album_id;
    }

    /* ============================================================
       EDIT MODE — UPDATE ALBUM
    ============================================================ */
    public function update_album($album_id, $sessionData)
    {
        $step1 = $sessionData['step1'];
        $step2 = $sessionData['step2'];
        $step3 = $sessionData['step3'];
        $step4 = $sessionData['step4'];

        // Update album table
        $albumData = [
            'album_title'  => $step1['album_title'],
            'artist'       => $step1['artist'],
            'featuring'    => $step1['featuring'],
            'album_type'   => $step1['album_type'],
            'num_tracks'   => $step1['num_tracks'],
            'genre'        => $step1['genre'],
            'subgenre'     => $step1['subgenre'],
            'release_date' => $step1['release_date'],
            'language'     => $step1['language'],
            'upc_code'     => $step1['upc_code'],
            'label'        => $step1['label'],
            'description'  => $step1['description'],
            'explicit'     => $step1['explicit'],
            'cover_art'    => $step4['cover_art'],  // may be unchanged
            'template'     => $step4['template'],
            'updated_at'   => date("Y-m-d H:i:s")
        ];

        $this->db->where('id', $album_id)->update('albums', $albumData);

        /* -------------------------------
           UPDATE STORES
        ------------------------------- */
        $this->db->where('album_id', $album_id)->delete('album_stores');

        if (!empty($step2['stores'])) {
            foreach ($step2['stores'] as $s) {
                $this->db->insert('album_stores', [
                    'album_id'   => $album_id,
                    'store_name' => $s,
                    'enabled'    => 1
                ]);
            }
        }

        /* -------------------------------
           UPDATE SOCIAL
        ------------------------------- */
        $this->db->where('album_id', $album_id)->delete('album_social');

        if (!empty($step2['social'])) {
            foreach ($step2['social'] as $s) {
                $this->db->insert('album_social', [
                    'album_id' => $album_id,
                    'platform' => $s,
                    'enabled' => 1
                ]);
            }
        }

        /* -------------------------------
           UPDATE TRACKS
        ------------------------------- */

        // Delete existing tracks — easier approach
        $this->db->where('album_id', $album_id)->delete('album_tracks');

        foreach ($step3 as $i => $track) {

            // Audio file handled by controller (optional replace)
            $this->db->insert('album_tracks', [
                'album_id'     => $album_id,
                'track_number' => $i + 1,
                'track_title'  => $track['track_title'],
                'songwriters'  => $track['songwriters'],
                'artists'      => $track['artists'],
                'producers'    => $track['producers'],
                'audio_file'   => $track['audio_file'],
                'is_explicit'  => $track['is_explicit']
            ]);
        }

        return true;
    }

    /* ============================================================
       GET SINGLE ALBUM
    ============================================================ */
    public function get_album($id)
    {
        return $this->db->where('id', $id)->get('albums')->row();
    }

    /* ============================================================
       GET TRACKS
    ============================================================ */
    public function get_album_tracks($album_id)
    {
        return $this->db
            ->where('album_id', $album_id)
            ->order_by('track_number', 'ASC')
            ->get('album_tracks')
            ->result();
    }

    /* ============================================================
       GET STORES
    ============================================================ */
    public function get_album_stores($album_id)
    {
        return $this->db
            ->where('album_id', $album_id)
            ->where('enabled', 1)
            ->get('album_stores')
            ->result();
    }

    /* ============================================================
       GET SOCIAL
    ============================================================ */
    public function get_album_social($album_id)
    {
        return $this->db
            ->where('album_id', $album_id)
            ->where('enabled', 1)
            ->get('album_social')
            ->result();
    }

    /* ============================================================
       DELETE TRACK (AJAX)
    ============================================================ */
    public function delete_track($track_id)
    {
        return $this->db->where('id', $track_id)->delete('album_tracks');
    }

    /* ============================================================
       UPDATE TRACK ORDER (AJAX)
    ============================================================ */
    public function update_track_order($track_id, $position)
    {
        return $this->db
            ->where('id', $track_id)
            ->update('album_tracks', ['track_number' => $position]);
    }

    /* ============================================================
       DELETE ALBUM + Related Data
    ============================================================ */
    public function delete_album($album_id)
    {
        // Delete artwork file
        $album = $this->get_album($album_id);
        if ($album && file_exists(FCPATH . $album->cover_art)) {
            @unlink(FCPATH . $album->cover_art);
        }

        // Delete audio files
        $tracks = $this->get_album_tracks($album_id);
        foreach ($tracks as $t) {
            if (file_exists(FCPATH . $t->audio_file)) {
                @unlink(FCPATH . $t->audio_file);
            }
        }

        // Delete rows
        $this->db->where('album_id', $album_id)->delete('album_tracks');
        $this->db->where('album_id', $album_id)->delete('album_stores');
        $this->db->where('album_id', $album_id)->delete('album_social');

        return $this->db->where('id', $album_id)->delete('albums');
    }

    /* ============================================================
       LISTING — COUNT
    ============================================================ */
    public function count_albums($user_id, $search = null, $from = null, $to = null)
    {
        $this->db->where('user_id', $user_id);

        if ($search) {
            $this->db->group_start()
                 ->like('album_title', $search)
                 ->or_like('artist', $search)
            ->group_end();
        }

        if ($from) {
            $this->db->where('release_date >=', $from);
        }
        if ($to) {
            $this->db->where('release_date <=', $to);
        }

        return $this->db->count_all_results('albums');
    }

    /* ============================================================
       LISTING — GET PAGED ALBUMS
    ============================================================ */
    public function get_albums($user_id, $limit, $offset, $search = null, $from = null, $to = null)
    {
        $this->db->where('user_id', $user_id);

        if ($search) {
            $this->db->group_start()
                 ->like('album_title', $search)
                 ->or_like('artist', $search)
            ->group_end();
        }

        if ($from) {
            $this->db->where('release_date >=', $from);
        }
        if ($to) {
            $this->db->where('release_date <=', $to);
        }

        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get('albums')
            ->result();
    }

}
