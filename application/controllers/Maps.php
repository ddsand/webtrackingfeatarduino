<?php 
class Maps extends CI_Controller{

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

	function index(){
		$data = array(); // variabel untuk menampung semua informasi yang akan dibawa ke halaman view
		$data['title'] = "Home Admin"; // Judul
		$data['pos_now'] = "Live Map"; // header pada halaman view
		$data['who'] = $this->session->userdata('username'); // data username yang telah login
		$data['access'] = $this->session->userdata('access'); // hak akses dari user yang login
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle(); // Menghitung jumlah dari mobil yang belum aktif sebagai notifikasi	
		$data['live_track'] = "Live"; // status dari tracking live berarti memantau titik lokasi dari masing masing mobil dan pada halaman view digunakan sebagai variabel acuan untuk menjalankan API dari GMaps
		$data['vehicle'] = $this->M_Mobil->get_active_vehicle(); // Memuat data mobil yang sedang dilakukan tracking
		$data['coordinates'] = $this->M_Maps->get_coordinates(); // Memuat data koordinat dari masing masing mobil yang di track
		$data['information'] = $this->M_Maps->get_information()->result();	 // Informasi dari masing masing titik lokasi (mengenai waktu , no plat dari titik lokasi)		
		$this->load->view('layout/v_home',$data); 	// Memuat halaman view dengan membawa seluruh informasi pada $data	
	}

	// Function yang akan dipanggil terus dengan event ajax untuk melakukan refresh otomatis tiap satuan waktu
	// waktu yang kami gunakan adalah setiap 5 menit sekali untuk merefres informasi pada area map
	function map_content(){
		// informasi yang dibawa pada function ini sama dengan function index
		$data = array(); 
		$data['title'] = "Map";
		$data['pos_now'] = "Live Map";
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle();
		$data['live_track'] = "Live";
		$data['vehicle'] = $this->M_Mobil->get_active_vehicle();
		$data['coordinates'] = $this->M_Maps->get_coordinates();
		$data['information'] = $this->M_Maps->get_information()->result();			
		$this->load->view('layout/v_map_content',$data); // untuk memanggil view yang akan memuat data lokasi dan diimplementasikan pada area map di halaman utama
	}

	// Function untuk menampilkan halaman hisotry rute untuk mobil tertentu
	function history(){
		$data = array(); // variabel untuk menampung semua informasi yang akan dibawa ke halaman view
		$data['title'] = "History Route"; // Judul
		$data['pos_now'] = "History";
		$data['who'] = $this->session->userdata('username'); // data username yang telah login
		$data['access'] = $this->session->userdata('access'); // hak akses dari user yang login
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle(); // Menghitung jumlah dari mobil yang belum aktif sebagai notifikasi	
		$data['live_track'] = "Live"; // status dari tracking live berarti memantau titik lokasi dari masing masing mobil dan pada halaman view digunakan sebagai variabel acuan untuk menjalankan API dari GMaps
		$data['vehicle'] = $this->M_Mobil->get_active_vehicle(); // Memuat data mobil yang sedang dilakukan tracking
		$data['coordinates'] = $this->M_Maps->get_coordinates(); // Memuat data koordinat dari masing masing mobil yang di track
		$data['information'] = $this->M_Maps->get_information()->result(); // Informasi dari masing masing titik lokasi (mengenai waktu , no plat dari titik lokasi)					
		$this->load->view('layout/v_history',$data); // Memuat halaman view dengan membawa seluruh informasi pada $data		
	}
	function show_route() {
		$this->M_Maps->get_trunc('temp');
		$data = array(); // variabel untuk menampung semua informasi yang akan dibawa ke halaman view
		$param1=''; // Deklarasi variabel untuk parameter 1 pada fungsi get_route
		$param2=''; // Deklarasi variabel untuk parameter 2 pada fungsi get_route
		$data['start_lat'] = ''; // Deklarasi variabel start_lat untuk koordinat awal Latitude
		$data['start_lon'] = ''; // Deklarasi variabel start_lon untuk koordinat awal Longitude
		$data['end_lat'] = ''; // Deklarasi variabel end_lat untuk koordinat akhir Latitude
		$data['end_lon'] = ''; // Deklarasi variabel end_lon untuk koordinat akhir Longitude
		$data['count_inactive'] = $this->M_Mobil->check_status_vehicle(); // Menghitung jumlah dari mobil yang belum aktif sebagai notifikasi	
		$data['information'] = $this->M_Maps->get_information()->result(); // Informasi dari masing masing titik lokasi (mengenai waktu , no plat dari titik lokasi)	
		$data['title'] 	= "Tracking";
		$data['pos_now'] = "Route";
		$data['live_track'] = "Route";
		$data['who'] = $this->session->userdata('username');
		$data['access'] = $this->session->userdata('access');
		$data['vehicle'] = $this->M_Mobil->get_mobil();

		$new_input = $this->input->post('daterange'); //  Mengambil data input berupa data tanggal
		$vehicle = $this->input->post('vehicle'); // Mengambil data id dari mobil yang akan dilakukan penulusuran rute
		$show_car = $this->M_Mobil->get_where_vehicle('mobil' , $vehicle);
		foreach ($show_car as $row) {
			$data['plat'] = $row->no_plat;
		}
		$tampung = explode('-', $new_input , 2); // dilakukan parsing dengan memisahkan data input tanggal dan waktu dengan acuan notasi - dan akan dihailkan suatu array ayng menampung data awal dan data akhir
		//echo date('Y-m-d h:i', strtotime($tampung[0]))."<br>";
		//echo date('Y-m-d h:i', strtotime($tampung[1]))."<br>";
		$date_start = date('Y-m-d', strtotime($tampung[0])); // mengambil date start pada array 0 variabel tampung
		$date_end = date('Y-m-d', strtotime($tampung[1])); // mengambil date_end pada array 1 variabel tampung
		$search_start = date('Y-m-d G:i', strtotime($tampung[0])); // mengambil date_start ditambah format waktu pada array 0 variabel tampung
		$search_end   = date('Y-m-d G:i', strtotime($tampung[1])); // mengambil date_end ditambah format waktu pada array 1 variabel tampung
		//echo $search_start;
		$count_start = $this->M_Maps->count_search_start('tracking_history',$vehicle,$search_start); // Mencari apakah ada data lokasi dari waktu awal yang dimasukkan
		$count_end = $this->M_Maps->count_search_end('tracking_history',$vehicle,$search_end); // Mencari apakah ada data lokasi dari waktu akhir yang dimasukkan	
		//echo $count_start;		
		if($count_start < 1){
			// Apabila pencarian dalam format waktu+tangal tidak ditemukan , maka akan dilakukan penelusuran dengan mengambil waktu paling kecil dari tanggal input
			$data['start_marker'] = $this->M_Maps->get_min_start('tracking_history',$vehicle,$date_start); // memanggil fungsi get_min_start untuk mengambil informasi data lokasi pada waktu minimal
			foreach($data['start_marker'] as $row){
				$param1 = $row->waktu_update; // memasukkan data waktu minimal kedalam parameter1 
				$a=$row->id_mobil;
			}				
		}else{
			$data['start_marker'] = $this->M_Maps->get_start('tracking_history',$vehicle,$search_start); // namun apabila waktu dan tanggal yang di inputkan ada pada database maka akan dilakukan pencarian sesuai dengan input yang dimasukkan
			foreach($data['start_marker'] as $row){
				$param1 = $row->waktu_update; // memasukkan data waktu minimal kedalam parameter1 
				$a=$row->id_mobil;
			} 
		}	
		if($count_end < 1){
			// Apabila pencarian dalam format waktu+tangal tidak ditemukan , maka akan dilakukan penelusuran dengan mengambil waktu paling besar / akhir dari tanggal input
			$data['end_marker'] = $this->M_Maps->get_max_end('tracking_history',$vehicle,$date_end);
			// memanggil fungsi get_min_start untuk mengambil informasi data lokasi pada waktu maksimal	
			foreach($data['end_marker'] as $row){
				$param2 = $row->waktu_update; // memasukkan data waktu minimal kedalam parameter1 
				$a=$row->id_mobil;
			}			
		}else{
			$data['end_marker'] = $this->M_Maps->get_end('tracking_history',$vehicle,$search_end); // namun apabila waktu dan tanggal yang di inputkan ada pada database maka akan dilakukan pencarian sesuai dengan input yang dimasukkan
			foreach($data['end_marker'] as $row){
				$param2 = $row->waktu_update; // memasukkan data waktu minimal kedalam parameter1 
				$a=$row->id_mobil;
			}	
		}

		foreach($data['start_marker'] as $row){ // Mengambil informasi titik lokasi awal untuk dilakukan penelusuran
			$data['waktu1'] = $row->waktu_update; // waktu sebagai parameter 1
			$a=$row->id_mobil;
			$data['start_lat'] = $row->lat;
			$data['start_lon'] = $row->lon;			
		}
		foreach($data['end_marker'] as $row){ // Mengambil informasi titik lokasi akhir untuk dilakukan penelusuran
			$data['waktu2'] = $row->waktu_update; // waktu sebagai parameter 2
			$a=$row->id_mobil;
			$data['end_lat'] = $row->lat;
			$data['end_lon'] = $row->lon;
		}
		$data['track_point'] = $this->M_Maps->get_route('tracking_history',$vehicle,$param1,$param2); // informasi rute yang telah dilalui dari titik awal waktu yang dimasukkan hingga titik akhir waktu
		/*echo json_encode($data['track_point']);
		echo $param1."<br>";
		echo $param2."<br>";*/
		$data['lat'] = array();
		$data['lng']=array();
		$index=0;
		foreach ($data['track_point'] as $res) {		
			$data['lat'][]=$res->lat;
			$data['lng'][]=$res->lon;	
			/*echo json_encode($data['lat'][$index])."</br>";
			echo json_encode($data['lng'][$index])."</br>";*/
			$index++;
		}
		$a= array();
		for ($i=0; $i <= $index-1; $i++) { 
			if(($i>=0)&&($i<$index-1)){
				$theta = $data['lng'][$i] - $data['lng'][$i+1];
				$dist = sin(deg2rad($data['lat'][$i])) * sin(deg2rad($data['lat'][$i+1])) +  cos(deg2rad($data['lat'][$i])) * cos(deg2rad($data['lat'][$i+1])) * cos(deg2rad($theta));
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$miles = $dist * 60 * 1.1515;
				$km = $miles * 1.609344;
				//echo $km."</br>";
				if($km > 0.2){
					/*$data['result'][]="lat:".$data['lat'][$i];
					$data['result'][]="lng:".$data['lng'][$i];*/
					$isi= array(
						'lat' => $data['lat'][$i],
						'lng' => $data['lng'][$i]
					);	
					$res = $this->M_Maps->insert_temp('temp',$isi);
					//var_dump($res);
				}
			}
		}


		$data['track']=$this->M_Maps->get_temp('temp')->result();
		//echo $data['track_point'];

		$this->load->view('layout/v_history',$data); // memuat halaman history dengan membawa semua informasi pada $data	
		
	}

	function send_data(){
		//fungsi cek id
		$lat = $this->input->post('lat');
		$lon = $this->input->post('lon');
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		$vehicle_id = $this->input->post('id');

		$check = $this->M_Mobil->check_count('mobil',$vehicle_id);
		$id = '';
		//echo $check;
		if($check < 1){
			$data = array(
				'no_mesin' => $vehicle_id,
				'status' => '0'
			);
			$this->M_Mobil->insert_mobil('mobil',$data);
		}else{
			echo "Data mobil tersedia"."<br/>";
			$getID = $this->M_Mobil->get_where('mobil',$vehicle_id);
			foreach ($getID as $row) {
				$id = $row->id_mobil;
			}
			echo $id;
			$data_loc = array(
				'id_mobil' => $id,
				'lon' => $lon , 
				'lat' => $lat,
				'waktu_update' =>$date." ".$time
			);
			$data_loc_update = array(
				'lon' => $lon , 
				'lat' => $lat,
				'waktu_update' => $date." ".$time
			);
			//echo $date." ".$time;			
			$insert_history = $this->M_Maps->insert_trackPoint('tracking_history',$data_loc);
			$check_track_live = $this->M_Maps->check_track_live('tracking_update',$id);
			if($check_track_live > 0){
				echo "Update Data Lokasi";
				//echo json_encode($data_loc_update);
				$update_coordinates = $this->M_Maps->update_coordinates($id,$data_loc_update);				
			}else{
				echo "Insert Data Lokasi";
				$insert_coordinates = $this->M_Maps->insert_trackPoint('tracking_update',$data_loc);
			}
		}
	}



	
}