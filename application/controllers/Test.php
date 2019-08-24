<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct(){
		parent::__construct();
		/** Memuat model M_Maps dan M_Mobil**/
		$this->load->model('M_Maps'); 	
		$this->load->model('M_Mobil'); 	
		// Cek status login
		if($this->session->userdata('status') != "login"){
			redirect('account/login'); // apbila status tidak sama dengan login maka akan dilakukan redirect ke halaman login
		}
	}

	public function index()
	{
		$data = array();
		$data['information'] = $this->M_Maps->get_information()->result(); // Informasi dari masing masing titik lokasi (mengenai waktu , no plat dari titik lokasi)	
		$data['title'] 	= "Tracking";
		$data['pos_now'] = "Route";
		$data['live_track'] = "Route";
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['vehicle'] = $this->M_Mobil->get_mobil();
		$this->load->view('layout/v_history_coba',$data);
	}
}
