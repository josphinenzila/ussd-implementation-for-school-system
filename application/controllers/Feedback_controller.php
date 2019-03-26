<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
    $this->load->model('sms_model');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
		require_once APPPATH."third_party/vendor/autoload.php";
	}

	public function index()
	{

      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
	  $this->load->view('backend/secondary/feedback/messages/messages');
	}

   public function sendFeedback(){

    $this->form_validation->set_rules('textInput', 'Text Message', 'required');

     
     if ($this->form_validation->run() == FALSE)
        {

      	$data['school_name']=$this->session->userdata('school_name');
      	$data['school_id']=$this->session->userdata('school_id');
      	$data['logo']=$this->session->userdata('logo');
        $this->load->view('backend/secondary/feedback/messages/messages');
        }

     if (!isset($_POST['toInput'])) {

        $school=$this->session->userdata['logged_in']['school_name'];
        $text = $_POST['textInput'];
        $message = "<html><head><head></head><body><p>Hi WIRETECH,</p><p>".$text." </p>
        <p>Sincerely,</p><p>".$school."</p></body></html>";

        $this->load->library('email'); // load email library
        $this->email->from('info@wiretechsystems.co.ke', $school);
        $this->email->to('basilndonga@gmail.com');
        $this->email->cc('info@wiretechsystems.co.ke'); 
        $this->email->subject('SCHOOL ENQUIRIES');
        $this->email->message($message);
        //$this->email->attach('/path/to/file1.png'); // attach file
        // $this->email->attach('/path/to/file2.pdf');
        $this->email->send();
        
       // $to = $_POST['toInput'];
        $contact = '254728986084';
        $phone = explode(',',$contact);
        foreach($phone as $to){

        //$contact = explode("\n", $_POST['toInput']); // explode textarea on a line break into an array
        // $to = implode(",", $contact); // take each of the emails and implode together with the ,
        if ($to <> '') {
            $from = 'WIRETECH';
            $text = $_POST['textInput']."\nSent by ".$school;
           
            $messageId = "MESSAGE-ID-".time();
            $notifyUrl = "http://www.wiretechsystems.co.ke/sms/advanced";
            $notifyContentType = "application/json";
            $callbackData = "DLR callback data";

            $username = "WireTech";
            $password="h@cktivist1";

            //$username = "WireTech";
            //$password="h@cktivist1";

            $postUrl = "https://api.infobip.com/sms/1/text/advanced";

            // creating an object for sending SMS
            $destination = array("messageId" => $messageId,
                "to" => $to);

            $message = array("from" => $from,
                "destinations" => array($destination),
                "text" => $text,
                "notifyUrl" => $notifyUrl,
                "notifyContentType" => $notifyContentType,
                "callbackData" => $callbackData);

            $postData = array("messages" => array($message));
            $postDataJson = json_encode($postData);

            /**
            cURL stand for Client URL. cURL is a library to transfer data via various protocol like http, ftp, tftp etc. By using cURL we can send HTTP request using various method like GET, POST etc

            There are four main steps:
                Initialize
                Set Options
                Execute and Fetch Result
                Free up the cURL handle
                **/
           
            // 1. initialize
            $ch = curl_init();
            $header = array("Content-Type:application/json", "Accept:application/json");

            // 2. set the options, including the url
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

             //Setting option to transfer data as a string.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // response of the POST request
            // 3. execute and fetch the resulting HTML output
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $responseBody = json_decode($response);

            // 4. free up the curl handle
            curl_close($ch);


            if ($httpCode >= 200 && $httpCode < 300) {
                
                 $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Message successfully sent</div>');
                  	 redirect(base_url().'Feedback','refresh');

                }
                else {
                
                     $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Not sent. Check sender ID</div>'); 
                      redirect(base_url().'Feedback','refresh');
                
               }

        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Enter phone Number</div>');
             redirect(base_url().'Feedback','refresh');
               
        }

        }
    }
      
      
}

    	
}
