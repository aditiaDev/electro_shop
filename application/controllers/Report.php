<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

  public function __construct(){
      parent::__construct();
  
      if(!$this->session->userdata('id_user'))
        redirect('login', 'refresh');

      $this->load->library('pdf');
  }

	public function ctkStruk()
	{
		$data['data'] = $this->db->query("
    SELECT A.id_penjualan, A.tgl_penjualan, A.tot_biaya_barang, A.diskon, A.tot_akhir, 
    B.id_barang, D.nm_barang, B.jumlah, B.harga, B.diskon as diskon_item, B.subtotal,
    A.id_pelanggan, C.nm_pelanggan
    FROM tb_penjualan A
    LEFT JOIN tb_dtl_penjualan B ON A.id_penjualan = B.id_penjualan
    LEFT JOIN tb_pelanggan C ON A.id_pelanggan = C.id_pelanggan
    LEFT JOIN tb_barang D ON B.id_barang = D.id_barang 
    WHERE A.id_penjualan = '".$this->input->post('id_penjualan')."'
    ")->result_array();

    // $this->pdf->setPaper('A4', 'potrait');
    $customPaper = array(0,0,290,380);
    $this->pdf->set_paper($customPaper);
    $this->pdf->filename = "ctk_struk.pdf";
    $this->pdf->load_view('report/ctk_struk', $data);

	}
}
