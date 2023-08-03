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
      A.id_pelanggan, D.nm_pelanggan, A.status_penjualan
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
}
