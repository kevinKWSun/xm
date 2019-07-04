<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wx_model extends CI_model {
	public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	
}