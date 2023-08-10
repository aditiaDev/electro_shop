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
</div>
<!-- /SECTION -->

		
<script src="<?php echo base_url(); ?>assets/template/front/js/jquery.min.js"></script>
<script>
  var tb_data;

  $(function(){
    
    REFRESH_DATA()
    $(".dataTables_filter, .dataTables_paginate").css("text-align", "right")
  })

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
                }else{
                  return data.status_penjualan
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
</script>