<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Front extends CI_Controller {

  public function __construct(){
      parent::__construct();
  
      // if(!$this->session->userdata('id_user'))
      //   redirect('login', 'refresh');

      $params = array('server_key' => 'SB-Mid-server-ij2O22aUOUuH5-RZB5Tyyynn', 'production' => false);
      $this->load->library('midtrans');
      $this->midtrans->config($params);
      
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
        $users_record = $this->db->query("SELECT * FROM tb_barang 
        WHERE id_kategori LIKE '%".$this->input->get('kategori')."%'
        AND merk LIKE '%".$this->input->get('merk')."%'
        AND nm_barang LIKE '%".$this->input->get('barang')."%'
        AND stock > 0
        ")->result_array();
  
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
        A.id_barang, A.qty, A.harga, B.stock, B.nm_barang, (A.qty * A.harga) as sub_total
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

  public function generateIdBarangKeluar(){
    $unik = 'K'.date('y');
    $kode = $this->db->query("SELECT MAX(id_barang_keluar) LAST_NO FROM tb_barang_keluar WHERE id_barang_keluar LIKE '".$unik."%'")->row()->LAST_NO;
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
              "point_pengurangan" => $this->input->post('jml_point'),
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
        "subtotal" => $subtotal,
      );

      $this->db->insert('tb_dtl_penjualan', $dataDtl);

      $id_barang_keluar = $this->generateIdBarangKeluar();

      $dataDtl2 = array(
        "id_barang_keluar" => $id_barang_keluar,
        "doc_referensi" => $id,
        "doc_tipe" => "PENJUALAN",
        "tgl_barang_keluar" => date('Y-m-d H:i:s'),
        "id_barang" => $this->input->post('id_barang')[$key],
        "jumlah" => $this->input->post('qty')[$key],
        "harga" => $this->input->post('harga')[$key],
      );

      $this->db->insert('tb_barang_keluar', $dataDtl2);

      $this->db->query("
        UPDATE tb_barang SET stock = ( stock - ".$this->input->post('qty')[$key]." ) 
        WHERE id_barang = '".$this->input->post('id_barang')[$key]."'
      ");
    }

    $total_akhir = $total_barang + $this->input->post('harga_kirim') - $this->input->post('jml_point');

    $this->db->query("UPDATE tb_penjualan 
    SET tot_biaya_barang = '".$total_barang."', tot_akhir = '".$total_akhir."'
    WHERE id_penjualan = '".$id."'
    ");

    $this->db->query("
    DELETE FROM tb_temp_chart WHERE id_user = '".$id_user."'
    ");

    $this->db->query("
      UPDATE tb_pelanggan SET jml_point = ( jml_point - ".$this->input->post('jml_point')." )
      WHERE id_pelanggan = '".$id_pelanggan."'
    ");

    $potongan_point = $this->db->query("
          SELECT MAX(potongan_point) potongan_point FROM tb_sys_point
    ")->row()->potongan_point;

    $calc_point = ($potongan_point/100) * $total_akhir;
    $this->db->query("
      UPDATE tb_pelanggan SET jml_point = ( jml_point + ".$calc_point." )
      WHERE id_pelanggan = '".$id_pelanggan."'
    ");

    $token = $this->token($id);

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan", "token" => $token);
    echo json_encode($output);

  }

  public function token($id){
    $id_penjualan = $id;
    $tot_bayar = $this->db->query(
      "SELECT tot_akhir FROM tb_penjualan WHERE id_penjualan = '".$id_penjualan."'"
    )->row()->tot_akhir;

    // //Required
    $transaction_details = array(
      'order_id' => $id_penjualan,
      'gross_amount' => $tot_bayar, // no decimal allowed for creditcard
    );

    // Optional
    // $item1_details = array(
    //   'id' => $id_event,
    //   'price' => $event[0]['biaya_pendaftaran'],
    //   'quantity' => 1,
    //   'name' => $event[0]['nm_event']
    // );

    // // Optional
    // $item_details = array ($item1_details);

    // // Optional
    // $customer_details = array(
    //   'first_name'    => "Yusuf",
    //   'last_name'     => "Hayhay",
    //   'email'         => "Yusuf@Hayhay.com",
    //   'phone'         => "085632436786",
    // );

    // Data yang akan dikirim untuk request redirect_url.
    $credit_card['secure'] = true;
    //ser save_card true to enable oneclick or 2click
    //$credit_card['save_card'] = true;

    $time = time();
    $custom_expiry = array(
        'start_time' => date("Y-m-d H:i:s O",$time),
        'unit' => 'hour', 
        'duration'  => 24
    );
    
    $transaction_data = array(
        'transaction_details'=> $transaction_details,
        // 'item_details'       => $item_details,
        // 'customer_details'   => $customer_details,
        'credit_card'        => $credit_card,
        'expiry'             => $custom_expiry
    );

    error_log(json_encode($transaction_data));
    $snapToken = $this->midtrans->getSnapToken($transaction_data);
    error_log($snapToken);
    return $snapToken;
    
  }

  public function bayar(){
    $id_penjualan = $this->input->post('id');
    $tot_bayar = $this->db->query(
      "SELECT tot_akhir FROM tb_penjualan WHERE id_penjualan = '".$id_penjualan."'"
    )->row()->tot_akhir;

    // //Required
    $transaction_details = array(
      'order_id' => $id_penjualan,
      'gross_amount' => $tot_bayar, // no decimal allowed for creditcard
    );

    // Optional
    // $item1_details = array(
    //   'id' => $id_event,
    //   'price' => $event[0]['biaya_pendaftaran'],
    //   'quantity' => 1,
    //   'name' => $event[0]['nm_event']
    // );

    // // Optional
    // $item_details = array ($item1_details);

    // // Optional
    // $customer_details = array(
    //   'first_name'    => "Yusuf",
    //   'last_name'     => "Hayhay",
    //   'email'         => "Yusuf@Hayhay.com",
    //   'phone'         => "085632436786",
    // );

    // Data yang akan dikirim untuk request redirect_url.
    $credit_card['secure'] = true;
    //ser save_card true to enable oneclick or 2click
    //$credit_card['save_card'] = true;

    $time = time();
    $custom_expiry = array(
        'start_time' => date("Y-m-d H:i:s O",$time),
        'unit' => 'hour', 
        'duration'  => 24
    );
    
    $transaction_data = array(
        'transaction_details'=> $transaction_details,
        // 'item_details'       => $item_details,
        // 'customer_details'   => $customer_details,
        'credit_card'        => $credit_card,
        'expiry'             => $custom_expiry
    );

    error_log(json_encode($transaction_data));
    $snapToken = $this->midtrans->getSnapToken($transaction_data);
    error_log($snapToken);
    echo $snapToken;
    
  }

}