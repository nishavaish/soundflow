<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function login()
    {
        // If already logged in, redirect
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === TRUE) {
                $email    = $this->input->post('email', TRUE);
                $password = $this->input->post('password', TRUE);

                $user = $this->User_model->get_by_email($email);

                if ($user && $user->is_active && password_verify($password, $user->password_hash)) {
                    // Set session
                    $this->session->set_userdata([
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                        'logged_in' => TRUE
                    ]);

                    // update last login time
                    $this->User_model->update_last_login($user->id);

                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Invalid email or password.');
                    redirect('login');
                }
            }
        }

        $this->load->view('layouts/auth_header');
        $this->load->view('auth/login');
        $this->load->view('layouts/auth_footer');
    }

    public function register()
    {
        // If already logged in, redirect
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]', [
                'is_unique' => 'This email address is already registered.'
            ]);
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() === TRUE) {
                $name  = $this->input->post('name', TRUE);
                $email = $this->input->post('email', TRUE);
                $pass  = $this->input->post('password', TRUE);

                $user_data = [
                    'name'          => $name,
                    'email'         => $email,
                    'password_hash' => password_hash($pass, PASSWORD_BCRYPT),
                    'is_active'     => 1
                ];

                if ($this->User_model->create_user($user_data)) {
                    $this->session->set_flashdata('success', 'Registration successful! You can now login.');
                    redirect('login');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                    redirect('register');
                }
            }
        }

        $this->load->view('layouts/auth_header');
        $this->load->view('auth/register');
        $this->load->view('layouts/auth_footer');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
