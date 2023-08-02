<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct(){
    parent::__construct();
    
  }

  public function index(){
    if($this->session->userdata('id_user'))
      redirect('front', 'refresh');

    $this->load->view('login');
  }

  public function login(){
    $this->db->where('username', $this->input->post('username'));  
    $this->db->where('password', $this->input->post('password'));  
    $query = $this->db->get('tb_user');   
    if($query->num_rows() > 0){  
      foreach ($query->result() as $row)
      {   
        $arrdata = array(
          'id_user'=>$row->id_user,
          'level'=>$row->level,
          'nm_pengguna'=>$row->nm_pengguna,
        );  
          $this->session->set_userdata($arrdata);
      }

      $output = array("status" => "success", "message" => "Login Berhasil");
    }else{  
      $output = array("status" => "error", "message" => "Login Gagal");  
    }

    echo json_encode($output);
  }

  function logout(){
    $this->session->unset_userdata('id_user');
    $this->session->sess_destroy();
    redirect('/', 'refresh');
  }

}