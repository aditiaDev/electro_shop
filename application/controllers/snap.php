<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Snap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
      parent::__construct();
      $params = array('server_key' => 'SB-Mid-server-ij2O22aUOUuH5-RZB5Tyyynn', 'production' => false);
      $this->load->library('midtrans');
      $this->midtrans->config($params);
      $this->load->helper('url');	
    }

    public function index()
    {
    	$this->load->view('checkout_snap');
    }

    public function token(){
      // $id_event = $this->input->post('id_event');
      // $event = $this->db->query("SELECT nm_event, biaya_pendaftaran FROM tb_event WHERE id_event='".$id_event."'")->result_array();
      
      // $unik = 'DF'.date('Ym');
      // $kode = $this->db->query("select MAX(id_pendaftaran) LAST_NO from tb_pendaftaran WHERE id_pendaftaran LIKE '".$unik."%'")->row()->LAST_NO;
      
      // $urutan = (int) substr($kode, -4);
      // $urutan++;
      // $kode = $unik . sprintf("%04s", $urutan);
      
      // $id_pesanan = rand();

      // $this->db->query("INSERT INTO tb_pendaftaran(id_pendaftaran,tgl_daftar,id_team,id_event,status_pendaftaran,id_pesanan)
      // VALUES('".$kode."', SYSDATE(), (SELECT id_team FROM tb_team WHERE id_user='".$this->session->userdata('id_user')."'), 
      // '".$id_event."', 'AKTIF', '".$id_pesanan."')");

      // //Required
      $transaction_details = array(
        'order_id' => '12345',
        'gross_amount' => 100000, // no decimal allowed for creditcard
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

    public function finish()
    {
    	$result = json_decode($this->input->post('result_data'));
    	// echo 'RESULT <br><pre>';
    	// var_dump($result);
    	// echo '</pre>' ;
      redirect('front', 'refresh');

    }

    public function status(){
      $data = $this->midtrans->status('828784954');
      print_r($data);
    }
}
