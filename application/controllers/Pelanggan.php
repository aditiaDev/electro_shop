<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index()
	{

		$this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/pelanggan');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("
      SELECT A.*, B.username, B.password FROM tb_pelanggan A
      LEFT JOIN tb_user B ON A.id_user = B.id_user
    ")->result();
    echo json_encode($data);
  }

  public function getPelanggan(){
    $data['data'] = $this->db->query("
      SELECT * FROM tb_pelanggan 
    ")->result();
    echo json_encode($data);
  }

  public function newUser(){
    $user_id = $this->generateId();

    echo $user_id;
  }

  public function generateId(){
    $unik = 'P'.date('y');
    $kode = $this->db->query("SELECT MAX(id_pelanggan) LAST_NO FROM tb_pelanggan WHERE id_pelanggan LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membentuk kode barang baru
    // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function generateId_user(){
    $unik = 'U'.date('y');
    $kode = $this->db->query("SELECT MAX(id_user) LAST_NO FROM tb_user WHERE id_user LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membentuk kode barang baru
    // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama pelanggan', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'No pelanggan', 'required');
    $this->form_validation->set_rules('alamat', 'alamat', 'required');

    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]');
    $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    $id_user = $this->generateId_user();

    $dataUser = array(
      "id_user" => $id_user,
      "nm_pengguna" => $this->input->post('nm_pelanggan'),
      "username" => $this->input->post('username'),
      "password" => $this->input->post('password'),
      "password" => "PELANGGAN",
    );
    $this->db->insert('tb_user', $dataUser);
    
    $data = array(
              "id_pelanggan" => $id,
              "id_user" => $id_user,
              "nm_pelanggan" => $this->input->post('nm_pelanggan'),
              "no_pelanggan" => $this->input->post('no_pelanggan'),
              "alamat" => $this->input->post('alamat'),
              "tgl_register" => date('Y-m-d'),
            );
    $this->db->insert('tb_pelanggan', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama pelanggan', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'No pelanggan', 'required');
    $this->form_validation->set_rules('alamat', 'alamat', 'required');

    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
        "id_user" => $id_user,
        "nm_pelanggan" => $this->input->post('nm_pelanggan'),
        "no_pelanggan" => $this->input->post('no_pelanggan'),
        "alamat" => $this->input->post('alamat'),
        "username" => $this->input->post('username'),
        "password" => $this->input->post('password'),
    );
    $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
    $this->db->update('tb_pelanggan', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
    $this->db->delete('tb_pelanggan');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

  
}
