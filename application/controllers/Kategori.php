<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index()
	{
		$this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/kategori');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $this->db->from('tb_kategori_barang');
    $this->db->order_by('nm_kategori', 'asc');
    $data['data'] = $this->db->get()->result();
    echo json_encode($data);
  }


  public function generateId(){
    $unik = 'K';
    $kode = $this->db->query("SELECT MAX(id_kategori) LAST_NO FROM tb_kategori_barang WHERE id_kategori LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 1, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');

    $this->form_validation->set_rules('nm_kategori', 'nm_kategori', 'required|is_unique[tb_kategori_barang.nm_kategori]');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_kategori" => $id,
              "nm_kategori" => $this->input->post('nm_kategori'),
            );
    $this->db->insert('tb_kategori_barang', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_kategori', 'Nama kategori', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "nm_kategori" => $this->input->post('nm_kategori'),
    );
    $this->db->where('id_kategori', $this->input->post('id_kategori'));
    $this->db->update('tb_kategori_barang', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_kategori', $this->input->post('id_kategori'));
    $this->db->delete('tb_kategori_barang');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}
