<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bug_controller extends CI_Controller {
	function __Construct(){
    parent::__Construct();
    $this->load->helper(array('form', 'url','string'));
    $this->load->library(array('session', 'form_validation', 'email')); 
    $this->load->database();
    $this->load->model('user_model');
    }  


	public function index()
	{
		// $data['username'] = $session_data['username'];
		$data['title'] = 'USSD Schools';
		$this->load->helper('url');
		$this->load->view('backend/secondary/feedback/bug_report/bugs',$data);
	}

	function sendmail()
	{

    $this->form_validation->set_rules('textInput', 'Message', 'required');

     if ($this->form_validation->run() == FALSE) {
           $this->load->view('backend/secondary/feedback/bug_report/bugs');
        }

    else {
    $school=$this->session->userdata['logged_in']['school_name'];
    $text = $_POST['textInput'];
    
    $message = "<html><head><head></head><body><p>Hi WIRETECH,</p><p>".$text." </p>
    <p>Sincerely,</p><p>".$school."</p></body></html>";

    $this->load->library('email'); // load email library
    $this->email->from('simplebasil@gmail.com', $school);
    $this->email->to('basilndonga@gmail.com');
    $this->email->cc('info@wiretechsystems.co.ke'); 
    $this->email->subject('BUG REPORT');
    $this->email->message($message);
    //$this->email->attach('/path/to/file1.png'); // attach file
    // $this->email->attach('/path/to/file2.pdf');
    if ($this->email->send()){
        $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Email sent successfully.We will get back to you as soon as possible</div>'); 
            redirect(base_url().'Bugs');
    }
    else{
        $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Email not sent successfully.Check your internet connection</div>');
            redirect(base_url().'Bugs'); 
		}

	}

  }

}
