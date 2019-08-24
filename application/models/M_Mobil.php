<?php 
class M_Mobil extends CI_Model{	
	//Mendefinisikan tabel yang digunakan
	var $table = 'mobil';
	//Mendefinisikan nama kolom pada tabel yang digunakan untuk menggunakan fungsi order/sort
	var $column_order = array('no_mesin','no_plat','nama_mobil'); 
	//Mendefinisikan nama kolom pada tabel untuk query search
	var $column_search = array('no_mesin','no_plat','nama_mobil');
	//Mendefinisikan id tabel untuk fungsi search dan order  
	var $order = array('id_mobil' => 'desc'); 
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Fungsi dibawah ini digunakan mengambil data query pada tabel berdasarkan struktur dari datatable
	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);//mendefiniskan tabel yang akan digunakan 

		$i = 0; //Mendefiniskan nilai awal counter data pada tabel
	
		foreach ($this->column_search as $item) //Looping kolom yang akan ditampilkan
		{
			if($_POST['search']['value'])//Mulai perintah untuk menggunakan fungsi cari menggunakan metode POST
			{
				if($i===0) // Counter awal loop
				{
					$this->db->group_start(); //Menggunakan perintah query group start untuk mengantisipasi apabila input POST lebih dari satu karakter kata sehingga dapat menggunakan perintah AND and LIKE
					$this->db->like($item, $_POST['search']['value']);//Perintah query LIKE untuk mencari karakter / kata yang sama dengan data pada tabel dan input POST
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);//Perintah query OR LIKE apabila karakter/kata lebih dari satu
				}

				if(count($this->column_search) - 1 == $i) //Akhir loop
					$this->db->group_end(); //Menutup perintah query group start
			}
			$i++;
		}
		//Perintah ini digunakan untuk proses fungsi order
		if(isset($_POST['order'])) 
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	//Fungsi ini digunakan untuk mendapatkan data pada datatables pada frontend
	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	//Fungsi ini digunakan untuk menghitung jumlah data pada tabel
	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	//Fungsi ini digunakan untuk menjumlah kan semua data pada tabel
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	//Fungsi ini digunakan untuk mendapatkan suatu query data berdasarkan id yang ada pada tabel
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_mobil',$id);
		$query = $this->db->get();

		return $query->row();
	}
	//Fungsi ini digunakan untuk menyimpan data baru yang dimasukkan dari form
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	//Fungsi ini digunakan untuk memperbarui data pada tabel 
	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	//Fungsi ini digunakan untuk menghapus data dari tabel
	public function delete_by_id($id)
	{
		$this->db->where('id_mobil', $id);
		$this->db->delete($this->table);
	}
	public function getNotif(){
		$this->db->select('count(id_mobil) as mobil');
		$this->db->from($this->table);
		$this->db->where('status','0');
		$query = $this->db->get()->row();
		return $query;
	}
	//
	function get_active_vehicle(){
		$this->db->select('*');
		$this->db->from('tracking_update');
		$this->db->join('mobil','tracking_update.id_mobil = mobil.id_mobil');
		$query = $this->db->get();
		return $query->result();	
	}
	function check_status_vehicle(){
		$this->db->where('status','0');
		$query = $this->db->get('mobil');
		return $query->num_rows();
	}
	function insert_mobil($table,$data){		
		return $this->db->insert($table,$data);
	}	
	function get_mobil() {
		$query = $this->db->get('mobil');
		$this->db->order_by("id_mobil", "desc");
		return $query->result();
	}
	function get_where_vehicle($table , $where){
		$this->db->where('id_mobil', $where);
		$query = $this->db->get($table);
		return $query->result();
	}
	function get_where($table , $where){
		$this->db->where('no_mesin', $where);
		$query = $this->db->get($table);
		return $query->result();	
	}
	function check_count($table , $where){
		$this->db->where('no_mesin', $where);
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	function delete_mobil($table , $where) {
		$this->db->where('id_mobil', $where);
		$this->db->delete($table);
	}

	function update_mobil($where , $data) {
		$this->db->where('id_mobil', $where);
		return $this->db->update('mobil',$data);
	}
}