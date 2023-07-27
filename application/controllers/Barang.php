<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index()
	{
		$this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/barang');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("
    SELECT B.nm_kategori, A.id_barang, A.id_kategori, A.nm_barang, 
    A.harga, A.unit_pengukuran, A.foto_barang, A.ket_barang 
    FROM tb_barang A 
    LEFT JOIN tb_kategori_barang B ON A.id_kategori = B.id_kategori
    ")->result();
    echo json_encode($data);
  }

  private function _do_upload(){
		$config['upload_path']          = 'assets/images/barang/';
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

  public function generateId(){
    $unik = 'B'.date('y');
    $kode = $this->db->query("SELECT MAX(id_barang) LAST_NO FROM tb_barang WHERE id_barang LIKE '".$unik."%'")->row()->LAST_NO;
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

    if(!empty($_FILES['foto']['name'])){
      $upload = $this->_do_upload();
      $data['foto'] = $upload;
    }

    $this->db->insert('tb_barang', $data);
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
