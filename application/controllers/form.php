<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class form extends CI_Controller {
	function __construct() {
		
		parent::__construct();
		$this->load->model('viewdatamodel');
		$this->load->model('displaymodel');
		$this->load->model('savemodel');
		$this->load->model('data_table_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('value_data_model');
		}
	public function index()
	{
		$this->load->view('form_view');
	}
	public function loadView()
	{
		$recieveFormData = $this->input->post('data');
		$formname = $this->input->post('form_name');
		$type = $this->input->post('type');
		$formid = $this->viewdatamodel->view_data($recieveFormData,$formname,$type);
		$fieldlabel = [];
		$recieveFormData = json_decode($recieveFormData);
		for( $i = 0; $i < count($recieveFormData); $i++){
			$fieldname[$i] = $recieveFormData[$i]->name;
			$fieldlabel[$i] = isset($recieveFormData[$i]->label)?$recieveFormData[$i]->label:$recieveFormData[$i]->name;
			$this->savemodel->savedata($formid,$fieldname[$i],$fieldlabel[$i]);
	  }
		echo json_encode($formid);
	}
	public function displayformbutton()
	{
		$this->load->helper('url');
        $this->load->view('datatable_view');
	}


	public function deletedata()
	{
		$fid = $this->input->post('deleteformid');
		$rid = $this->input->post('deleterowid');
		$this->savemodel->delete($fid,$rid);
		echo "deleted";

	}


	 public function displayform()
	 {
		$id = $this->input->get('id');
		$formjson['data'] = $this->displaymodel->viewtable($id);
		$formjson['id'] = $id;
		$this->load->view('tableview',$formjson);
	}


	public function saveuserdata()
	{
		$recieveFormData = $_POST['data'];
	
		$formid  = $_POST['id'];

		$numoffields = count($recieveFormData);
		for( $i = 0; $i < $numoffields; $i++){
			$fieldname[$i] = $recieveFormData[$i]['name'];

			$fieldvalue[$i] = "";
			if(isset($recieveFormData[$i]['userData']))
			{
				$userdatacount = count($recieveFormData[$i]['userData']);
				//die($userdatacount);
				for( $j = 0; $j < $userdatacount; $j++)
				{
					if($j>0)
					{
						$fieldvalue[$i] .= ",";
					}
					$fieldvalue[$i] .= $recieveFormData[$i]['userData'][$j];
				}
			}
			$currentid = $this->savemodel->savevalue($formid,$fieldvalue[$i],$fieldname[$i],$numoffields);
	  }
	  $this->savemodel->savecurid($formid,$currentid);
	  echo "saved sucessfully";
	}



	public function updateuserdata()
	{
		$recieveFormData = $_POST['data'];
	
		$formid  = $_POST['id'];

		$fv_row_id = $_POST['rowid'];
		
		$numoffields = count($recieveFormData);
		for( $i = 0; $i < $numoffields; $i++){
			$fieldname[$i] = $recieveFormData[$i]['name'];

			$fieldvalue[$i] = "";
			if(isset($recieveFormData[$i]['userData']))
			{
				$userdatacount = count($recieveFormData[$i]['userData']);
				//die($userdatacount);
				for( $j = 0; $j < $userdatacount; $j++)
				{
					if($j>0)
					{
						$fieldvalue[$i] .= ",";
					}
					$fieldvalue[$i] .= $recieveFormData[$i]['userData'][$j];
				}
			}
		$currentid = $this->savemodel->getFieldid($fieldname[$i],$formid);
	    $jcount = $currentid[0]['field_id'];
		// echo $formid.",".$jcount.",".$fieldvalue[$i].",".$fv_row_id;
		// echo "<br>";
		$this->savemodel->updatevalue($formid,$jcount,$fieldvalue[$i],$fv_row_id);
	  }
	 // $this->savemodel->savecurid($formid,$currentid);
	  echo "saved sucessfully";
	}











	public function listing()
	{
		$formid = $this->input->get('id');
		$recieve['FormFields'] = $this->savemodel->getFormFields($formid);
		$recieve['FormFieldsValue'] = $this->savemodel->getFormFieldValues($formid,$recieve['FormFields']);	
		$recieve['form_id'] = $formid;	
		$recieve['data'] = $this->displaymodel->viewtable($formid);
		$this->load->view('valuelistingview',$recieve);



	}

	public function listing2()
	{
		$formid = $this->input->get('id');
		$recieve['formid'] = $formid;
		$recieve['FormFields'] = $this->savemodel->getFormFields($formid);
		//$recieve['FormFieldsValue'] = $this->savemodel->getFormFieldValues($formid,$recieve['FormFields']);		
		$this->load->view('valuelistingviewdatatable',$recieve);
	}


	public function excelTojson()
	{
		if($this->input->post('submit') == "upload")
		{
		echo "posted ";
		$path='img/formGenerateexcel';
		if (!is_dir($path)) {
		mkdir('./' . $path, 0777, TRUE);
		}
			$config['upload_path']          = "./$path  ";
			$config['allowed_types']        = 'xlsx';
			$config['max_size']             = 100000;
			$config['file_name']           = 'file'.date('YmdHis');
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('userfile'))
			{
			echo " fail ";

				$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('upload', $error);
				$this->load->view('fileupload_view',$error);

			}
			else
			{
			echo " pass ";

				$data = array('upload_data' => $this->upload->data(),"error"=>"");
				$this->load->view('fileupload_view',$data);
				$finalpath = $path."/".$config['file_name'].".xlsx";


			/////--------------------


		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
		$reader->setReadDataOnly(TRUE);
		$spreadsheet = $reader->load($finalpath);
		$json = '';
		

		$worksheet = $spreadsheet->getActiveSheet();
		// Get the highest row number and column letter referenced in the worksheet
		$asso_arr = array("type"=>"q","required"=>"w","label"=>"e","placeholder"=>"r","class"=>"t","name"=>"y");
		$asso_arr_keys = array_keys($asso_arr);
		$highestRow = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
		// Increment the highest column letter
		$highestColumn++;
		$row = 2;
		$col = 'A';
		$firstcell = $worksheet->getCell($col . $row)->getValue();
		if(isset($firstcell))
		{
		for ($row = 2; $row <= $highestRow; ++$row) {
			echo '<tr>' . PHP_EOL;
			$asso_arr_cell_values = array();
			for ($col = 'A'; $col != $highestColumn; ++$col){
					$col_name = 'C';
					if($worksheet->getCell($col . $row)->getValue() == NULL)
					{
						$asso_arr_cell_values[] = "";
					}
					else
					{
						$asso_arr_cell_values[] = $worksheet->getCell($col . $row)->getValue();
					}
			} 
			$asso_arr_cell_values[] = 'form-control';
			$asso_arr_cell_values[] = $worksheet->getCell($col_name . $row)->getValue().date("YmdHisu").$row; // predefine values by us in array
			$final_arr = array_combine($asso_arr_keys,$asso_arr_cell_values);
			
			if($final_arr['required'] == NULL)
			{
				$final_arr['required'] = 'false';
			}
			else
			{
				$final_arr['required'] = 'true';
			}
			$strings[] = json_encode($final_arr);
			$final_arr = array();  //redine the array to clear it
		}
		$str = implode(',',$strings); //gnerate json string
		$data['row'] = $str;
		$this->load->view('excelToJsonview',$data);
		//--------------------
		}
	else
	{
		echo "empty cell";
	}
		}
		}
		else
		{
			//echo " 12321";
			$this->load->view('fileupload_view',["error"=>""]);
		}
			//--------------------------------------------------
			
		
		}


		public function ajax_list()
    	{
				$list = $this->data_table_model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $customers) {
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $customers->form_id;
					$row[] = $customers->form_name;
					$row[] = "";
					$row[] = "";
					$data[] = $row;
				} 
				$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->data_table_model->count_all(),
					"recordsFiltered" => $this->data_table_model->count_filtered(),
					"data" => $data,
			);
				//output to json format
				echo json_encode($output);
			
	}
	public function ajax_list_formvalues()
	{
			$formid = $this->input->post('formid');//form id
			$list = $this->value_data_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			// foreach ($list as $customers) {
			// 	$no++;
			// 	$row = array();
			// 	$row[] = $no;
			// 	$row[] = $customers->fv_row_id;
			// 	$row[] = $customers->fv_value;
			// 	$data[] = $row;
			// } 

			foreach ($list as $customers) {
				$arrValue=array_values($customers);
				//print_r($customers);
				$no++;
				$data[] = array_merge([$no],$arrValue);
				//print_r($data);die;
			} 
			
			//print_r($data);die;
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->data_table_model->count_all(),
				"recordsFiltered" => $this->data_table_model->count_filtered(),
				"data" => $list,
		);
			//output to json format
			echo json_encode($output);
		
}

}
