<?php
	
	class Admin_model extends CI_Model {

    public function login($email, $password)
    {
        $admin = $this->db
            ->where('email', $email)
            ->get('admins')
            ->row();

        if ($admin && password_verify($password, $admin->password)) {
            return $admin;
        }
        return false;
    }
}


?>