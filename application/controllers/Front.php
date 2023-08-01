<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
        $this->load->helper('url');
		$this->load->library('pagination');
		$this->load->database();
    }

	public function index()
	{
        $this->db->order_by("nm_kategori", "asc");
        $data['kategori'] = $this->db->get('tb_kategori_barang')->result();

        $data['merk'] = $this->db->query("select distinct merk from tb_barang where merk not in ('-') order by merk")->result();
        
        $head['jml_chart'] = $this->db->query("select count(*) as jml_chart from tb_temp_chart")->row()->jml_chart;
        $this->load->view('template/front/header',$head);
        $this->load->view('template/front/menu');
        $this->load->view('pages/front/home', $data);
        $this->load->view('template/front/footer');
	}

    public function loadRecord($rowno=0){
 
        $rowperpage = 15;
 
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
  
        $allcount = $this->db->count_all('tb_barang');
 
        $this->db->limit($rowperpage, $rowno);
        $users_record = $this->db->get('tb_barang')->result_array();
  
        $config['base_url'] = base_url().'welcome/loadRecord';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
 
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
 
        $this->pagination->initialize($config);
 
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
 
        echo json_encode($data);
  	}

}