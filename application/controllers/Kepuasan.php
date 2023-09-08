<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepuasan extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index()
	{
		$this->load->view('template/back/header');
    $this->load->view('template/back/topmenu');
    $this->load->view('pages/back/kepuasan');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $this->db->from('tb_penilaian');
    $this->db->order_by('tgl_penilaian', 'desc');
    $data['data'] = $this->db->get()->result();
    echo json_encode($data);
  }

}