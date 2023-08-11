<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index()
	{
    $this->db->order_by("nm_kategori", "asc");
    $data['kategori'] = $this->db->get('tb_kategori_barang')->result();

		$this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/penjualan2', $data);
    $this->load->view('template/back/footer');

	}

  public function datapenjualan(){
    $this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/datapenjualan');
    $this->load->view('template/back/footer');
  }

  public function getAllData(){
    $data['data'] = $this->db->query("
      SELECT A.id_penjualan, 
      DATE_FORMAT(A.tgl_penjualan, '%d %b %Y') as tgl_penjualan,
      A.tipe_penjualan,
      B.id_barang, C.nm_barang,
      B.jumlah,
      B.harga,
      (B.jumlah * B.harga) AS SUB_TOTAL,
      A.id_pelanggan, D.nm_pelanggan, A.status_penjualan, A.bukti_bayar
      FROM tb_penjualan A
      LEFT JOIN tb_dtl_penjualan B ON A.id_penjualan = B.id_penjualan
      LEFT JOIN tb_barang C ON B.id_barang = C.id_barang
      LEFT JOIN tb_pelanggan D ON A.id_pelanggan = D.id_pelanggan
      ORDER BY A.tgl_penjualan DESC
    ")->result();
    echo json_encode($data);
  }

  public function changeStatus(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_penjualan', 'id_penjualan', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "status_penjualan" => $this->input->post('status'),
    );
    $this->db->where('id_penjualan', $this->input->post('id_penjualan'));
    $this->db->update('tb_penjualan', $data);

    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function generateId(){
    $unik = 'J'.date('y');
    $kode = $this->db->query("SELECT MAX(id_penjualan) LAST_NO FROM tb_penjualan WHERE id_penjualan LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function generateIdBarangKeluar(){
    $unik = 'K'.date('y');
    $kode = $this->db->query("SELECT MAX(id_barang_keluar) LAST_NO FROM tb_barang_keluar WHERE id_barang_keluar LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveCheckout(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
    $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');

    
    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_penjualan" => $id,
              "tgl_penjualan" => date('Y-m-d H:i:s'),
              "id_pelanggan" => $this->input->post('id_pelanggan'),
              "tipe_penjualan" => 'ONSITE',
              "diskon" => $this->input->post('diskon_header'),
              "tot_biaya_barang" => $this->input->post('tot_biaya_barang'),
              "tot_akhir" => $this->input->post('tot_akhir'),
              "status_penjualan" => "SELESAI"
            );
    $this->db->insert('tb_penjualan', $data);

    $subtotal = 0;
    foreach($this->input->post('id_barang') as $key => $each){
      $subtotal = ( $this->input->post('qty')[$key] * $this->input->post('harga')[$key] ) - $this->input->post('diskon')[$key];


      $dataDtl = array(
        "id_penjualan" => $id,
        "id_barang" => $this->input->post('id_barang')[$key],
        "jumlah" => $this->input->post('qty')[$key],
        "harga" => $this->input->post('harga')[$key],
        "diskon" => $this->input->post('diskon')[$key],
        "subtotal" => $subtotal,
      );

      $this->db->insert('tb_dtl_penjualan', $dataDtl);

      $id_barang_keluar = $this->generateIdBarangKeluar();

      $dataDtl2 = array(
        "id_barang_keluar" => $id_barang_keluar,
        "doc_referensi" => $id,
        "doc_tipe" => "PENJUALAN",
        "tgl_barang_keluar" => date('Y-m-d H:i:s'),
        "id_barang" => $this->input->post('id_barang')[$key],
        "jumlah" => $this->input->post('qty')[$key],
        "harga" => $this->input->post('harga')[$key],
      );

      $this->db->insert('tb_barang_keluar', $dataDtl2);

      $this->db->query("
        UPDATE tb_barang SET stock = ( stock - ".$this->input->post('qty')[$key]." ) 
        WHERE id_barang = '".$this->input->post('id_barang')[$key]."'
      ");
    }
    
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan</br>No Penjualan ".$id, "id" => $id);
    echo json_encode($output);
  }
}
