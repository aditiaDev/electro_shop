<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Penjualan extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');

        $params = array('server_key' => 'SB-Mid-server-ij2O22aUOUuH5-RZB5Tyyynn', 'production' => false);
        $this->load->library('midtrans');
        $this->midtrans->config($params);
        $this->load->helper('url');
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
    $rows = $this->db->query("
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
      $data['data'][$i]['SUB_TOTAL'] = $row['SUB_TOTAL'];
      $data['data'][$i]['id_pelanggan'] = $row['id_pelanggan'];
      $data['data'][$i]['nm_pelanggan'] = $row['nm_pelanggan'];
      
      $data['data'][$i]['bukti_bayar'] = $row['bukti_bayar'];

      $status = $row['status_penjualan'];
      if($row['tipe_penjualan'] == "ONLINE" AND $row['status_penjualan'] == "MENUNGGU PEMBAYARAN"){
        $retPenjualan = $this->cekPembayaranOnline($row['id_penjualan']);

        if($retPenjualan->status_code != "404" and strtoupper($retPenjualan->transaction_status) == "SETTLEMENT"){
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

  public function test(){
    $id_penjualan = 'J2300018';

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
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    // return $data;
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
              "point_pengurangan" => $this->input->post('jml_point'),
              "tot_biaya_barang" => $this->input->post('tot_biaya_barang'),
              "tot_akhir" => $this->input->post('tot_akhir'),
              "status_penjualan" => "SELESAI"
            );
    $this->db->insert('tb_penjualan', $data);

    if( $this->input->post('id_pelanggan') <> "GUEST" ){
      $this->db->query("
        UPDATE tb_pelanggan SET jml_point = ( jml_point - ".$this->input->post('jml_point')." )
        WHERE id_pelanggan = '".$this->input->post('id_pelanggan')."'
      ");

      $potongan_point = $this->db->query("
            SELECT MAX(potongan_point) potongan_point FROM tb_sys_point
      ")->row()->potongan_point;

      $calc_point = ($potongan_point/100) * $this->input->post('tot_akhir');
      $this->db->query("
        UPDATE tb_pelanggan SET jml_point = ( jml_point + ".$calc_point." )
        WHERE id_pelanggan = '".$this->input->post('id_pelanggan')."'
      ");
    }
    

    $subtotal = 0;
    foreach($this->input->post('id_barang') as $key => $each){
      $subtotal = ( $this->input->post('qty')[$key] * $this->input->post('harga')[$key] ) - $this->input->post('diskon')[$key];


      $dataDtl = array(
        "id_penjualan" => $id,
        "id_barang" => $this->input->post('id_barang')[$key],
        "jumlah" => $this->input->post('qty')[$key],
        "harga" => $this->input->post('harga')[$key],
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
