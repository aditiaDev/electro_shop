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
    $id_pelanggan = $this->db->query(
      "SELECT id_pelanggan FROM tb_pelanggan WHERE id_user='".$this->session->userdata('id_user')."'"
    )->row()->id_pelanggan;

    $rows = $this->db->query("
      SELECT 
      A.id_penjualan,
      DATE_FORMAT(A.tgl_penjualan, '%d %b %Y') as tgl_penjualan,
      a.tipe_penjualan,
      B.id_barang,
      C.nm_barang,
      B.jumlah,
      B.harga,
      B.subtotal,
      A.status_penjualan,
      CASE WHEN D.id_penilaian IS NOT NULL THEN 'SUDAH' ELSE 'BELUM' END PENILAIAN
      FROM tb_penjualan A
      LEFT JOIN tb_dtl_penjualan B ON A.id_penjualan = B.id_penjualan
      LEFT JOIN tb_barang C ON B.id_barang = C.id_barang
      LEFT JOIN tb_penilaian D ON D.id_penjualan = A.id_penjualan
      WHERE A.id_pelanggan = '".$id_pelanggan."'
    ")->result_array();
    
    $i=0;
    foreach($rows as $row){
      $data['data'][$i]['id_penjualan'] = $row['id_penjualan'];
      $data['data'][$i]['tgl_penjualan'] = $row['tgl_penjualan'];
      $data['data'][$i]['tipe_penjualan'] = $row['tipe_penjualan'];
      $data['data'][$i]['id_barang'] = $row['id_barang'];

      $data['data'][$i]['nm_barang'] = $row['nm_barang'];
      $data['data'][$i]['jumlah'] = $row['jumlah'];
      $data['data'][$i]['harga'] = $row['harga'];
      $data['data'][$i]['subtotal'] = $row['subtotal'];
      $data['data'][$i]['PENILAIAN'] = $row['PENILAIAN'];
      

      $status = $row['status_penjualan'];
      if($row['tipe_penjualan'] == "ONLINE" AND $row['status_penjualan'] == "MENUNGGU PEMBAYARAN"){
        $retPenjualan = $this->cekPembayaranOnline($row['id_penjualan']);
        // echo "</br>";
        // print_r($retPenjualan);
        if(@$retPenjualan->status_code != "404" and strtoupper(@$retPenjualan->transaction_status) == "SETTLEMENT"){
          $status = "DISIAPKAN";
          $this->db->query(
            "UPDATE tb_penjualan SET status_penjualan = 'DISIAPKAN' WHERE id_penjualan = '".$row['id_penjualan']."'"
          );
        }else{
          $status = $row['status_penjualan'];
        }
      }

      $data['data'][$i]['status_penjualan'] = $status;
      
      $i++;
    }

    echo json_encode($data);
  }

  public function cekPembayaranOnline($id){
    $id_penjualan = $id;

    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.midtrans.com/v2/".$id_penjualan."/status");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Accept: application/json',
      'Authorization: Basic ' . base64_encode('SB-Mid-server-ij2O22aUOUuH5-RZB5Tyyynn' . ':')
    )); 

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/cacert.pem"); 
    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    $data = json_decode($output);
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";

    return $data;
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
  
  public function generateId(){
    $unik = 'N'.date('y');
    $kode = $this->db->query("SELECT MAX(id_penilaian) LAST_NO FROM tb_penilaian WHERE id_penilaian LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function penilaian(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('score', 'score', 'required');
    $this->form_validation->set_rules('masukan', 'masukan', 'required');

    
    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_penilaian" => $id,
              "tgl_penilaian" => date('Y-m-d'),
              "id_penjualan" => $this->input->post('id_penjualan'),
              "nilai" => $this->input->post('score'),
              "masukan" => $this->input->post('masukan'),
              "id_user" => $this->session->userdata('id_user'),
            );
    $this->db->insert('tb_penilaian', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);
  }

}