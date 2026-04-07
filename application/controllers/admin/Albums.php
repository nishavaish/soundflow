<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/admin/AdminBase.php');

require_once APPPATH . 'third_party/phpspreadsheet_autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Albums extends AdminBase
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/AdminAlbum_model');
    }

    public function index()
    {
        $q = $this->input->get('q');

        $data['title'] = 'Albums';
        $data['albums'] = $this->AdminAlbum_model->get_albums($q);
        $data['view'] = 'admin/albums/list';

        $this->load->view('admin/layout/layout', $data);
    }

    public function delete($id)
    {
        $this->AdminAlbum_model->delete_album($id);
        echo json_encode(['success' => true]);
    }


    public function toggle($id)
    {
        $this->AdminAlbum_model->toggle($id);
        echo json_encode(['success' => true]);
    }


    public function tracks($album_id)
    {

        $data['title'] = 'Albums Track';
        $data['album'] = $this->AdminAlbum_model->get_album($album_id);
        $data['tracks'] = $this->AdminAlbum_model->get_album_tracks_with_stats($album_id);

        $data['view'] = 'admin/albums/tracks_list';
        //echo "<pre>"; print_r($data); die;
        $this->load->view('admin/layout/layout', $data);
    }

    public function streams($track_id)
    {
        $data['single'] = $this->AdminAlbum_model->get_single_basic($track_id);
        if (!$data['single']) {
            show_404();
        }

        $data['title'] = 'Albums Streams';
        $data['release_id'] = $track_id;
        $data['platforms'] = $this->AdminAlbum_model->get_platform_wise_streams($track_id);
        $data['datewise'] = $this->AdminAlbum_model->get_platform_datewise_streams($track_id);
        $data['months'] = $this->AdminAlbum_model->get_available_months($track_id);

        $data['view'] = 'admin/albums/streams';

        // echo "<pre>";
        // print_r($data);
        // die();

        $this->load->view('admin/layout/layout', $data);
    }

    public function streams_by_month($release_id, $month = 'all')
    {
        // $month = $this->input->get('month');

        $platforms = $this->AdminAlbum_model->get_platform_streams_by_month($release_id, $month);

        $datewise = $this->AdminAlbum_model->get_platform_datewise_streams($release_id, $month);

        // 🔹 NEW: trend data (all months)
        //   $trends = $this->AdminRelease_model->get_monthly_platform_trends($release_id);

        echo json_encode([
            'platforms' => $platforms,
            'datewise' => $datewise,
            //	 'trends' => $trends
        ]);
        exit;
    }




    public function update_isrc()
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $isrc = strtoupper(trim($this->input->post('isrc')));

        if (!preg_match('/^[A-Z]{2}[A-Z0-9]{3}\d{7}$/', $isrc)) {
            echo json_encode(array_merge([
                'status' => 'error',
                'message' => 'Invalid ISRC format'
            ], $this->csrf_response()));
            return;
        }

        $isrcInfo = $this->AdminAlbum_model->check_track_isrc($this->input->post('track_id'), $isrc);
        //echo $this->db->last_query();
        if ($isrcInfo) {
            echo json_encode(array_merge([
                'status' => 'error',
                'message' => 'This ISRC is already used by another track!'
            ], $this->csrf_response()));
            return;

        } else {

            $this->AdminAlbum_model->update_track_isrc($this->input->post('track_id'), $isrc);

            echo json_encode(array_merge([
                'status' => 'success',
                'message' => 'ISRC saved successfully'
            ], $this->csrf_response()));
        }
    }



    private function csrf_response()
    {
        return [
            'csrf' => [
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            ]
        ];
    }




    public function download_metadata($release_id)
    {

        $single = $this->AdminAlbum_model->get_track_full_metadata($release_id);

        if (!$single) {
            show_404();
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=track_' . $single->isrc . '_metadata.csv');

        $out = fopen('php://output', 'w');

        fputcsv($out, [
            'ISRC',
            'Title',
            'Primary Artist',
            'Album Name',
            'Album Genre',
            'Album Sub Genre',
            'Album label',
            'Album Language',
            'Explicit Content',
            'Streams',
            'Revenue',
            'Downloads',
            'Release Date'
        ]);

        fputcsv($out, [
            $single->isrc,
            $single->track_title,
            $single->artists,
            $single->album_title,
            $single->genre,
            $single->subgenre,
            $single->label,
            $single->language,
            $single->is_explicit,

            $single->total_streams,
            $single->total_revenue,
            $single->total_downloads,

            date('Y-m-d', strtotime($single->release_date))
        ]);

        fclose($out);
        exit;

    }




    public function export_track_zip($release_id)
    {
        $single = $this->AdminAlbum_model->get_track_full_metadata($release_id);

        if (!$single) {
            show_404();
        }

        $zip = new ZipArchive();
        $zipName = 'track_' . $single->isrc . '_export.zip';
        $zipPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipName;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            show_error('Could not create ZIP');
        }

        // Add audio
        $audioPath = FCPATH . ltrim($single->audio_file, '/');
        if (is_file($audioPath)) {
            $zip->addFile($audioPath, 'audio/' . basename($audioPath));
        }

        // Add artwork
        $artPath = FCPATH . ltrim($single->cover_art, '/');
        if (is_file($artPath)) {
            $zip->addFile($artPath, 'artwork/' . basename($artPath));
        }

        // Create metadata CSV in memory
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, [
            'ISRC',
            'Title',
            'Primary Artist',
            'Album Name',
            'Album Genre',
            'Album Sub Genre',
            'Album label',
            'Album Language',
            'Explicit Content',
            'Streams',
            'Revenue',
            'Downloads',
            'Release Date'
        ]);
        fputcsv($csv, [
            $single->isrc,
            $single->track_title,
            $single->artists,
            $single->album_title,
            $single->genre,
            $single->subgenre,
            $single->label,
            $single->language,
            $single->is_explicit,

            $single->total_streams,
            $single->total_revenue,
            $single->total_downloads,

            date('Y-m-d', strtotime($single->release_date))
        ]);
        rewind($csv);
        $zip->addFromString('metadata/metadata.csv', stream_get_contents($csv));
        fclose($csv);

        $zip->close();

        /* ---------- CRITICAL PART ---------- */

        // Clean ALL output buffers
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Send headers
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipName . '"');
        header('Content-Length: ' . filesize($zipPath));
        header('Pragma: public');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        // Output file
        readfile($zipPath);

        // Cleanup
        unlink($zipPath);
        exit;
    }


    public function download_template()
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="streaming_template.csv"');

        echo "ISRC,Platform,Streams,Revenue,Downloads,Date\n";
        echo "INABC1234567,spotify,12000,450.50,50,2025-01\n";
        exit;
    }




    public function upload_streaming_excel($album_id)
    {
        //	echo "1 <br>";
        if (empty($_FILES['excel_file']['tmp_name'])) {
            $this->session->set_flashdata('error', 'No file uploaded.');
            redirect('admin/albums/tracks/' . $album_id);
        }
        //echo "2 <br>";
        $allowed = ['csv', 'xlsx', 'xls'];
        $ext = strtolower(pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $this->session->set_flashdata('error', 'Unsupported file type.');
            redirect('admin/albums/tracks/' . $album_id);
        }
        //echo "3 <br>";
        try {

            $filePath = $_FILES['excel_file']['tmp_name'];

            $spreadsheet = IOFactory::load($filePath);
            $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Invalid Excel/CSV file.');
            redirect('admin/albums/tracks/' . $album_id);
        }

        //	echo "4 <br>";

        if (count($rows) < 2) {
            $this->session->set_flashdata('error', 'Excel file is empty.');
            redirect('admin/albums/tracks/' . $album_id);
        }

        //	echo "5 <br>";

        // 🔥 Remove header
        unset($rows[1]);

        $success = 0;
        $failed = 0;
        $errors = [];

        $this->db->trans_begin();

        foreach ($rows as $rowNum => $row) {

            // Column mapping (SAFE)
            $isrc = trim($row['A'] ?? '');
            $platform = strtolower(trim($row['B'] ?? ''));
            $streams = (int) ($row['C'] ?? 0);
            $revenue = (float) ($row['D'] ?? 0);
            $downloads = (int) ($row['E'] ?? 0);
            $monthRaw = trim($row['F'] ?? '');

            // Basic validation
            if (!$isrc || !$platform || !$monthRaw) {
                $failed++;
                $errors[] = "Row {$rowNum}: Missing ISRC / Platform / Month";
                continue;
            }

            //	echo "6 <br>";

            // Normalize month → YYYY-MM-01
            $timestamp = strtotime($monthRaw);
            if (!$timestamp) {
                $failed++;
                $errors[] = "Row {$rowNum}: Invalid month format";
                continue;
            }

            //	echo "7 <br>";

            $reportMonth = date('Y-m-d', $timestamp);

            // Track lookup
            $track = $this->AdminAlbum_model->get_track_by_isrc($isrc);
            if (!$track) {
                $failed++;
                $errors[] = "Row {$rowNum}: ISRC not found ({$isrc})";
                continue;
            }

            //	echo "8 <br>";

            //	echo "<pre>"; print_r($errors);

            // 🔁 Remove existing record (same track + platform + month)
            $checkDate = date('Y-m-d', strtotime($reportMonth));
            $checkPlateform = strtolower($platform);
            $trackStreams = $this->AdminAlbum_model->check_streaming_history_datewise($track->id, $checkPlateform, $checkDate);
            if (@$trackStreams->id) {
                //echo $trackStreams->id; 
                $this->db->where('track_id', $track->id);
                $this->db->where('isrc', $isrc);
                $this->db->where('report_month', $checkDate);
                $this->db->delete('album_track_streaming_history');
            }

            // Insert fresh data
            $this->AdminAlbum_model->insert_streaming_history([
                'track_id' => $track->id,
                'isrc' => $isrc,
                'platform' => $platform,
                'streams' => $streams,
                'downloads' => $downloads,
                'revenue' => $revenue,
                'report_month' => date('Y-m-d', strtotime($reportMonth))
            ]);

            // Update aggregate totals
            $this->AdminAlbum_model->recalculate_track_totals($track->id);

            $success++;
        }


        //echo "9 <br>";
        // 🔄 Commit / Rollback
        if ($failed > 0) {
            $this->db->trans_rollback();
            $this->session->set_flashdata(
                'error',
                "Upload failed. {$failed} invalid rows found."
            );
            $this->session->set_flashdata('upload_errors', $errors);
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata(
                'success',
                "Streaming data uploaded successfully ({$success} rows)."
            );
        }

        //	echo "10 <br>";
        redirect('admin/albums/tracks/' . $album_id);
    }




}
