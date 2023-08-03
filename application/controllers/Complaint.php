<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        if(!$this->session->userdata('id_user'))
          redirect('login', 'refresh');
    }

	public function index()
	{
		$this->load->view('template/front/header');
    $this->load->view('template/front/menu');
    $this->load->view('pages/front/complaint');
    $this->load->view('template/front/footer');

	}

  public function getComplaintByUser(){
    $data['data'] = $this->db->query("SELECT * FROM tb_complaint 
    WHERE id_user = '".$this->session->userdata('id_user')."'")->result();
    echo json_encode($data);
  }

  private function _do_upload(){
		$config['upload_path']          = 'assets/images/complaint/';
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
    $unik = 'C'.date('y');
    $kode = $this->db->query("SELECT MAX(id_complaint) LAST_NO FROM tb_complaint WHERE id_complaint LIKE '".$unik."%'")->row()->LAST_NO;

    $urutan = (int) substr($kode, 3, 5);
    
    $urutan++;
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');

    $this->form_validation->set_rules('id_penjualan', 'No Pembelian', 'required');
    $this->form_validation->set_rules('judul_complaint', 'judul_complaint', 'required');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi Complaint', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_complaint" => $id,
              "id_penjualan" => $this->input->post('id_penjualan'),
              "id_user" => $this->session->userdata('id_user'),
              "tgl_complaint" => date('Y-m-d'),
              "judul_complaint" => $this->input->post('judul_complaint'),
              "deskripsi" => $this->input->post('deskripsi'),
              "status" => "OPEN",
            );

    if(!empty($_FILES['foto']['name'])){
      $upload = $this->_do_upload();
      $data['foto'] = $upload;
    }
    
    $this->db->insert('tb_complaint', $data);
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
    $this->db->where('id_complaint', $this->input->post('id_complaint'));
    $this->db->delete('tb_complaint');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

  public function dtlComplaint($id_Complaint){
    $data['data'] = $this->db->query("SELECT 
      id_complaint, tgl_jawab, deskripsi, 
      case when oleh = 'ADMIN' then 'Admin' else 'You' end as oleh, id_user,
      case when oleh = 'ADMIN' then 'avatar5.png' else 'avatar4.png' end as avatar
    FROM tb_jawab_complaint
    WHERE id_complaint='".$id_Complaint."'
    ORDER BY tgl_jawab DESC")->result();

    // $data['data'] = $id_Complaint;

    $this->load->view('template/front/header');
    $this->load->view('template/front/menu');
    $this->load->view('pages/front/dtlcomplaint',$data);
    $this->load->view('template/front/footer');
  }

  public function saveComplaint(){
    
    $this->load->library('form_validation');

    $this->form_validation->set_rules('id_complaint', 'No Complaint', 'required');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi Complaint', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    // $id = $this->generateId();
    
    $data = array(
              "id_complaint" => $this->input->post('id_complaint'),
              "tgl_jawab" => date('Y-m-d H:i:s'),
              "id_user" => $this->session->userdata('id_user'),
              "deskripsi" => $this->input->post('deskripsi'),
              "oleh" => "PELANGGAN",
            );

    
    $this->db->insert('tb_jawab_complaint', $data);
    $output = array("status" => "success", "message" => "Pesan Terkirim");
    echo json_encode($output);

  }
}
