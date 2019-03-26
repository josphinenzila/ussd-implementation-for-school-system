<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors404 extends CI_Controller {
	public function __construct() 
    {
        parent::__construct(); 
    } 



	public function index()
	{
		
        $this->output->set_status_header('404'); 
        $data['content'] = 'error_404'; // View name e'];
		$data['title'] = 'Error';

		$this->load->helper('url');
		$this->load->view('backend/secondary/errors/404/Error',$data);
	}

	


}
