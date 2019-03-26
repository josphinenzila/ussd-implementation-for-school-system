<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exams_controller_3 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('exams_model_3','exam');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}

	public function index()
	{

      $this->load->model('exams_model_3','exam');
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
      $data['groups'] = $this->exam->getAllGroups();
  
	  $this->load->helper('url');
	  $this->load->view('backend/secondary/exams/form3/Exams',$data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->exam->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $exam) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" class="data-check" value="'.$exam->id.'">';
			$row[] = $exam->adm;
			$row[] = $exam->student_name;
			$row[] = $exam->exam_name;
			$row[] = $exam->results;
			$row[] = $exam->stream;
			$row[] = $exam->class;
		
		


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_exam('."'".$exam->id."'".')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_exam('."'".$exam->id."'".')"><i class="fa fa-trash-o"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->exam->count_all(),
						"recordsFiltered" => $this->exam->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    
	public function ajax_edit($id)
	{
		$data = $this->exam->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		
		$data = array(
				'adm' => $this->input->post('adm'),
				'student_name' => $this->input->post('student_name'),
				'exam_name' => $this->input->post('exam_name'),
				'results' => $this->input->post('results'),
				'stream' => $this->input->post('stream'),
				'class' => $this->input->post('class'),
				'school_id'  => $this->session->userdata['logged_in']['school_id'], 
			    'date_posted' => date_create('now')->format('Y-m-d H:i:s'),
			);

		$insert = $this->exam->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'adm' => $this->input->post('adm'),
				'student_name' => $this->input->post('student_name'),
				'exam_name' => $this->input->post('exam_name'),
				'results' => $this->input->post('results'),
				'stream' => $this->input->post('stream'),
				'class' => $this->input->post('class'),
			
			);
		$this->exam->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->exam->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->exam->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('adm') == '')
		{
			$data['inputerror'][] = 'adm';
			$data['error_string'][] = 'Admission number is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('student_name') == '')
		{
			$data['inputerror'][] = 'student_name';
			$data['error_string'][] = 'Student name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('exam_name') == '')
		{
			$data['inputerror'][] = 'exam_name';
			$data['error_string'][] = 'Exam name is required';
			$data['status'] = FALSE;
		}


		if($this->input->post('results') == '')
		{
			$data['inputerror'][] = 'results';
			$data['error_string'][] = 'Results are required';
			$data['status'] = FALSE;
		}

		if($this->input->post('stream') == '')
		{
			$data['inputerror'][] = 'stream';
			$data['error_string'][] = 'Please select stream';
			$data['status'] = FALSE;
		}

		if($this->input->post('class') == '')
		{
			$data['inputerror'][] = 'class';
			$data['error_string'][] = 'Class is required';
			$data['status'] = FALSE;
		}

        /**
		if($this->input->post('parent_phone2') == '')
		{
			$data['inputerror'][] = 'parent_phone2';
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

	 public function clearExams(){
        $this->db->where('school_id',$this->session->userdata['logged_in']['school_id']);
        $this->db->where('class','FORM3');
        $this->db->delete('exam_results');
        redirect(base_url().'exams3');

    }

    public function upload() {
	
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
    

  	  $this->load->view('backend/secondary/exams/form3/uploadExcel',$data);

	}

    public function add()
 	{

 		 if($this->input->post('userSubmit')){
            
            //Check whether user upload picture
            if(!empty($_FILES['exams']['name'])){
                $config['upload_path'] = 'assets/uploads/secondary/';
                $config['allowed_types'] = 'xlsx|xls|csv';
                $config['file_name'] = $_FILES['exams']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('exams')){
                    $uploadData = $this->upload->data();
                    $file = $uploadData['file_name'];
                    
                 //$storagename = "assets/uploads/secondary/".time()."_contacts.xlsx";

                 $storagename = "assets/uploads/secondary/Exams.xlsx";
                 move_uploaded_file($_FILES["exams"]["tmp_name"],  $storagename);
                 unlink("assets/uploads/secondary/".$file);

                }else{
                    $file = '';
                }
            }else{
               $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Please select an Excel File</div>');
        		redirect(base_url().'uploadExams3');
            }
         }
    
    
      include 'Excel/PHPExcel/IOFactory.php';

      //load the excel library
      $this->load->library('Excel');
      //read file from path
      $objPHPExcel = PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
      $objPHPExcel = PHPExcel_IOFactory::load($storagename);
  		//$objPHPExcel = $this->excel->load($file);
  		//$objPHPExcel = $objReader->load("upload/exams.xlsx");

  		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
  		
 		//loop from first data until last data
  		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

 		for($i=2;$i<=$arrayCount;$i++){
 			$adm = trim($allDataInSheet[$i]["A"]);
			$student_name = trim($allDataInSheet[$i]["B"]);
			$exam_name = trim($allDataInSheet[$i]["C"]);
			$results = trim($allDataInSheet[$i]["D"]);
			$stream = trim($allDataInSheet[$i]["E"]);
			$class = trim($allDataInSheet[$i]["F"]);
		
        	$school_id = $this->session->userdata['logged_in']['school_id'];

   			$data_user = array(
    		"adm" => $adm,
    		"student_name" => $student_name,
    		"exam_name" => $exam_name,
    		"results" => $results,
    		"stream" => $stream,
    		"class" => $class,
        	"school_id"=> $school_id,
        	"date_posted"=>date_create('now')->format('Y-m-d H:i:s'),
			 );

        	$this->load->database();
        	$this->load->model('exams_model_3');
   			$this->exams_model_3->add_data($data_user);
  			}

        	$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Exams Successfully Uploaded</div>');
        		redirect(base_url().'exams3');
		 }




}
