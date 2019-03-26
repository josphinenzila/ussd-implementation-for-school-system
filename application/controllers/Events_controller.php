<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('events_model','event');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}

	public function index()
	{

      $this->load->model('group_model');
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
      $data['groups'] = $this->group_model->getAllGroups();
  
	  $this->load->helper('url');
	  $this->load->view('backend/secondary/events/events',$data);
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
			$row[] = '<input type="checkbox" class="data-check" value="'.$event->id.'">';
			$row[] = $event->event_name;
			$row[] = $event->event_details;
			$row[] = date("d/m/Y",strtotime($event->start_date));
			$row[] = date("d/m/Y",strtotime($event->end_date));
		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_event('."'".$event->id."'".')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_event('."'".$event->id."'".')"><i class="fa fa-trash-o"></i></a>';
		
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

    
	public function ajax_edit($id)
	{
		$data = $this->event->get_by_id($id);
		$data->start_date = ($data->start_date == '0000-00-00') ? '' : $data->start_date; // if 0000-00-00 set to empty for datepicker compatibility
		$data->end_date = ($data->end_date == '0000-00-00') ? '' : $data->end_date; // if 0000-00-00 set to empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		
		$data = array(
			
				'event_name' => $this->input->post('event_name'),
				'event_details' => $this->input->post('event_details'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'school_id'  => $this->session->userdata['logged_in']['school_id'], 
			    'date_posted' => date_create('now')->format('Y-m-d H:i:s'),
			);

		$insert = $this->event->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();

		//$startDate = date("Y-m-d",strtotime($this->input->post('start_date')));
        //$endDate = date("Y-m-d",strtotime($this->input->post('end_date')));

		$data = array(
				'event_name' => $this->input->post('event_name'),
				'event_details' => $this->input->post('event_details'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
			);
		$this->event->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->event->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->event->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('event_name') == '')
		{
			$data['inputerror'][] = 'event_name';
			$data['error_string'][] = 'Event name is required';
			$data['status'] = FALSE;
		}


		if($this->input->post('event_details') == '')
		{
			$data['inputerror'][] = 'event_details';
			$data['error_string'][] = 'Event details required';
			$data['status'] = FALSE;
		}

		if($this->input->post('start_date') == '')
		{
			$data['inputerror'][] = 'start_date';
			$data['error_string'][] = 'Start date required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	 public function clearEvents(){
        $this->db->where('school_id',$this->session->userdata['logged_in']['school_id']);
        $this->db->delete('upcoming_events');
        redirect(base_url().'events');

    }

   
   
}
