<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
				<div class="col-md-12">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Data Kategori Barang</h4>

              <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                  <i class="ace-icon fa fa-chevron-up"></i>
                </a>

                <a href="#" data-action="close">
                  <i class="ace-icon fa fa-times"></i>
                </a>
              </div>
            </div>

            <div class="widget-body">
              <div class="widget-main">
                <table id="tb_data" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>ID Penjualan</th>
                      <th>Tanggal</th>
                      <th>Jns Penjualan</th>
                      <th>Pelanggan</th>
                      <th>Barang</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Total</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
          
        </div>
			</div><!-- /.row -->
		</div><!-- /.page-content -->

    
	</div>
</div><!-- /.main-content -->
<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script>
  $(document).ready(function () {
    REFRESH_DATA()
  });

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    var tb_data =  $("#tb_data").DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('penjualan/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "id_penjualan", className: "text-center" },
            { "data": "tgl_penjualan"},
            { "data": "tipe_penjualan"},
            { "data": null, 
              "render" : function(data){
                return data.id_pelanggan+"</br>"+data.nm_pelanggan
              },
            },
            { "data": null, 
              "render" : function(data){
                return data.id_barang+"</br>"+data.nm_barang
              },
            },
            { "data": "jumlah"},
            { "data": "harga"},
            { "data": "SUB_TOTAL"},
            { "data": null, 
              "render" : function(data){
                if(data.status_penjualan == "DITERIMA"){
                  return "<button class='btn btn-sm btn-warning' title='Hapus Data' onclick='changeStatus(\""+data.id_penjualan+"\", \"DISIAPKAN\");'>Proses </button>"
                }else if(data.status_penjualan == "DISIAPKAN"){
                  return "<button class='btn btn-sm btn-warning' title='Hapus Data' onclick='changeStatus(\""+data.id_penjualan+"\", \"DIKIRIM\");'>Kirim </button>"
                }else if(data.status_penjualan == "DIKIRIM"){
                  return "<button class='btn btn-sm btn-warning' title='Hapus Data' onclick='changeStatus(\""+data.id_penjualan+"\", \"SELESAI\");'>Selesai </button>"
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