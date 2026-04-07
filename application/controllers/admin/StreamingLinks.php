<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/admin/AdminBase.php');

class StreamingLinks extends AdminBase {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/AdminStreamingLink_model');
		 $this->load->config('streaming_platforms');
    }

    public function manage($type, $id)
    {
        $data['title'] = 'Streaming Links';
        $data['type']  = $type;
        $data['id']    = $id;
        $data['links'] = $this->AdminStreamingLink_model->get_links($type, $id);
		
		if($type=='single')
			$data['release'] = $this->AdminStreamingLink_model->get_release($id);
		else 
			$data['release'] = $this->AdminStreamingLink_model->get_album_track($id);
		
		$data['platforms']    = $this->config->item('streaming_platforms');
		$data['view']  = 'admin/streaming_links/manage';

		//echo "<pre>"; print_r($data); die;
        $this->load->view('admin/layout/layout', $data);
    }

    public function add()
    {
		$type = $this->input->post('content_type');
		$id = $this->input->post('content_id');
		$platform = $this->input->post('platform');
		
		
         $checkLinkExist = $this->AdminStreamingLink_model->check_link_by_platform($type, $id, $platform);
	 //  echo $this->db->last_query();
		//die;
		if($checkLinkExist){
			 $this->session->set_flashdata( 'error',  "Streaming link already added!.");
		} else {
			$this->AdminStreamingLink_model->add_link([
				'content_type' => $this->input->post('content_type'),
				'content_id'   => $this->input->post('content_id'),
				'platform'     => $this->input->post('platform'),
				'url'          => $this->input->post('url'),
			]);
		}

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->AdminStreamingLink_model->delete_link($id);
        echo json_encode(['success' => true]);
    }

    public function toggle($id)
    {
        $this->AdminStreamingLink_model->toggle($id);
        echo json_encode(['success' => true]);
    }
}
