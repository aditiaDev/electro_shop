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
        
        

        $this->load->view('template/front/header');
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

    public function addToChart(){
      $this->load->library('form_validation');

      $this->form_validation->set_rules('id_barang', 'Barang', 'required');

      if($this->form_validation->run() == FALSE){
        // echo validation_errors();
        $output = array("status" => "error", "message" => validation_errors());
        echo json_encode($output);
        return false;
      }
  
      $cek_barang = $this->db->query("select count(*) as cek_barang from tb_temp_chart WHERE id_barang='".$this->input->post('id_barang')."' AND id_user='".$this->session->userdata('id_user')."'")->row()->cek_barang;
      if($cek_barang == 0){
        $data = array(
          "id_barang" => $this->input->post('id_barang'),
          "id_user" => $this->session->userdata('id_user'),
          "qty" => 1,
          "harga" => $this->input->post('harga'),
        );
        $this->db->insert('tb_temp_chart', $data);
      }else{
        $this->db->query("
        UPDATE tb_temp_chart SET qty = qty+1 
        WHERE id_barang = '".$this->input->post('id_barang')."'
        AND id_user = '".$this->session->userdata('id_user')."'
        ");
      }
      
      $output = array("status" => "success", "message" => "Berhasil memasukkan ke keranjang");
      echo json_encode($output);
    }

    public function count_chart(){
      $jml_chart = $this->db->query("select count(*) as jml_chart from tb_temp_chart WHERE id_user='".$this->session->userdata('id_user')."'")->row()->jml_chart;
      echo $jml_chart;
    }

  public function checkout(){
        $data['item_order'] = $this->db->query("
        SELECT 
        A.id_barang, A.qty, A.harga, B.nm_barang, (A.qty * A.harga) as sub_total
        FROM tb_temp_chart A
        INNER JOIN tb_barang B ON A.id_barang = B.id_barang
        WHERE A.id_user='".$this->session->userdata('id_user')."'
        ")->result();
        $this->load->view('template/front/header');
        $this->load->view('template/front/menu');
        $this->load->view('pages/front/checkout', $data);
        $this->load->view('template/front/footer');
	}

  public function deleteKeranjang(){
    $this->db->where('id_barang', $this->input->post('id_barang'));
    $this->db->where('id_user', $this->session->userdata('id_user'));
    $this->db->delete('tb_temp_chart');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}