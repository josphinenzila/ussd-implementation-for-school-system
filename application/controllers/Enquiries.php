<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enquiries extends CI_Controller {
	function __Construct(){
    parent::__Construct();
    $this->load->helper(array('form', 'url','string'));
    $this->load->library(array('session', 'form_validation', 'email')); 
   
 
    }  
    
	public function sendmail()
	{
	
    $this->form_validation->set_rules('firstname', 'First Name', 'required');
    $this->form_validation->set_rules('lastname', 'Last Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('subject', 'Subject', 'required');
    $this->form_validation->set_rules('message', 'Message', 'required');

     if ($this->form_validation->run() == FALSE) {
           $this->load->view('frontend/contacts');
        }

    else {
     $firstname = $this->input->post('firstname');
     $lastname = $this->input->post('lastname');
     $email = $this->input->post('email');
     $subject =$this->input->post('subject');
     $text = $this->input->post('message');
     

     $body  = "<html><head><head></head><body><p>Hi WIRETECH,</p><p>".$text." </p>
              <p>Sincerely,</p><p>".ucfirst($firstname)."</p>
              <p>".$email."</p>
              
              </body></html>";
     
     $this->load->library('email');
     $this->email->from('info@wiretechsystems.co.ke', 'ENQUIRIES');
     $this->email->to('basilndonga@gmail.com'); //change it
     $this->email->subject($subject);
     $this->email->message($body);

    
    if ($this->email->send()){

         $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Email Successfully sent.We will contact you as soon as possible!</div>');
         redirect(base_url().'contacts');
    }
    else{
        $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Email not sent.Please check your internet connection and try again!</div>');
           redirect(base_url().'contacts');
        }

    }

	}

	

}
