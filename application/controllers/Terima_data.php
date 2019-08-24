<?php
	
	class Terima_data extends CI_Controller{

		function __construct(){
			parent::__construct();
			/*Insialisasi Model dari MAPS dan MOBIL*/
			$this->load->model('M_Maps'); 	
			$this->load->model('M_Mobil'); 	
			
		}
		/*Function ini digunakan untuk menerima data yang dikirim oleh modul perangkat keras, dimana perangkat keras tersebut akan mengakses url yang menarah pada fungsi dibawah ini. Parameter yang dikirimkan berupa data latitude dan longitude, tanggal, waktu dan id dari kendaraan
		 */
		function send_data($lat,$lon,$date,$time,$vehicle_id){
			$check = $this->M_Mobil->check_count('mobil',$vehicle_id); //Memeriksa apakah id mobil yang dikirimkan oleh perangkat keras sama dengan data kendaraan pada tabel
			$id = '';
			//echo $check;
			//Perintah Apabila tidak ditemukan data id mobil pada tabel kendaraan
			if($check < 1){ 
				$data = array(
					'no_mesin' => $vehicle_id,
					'status' => '0'
				);
				$this->M_Mobil->insert_mobil('mobil',$data); //Perintah untuk memasukkan data pada tabel, yang kemudian kita dapat mengubah informasi mobil pada form edit pada menu data kendaraan
			}else{
				echo "Data mobil tersedia"."<br/>";
				$getID = $this->M_Mobil->get_where('mobil',$vehicle_id);//mendapatkan informasi dari query data yang ditunjuk berdasarkan id primary pada tabel
				//Mengambil data menggunakan perintah foreach
				foreach ($getID as $row) {
					$id = $row->id_mobil;
				}
				//echo $id;
				//Memetakan data value dari variable parameter yang didapat
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
				//Perintah dibawah ini digunakan untuk memeriksa 
				$cek_marker = $this ->M_Maps->check_mark('tracking_history',$id,$date,$lat,$lon)->num_rows();
				$query_get = $this ->M_Maps->check_mark('tracking_history',$id,$date,$lat,$lon)->result();
				foreach ($query_get as $res) {
					$id_update = $res->id_track_his;
				}
				echo json_encode($query_get);
				if($cek_marker > 0){					
					$update_coordinates = $this->M_Maps->update_history($id_update,$data_loc);
					echo "Update data lokasi";
				}else{
					$insert_history = $this->M_Maps->insert_trackPoint('tracking_history',$data_loc);
					echo "Insert data history lokasi <br>";	
				}
				
				$check_track_live = $this->M_Maps->check_track_live('tracking_update',$id);
				if($check_track_live > 0){
					echo "Update Data Lokasi <br>";
					//echo json_encode($data_loc_update);
					$update_coordinates = $this->M_Maps->update_coordinates($id,$data_loc_update);				
				}else{
					echo "Insert Data Lokasi <br>";
					$insert_coordinates = $this->M_Maps->insert_trackPoint('tracking_update',$data_loc);
				}
			}
		}
	}
?>