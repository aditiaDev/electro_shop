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

  private function _do_upload(){
		$config['upload_path']          = 'assets/images/bukti_bayar/';
    $config['allowed_types']        = 'gif|jpg|jpeg|png';
    $config['max_size']             = 5000; //set max size allowed in Kilobyte
    $config['max_width']            = 4000; // set max width image allowed
    $config['max_height']           = 4000; // set max height allowed
    $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

    $this->load->library('upload', $config);

    if(!$this->upload->do_upload('foto')) //upload and validate
    {
      $data['inputerror'] = 'foto';
			$data['message'] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

  public function uploadBuktiBayar($id_penjualan){
    $data = array(
            "status_penjualan" => "DITERIMA",
          );

    if(!empty($_FILES['foto']['name'])){
      $upload = $this->_do_upload();
      $data['bukti_bayar'] = $upload;
    }

    $this->db->where('id_penjualan', $id_penjualan);
    $this->db->update('tb_penjualan', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Bukti Pembayran telah terupload");
    echo json_encode($output);
  }

  public function batalPesan(){
    $this->db->where('id_penjualan', $this->input->post('id_penjualan'));
    $this->db->delete('tb_penjualan');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}