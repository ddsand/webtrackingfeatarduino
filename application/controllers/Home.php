<?php 

class Home extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('M_Maps'); 	
		$this->load->model('M_Mobil'); 	
		if($this->session->userdata('status') != "login"){
			//$this->load->view('layout/v_login');
			redirect('account/login');
		}
	}

	function index(){
		$data = array();
		$data['title'] = "Home Admin";
		$data['pos_now'] = "Home";
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['live_track'] = "Live";
		$data['coordinates'] = $this->M_Maps->get_coordinates();		
		redirect('maps');
	}
}