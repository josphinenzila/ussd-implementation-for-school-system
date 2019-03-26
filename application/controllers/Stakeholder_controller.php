<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stakeholder_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('stakeholder_model','person');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}

	public function index()
	{
      $this->load->model('roles_model','roles');
      $this->load->model('stakeholder_model','stakeholders');
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
      $data['groups'] = $this->stakeholders->getAllGroups();
      $data['roles'] = $this->roles->getAllRoles();
  
	  $this->load->helper('url');
	  $this->load->view('backend/secondary/admissions/stakeholders/Stakeholders',$data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->person->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" class="data-check" value="'.$person->id.'">';
			$row[] = $person->name;
			$row[] = $person->category;
			$row[] = $person->role;
			$row[] = $person->phone1;
			$row[] = $person->phone2;
		


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_person('."'".$person->id."'".')"><i class="fa fa-trash-o"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(),
						"recordsFiltered" => $this->person->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    
	public function ajax_edit($id)
	{
		$data = $this->person->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		
		$data = array(
				'name' => $this->input->post('name'),
				'category' => $this->input->post('category'),
				'role' => $this->input->post('role'),
				'phone1' => $this->input->post('phone1'),
				'phone2' => $this->input->post('phone2'),
				'school_id'  => $this->session->userdata['logged_in']['school_id'], 
			    'date_posted' => date_create('now')->format('Y-m-d H:i:s'),
			);

		$insert = $this->person->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'name' => $this->input->post('name'),
				'category' => $this->input->post('category'),
				'role' => $this->input->post('role'),
				'phone1' => $this->input->post('phone1'),
				'phone2' => $this->input->post('phone2'),
			);
		$this->person->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->person->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->person->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('category') == '')
		{
			$data['inputerror'][] = 'category';
			$data['error_string'][] = 'Please select Category';
			$data['status'] = FALSE;
		}

		if($this->input->post('role') == '')
		{
			$data['inputerror'][] = 'role';
			$data['error_string'][] = 'Role is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('phone1') == '')
		{
			$data['inputerror'][] = 'phone1';
			$data['error_string'][] = 'Primary phone is required';
			$data['status'] = FALSE;
		}

        /**
		if($this->input->post('phone2') == '')
		{
			$data['inputerror'][] = 'phone2';
			$data['error_string'][] = 'Secondary phone is required';
			$data['status'] = FALSE;
		}
		**/


		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	 public function clearStakeholders(){
        $this->db->where('school_id',$this->session->userdata['logged_in']['school_id']);
        $this->db->delete('stakeholders');
        redirect(base_url().'Stakeholders');

    }

    public function upload() {
	
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
    

  	  $this->load->view('backend/secondary/admissions/stakeholders/uploadExcel',$data);

	}

    public function add()
 	{

 		 if($this->input->post('userSubmit')){
            
            //Check whether user upload picture
            if(!empty($_FILES['staff']['name'])){
                $config['upload_path'] = 'assets/uploads/secondary/';
                $config['allowed_types'] = 'xlsx|xls|csv';
                $config['file_name'] = $_FILES['staff']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('staff')){
                    $uploadData = $this->upload->data();
                    $file = $uploadData['file_name'];
                    
                 //$storagename = "assets/uploads/secondary/".time()."_contacts.xlsx";

                 $storagename = "assets/uploads/secondary/Staff.xlsx";
                 move_uploaded_file($_FILES["staff"]["tmp_name"],  $storagename);
                 unlink("assets/uploads/secondary/".$file);

                }else{
                    $file = '';
                }
            }else{
                 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Please select an Excel File</div>');
        			 redirect(base_url().'uploadStakeholders');
            }
         }
    
    
      include 'Excel/PHPExcel/IOFactory.php';

      //load the excel library
      $this->load->library('Excel');
      //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($storagename);
  		//$objPHPExcel = $this->excel->load($file);
  		//$objPHPExcel = $objReader->load("upload/stakeholders.xlsx");

  		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
  		
 		//loop from first data until last data
  		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

 		for($i=2;$i<=$arrayCount;$i++){
			$name = trim($allDataInSheet[$i]["A"]);
			$category = trim($allDataInSheet[$i]["B"]);
			$role = trim($allDataInSheet[$i]["C"]);
			$phone1 = trim($allDataInSheet[$i]["D"]);
			$phone2 = trim($allDataInSheet[$i]["E"]);
		

        	$school_id = $this->session->userdata['logged_in']['school_id'];

   			$data_user = array(
    		"name" => $name,
    		"category" => $category,
    		"role" => $role,
    		"phone1" => $phone1,
    		"phone2" => $phone2,
        	"school_id"=> $school_id,
        	"date_posted"=>date_create('now')->format('Y-m-d H:i:s'),
			 );

        	$this->load->database();
        	$this->load->model('stakeholder_model');
   			$this->stakeholder_model->add_data($data_user);
  			}

        	$this->session->set_flashdata('msg','<div class="alert alert-success text-center">admission Successfully Uploaded</div>');
        		redirect(base_url().'Stakeholders');
		 }




}
