<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       SAVE MAIN ALBUM RECORD
    ============================================================ */
    public function saveAlbum($data)
    {
        $insert = [
            'user_id'       => $data['user_id'],
            'album_title'   => $data['album_title'],
            'artist'        => $data['artist'],
            'featuring'     => $data['featuring'],
            'album_type'    => $data['album_type'],
            'num_tracks'    => $data['num_tracks'],
            'genre'         => $data['genre'],
            'subgenre'      => $data['subgenre'],
            'release_date'  => $data['release_date'],
            'language'      => $data['language'],
            'upc_code'      => $data['upc_code'],
            'label'         => $data['label'],
            'description'   => $data['description'],
            'explicit'      => $data['explicit'],
            'cover_art'     => $data['cover_art'],
            'template'      => $data['template'],
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        ];

        $this->db->insert('albums', $insert);
        return $this->db->insert_id();
    }

    /* ============================================================
       SAVE TRACKS FOR ALBUM
    ============================================================ */
    public function saveTracks($album_id, $tracks)
    {
        foreach ($tracks as $i => $track) {

            $insert = [
                'album_id'      => $album_id,
                'track_number'  => $i + 1,
                'track_title'   => $track['track_title'],
                'songwriters'   => json_encode($track['songwriters']),
                'artists'       => json_encode($track['artists']),
                'producers'     => json_encode($track['producers']),
                'audio_file'    => $track['audio_file'],
                'is_explicit'   => isset($track['is_explicit']) ? $track['is_explicit'] : 0
            ];

            $this->db->insert('album_tracks', $insert);
        }
    }

    /* ============================================================
       SAVE STORE SELECTION
    ============================================================ */
    public function saveStores($album_id, $stores)
    {
        if (!$stores || !is_array($stores)) return;

        foreach ($stores as $store_name => $enabled) {
            $this->db->insert('album_stores', [
                'album_id'  => $album_id,
                'store_name'=> $store_name,
                'enabled'   => $enabled ? 1 : 0
            ]);
        }
    }

    /* ============================================================
       SAVE SOCIAL PLATFORM SELECTION
    ============================================================ */
    public function saveSocial($album_id, $platforms)
    {
        if (!$platforms || !is_array($platforms)) return;

        foreach ($platforms as $platform => $enabled) {
            $this->db->insert('album_social', [
                'album_id'  => $album_id,
                'platform'  => $platform,
                'enabled'   => $enabled ? 1 : 0
            ]);
        }
    }

    /* ============================================================
       MASTER METHOD: PERSIST EVERYTHING
    ============================================================ */
    public function persist_album($sessionData)
    {
        /* ------------------------------
           1. Save main album
        ------------------------------ */
        $album_id = $this->saveAlbum([
            'user_id'       => $sessionData['step1']['user_id'],
            'album_title'   => $sessionData['step1']['album_title'],
            'artist'        => $sessionData['step1']['artist'],
            'featuring'     => $sessionData['step1']['featuring'] ?? '',
            'album_type'    => $sessionData['step1']['album_type'],
            'num_tracks'    => $sessionData['step1']['num_tracks'],
            'genre'         => $sessionData['step1']['genre'],
            'subgenre'      => $sessionData['step1']['subgenre'],
            'release_date'  => $sessionData['step1']['release_date'],
            'language'      => $sessionData['step1']['language'],
            'upc_code'      => $sessionData['step1']['upc_code'],
            'label'         => $sessionData['step1']['label'],
            'description'   => $sessionData['step1']['description'],
            'explicit'      => $sessionData['step1']['explicit'],
            'cover_art'     => $sessionData['step4']['cover_art'],
            'template'      => $sessionData['step4']['template'] ?? '',
        ]);

        /* ------------------------------
           2. Save track list
        ------------------------------ */
        if (isset($sessionData['step3']) && is_array($sessionData['step3'])) {
            $this->saveTracks($album_id, $sessionData['step3']);
        }

        /* ------------------------------
           3. Save store choices
        ------------------------------ */
        if (isset($sessionData['step2']['stores'])) {
            $this->saveStores($album_id, $sessionData['step2']['stores']);
        }

        /* ------------------------------
           4. Save social platform choices
        ------------------------------ */
        if (isset($sessionData['step2']['social'])) {
            $this->saveSocial($album_id, $sessionData['step2']['social']);
        }

        return $album_id;
    }
}
