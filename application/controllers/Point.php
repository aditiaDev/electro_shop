<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Point extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index()
	{
		$this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/point');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $this->db->from('tb_sys_point');
    $data['data'] = $this->db->get()->result();
    echo json_encode($data);
  }

  public function saveData(){
    
    $this->load->library('form_validation');

    $this->form_validation->set_rules('potongan_point', 'Penambahan Point (%)', 'required|numeric');
    $this->form_validation->set_rules('min_point', 'Minimal Penggunaan Point', 'required|numeric');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "potongan_point" => $this->input->post('potongan_point'),
              "min_point" => $this->input->post('min_point'),
            );
    $this->db->insert('tb_sys_point', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('potongan_point', 'Penambahan Point (%)', 'required|numeric');
    $this->form_validation->set_rules('min_point', 'Minimal Penggunaan Point', 'required|numeric');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "potongan_point" => $this->input->post('potongan_point'),
      "min_point" => $this->input->post('min_point'),
    );
    $this->db->where('id', $this->input->post('id'));
    $this->db->update('tb_sys_point', $data);

    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id', $this->input->post('id'));
    $this->db->delete('tb_sys_point');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}
