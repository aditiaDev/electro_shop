<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usercomplaint extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        if(!$this->session->userdata('id_user'))
          redirect('login', 'refresh');
    }

	public function index()
	{
		$this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/complaint');
    $this->load->view('template/back/footer');

	}

  public function getComplaint(){
    $data['data'] = $this->db->query("SELECT A.*, B.id_pelanggan, C.nm_pelanggan FROM tb_complaint A
    LEFT JOIN tb_penjualan B ON A.id_penjualan = B.id_penjualan
    LEFT JOIN tb_pelanggan C ON B.id_pelanggan = C.id_pelanggan
    ORDER BY A.tgl_complaint DESC")->result();
    echo json_encode($data);
  }

  public function changeStatus(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_complaint', 'id_complaint', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "status" => "CLOSED",
    );
    $this->db->where('id_complaint', $this->input->post('id_complaint'));
    $this->db->update('tb_complaint', $data);

    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function usercomplaintdtl($id_complaint){

    $data['data'] = $this->db->query("SELECT 
      id_complaint, tgl_jawab, deskripsi, 
      case when oleh = 'ADMIN' then 'Admin' else 'Pelanggan' end as oleh, id_user,
      case when oleh = 'ADMIN' then 'avatar5.png' else 'avatar4.png' end as avatar
    FROM tb_jawab_complaint
    WHERE id_complaint='".$id_complaint."'
    ORDER BY tgl_jawab DESC")->result();

    $this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/usercomplaindtl', $data);
    $this->load->view('template/back/footer');
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

    
    $data = array(
              "id_complaint" => $this->input->post('id_complaint'),
              "tgl_jawab" => date('Y-m-d H:i:s'),
              "id_user" => $this->session->userdata('id_user'),
              "deskripsi" => $this->input->post('deskripsi'),
              "oleh" => "ADMIN",
            );

    
    $this->db->insert('tb_jawab_complaint', $data);
    $output = array("status" => "success", "message" => "Pesan Terkirim");
    echo json_encode($output);

  }
}