<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/admin/AdminBase.php');

require_once APPPATH . 'third_party/phpspreadsheet_autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Releases extends AdminBase {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/AdminRelease_model');
    }

    public function index()
    {
        $q = $this->input->get('q');

        $data['title'] = 'Singles';
        $data['releases'] = $this->AdminRelease_model->get_releases($q);
        $data['view'] = 'admin/releases/list';

        $this->load->view('admin/layout/layout', $data);
    }

    public function delete($id)
    {
        $this->AdminRelease_model->delete_release($id);
        echo json_encode(['success' => true]);
    }
	
	
	public function toggle($id)
    {
        $this->AdminRelease_model->toggle($id);
        echo json_encode(['success' => true]);
    }
	
	
	
	
	public function upload_excel()
{
    if (empty($_FILES['excel_file']['name'])) {
        $this->session->set_flashdata('error', 'No file selected');
        redirect('admin/releases');
    }

   
    $file = $_FILES['excel_file']['tmp_name'];
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet()->toArray();

    // Remove header row
    unset($sheet[0]);

    foreach ($sheet as $row) {
        $isrc    = trim($row[0]);
        $streams = (int)$row[1];
        $revenue = (float)$row[2];

        if (!$isrc) continue;

        $this->AdminRelease_model->update_streaming_by_isrc(
            $isrc,
            $streams,
            $revenue
        );
    }

    $this->session->set_flashdata('success', 'Streaming data uploaded successfully');
    redirect('admin/releases');
}

public function download_template()
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="streaming_template.csv"');

    echo "ISRC,Platform,Streams,Revenue,Downloads,Date\n";
    echo "INABC1234567,spotify,12000,450.50,50,2025-01\n";
    exit;
}


public function upload_streaming_excel__old()
{
   
$sheet = IOFactory::load($_FILES['excel_file']['tmp_name']);


    $this->db->trans_begin(); // 🔥 rollback safety

    $file = $_FILES['excel_file']['tmp_name'];
    $sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file)
             ->getActiveSheet()->toArray();

    unset($sheet[0]); // remove header

    $success = 0;
    $failed  = 0;

    foreach ($sheet as $row) {
        [$isrc, $platform, $streams, $revenue,  $downloads, $month] = $row;

        if (!$isrc || !$platform || !$month) {
            $failed++;
            continue;
        }

        $track = $this->AdminRelease_model->get_track_by_isrc($isrc);
        if (!$track) {
            $failed++;
            continue;
        }
		
		
		$checkDate = date('Y-m-d', strtotime($month));
		$checkPlateform =  strtolower($platform);
        $trackStreams = $this->AdminRelease_model->check_streaming_history_datewise($track->id, $checkPlateform,  $checkDate) ;
		if(@$trackStreams->id){
			//echo $trackStreams->id; 
				$this->db->where('track_id', $track->id);
				$this->db->where('isrc', $isrc);
				$this->db->where('report_month', $checkDate);
				$this->db->delete('track_streaming_history');
		}
		
        $this->AdminRelease_model->insert_streaming_history([
            'track_id' => $track->id,
            'isrc'     => $isrc,
            'platform' => strtolower($platform),
            'streams'  => (int)$streams,
            'revenue'  => (float)$revenue,
            'downloads'  => (int)$downloads,
         
            'report_month' => date('Y-m-d', strtotime($month))
        ]);

		
        $this->AdminRelease_model->recalculate_track_totals($track->id);
        $success++;
    }

    if ($failed > 0) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('error', 'Upload failed. Invalid rows found.');
    } else {
        $this->db->trans_commit();
        $this->session->set_flashdata('success', 'Streaming data uploaded successfully.');
    }

    redirect('admin/releases');
}


public function upload_streaming_excel()
{
    if (empty($_FILES['excel_file']['tmp_name'])) {
        $this->session->set_flashdata('error', 'No file uploaded.');
        redirect('admin/releases');
    }

	$allowed = ['csv', 'xlsx', 'xls'];
		$ext = strtolower(pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION));

		if (!in_array($ext, $allowed)) {
			$this->session->set_flashdata('error', 'Unsupported file type.');
			redirect('admin/releases');
		}

    try {
		
        $filePath = $_FILES['excel_file']['tmp_name'];

        $spreadsheet = IOFactory::load($filePath);
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    } catch (Exception $e) {
        $this->session->set_flashdata('error', 'Invalid Excel/CSV file.');
        redirect('admin/releases');
    }

    if (count($rows) < 2) {
        $this->session->set_flashdata('error', 'Excel file is empty.');
        redirect('admin/releases');
    }

    // 🔥 Remove header
    unset($rows[1]);

    $success = 0;
    $failed  = 0;
    $errors  = [];

    $this->db->trans_begin();

    foreach ($rows as $rowNum => $row) {

        // Column mapping (SAFE)
        $isrc      = trim($row['A'] ?? '');
        $platform  = strtolower(trim($row['B'] ?? ''));
        $streams   = (int)($row['C'] ?? 0);
        $revenue   = (float)($row['D'] ?? 0);
        $downloads = (int)($row['E'] ?? 0);
        $monthRaw  = trim($row['F'] ?? '');

        // Basic validation
        if (!$isrc || !$platform || !$monthRaw) {
            $failed++;
            $errors[] = "Row {$rowNum}: Missing ISRC / Platform / Month";
            continue;
        }

        // Normalize month → YYYY-MM-01
        $timestamp = strtotime($monthRaw);
        if (!$timestamp) {
            $failed++;
            $errors[] = "Row {$rowNum}: Invalid month format";
            continue;
        }

        $reportMonth = date('Y-m-d', $timestamp);

        // Track lookup
        $track = $this->AdminRelease_model->get_track_by_isrc($isrc);
        if (!$track) {
            $failed++;
            $errors[] = "Row {$rowNum}: ISRC not found ({$isrc})";
            continue;
        }

        // 🔁 Remove existing record (same track + platform + month)
        $checkDate = date('Y-m-d', strtotime($reportMonth));
		$checkPlateform =  strtolower($platform);
        $trackStreams = $this->AdminRelease_model->check_streaming_history_datewise($track->id, $checkPlateform,  $checkDate) ;
		if(@$trackStreams->id){
			//echo $trackStreams->id; 
				$this->db->where('track_id', $track->id);
				$this->db->where('isrc', $isrc);
				$this->db->where('report_month', $checkDate);
				$this->db->delete('track_streaming_history');
		}

        // Insert fresh data
        $this->AdminRelease_model->insert_streaming_history([
            'track_id'     => $track->id,
            'isrc'         => $isrc,
            'platform'     => $platform,
            'streams'      => $streams,
            'downloads'    => $downloads,
            'revenue'      => $revenue,
            'report_month' => date('Y-m-d', strtotime($reportMonth))
        ]);

        // Update aggregate totals
        $this->AdminRelease_model->recalculate_track_totals($track->id);

        $success++;
    }

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

    redirect('admin/releases');
}



public function monthly_revenue_data()
{
    $data = $this->AdminRelease_model->get_monthly_revenue();
    echo json_encode($data);
}




public function download_single_metadata($release_id)
{
	
    $single = $this->AdminRelease_model->get_single_full_metadata($release_id);
	
    if (!$single) {
        show_404();
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=single_'.$single->isrc.'_metadata.csv');

    $out = fopen('php://output', 'w');

    fputcsv($out, [
		'ISRC',
        'Title',
        'Primary Artist',
        'Featuring Artist',        
        'Genre',
        'Sub Genre',
        'Language',
        'Explicit Content',
        'Lyrics',
        'Lyrics Language',
		'Explicit Lyrics',      
        'Streams',
        'Revenue',
        'Downloads',
		'Release Date'
    ]);

    fputcsv($out, [
        $single->isrc,
        $single->title,
        $single->primary_artist,
        $single->featuring,
        $single->genre,
        $single->subgenre,
        $single->language,
        $single->explicit_content,
        $single->lyrics,
        $single->lyrics_language,
        $single->explicit_lyrics,
        $single->stream_count,
        $single->revenue,
        $single->download_count,
        date('Y-m-d', strtotime($single->release_date))
    ]);

    fclose($out);
    exit;
	
}




public function export_single_zip($release_id)
{
    $single = $this->AdminRelease_model->get_single_full_metadata($release_id);

    if (!$single) {
        show_404();
    }

    $zip = new ZipArchive();
    $zipName = 'single_' . $single->isrc . '_export.zip';
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
    $artPath = FCPATH . ltrim($single->file_path, '/');
    if (is_file($artPath)) {
        $zip->addFile($artPath, 'artwork/' . basename($artPath));
    }

    // Create metadata CSV in memory
    $csv = fopen('php://temp', 'r+');
    fputcsv($csv, [
       'ISRC',
        'Title',
        'Primary Artist',
        'Featuring Artist',        
        'Genre',
        'Sub Genre',
        'Language',
        'Explicit Content',
        'Lyrics',
        'Lyrics Language',
		'Explicit Lyrics',      
        'Streams',
        'Revenue',
        'Downloads',
		'Release Date'
    ]);
    fputcsv($csv, [
         $single->isrc,
        $single->title,
        $single->primary_artist,
        $single->featuring,
        $single->genre,
        $single->subgenre,
        $single->language,
        $single->explicit_content,
        $single->lyrics,
        $single->lyrics_language,
        $single->explicit_lyrics,
        $single->stream_count,
        $single->revenue,
        $single->download_count,
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



public function streams($release_id)
{
    $data['single'] = $this->AdminRelease_model->get_single_basic($release_id);
    if (!$data['single']) {
        show_404();
    }

	$data['title'] = 'Singles Streams';
	$data['release_id'] = $release_id;
    $data['platforms'] = $this->AdminRelease_model->get_platform_wise_streams($release_id);
	$data['datewise'] = $this->AdminRelease_model->get_platform_datewise_streams($release_id);
	$data['months'] = $this->AdminRelease_model->get_available_months($release_id);

    $data['view'] = 'admin/releases/streams';

    // echo "<pre>";
    // print_r($data);
    // die();
	
	$this->load->view('admin/layout/layout', $data);
}


public function streams_by_month($release_id, $month='all')
{
   // $month = $this->input->get('month');

    $platforms  = $this->AdminRelease_model->get_platform_streams_by_month($release_id, $month);
	
    $datewise = $this->AdminRelease_model->get_platform_datewise_streams($release_id, $month);
	
	  // 🔹 NEW: trend data (all months)
   //   $trends = $this->AdminRelease_model->get_monthly_platform_trends($release_id);

    echo json_encode([
        'platforms' => $platforms,
        'datewise'  => $datewise,
	//	 'trends' => $trends
    ]);
    exit;
}


public function save_isrc()
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

	 $isrcInfo = $this->AdminRelease_model->check_track_isrc(  $this->input->post('track_id'),  $isrc  );
	//echo $this->db->last_query();
	if($isrcInfo){
		 echo json_encode(array_merge([
            'status' => 'error',
            'message' => 'This ISRC is already used by another track!'
        ], $this->csrf_response()));
        return;
		
	} else {

		$this->AdminRelease_model->update_track_isrc(
			$this->input->post('track_id'),
			$isrc
		);

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



}
?>