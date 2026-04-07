<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct() {
       parent::__construct();

        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }

        $this->load->model([
            'Bank_model',
            'Invoice_model'
        ]);

        $this->load->library(['upload', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

   
	
	public function index()
	{
		$user_id = $this->session->userdata('user_id');

		$data['bank'] = $this->Bank_model->get_by_user($user_id);

		// ✅ only last 30 days
		$data['invoices'] = $this->Invoice_model->get_last_30_days($user_id);

		$this->load->view('profile/index', $data);
	}


    public function update_bank()
    {
        $user_id = $this->session->userdata('user_id');

        $data = [
            'user_id'        => $user_id,
            'account_name'   => $this->input->post('account_name'),
            'account_number' => $this->input->post('account_number'),
            'ifsc'           => strtoupper($this->input->post('ifsc')),
            'bank_name'      => $this->input->post('bank_name'),
        ];

        $this->Bank_model->save($data);

        $this->session->set_flashdata('success', 'Bank details updated successfully');
        redirect('profile');
    }

    public function upload_invoice()
    {
        $user_id = $this->session->userdata('user_id');

        $config = [
            'upload_path'   => './uploads/invoices/',
            'allowed_types' => 'pdf|jpg|jpeg|png',
            'max_size'      => 5120,
            'encrypt_name'  => true
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('invoice_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('profile');
        }

        $file = $this->upload->data();

        $this->Invoice_model->insert([
            'user_id'   => $user_id,
            'title'     => $this->input->post('title'),
            'file_path' => 'uploads/invoices/' . $file['file_name']
        ]);

        $this->session->set_flashdata('success', 'Invoice uploaded successfully');
        redirect('profile');
    }
	
	
	
public function update_bank_ajax()
{
   /*  if (!$this->input->is_ajax_request()) {
        show_404();
    }
 */
    $user_id = $this->session->userdata('user_id');

    $data = [
        'user_id'        => $user_id,
        'account_name'   => $this->input->post('account_name'),
        'account_number' => $this->input->post('account_number'),
        'ifsc'           => strtoupper($this->input->post('ifsc')),
        'bank_name'      => $this->input->post('bank_name'),
    ];

    $this->Bank_model->save($data);

    echo json_encode([
        'status'     => 'success',
        'message'    => 'Bank details saved successfully',
        'csrf_hash'  => $this->security->get_csrf_hash()
    ]);
}



public function upload_invoice_ajax()
{
   // if (!$this->input->is_ajax_request()) show_404();

    $config = [
        'upload_path'   => './uploads/invoices/',
        'allowed_types' => 'pdf|jpg|jpeg|png',
        'max_size'      => 5120,
        'encrypt_name'  => true
    ];

    $this->upload->initialize($config);

    if (!$this->upload->do_upload('invoice_file')) {
        echo json_encode([
            'status' => 'error',
            'message' => strip_tags($this->upload->display_errors())
        ]);
        return;
    }

    $file = $this->upload->data();

   
	$this->Invoice_model->insert([
		'user_id'        => $this->session->userdata('user_id'),
		'title'          => $this->input->post('title'),
		'invoice_month'  => $this->input->post('invoice_month'),
		'file_path'      => 'uploads/invoices/' . $file['file_name']
	]);


	echo json_encode([
        'status'     => 'success',
        'message'    => 'Invoice uploaded successfully',
        'csrf_hash'  => $this->security->get_csrf_hash()
    ]);
}


public function delete_invoice()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        show_404();
    }

    $id = $this->input->post('id');
    $user_id = $this->session->userdata('user_id');

    if (!$id) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid invoice',
            'csrf_hash' => $this->security->get_csrf_hash()
        ]);
        return;
    }

    $invoice = $this->Invoice_model->get($id, $user_id);


	if ($invoice && $invoice->status === 'paid') {
		echo json_encode([
			'status' => 'error',
			'message' => 'Paid invoices cannot be deleted',
			'csrf_hash' => $this->security->get_csrf_hash()
		]);
		return;
	} else {

    if ($invoice) {
        $file = FCPATH . $invoice->file_path;
        if (file_exists($file)) {
            unlink($file);
        }
        $this->Invoice_model->delete($id);
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Invoice deleted successfully',
        'csrf_hash' => $this->security->get_csrf_hash()
    ]);
	
	}
}


}
