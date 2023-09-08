<link rel="stylesheet" href="<?php echo base_url('/assets/raty/jquery.raty.css'); ?>">
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb-tree">
					<li><a href="<?php echo base_url('front'); ?>">Home</a></li>
					<li class="active"><a href="javascript;:">All Categories</a></li>
				</ul>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
    <div class="row">
      <div class="col-md-8">
        <table class="table table-bordered table-strpped table-hover">
          <tbody>
            <tr>
              <td colspan="3">Silahkan untuk melakukan Pembayaran melalui Bank Transfer di bawah ini.</td>
            </tr>
            <tr>
              <td>BNI</td>
              <td>0753788</td>
              <td>a/n Mahir Comp</td>
            </tr>
            <tr>
              <td>BCA</td>
              <td>000323-78687-4532</td>
              <td>a/n Mahir Comp</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
		<!-- row -->
		<div class="row">
      <div class="col-md-12">
        <table id="tb_data" class="table table-bordered table-strpped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>No Pemeblian</th>
              <th>Tanggal</th>
              <th style="width:350px;">Item</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Total</th>
              <th>Status Pesanan</th>
              <th>Action</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->

  <!-- Basic Modal -->
  <div class="modal fade" id="modal_add" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="FRM_DATA" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Tambah data</h4>
        </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Bukti Pembayaran</label>
                  <div class="custom-file">
                    <input type="file"  name="foto" accept="image/png, image/gif, image/jpeg">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btnModalbatal">Batal</button>
            <button type="submit" class="btn btn-primary" id="BTN_SAVE">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End Basic Modal-->

  <div class="modal fade" id="modal_nilai" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="FRM_NILAI" method="post" >
        <div class="modal-header">
          <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Berikan Penilaian</h4>
        </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Nilai</label>
                  <div class="demo"></div>

                </div>
                <div class="form-group">
                  <label>Masukan</label>
                  <textarea name="masukan" ows="3" class="form-control"></textarea>

                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary">Batal</button>
            <button type="button" class="btn btn-primary" id="BTN_SAVE_NILAI">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  
  
</div>
<!-- /SECTION -->
<form id="payment-form" method="post" action="<?=site_url()?>snap/finish">
  <input type="hidden" name="result_type" id="result-type" value=""></div>
  <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>
		
<script src="<?php echo base_url(); ?>assets/template/front/js/jquery.min.js"></script>
<script src="<?php echo base_url('/assets/raty/jquery.raty.js'); ?>"></script>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-C_hVzhEuRXcHPsa6"></script>
<script>
  var id_data
  var tb_data;

  $(function(){
    
    REFRESH_DATA()
    $(".dataTables_filter, .dataTables_paginate").css("text-align", "right")

    

  })

  $('.demo').raty({

});

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    tb_data =  $("#tb_data").DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('history/getDataByUser') ?>",
            "type": "POST",
        },
        "columns": [
            {
                "data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { "data": "id_penjualan", className: "text-center" },
            { "data": "tgl_penjualan", className: "text-center" },
            { "data": "nm_barang"},
            { "data": "jumlah", className: "text-right"},
            { "data": "harga", className: "text-right"},
            { "data": "subtotal", className: "text-right"},
            { "data": null, 
              "render" : function(data){
                if(data.status_penjualan == "DIKIRIM"){
                  return "<button class='btn btn-sm btn-warning' title='Hapus Data' onclick='changeStatus(\""+data.id_penjualan+"\", \"SELESAI\");'>Pesanan Diterima </button>"
                }else if(data.status_penjualan == "DITERIMA"){
                  return "Pesanan Sedang disiapkan Admin"
                }else{
                  return data.status_penjualan
                }
                
              },
            },
            { "data": null, 
              "render" : function(data){
                if(data.status_penjualan == "MENUNGGU PEMBAYARAN"){
                  return "<button class='btn btn-sm btn-primary' title='Bayar' onclick='bayar(\""+data.id_penjualan+"\");'>Bayar </button> "+
                        "<button class='btn btn-sm btn-info' title='Upload pembayaran' onclick='uploadPembayaran(\""+data.id_penjualan+"\");'>Upload Pembayaran </button> "+
                        "<button class='btn btn-sm btn-danger' title='Batalkan Pesanan' onclick='batalPesan(\""+data.id_penjualan+"\");'>Batalkan Pesanan </button>"
                }else{
                  return ""
                }
                
              },
            },
            { "data": null, 
              "render" : function(data){
                if(data.PENILAIAN != "SUDAH"){
                  return "<button class='btn btn-sm btn-warning' title='Nilai' onclick='nilai(\""+data.id_penjualan+"\");'>Nilai </button> "
                }else{
                  return ""
                }
              },
            },
        ]
      }
    )
  }

  function changeStatus(id_penjualan, status){
    $.ajax({
      url: "<?php echo site_url('penjualan/changeStatus') ?>",
      type: "POST",
      dataType: "JSON",
      beforeSend: function(){
        $("#LOADER").show();
      },
      complete: function(){
        $("#LOADER").hide();
      },
      data: {
        id_penjualan,
        status
      },
      success: function(data){
        if (data.status == "success") {
          toastr.info(data.message)
          REFRESH_DATA()

        }else{
          toastr.error(data.message)
        }
      }
    })
  }

  function bayar(id){
    $.ajax({
      url: "<?php echo site_url('front/bayar') ?>",
      type: "POST",
      // dataType: "JSON",
      data: {
        id
      },
      success: function(data){
        console.log(data)


          var resultType = document.getElementById('result-type');
          var resultData = document.getElementById('result-data');

          function changeResult(type,data){
            $("#result-type").val(type);
            $("#result-data").val(JSON.stringify(data));
          }

          snap.pay(data, {
            
            onSuccess: function(result){
              changeResult('success', result);
              console.log(result.status_message);
              console.log(result);
              $("#payment-form").submit();
            },
            onPending: function(result){
              changeResult('pending', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            },
            onError: function(result){
              changeResult('error', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            }
          });

      }
    })
  }

  function uploadPembayaran(id_penjualan){
    id_data = id_penjualan
    $("#modal_add").modal('show')
  }

  function nilai(id_penjualan){
    id_data = id_penjualan
    $("#modal_nilai").modal('show')
  }

  $("#btnModalbatal").click(function(){
    $("#modal_add").modal('hide')
  })

  $("#FRM_DATA").on('submit', function(event){
    event.preventDefault();
    let formData = new FormData(this);
    urlPost = "<?php echo site_url('history/uploadBuktiBayar/') ?>"+id_data;

    // console.log(formData)
    ACTION(urlPost, formData)
    // $("#modal_add").modal('hide')
  })

  function ACTION(urlPost, formData){
    $.ajax({
      url: urlPost,
      type: "POST",
      data: formData,
      beforeSend: function(){
        $("#LOADER").show();
      },
      complete: function(){
        $("#LOADER").hide();
      },
      processData : false,
      cache: false,
      contentType : false,
      success: function(data){
        data = JSON.parse(data)
        console.log(data)
        if (data.status == "success") {
          toastr.info(data.message)
          REFRESH_DATA()
          $("#modal_add").modal('hide')

        }else{
          toastr.error(data.message)
        }
      },
      error: function (err) {
        console.log(err);
      }
    })
  }

  function batalPesan(id_penjualan){
    if(!confirm('Batalkan Pesanan?')) return

    $.ajax({
      url: "<?php echo site_url('history/batalPesan') ?>",
      type: "POST",
      dataType: "JSON",
      beforeSend: function(){
        $("#LOADER").show();
      },
      complete: function(){
        $("#LOADER").hide();
      },
      data: {
        id_penjualan
      },
      success: function(data){
        if (data.status == "success") {
          toastr.info(data.message)
          REFRESH_DATA()
          

        }else{
          toastr.error(data.message)
        }
      }
    })
  }

  $("#BTN_SAVE_NILAI").click(function(){
    event.preventDefault();
    let formData = $("#FRM_NILAI").serialize();
    formData+="&id_penjualan="+id_data
    $.ajax({
      url: "<?php echo site_url('history/penilaian') ?>",
      type: "POST",
      data: formData,
      dataType: "JSON",
      beforeSend: function(){
        $("#LOADER").show();
      },
      complete: function(){
        $("#LOADER").hide();
      },
      success: function(data){
        if (data.status == "success") {
          toastr.info(data.message)
          REFRESH_DATA()
          $("#modal_nilai").modal('hide')

        }else{
          toastr.error(data.message)
        }
      }
    })
  })
</script>