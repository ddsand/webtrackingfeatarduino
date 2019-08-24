<?php 
 
class M_login extends CI_Model{	
	//Mendefinisikan tabel yang digunakan
	var $table = 'account';
	//Mendefinisikan nama kolom pada tabel yang digunakan untuk menggunakan fungsi order/sort
	var $column_order = array('username','last_update'); 
	//Mendefinisikan nama kolom pada tabel untuk query search
	var $column_search = array('username','last_update'); 
	//Mendefinisikan id tabel untuk fungsi search dan order   
	var $order = array('id' => 'desc'); 
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Fungsi dibawah ini digunakan mengambil data query pada tabel berdasarkan struktur dari datatable
	private function _get_datatables_query()
	{
		//mendefiniskan tabel yang akan digunakan
		$this->db->from($this->table);
		 //Mendefiniskan nilai awal counter data pada tabel
		$i = 0;
		//Looping kolom yang akan ditampilkan
		foreach ($this->column_search as $item) 
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
					$this->db->group_end();  //Menutup perintah query group start
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
		$this->db->where('id',$id);
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
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	//Fungsi ini digunakan untuk memeriksa data yang dimasukkan pada form login sesuai dengan yang ada tabel account
	function login_check($table,$where){		
		return $this->db->get_where($table,$where);
	}
	
	function login_update($where , $data){
		$this->db->where('username', $where);
		return $this->db->update('account',$data);
	}
	function get_account() {
		$query = $this->db->get('account');
		$this->db->order_by("id", "desc");
		return $query->result();
	}
	function change_pass($where , $data){
		$this->db->where('username', $where);
		return $this->db->update('account',$data);
	}
	function insert_account($table,$data){		
		return $this->db->insert($table,$data);
	}	
	function delete_account($table , $where) {
		$this->db->where('id', $where);
		$this->db->delete($table);
	}
	function get_where_account($table , $where){
		$this->db->where('id', $where);
		$query = $this->db->get($table);
		return $query->result();
	}
	function update_account($where , $data) {
		$this->db->where('id', $where);
		return $this->db->update('account',$data);
	}

}