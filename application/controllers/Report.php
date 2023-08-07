<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

  public function __construct(){
      parent::__construct();
  
      if(!$this->session->userdata('id_user'))
        redirect('login', 'refresh');

      $this->load->library('pdf');
  }

	public function ctkStruk()
	{
		$data['data'] = $this->db->query("
      SELECT * FROM tb_penjualan
    ")->result_array();

    // $this->pdf->setPaper('A4', 'potrait');
    $customPaper = array(0,0,230,360);
    $this->pdf->set_paper($customPaper);
    $this->pdf->filename = "ctk_struk.pdf";
    $this->pdf->load_view('report/ctk_struk', $data);

	}
}
