<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_controller_main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('events_model_main','event');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}


	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->event->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $event) {
			$no++;
			$row = array();
			
			$row[] = $event->event_name;
			
			$row[] = date("d/m/Y",strtotime($event->start_date));
			$row[] = date("d/m/Y",strtotime($event->end_date));
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->event->count_all(),
						"recordsFiltered" => $this->event->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    
	
   
   
}
