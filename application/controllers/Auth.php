<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->get_user_by_username($username);

        if ($user && (md5($password) == $user->password)) {
            $token = generate_jwt([
                'id' => $user->user_id, 
                'username' => $user->username, 
                'employee_name' => $user->employee_name,
                'employee_id' => $user->employee_id
            ]);
            $this->output->set_content_type('application/json')->set_output(json_encode(['token' => $token]));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode(['message' => 'Invalid credentials']));
        }
    }
}