<?php 

class Data_kendaraan extends CI_Controller{

	function __construct(){
		parent::__construct();	
		if($this->session->userdata('status') != "login"){
			redirect('account/login');
		}	
		$this->load->model('M_Mobil'); 
		$this->load->library('datatables');
	}

	// Index Function that shows all element of vehicle data
	function index() {
		$data = array();
		$data['title'] = "Data Kendaraan";
		$data['pos_now'] = "Data Kendaraan";
		$data['pos_prev'] = "Home";
		$data['access'] = $this->session->userdata('access');
		$data['who'] = $this->session->userdata('username');
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		//$data['vehicle'] = $this->M_Mobil->get_mobil();
		$this->load->view('layout/v_data_kendaraan',$data);		
	}	
	
	public function ajax_list()
	{
		$list = $this->M_Mobil->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$nomer=1;
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[]=$nomer;
			$row[] = $person->no_mesin;
			$row[] = $person->nama_mobil;
			if($person->status==1){
				$a="Terdaftar";
			}else{
				$a="Tidak Terdaftar";
			}
			$row[] = $a;
			

				//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('."'".$person->id_mobil."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_data('."'".$person->id_mobil."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
			$data[] = $row;
			$nomer++;
		}

		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->M_Mobil->count_all(),
				"recordsFiltered" => $this->M_Mobil->count_filtered(),
				"data" => $data,
			);
			//output to json format
		echo json_encode($output);
	}
	public function ajax_add()
	{
		$id_mesin 	= $this->input->post('inputID');
		$no_plat 	= $this->input->post('inputNP');
		$tipe_mobil = $this->input->post('inputTipe');
		$merk 		= $this->input->post('inputMerk');
		$tahun	    = $this->input->post('inputTahun');

		$data = array(
			'no_mesin' 		 => $id_mesin ,
			'no_plat' 		 => $no_plat ,
			'nama_mobil' 	 => $merk,
			'tipe_mobil' 	 => $tipe_mobil,
			'tahun_keluaran' => $tahun,
			'status' => '1'
		);
		$insert = $this->M_Mobil->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_edit($id)
	{
		$data = $this->M_Mobil->get_by_id($id);
		echo json_encode($data);
	}
	public function ajax_update()
	{
		$id_mesin 	= $this->input->post('inputID');
		$no_plat 	= $this->input->post('inputNP');
		$tipe_mobil = $this->input->post('inputTipe');
		$merk 		= $this->input->post('inputMerk');
		$tahun	    = $this->input->post('inputTahun');

		$data = array(
			'no_mesin' 		 => $id_mesin ,
			'no_plat' 		 => $no_plat ,
			'nama_mobil' 	 => $merk,
			'tipe_mobil' 	 => $tipe_mobil,
			'tahun_keluaran' => $tahun ,
			'status' => '1'
		);
		$this->M_Mobil->update(array('id_mobil' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_delete($id)
	{
		$this->M_Mobil->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function Notifikasi(){
		$res = $this->M_Mobil->getNotif();
		echo json_encode($res);
	}
	// Show Insert data form 
	/*
	function insert_page(){	
		$data = array();
		$data['title'] = "Data Kendaraan";
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		$data['pos_now'] = "Insert Data";
		$data['pos_prev'] = "Data Kendaraan";		
		$this->load->view('layout/v_insert',$data);
	}

	//Insert process function
	function insert_process(){
		$id_mesin 	= $this->input->post('inputID');
		$no_plat 	= $this->input->post('inputNP');
		$tipe_mobil = $this->input->post('inputTipe');
		$merk 		= $this->input->post('inputMerk');
		$tahun	    = $this->input->post('inputTahun');

		$data = array(
			'no_mesin' 		 => $id_mesin ,
			'no_plat' 		 => $no_plat ,
			'nama_mobil' 	 => $merk,
			'tipe_mobil' 	 => $tipe_mobil,
			'tahun_keluaran' => $tahun
		);
		$proc = $this->M_Mobil->insert_mobil('mobil',$data);
		if($proc){
			redirect('data_kendaraan');
		}
	}

	// Edit Page
	function edit_page($where){	
		$data = array();
		$data['title'] = "Data Kendaraan";
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['pos_now'] = "Edit Data";
		$data['pos_prev'] = "Data Kendaraan";		
		$data['id'] = $where;		
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		$data['vehicle'] = $this->M_Mobil->get_where_vehicle('mobil',$where);
		$this->load->view('layout/v_edit',$data);
	}

	// Edit Process
	function edit_process(){
		$hiddenID	= $this->input->post('hiddenID');
		$id_mesin 	= $this->input->post('inputID');
		$no_plat 	= $this->input->post('inputNP');
		$tipe_mobil = $this->input->post('inputTipe');
		$merk 		= $this->input->post('inputMerk');
		$tahun	    = $this->input->post('inputTahun');

		$data = array(
			'no_mesin' 		 => $id_mesin ,
			'no_plat' 		 => $no_plat ,
			'nama_mobil' 	 => $merk,
			'tipe_mobil' 	 => $tipe_mobil,
			'tahun_keluaran' => $tahun,
			'status' => '1'
		);

		$proc = $this->M_Mobil->update_mobil($hiddenID,$data);
		if($proc){
			redirect('data_kendaraan');
		}
	}


	// Delete Function to remove data from database
	function Delete($where){
		//echo $where;
		$query = $this->M_Mobil->delete_mobil('mobil',$where);

		redirect('data_kendaraan');
	}
	*/
	
}