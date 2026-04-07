
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/aws/aws.phar';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;



class Assets extends MY_Controller {

    public function __construct() {
        parent::__construct();
        // ensure logged in
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
		
		 $this->load->model('Assets_model');
    }



// *************************************************************************************************//
	// ************************************************************************************************//
	
	// ******************************************* S3 file upload starts  ******************************//
	
	
    public function uploadCustomFiles($fileName, $tmpPath) {
		//echo "<br><pre>"; print_r($_FILES); 
		//echo "<br><pre>"; print_r($tmpPath); 
		//echo "<br><pre>"; print_r($fileName); die;
		
		if(!empty($fileName) && !empty($tmpPath)){ 
		
			$objAwsS3Client = new S3Client([
				'version' => 'latest',
				'region' => AWS_ACCESS_REGION,
				'endpoint' => AWS_ACCESS_ENDPOINT,
				'credentials' => [
					'key' => AWS_ACCESS_KEY_ID,
					'secret' => AWS_ACCESS_KEY_SECRET
				]
			]);
       
            $fileName = $fileName;
            $fileTempName = $tmpPath;
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
			
			$new_image_name = md5(time() . $fileName) . '.' . $fileExtension;
            $newFileName = 'users-assets/' . $new_image_name;

            try {

                $fileMimeType = mime_content_type($fileTempName);

                // Define an array of allowed image and video mime types
               // $allowedMimeTypes = ['image/bmp', 'image/webp',  'image/gif', 'image/jpeg', 'image/jpg', 'image/png', 'image/png'];
                $allowedMimeTypes = [

    /* ================= IMAGES ================= */
    'image/jpeg','image/jpg', 'image/png', 'image/gif', 'image/webp','image/bmp','image/tiff','image/svg+xml','image/heic','image/heif',

    /* ================= AUDIO ================= */
    'audio/mpeg','audio/mp3','audio/wav','audio/x-wav','audio/wave','audio/flac','audio/x-flac','audio/aac','audio/ogg',
    'audio/opus','audio/x-ms-wma','audio/webm','audio/3gpp','audio/3gpp2','audio/mp4',   

    /* ================= VIDEO ================= */
    'video/mp4', 'video/mpeg',
    'video/quicktime',   // mov
    'video/x-msvideo',   // avi
    'video/x-ms-wmv', 'video/webm',
    'video/ogg', 'video/3gpp',
    'video/3gpp2', 'video/x-flv',
    'video/x-matroska',  // mkv
    'video/mp2t',        // ts
    'video/hevc','video/h265'
];

                if (in_array($fileMimeType, $allowedMimeTypes)) {
                    $objAwsS3Client->putObject([
                        'Bucket' => AWS_BUCKET_NAME,
                        'Key' => $newFileName,
                        //'SourceFile' => $fileName,
                        'Body' => fopen($fileTempName, 'r'),
                        'ACL' => 'public-read',
                        'ContentType' => $fileMimeType,
                        'Metadata' => [
                            'Content-Disposition' => 'inline'
                        ]
                    ]);
                }

                $image_file_name = AWS_ACCESS_URL . $newFileName;
                
                $image_details = [
                    'fileName' => $fileName,
                    'new_fileName' => $new_image_name,
                    'image_path' => $image_file_name
                ];
                
                return json_encode(['status'=> 'success', 'message'=> 'Image saved successfully!', 'image'=> $image_details]);
                
            }  catch (Aws\S3\Exception\S3Exception $e) {
                return json_encode(['status'=> 'error', 'message'=> 'Error! Image not saved.']);
            }
		}	
		
    }
    
	
	 
	public function deleteS3Files($filePath) {		
		if(!empty($filePath)){ 
			
			$fileName = basename($filePath); 
			$fileName = 'users-assets/'.$fileName;
			$objAwsS3Client = new S3Client([
				'version' => 'latest',
				'region' => AWS_ACCESS_REGION,
				'endpoint' => AWS_ACCESS_ENDPOINT,
				'credentials' => [
					'key' => AWS_ACCESS_KEY_ID,
					'secret' => AWS_ACCESS_KEY_SECRET
				]
			]);
       
			$response = array();
            try {
				 
				$objAwsS3Client->deleteObject([
					'Bucket' => AWS_BUCKET_NAME,
					'Key' => $fileName
				]);                

                $response = array(['status'=> 'success', 'message'=> 'Image deleted successfully!']);
                
            }  catch (Aws\S3\Exception\S3Exception $e) {
                $response = array(['status'=> 'error', 'message'=> 'Error! Image not deleted.']);
            }
			
			return  json_encode($response);
		}
    }
    
	
	
	// *******************************************  S3 file upload ends ******************************//
	
	// *************************************************************************************************//
	// ************************************************************************************************//
	

	
    public function index(){
			$this->load->view('user/asset_library');
	}
	
	
	public function library()
	{
		$user_id = $this->session->user_id;

		$data['storage_used'] = $this->Assets_model->get_storage_used($user_id);
		$data['projects'] = $this->Assets_model->get_projects_with_counts($user_id);

		$this->load->view('user/assets/library', $data);
	}

	public function project($id)
	{
		$user_id = $this->session->user_id;

		$data['project'] = $this->Assets_model->get_project($id, $user_id);
		$data['assets']  = $this->Assets_model->get_assets($id, $user_id);

		$this->load->view('user/assets/project_assets', $data);
	}

	public function create_project() {
	   //echo $this->session->user_id;

		$data = [
			'user_id'      => $this->session->user_id,
			'name'         => trim($this->input->post('name')),
			'project_type' => $this->input->post('project_type'),
			'genre'        => $this->input->post('genre'),
			'bpm'          => $this->input->post('bpm'),
			'musical_key'  => $this->input->post('musical_key'),
			'description'  => $this->input->post('description'),
			'status'       => $this->input->post('status'),
			'tags'         => $this->input->post('tags')
		];

		if (!$data['name']) {
			echo json_encode(['status'=>'error','message'=>'Project name required']);
			return;
		}

		$this->Assets_model->create_project($data);

		echo json_encode(['status'=>'success']);
	}


	public function upload_asset(){
		/* if (!$this->input->is_ajax_request()) {
			show_404();
		} */

		if (empty($_FILES['file']['name'])) {
			echo json_encode(['status'=>'error','message'=>'No file selected']);
			return;
		}
		
		$user_id    = $this->session->user_id;
		$project_id = $this->input->post('project_id');

		$newFileName = '';

		$fileName = $_FILES["file"]['name'];
		$tmpPath = $_FILES["file"]['tmp_name'];
		
		$responseJSON = $this->uploadCustomFiles($fileName, $tmpPath);
		//echo "<pre>"; print_r($responseJSON); die;
		
		$imageData =  json_decode($responseJSON, TRUE);
		//echo "<pre>"; print_r($imageData); die;
		
		$imageStatus = $imageData['status'];
		$imagePath = $imageData['image']['image_path'];
		
		if($imageStatus == 'success'){
			$newFileName = $imagePath;
			 $data = [
				'user_id'    => $user_id,
				'project_id' => $project_id,

				'asset_name' => $this->input->post('asset_name') ?: $_FILES['file']['name'],
				'asset_type' => $this->input->post('asset_type'),
				'version'    => $this->input->post('version'),
				'tags'       => $this->input->post('tags'),
				'credits'    => $this->input->post('credits'),
				'notes'      => $this->input->post('notes'),

				'file_path'  => $newFileName,
				'file_size'  => $_FILES['file']['size']
			];

			$this->Assets_model->insert_asset($data); 
			$this->session->set_flashdata('flash_success', 'Asset uploaded successfully!');

			echo json_encode(['status'=>'success']);
			
		} else {
			$this->session->set_flashdata('flash_error', 'Unable to upload asset file!');

			 echo json_encode(['status'=>'error', 'message'=>'Unable to upload selected file!']);
			 return;
		}
	}

  
    public function uploadImage() {
        $this->load->view('upload_image');	
    }
    
    public function uploadFileS3() {
	
	require_once FCPATH . 'vendor/autoload.php';

		echo "1";
       /*  $objAwsS3Client = new S3Client([
            'version' => 'latest',
            'region' => AWS_ACCESS_REGION,
            'endpoint' => 'https://blr1.digitaloceanspaces.com',
            'credentials' => [
                'key' => AWS_ACCESS_KEY_ID,
                'secret' => AWS_ACCESS_KEY_SECRET
            ]
        ]);
		 */
		
		$objAwsS3Client = new S3Client([
			'version' => 'latest',
			'region' => AWS_ACCESS_REGION,
			'endpoint' => AWS_ACCESS_ENDPOINT,
			'credentials' => [
				'key' => AWS_ACCESS_KEY_ID,
				'secret' => AWS_ACCESS_KEY_SECRET
			]
		]);
       
		
		
        //echo "<pre>"; print_r($objAwsS3Client); //die;
        
		//echo "<br> 2 <br>";
        //echo "<pre>"; print_r($_FILES); die;

        //if (isset($_POST['Submit']) && $_POST['Submit'] == 'Upload') {
        if (isset($_FILES['upload_image'])) { 
           // echo "<pre>"; print_r($_FILES); echo "<br>";
            
            $fileName = $_FILES["upload_image"]['name'];
            $fileTempName = $_FILES["upload_image"]['tmp_name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            
            //$userId = $_POST['user_id'];

            // sanitize file-name
            $new_image_name = md5(time() . $fileName) . '.' . $fileExtension;
            $newFileName = 'users-assets/' . $new_image_name;

            //echo "<pre>"; print_r($newFileName); die();

            //try {

                $fileMimeType = mime_content_type($fileTempName);

                // Define an array of allowed image and video mime types
                $allowedMimeTypes = [
                    'image/bmp',
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                    // Add more mime types here if needed
                ];
                
                //echo $fileMimeType."<pre>"; print_r($allowedMimeTypes); die;
                //echo $newFileName; die;
                
                if (in_array($fileMimeType, $allowedMimeTypes)) {
                    $objAwsS3Client->putObject([
                        'Bucket' => AWS_BUCKET_NAME,
                        'Key' => $newFileName,
                        //'SourceFile' => $fileName,
                        'Body' => fopen($fileTempName, 'r'),
                        'ACL' => 'public-read',
                        'ContentType' => $fileMimeType,
                        'Metadata' => [ 'Content-Disposition' => 'inline' ]
                    ]);
                }

				// $image_file_name = "https://pmysm.blr1.cdn.digitaloceanspaces.com/" . $newFileName;
                $image_file_name = AWS_ACCESS_URL . $newFileName;
				  
                $image_details = [
                    'fileName' => $fileName,
                    'new_fileName' => $new_image_name,
                    'video_path' => $image_file_name
                ];
                
                echo json_encode(['status'=> 'success', 'message'=> 'Image saved successfully!', 'image'=> $image_details]);
            /*    
            } 
            catch (Aws\S3\Exception\S3Exception $e) {
                echo json_encode(['status'=> 'error', 'message'=> 'Error! Video not saved.']);
            }*/
        }
    }
    
	
	public function update_asset()
	{
		if (!$this->session->userdata('user_id')) {
			echo json_encode(['status'=>'error','message'=>'Unauthorized']);
			return;
		}

		$id = $this->input->post('id');

		$data = [
			'asset_name' => $this->input->post('asset_name'),
			'asset_type' => $this->input->post('asset_type'),
			'version'    => $this->input->post('version'),
			'tags'       => $this->input->post('tags'),
			'credits'    => $this->input->post('credits'),
			'notes'      => $this->input->post('notes'),
		];

		$this->Assets_model->update_asset($id, $this->session->user_id, $data);
		$this->session->set_flashdata('flash_success', 'Asset data updated successfully!');

		echo json_encode(['status'=>'success']);
	}


	public function delete_asset__old()
	{
		header('Content-Type: application/json');

		$input = json_decode(file_get_contents('php://input'), true);
		$id = $input['id'] ?? null;

		$asset = $this->Assets_model->get_asset($id, $this->session->user_id);
		if (!$asset) {
			echo json_encode(['status'=>'error','message'=>'Not found']);
			return;
		}

		// delete from S3
		$deleteRes = $this->deleteS3Files($asset->file_path);
		
		if($deleteRes['status'] == 'success')  {
			$this->Assets_model->delete_asset($id, $this->session->user_id);
			$this->session->set_flashdata('flash_success', 'Asset data deleted successfully!');

			echo json_encode(['status'=>'success']);
		} else {
		
			$this->session->set_flashdata('flash_error', 'Unable to delete the asset!');

			echo json_encode(['status'=>'error']);
		}
	}



public function delete_asset()
{
    header('Content-Type: application/json');

    if (!$this->session->userdata('user_id')) {
        echo json_encode(['status'=>'error','message'=>'Unauthorized']);
        return;
    }

    $id = $this->input->post('id');

    if (!$id) {
        echo json_encode(['status'=>'error','message'=>'Invalid request']);
        return;
    }

    $asset = $this->Assets_model->get_asset($id, $this->session->userdata('user_id'));
    if (!$asset) {
        echo json_encode(['status'=>'error','message'=>'Asset not found']);
        return;
    }

    // delete from S3 (already working in your app)
    $this->deleteS3Files($asset->file_path);
	$this->Assets_model->delete_asset($id, $this->session->userdata('user_id'));
	$this->session->set_flashdata('flash_success', 'Asset deleted successfully');
	echo json_encode(['status'=>'success']);
	
}

	
}
?>