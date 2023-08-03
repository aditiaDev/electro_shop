<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        if(!$this->session->userdata('id_user'))
          redirect('login', 'refresh');
    }

	public function index()
	{
		$this->load->view('template/front/header');
    $this->load->view('template/front/menu');
    $this->load->view('pages/front/history');
    $this->load->view('template/front/footer');

	}

  public function getDataByUser(){
    $data['data'] = $this->db->query("
      SELECT 
      A.id_penjualan,
      DATE_FORMAT(A.tgl_penjualan, '%d %b %Y') as tgl_penjualan,
      B.id_barang,
      C.nm_barang,
      B.jumlah,
      B.harga,
      B.subtotal,
      A.status_penjualan
      FROM tb_penjualan A
      LEFT JOIN tb_dtl_penjualan B ON A.id_penjualan = B.id_penjualan
      LEFT JOIN tb_barang C ON B.id_barang = C.id_barang
      WHERE A.id_pelanggan = 'P2300001'
    ")->result();
    echo json_encode($data);
  }

}