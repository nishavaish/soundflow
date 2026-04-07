<?php
class Plans extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Plan_model');
    }
	
	public function index()
	{
		$this->load->library('pagination');

		$q = $this->input->get('q');
		$config['base_url'] = site_url('admin/plans/index');
		$config['total_rows'] = $this->Plan_model->count_plans($q);
		$config['per_page'] = 10;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'per_page';

		$this->pagination->initialize($config);

		$page = $this->input->get('per_page') ?? 0;

		$data['plans'] = $this->Plan_model->get_plans($config['per_page'], $page, $q);
		$data['pagination'] = $this->pagination->create_links();
		$data['view'] = 'admin/plans/list';

		$this->load->view('admin/layout/layout', $data);
	}

    public function create(){
        if($this->input->post()){
            $data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'duration' => $this->input->post('duration')
            ];

            $features = $this->input->post('features'); // array

            $this->Plan_model->insert_plan($data, $features);

            redirect('admin/plans');
        }

         $data['view'] = 'admin/plans/form';
		$this->load->view('admin/layout/layout', $data);
    }

	public function edit($id)
	{
		$this->load->model('Plan_model');

		if ($this->input->post()) {

			$data = [
				'name'     => $this->input->post('name'),
				'price'    => $this->input->post('price'),
				'duration' => $this->input->post('duration'),
				'status'   => $this->input->post('status')
			];

			$features = $this->input->post('features');

			// update plan
			$this->Plan_model->update_plan($id, $data, $features);

			$this->session->set_flashdata('success', 'Plan updated successfully');

			redirect('admin/plans');
		}

		// load existing data
		$data['plan']  = $this->Plan_model->get_plan($id);
		$data['title'] = 'Edit Plan';
		$data['view']  = 'admin/plans/form';

		$this->load->view('admin/layout/layout', $data);
	}

  /*   public function delete($id){
        $this->Plan_model->delete_plan($id);
        redirect('plans');
    }
	 */
	
	public function delete($id){
		$this->Plan_model->delete_plan($id);

		echo json_encode(['status' => 'success']);
		exit; // ✅ VERY IMPORTANT
	}
	
	public function toggle_status(){
		$id = $this->input->post('id');

		$plan = $this->db->get_where('plans', ['id'=>$id])->row();

		if(!$plan){
			echo json_encode(['status'=>'error']);
			exit;
		}

		$new_status = ($plan->status == 'active') ? 'inactive' : 'active';

		$this->db->where('id', $id)->update('plans', ['status'=>$new_status]);

		echo json_encode([
			'status' => 'success',
			'new_status' => $new_status
		]);
		exit; // ✅ IMPORTANT
	}
	
}

?>