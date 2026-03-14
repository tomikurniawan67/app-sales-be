<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('JwtMiddleware');
        
        $this->middleware = new JwtMiddleware();
        $this->decoded_token = $this->middleware->validate_request();

        $this->load->model('User_model');
    }

    public function get_profile() {
        $this->output->set_content_type('application/json')->set_output(json_encode([
            'message' => 'OK',
            'user_data' => $this->decoded_token['data']
        ]));
    }

    public function get_data_sales() {
        $jwt = $this->decoded_token['data'];
        $employee_id = $jwt->employee_id;

        $data = $this->User_model->get_sales($employee_id);

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'message' => 'OK',
            'data' => $data
        ]));
    }
}