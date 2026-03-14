<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JwtMiddleware {
    public function __construct() {
        $CI =& get_instance();
        $CI->load->helper('jwt');
    }

    public function validate_request() {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            show_error('Unauthorized access', 401);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $decoded_token = validate_jwt($token);

        if (!$decoded_token) {
            show_error('Invalid or expired token', 401);
        }

        return $decoded_token;
    }
}