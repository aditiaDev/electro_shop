<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangmasuk extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index()
	{
		$this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/barangmasuk');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("
    SELECT A.id_barang_masuk, A.id_barang, A.doc_tipe, A.tgl_barang_masuk, 
    A.jumlah, A.harga, A.ket_barang_masuk, B.nm_barang, B.unit_pengukuran
    FROM tb_barang_masuk as A
    LEFT JOIN tb_barang as B ON A.id_barang = B.id_barang
    ")->result();
    echo json_encode($data);
  }


  public function generateId(){
    $unik = 'M'.date('y');
    $kode = $this->db->query("SELECT MAX(id_barang_masuk) LAST_NO FROM tb_barang_masuk WHERE id_barang_masuk LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');

    $this->form_validation->set_rules('id_barang', 'id_barang', 'required');
    $this->form_validation->set_rules('doc_tipe', 'doc_tipe', 'required');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
    $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_barang_masuk" => $id,
              "id_barang" => $this->input->post('id_barang'),
              "doc_tipe" => $this->input->post('doc_tipe'),
              "tgl_barang_masuk" => date('Y-m-d H:i:s'),
              "ket_barang_masuk" => $this->input->post('ket_barang_masuk'),
              "jumlah" => $this->input->post('jumlah'),
              "harga" => $this->input->post('harga'),
              "doc_referensi" => $this->input->post('doc_referensi'),
            );
    $this->db->insert('tb_barang_masuk', $data);

    $this->db->query("
      UPDATE tb_barang set stock = ( stock + ".$this->input->post('jumlah')." ),
      harga = '".$this->input->post('harga')."'
      WHERE id_barang = '".$this->input->post('id_barang')."'
    ");

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_barang', 'id_barang', 'required');
    $this->form_validation->set_rules('doc_tipe', 'doc_tipe', 'required');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
    $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "id_barang" => $this->input->post('id_barang'),
      "doc_tipe" => $this->input->post('doc_tipe'),
      "tgl_barang_masuk" => date('Y-m-d H:i:s'),
      "ket_barang_masuk" => $this->input->post('ket_barang_masuk'),
      "jumlah" => $this->input->post('jumlah'),
      "harga" => $this->input->post('harga'),
      "doc_referensi" => $this->input->post('doc_referensi'),
    );
    $this->db->where('id_barang_masuk', $this->input->post('id_barang_masuk'));
    $this->db->update('tb_barang_masuk', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_barang_masuk', $this->input->post('id_barang_masuk'));
    $this->db->delete('tb_barang_masuk');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}
