<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	function __construct(){
		parent::__construct();		
		$this->load->model('M_login'); 
		$this->load->model('M_Maps'); 	
		$this->load->model('M_Mobil'); 

	}
	//
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
			$row[] = $person->last_update;
			

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
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');
		$confirm    = $this->input->post('confirm_password');
		$access		= $this->input->post('access');
		

		$data = array(
			'username' => $username ,
			'password' => md5($password) ,
			'access'   => $access
			
		);
		
		$insert = $this->M_login->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_edit($id)
	{
		$data = $this->M_login->get_by_id($id);
		echo json_encode($data);
	}
	public function ajax_update()
	{
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');
		$confirm    = $this->input->post('confirm_password');
		$access		= $this->input->post('access');
		

		$data = array(
			'username' => $username ,
			'password' => md5($password) ,
			'access'   => $access
			
		);
		$this->M_login->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_delete($id)
	{
		$this->M_login->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	//
	// Function index
	public function index()
	{
		if($this->session->userdata('status') != "login"){			
			$this->load->view('layout/v_login');	
		}else{
			redirect('home');
		}		
	}
	public function login()
	{
		$this->load->view('layout/v_login');
	}

	public function login_error()
	{
		$data = array();
		$data['error'] = "1";
		$this->load->view('layout/v_login',$data);
	}

	function generateRandomString() {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < 10; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function reset($username){
		$data = array();
		$where = array(
			'username' => $username		
		);
		$check_row = $this->M_login->login_check('account',$where)->num_rows();
		if($check_row > 0){
			$new_pass = $this->generateRandomString();
			$data_update =array(
				'password' => md5($new_pass)				
			);			
			$update_pass = $this->M_login->change_pass($username , $data_update);			
			$data['reset'] = $new_pass;
			$this->load->view('layout/v_login',$data);
		}else{
			redirect('Account/login_error');
		}
	}

	// Authentication Function
	public function login_action(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		/*echo $username."<br>";
		echo $password."<br>";*/
		$where = array(
						'username' => $username,
						'password' => md5($password) 
		 			  );
		$check = $this->M_login->login_check("account",$where) -> num_rows();
		if($check > 0){
			date_default_timezone_set("Asia/Jakarta");
			$date = date('Y-m-d h:i:s');
			$data_login = $this -> M_login -> login_check("account",$where) -> result(); 
			foreach ($data_login as $row) {
				$access = $row->access;
			}
			$data_session = array(
				'username' => $username	 ,
				'access' => $access ,
				'status'   => "login" 
			);
			$data_update = array(
				'last_login' => $date
			);
			$this->M_login->login_update($username,$data_update);
			$this->session->set_userdata($data_session);
			redirect(base_url("home"));
		}else{
			redirect(base_url("account/login_error"));
		}
	}

	// Logout Function
	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url('account'));
	}

	public function change_pass(){
		$data = array();
		$data['title'] = "Ganti Password";
		$data['pos_now'] = "Home";
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		$data['live_track'] = "Live";
		$data['vehicle'] = $this->M_Mobil->get_active_vehicle();
		$data['coordinates'] = $this->M_Maps->get_coordinates();
		$data['information'] = $this->M_Maps->get_information()->result();		
		$this->load->view('layout/v_change_pass',$data);
	}

	public function change_process() {
		$data = array();
		$username = $this->session->userdata('username');
		$new_password 	= $this->input->post('new_pass');
		$confirm_pass 	= $this->input->post('confirm_pass');

		if($confirm_pass != $new_password){
			$data['error'] = "Maaf password baru dan konfirmasi tidak sama";
			redirect('change_pass');
			//$this->load->view('layout/v_change_pass',$data);
		}else{
			$data_update = array(
				'password' => md5($new_password)
			);
			$update_pass = $this->M_login->change_pass($username , $data_update);
			if($update_pass){
				redirect('Home');
			}else{
				echo "Gagal Update";
			}
		}
	}

	function data_admin() {
		$data = array();
		$data['title'] = "Data Admin";
		$data['pos_now'] = "Data Admin";
		$data['pos_prev'] = "Home";
		$data['access'] = $this->session->userdata('access');
		$data['who'] = $this->session->userdata('username');
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		$data['account'] = $this->M_login->get_account();
		$this->load->view('layout/v_admin',$data);		
	}

	function tambah_admin(){	
		$data = array();
		$data['title'] = "Data Admin";
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		$data['pos_now'] = "Insert Data";
		$data['pos_prev'] = "Data Admin";		
		$this->load->view('layout/v_insert_account',$data);
	}	

	function insert_process(){
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');
		$confirm    = $this->input->post('confirm_password');
		$access		= $this->input->post('access');
		

		$data = array(
			'username' => $username ,
			'password' => md5($password) ,
			'access'   => $access
			
		);
		$proc = $this->M_login->insert_account('account',$data);
		if($proc){
			redirect('Account/data_admin');
		}
	}

	function edit_page($where){	
		$data = array();
		$data['title'] = "Data Akun";
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['pos_now'] = "Edit Data";
		$data['pos_prev'] = "Data Kendaraan";		
		$data['id'] = $where;		
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		$data['account'] = $this->M_login->get_where_account('account',$where);
		$this->load->view('layout/v_edit_account',$data);
	}

	function edit_process(){
		$hiddenID	= $this->input->post('hiddenID');
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');
		$confirm    = $this->input->post('confirm_password');
		$access		= $this->input->post('access');
		echo $hiddenID."<br>";
		$data = array(
			'username' => $username ,
			'password' => md5($password) ,
			'access'   => $access
			
		);
		echo json_encode($data);
		$proc = $this->M_login->update_account($hiddenID,$data);
		if($proc){
			redirect('account/data_admin');
		}
	}

	function delete($where){
		//echo $where;
		$query = $this->M_login->delete_account('account',$where);
		redirect('account/data_admin');
	}
}
