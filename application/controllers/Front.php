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

  public function generateId(){
    $unik = 'J'.date('y');
    $kode = $this->db->query("SELECT MAX(id_penjualan) LAST_NO FROM tb_penjualan WHERE id_penjualan LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function checkOutSave(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('nm_penerima', 'Nama Penerima', 'required');
    $this->form_validation->set_rules('kota_asal', 'kota_asal', 'required');
    $this->form_validation->set_rules('kota_tujuan', 'kota_tujuan', 'required');
    $this->form_validation->set_rules('kurir', 'kurir', 'required');
    $this->form_validation->set_rules('layanan', 'layanan', 'required');
    $this->form_validation->set_rules('harga_kirim', 'harga Pengiriman', 'required');
    $this->form_validation->set_rules('estimasi', 'estimasi', 'required');
    $this->form_validation->set_rules('alamat_penerima', 'alamat_penerima', 'required');


    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();

    $id_user = $this->session->userdata('id_user');

    $id_pelanggan = $this->db->query("SELECT id_pelanggan FROM tb_pelanggan WHERE id_user = '".$id_user."'")->row()->id_pelanggan;
    
    $data = array(
              "id_penjualan" => $id,
              "tgl_penjualan" => date('Y-m-d H:i:s'),
              "id_pelanggan" => $id_pelanggan,
              "tipe_penjualan" => 'ONLINE',
              "diskon" => 0,
              "tot_biaya_barang" => 0,
              "tot_akhir" => 0,
              "status_penjualan" => "MENUNGGU PEMBAYARAN"
            );
    $this->db->insert('tb_penjualan', $data);

    $data = array(
          "id_penjualan" => $id,
          "nm_penerima" => $this->input->post('nm_penerima'),
          "kota_asal" => $this->input->post('kota_asal'),
          "kota_tujuan" => $this->input->post('kota_tujuan'),
          "kurir" => $this->input->post('kurir'),
          "harga" => $this->input->post('harga_kirim'),
          "estimasi" => $this->input->post('estimasi'),
          "layanan" => $this->input->post('layanan'),
          "alamat_penerima" => $this->input->post('alamat_penerima'),
        );
    $this->db->insert('tb_pengiriman', $data);

    $subtotal = 0;
    $total_barang = 0;
    $total_akhir = 0;
    foreach($this->input->post('id_barang') as $key => $each){
      $subtotal = $this->input->post('qty')[$key] * $this->input->post('harga')[$key];
      $total_barang = $total_barang + $subtotal;

      $dataDtl = array(
        "id_penjualan" => $id,
        "id_barang" => $this->input->post('id_barang')[$key],
        "jumlah" => $this->input->post('qty')[$key],
        "harga" => $this->input->post('harga')[$key],
        "diskon" => 0,
        "subtotal" => $subtotal,
      );

      $this->db->insert('tb_dtl_penjualan', $dataDtl);
    }

    $total_akhir = $total_barang + $this->input->post('harga_kirim');

    $this->db->query("UPDATE tb_penjualan 
    SET tot_biaya_barang = '".$total_barang."', tot_akhir = '".$total_akhir."'
    WHERE id_penjualan = '".$id."'
    ");

    $this->db->query("
    DELETE FROM tb_temp_chart WHERE id_user = '".$id_user."'
    ");

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

}