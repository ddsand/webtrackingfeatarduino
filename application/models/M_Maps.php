<?php 
 
class M_Maps extends CI_Model{	
	function get_coordinates() {
		$query = $this->db->get('tracking_update');
		return $query->result();
	}

	function get_information(){
		$this->db->select('*');
		$this->db->from('tracking_update');
		$this->db->join('mobil','tracking_update.id_mobil = mobil.id_mobil');
		$query = $this->db->get();
		return $query;
	}

	function count_search_start($table,$where_car,$where_start){
		$this->db->like('waktu_update',$where_start,'both');
		$this->db->where('id_mobil',$where_car);
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	function count_search_end($table,$where_car,$where_end){
		$this->db->like('waktu_update',$where_end,'both');
		$this->db->where('id_mobil',$where_car);
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	function get_min_start($table,$where_car,$date){
		$this->db->select_min('id_track_his');
		$this->db->like('waktu_update',$date,'both');
		$this->db->where('id_mobil',$where_car);
		$query = $this->db->get($table);
		foreach ($query->result() as $row) {
			$this->db->where('id_track_his',$row->id_track_his);
			$query = $this->db->get($table);
			return $query->result();		
		}
	}

	function get_max_end($table,$where_car,$date){
		$this->db->select_max('id_track_his');
		$this->db->like('waktu_update',$date,'both');
		$this->db->where('id_mobil',$where_car);
		$query = $this->db->get($table);
		foreach ($query->result() as $row) {
			$this->db->where('id_track_his',$row->id_track_his);
			$query = $this->db->get($table);
			return $query->result();		
		}
	}

	function get_start($table,$where_car,$where_start){
		
		$this->db->like('waktu_update',$where_start,'both');
		$this->db->where('id_mobil',$where_car);
		$query = $this->db->get($table);		
		return $query->result();
	}

	function get_end($table ,$where_car, $where_end){
		$this->db->like('waktu_update',$where_end,'both');
		$this->db->where('id_mobil',$where_car);
		$query = $this->db->get($table);
		return $query->result();
	}

	function get_route($table,$where_car,$where_start,$where_end){
		$this->db->select('*');
		$this->db->from('tracking_history');
		$this->db->join('mobil','tracking_history.id_mobil = mobil.id_mobil');
		$this->db->where('tracking_history.id_mobil', $where_car);
		$this->db->where('waktu_update >=', $where_start);
		$this->db->where('waktu_update <=', $where_end);
		$query = $this->db->get();
		return $query->result();
	}
	function get_mark_route($table,$where_car,$where_start,$where_end){
		$this->db->where('id_mobil', $where_car);
		$this->db->where('waktu_update >=', $where_start);
		$this->db->where('waktu_update <=', $where_end);
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	function insert_trackPoint($table,$data){
		return $this->db->insert($table,$data);
	}

	function update_history($where,$data){
		$this->db->where('id_track_his', $where);
		return $this->db->update('tracking_history',$data);
	}

	function check_track_live($table , $where){
		$this->db->where('id_mobil', $where);
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	function check_mark($table , $id , $date , $lat , $lon){
		$array = array('id_mobil' => $id , 'lat' => $lat , 'lon' => $lon);
		$this->db->like('waktu_update',$date,'both');
		$this->db->where($array);
		$query = $this->db->get($table);
		return $query;
	}

	function update_coordinates($where,$data){
		$this->db->where('id_mobil', $where);
		return $this->db->update('tracking_update',$data);
	}

	//temporary
	function insert_temp($table,$data){		
		return $this->db->insert($table,$data);
	}

	function get_temp($table){
		$query = $this->db->get($table);
		return $query;
	}
	function get_trunc($table){
		$this->db->from($table); 
		return $this->db->truncate(); 
	}

}