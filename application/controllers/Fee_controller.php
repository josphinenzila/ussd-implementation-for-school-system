<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fee_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('fee_model','fee');
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
	  $this->load->view('backend/secondary/payments/FeeStructure/FeeStructure',$data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->fee->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $fee) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" class="data-check" value="'.$fee->id.'">';
			$row[] = $fee->class;
			$row[] = $fee->term1;
			$row[] = $fee->term2;
			$row[] = $fee->term3;
			$row[] = $fee->total;
		
		


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_fee('."'".$fee->id."'".')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_fee('."'".$fee->id."'".')"><i class="fa fa-trash-o"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->fee->count_all(),
						"recordsFiltered" => $this->fee->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    
	public function ajax_edit($id)
	{
		$data = $this->fee->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		
		$data = array(
				'class' => $this->input->post('class'),
				'term1' => $this->input->post('term1'),
				'term2' => $this->input->post('term2'),
				'term3' => $this->input->post('term3'),
				'total' => $this->input->post('total'),
				'school_id'  => $this->session->userdata['logged_in']['school_id'], 
			    'date_posted' => date_create('now')->format('Y-m-d H:i:s'),
			);

		$insert = $this->fee->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'class' => $this->input->post('class'),
				'term1' => $this->input->post('term1'),
				'term2' => $this->input->post('term2'),
				'term3' => $this->input->post('term3'),
				'total' => $this->input->post('total'),
			
			);
		$this->fee->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->fee->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->fee->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('class') == '')
		{
			$data['inputerror'][] = 'class';
			$data['error_string'][] = 'Class is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('term1') == '')
		{
			$data['inputerror'][] = 'term1';
			$data['error_string'][] = 'Term 1 Fee is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('term2') == '')
		{
			$data['inputerror'][] = 'term2';
			$data['error_string'][] = 'Term 2 Fee is required';
			$data['status'] = FALSE;
		}


		if($this->input->post('term3') == '')
		{
			$data['inputerror'][] = 'term3';
			$data['error_string'][] = 'Term 3 Fee is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('total') == '')
		{
			$data['inputerror'][] = 'total';
			$data['error_string'][] = 'Total Fee is required';
			$data['status'] = FALSE;
		}

      
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	 public function clearFeeStructure(){
        $this->db->where('school_id',$this->session->userdata['logged_in']['school_id']);
        $this->db->delete('fee_structure');
        redirect(base_url().'FeeStructure');

    }

    public function upload() {
	
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
    

  	  $this->load->view('backend/secondary/payments/FeeStructure/uploadExcel',$data);

	}

    public function add()
 	{

 		 if($this->input->post('userSubmit')){
            
            //Check whether user upload picture
            if(!empty($_FILES['fees']['name'])){
                $config['upload_path'] = 'assets/uploads/secondary/';
                $config['allowed_types'] = 'xlsx|xls|csv';
                $config['file_name'] = $_FILES['fees']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('fees')){
                    $uploadData = $this->upload->data();
                    $file = $uploadData['file_name'];
                    
                 //$storagename = "assets/uploads/secondary/".time()."_contacts.xlsx";

                 $storagename = "assets/uploads/secondary/FeeStructure.xlsx";
                 move_uploaded_file($_FILES["fees"]["tmp_name"],  $storagename);
                 unlink("assets/uploads/secondary/".$file);

                }else{
                    $file = '';
                }
            }else{
                     $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Please select an Excel File</div>');
        			 redirect(base_url().'uploadFeeStructure');
            }
         }
    
    
      include 'Excel/PHPExcel/IOFactory.php';

      //load the excel library
      $this->load->library('Excel');
      //read file from path
      $objPHPExcel = PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
      $objPHPExcel = PHPExcel_IOFactory::load($storagename);
  		//$objPHPExcel = $this->excel->load($file);
  		//$objPHPExcel = $objReader->load("upload/FeeStructure.xlsx");

  		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
  		
 		//loop from first data until last data
  		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

 		for($i=2;$i<=$arrayCount;$i++){
 			$class = trim($allDataInSheet[$i]["A"]);
			$term1 = trim($allDataInSheet[$i]["B"]);
			$term2 = trim($allDataInSheet[$i]["C"]);
			$term3 = trim($allDataInSheet[$i]["D"]);
			$total = trim($allDataInSheet[$i]["E"]);
		
        	$school_id = $this->session->userdata['logged_in']['school_id'];

   			$data_user = array(
    		"class" => $class,
    		"term1" => $term1,
    		"term2" => $term2,
    		"term3" => $term3,
    		"total" => $total,
        	"school_id"=> $school_id,
        	"date_posted"=>date_create('now')->format('Y-m-d H:i:s'),
			 );

        	$this->load->database();
        	$this->load->model('fee_model');
   			$this->fee_model->add_data($data_user);
  			}

        	$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Fee Structure Successfully Uploaded</div>');
        		redirect(base_url().'FeeStructure');
		 }




}
