<?php	
	class AccountList extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();		
			$this->load->model('M_login'); 
			$this->load->model('M_Maps'); 	
			$this->load->model('M_Mobil');
		}

		// Ajax
		public function ajax_list()
		{
			$list = $this->M_login->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$nomer=1;
			foreach ($list as $person) {
				$no++;
				$row = array();
				$row[]=$nomer;
				$row[] = $person->username;
				if($person->access == 1){
					$a="Super Admin";
				}else{
					$a="Admin";
				}
				$row[] = $a;
				$row[] = $person->no_plat;
				

					//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
						  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_data('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
				
				$data[] = $row;
				$nomer++;
			}

			$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->M_login->count_all(),
					"recordsFiltered" => $this->M_login->count_filtered(),
					"data" => $data,
				);
				//output to json format
			echo json_encode($output);
		}
		public function ajax_add()
		{
			
			$insert = $this->M_login->save($data);
			echo json_encode(array("status" => TRUE));
		}
		public function ajax_edit($id)
		{
			$data = $this->M_Mobil->get_by_id($id);
			echo json_encode($data);
		}
		public function ajax_update()
		{
			
			$this->M_login->update(array('id' => $this->input->post('id')), $data);
			echo json_encode(array("status" => TRUE));
		}
		public function ajax_delete($id)
		{
			$this->M_login->delete_by_id($id);
			echo json_encode(array("status" => TRUE));
		}
	}