<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

//require_once APPPATH . '../vendor/autoload.php';

//use Aws\S3\S3Client;
class AWSUploading extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('S3Uploader');
        $this->load->database();
    }

	

    public function index() {
		$this->load->view('aws-upload/form');
	
	}
	
	
	public function getArtworkUrl() {
        echo json_encode(
            $this->s3uploader->getPutUrl($_GET['file_name']) // correct
        );
    }

	public function getInvoicesUrl() {
        echo json_encode(
            $this->s3uploader->getPutInvoiceUrl($_GET['file_name']) // correct
        );
    }

    public function initiateMultipart__old() {
        echo json_encode(
            $this->s3uploader->initiateMultipart($_GET['file_name'])
        );
    }
	
	public function initiateMultipart() {

		header('Content-Type: application/json');

		$fileName = $this->input->get('file_name', true);

		if (!$fileName) {
			echo json_encode(['error' => 'Missing file_name']);
			return;
		}

		$res = $this->s3uploader->initiateMultipart($fileName);

		// if library returned error
		if (isset($res['error'])) {
			echo json_encode($res);
			return;
		}

		echo json_encode($res);
	}


	public function initiateMultipartAssets() {
		
		header('Content-Type: application/json');

		$fileName = $this->input->get('file_name', true);

		if (!$fileName) {
			echo json_encode(['error' => 'Missing file_name']);
			return;
		}

		$res = $this->s3uploader->initiateMultipartAssets($fileName);

		// if library returned error
		if (isset($res['error'])) {
			echo json_encode($res);
			return;
		}

		echo json_encode($res);
	}




    public function getChunkUploadUrl() {
        echo json_encode(
            $this->s3uploader->getChunkUrl(
                $_GET['key'],
                $_GET['uploadId'],
                $_GET['partNumber']
            )
        );
    }

    public function completeMultipart__old() {

        $input = json_decode(file_get_contents('php://input'), true);

        $url = $this->s3uploader->completeMultipart(
            $input['key'],
            $input['uploadId'],
            $input['parts']
        );

        echo json_encode(['file_url' => $url]);
    }
	
	public function completeMultipart() {

    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);

    // ✅ Debug (temporary)
    if (!$input) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid JSON',
            'raw' => $raw
        ]);
        return;
    }

    if (empty($input['key']) || empty($input['uploadId']) || empty($input['parts'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields',
            'input' => $input
        ]);
        return;
    }

    $result = $this->s3uploader->completeMultipart(
        $input['key'],
        $input['uploadId'],
        $input['parts']
    );

    echo json_encode($result);
}

    public function saveSong() {

        $data = json_decode(file_get_contents('php://input'), true);

        $this->db->insert('tbl_uploaded_files', [
            'file_url' => $data['artwork'],
            'audio_url' => $data['audio'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status'=>'ok']);
    }
	
	
    public function playSong__old() {
		$data['artwork'] = "https://kbotunecore.s3.ap-south-1.amazonaws.com/test-uploads/artwork/1777115561_Yebo-Offer.jpg";
		$data['audio'] = "https://kbotunecore.s3.ap-south-1.amazonaws.com/test-uploads/audio/1777115561_page-shuffle-transition-429869.mp3";
       $this->load->view('aws-upload/player',$data);
    }
	
	public function playSong1() {

   
		$artworkKey = "test-uploads/artwork/1777115561_Yebo-Offer.jpg";
		$audioKey   = "test-uploads/audio/1777115561_page-shuffle-transition-429869.mp3";

		$data['artwork'] = $this->s3uploader->getSignedGetUrl($artworkKey, 300);
		$data['audio']   = $this->s3uploader->getSignedGetUrl($audioKey, 300);

		$this->load->view('aws-upload/player', $data);
	}
	
	public function playSong() {

		$this->load->library('S3Uploader');

		$artworkKey = "uploads/artwork/1777279957_data-meter.png";
		$audioKey   = "uploads/audio/1777280178_1777275945_1777115561_page-shuffle-transition-429869.mp3";

		// 🔐 Generate signed URLs (valid for 5 minutes)
		$data['artwork'] = $this->s3uploader->getSignedGetUrl($artworkKey, 300);
		$data['audio']   = $this->s3uploader->getSignedGetUrl($audioKey, 300);

		$this->load->view('aws-upload/player', $data);
	}
	
	
	public function getSignedUrl(){
		$key = $this->input->post('key');
		
		$url = $this->s3uploader->getSignedGetUrl($key, 3600);

		echo json_encode([
			'url' => $url
		]);
	}
	
	public function getBulkSignedUrls1111(){
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    $keys = $input['keys'] ?? [];

    if (empty($keys)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No keys'
        ]);
        exit;
    }

    // fallback image
    $fallback = base_url('assets/img/no-image.jpg');

    $result = [];

    foreach ($keys as $key) {

        try {

            // invalid key
            if (empty($key)) {
                $result[$key] = $fallback;
                continue;
            }

            $signedUrl = $this->s3uploader->getSignedGetUrl($key, 3600);

            // if somehow empty response
            if (empty($signedUrl)) {
                $result[$key] = $fallback;
            } else {
                $result[$key] = $signedUrl;
            }

        } catch (Exception $e) {
            $result[$key] = $fallback;
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $result
    ]);

    exit;
}
	
	
	public function getBulkSignedUrls()
{
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    $keys = $input['keys'] ?? [];

    $fallback = base_url('assets/img/no-image.jpg');
    $result = [];

    foreach ($keys as $key) {

        try {

            if (empty($key)) {
                $result[$key] = $fallback;
                continue;
            }

            // CHECK OBJECT EXISTS FIRST
            if (!$this->s3uploader->objectExists($key)) {
                $result[$key] = $fallback;
                continue;
            }

            $result[$key] = $this->s3uploader->getSignedGetUrl($key, 3600);

        } catch (Exception $e) {
            $result[$key] = $fallback;
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $result
    ]);
    exit;
}
	
}