<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
				<div class="col-12">
        <button class="btn btn-sm btn-primary" style="margin-bottom: 10px;" id="add_data"><i class="bi bi-cloud-plus-fill"></i> Tambah</button>
          <table id="tb_data" class="table table-bordered table-strpped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Complaint ID</th>
                <th>ID Penjualan</th>
                <th>Tanggal</th>
                <th>Complaint</th>
                <th>Pelanggan</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
				</div>
			</div><!-- /.row -->
		</div><!-- /.page-content -->

    <!-- Basic Modal -->
    <div class="modal fade" id="modal_add" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form id="FRM_DATA" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Tambah data</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>ID Pembelian</label>
                  <input type="text" class="form-control" name="id_penjualan">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Judul Complaint</label>
                  <input type="text" class="form-control" name="judul_complaint" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label id="lbl_foto">Foto</label>
                  <div class="custom-file">
                    <input type="file"  name="foto" accept="image/png, image/gif, image/jpeg">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label >Deskripsi Complaint</label>
                  <textarea name="deskripsi" rows="5" class="form-control"></textarea>
                </div>
              </div>
            </div>
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" id="btnBatal" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary" id="BTN_SAVE">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div><!-- End Basic Modal-->

	</div>
</div><!-- /.main-content -->
<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script>
  var tb_data;

  $(function(){
    REFRESH_DATA()

    $("#add_data").click(function(){
      $("#FRM_DATA")[0].reset()
      save_method = "save"
      $("#modal_add .modal-title").text('Tambah Complaint')
      $("#modal_add").modal('show')
    })

    $("#FRM_DATA").on('submit', function(event){
      event.preventDefault();
      let formData = new FormData(this);

      
      if(save_method == 'save') {
          urlPost = "<?php echo site_url('complaint/saveData') ?>";
      }else{
          urlPost = "<?php echo site_url('complaint/updateData/') ?>"+id_data;
      }
      // console.log(formData)
      ACTION(urlPost, formData)
      // $("#modal_add").modal('hide')
    })

  })
  

 function REFRESH_DATA(){
   $('#tb_data').DataTable().destroy();
   tb_data =  $("#tb_data").DataTable({
       "order": [[ 1, "desc" ]],
       "pageLength": 25,
       "autoWidth": false,
       "responsive": true,
       "ajax": {
           "url": "<?php echo site_url('usercomplaint/getComplaint') ?>",
           "type": "POST",
       },
       "columns": [
           {
             "className":      'dt-control',
             "orderable":      false,
             "data":           null,
             "defaultContent": ''
           },
           { "data": "id_complaint", className: "text-center" },
           { "data": "id_penjualan", className: "text-center" },
           { "data": "tgl_complaint"},
           { "data": "judul_complaint"},
           { "data": null, 
             "render" : function(data){
               return data.id_pelanggan+"</br>"+data.nm_pelanggan
             },
           },
           { "data": "status"},
           { "data": null, 
             "render" : function(data){
              if(data.status == "CLOSED"){
                return "<a class='btn btn-sm btn-info' href='<?= base_url() ?>usercomplaintdtl/"+data.id_complaint+"'>View</a>"
              }else{
                return "<button class='btn btn-sm btn-warning' title='Hapus Data' onclick='closeStatus(\""+data.id_complaint+"\");'>Close </button> "+
               "<a class='btn btn-sm btn-info' href='<?= base_url() ?>usercomplaintdtl/"+data.id_complaint+"'>View</a>"
              }
               
             },
             className: "text-center"
           },
       ]
     }
   )
 }

 $('#tb_data tbody').on('click', 'td.dt-control', function () {
      var tr = $(this).closest('tr');
      var row = tb_data.row( tr );

      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
          // Open this row
          row.child( format(row.data()) ).show();
          tr.addClass('shown');
      }
  } );

  function format ( d ) {
    // `d` is the original data object for the row
    console.log(d)
    if(d.foto){
      img = "<a target='_blank' href='<?php echo base_url() ?>assets/images/complaint/"+d.foto+"'><img  style='max-width: 120px;' class='img-fluid' src='<?php echo base_url() ?>assets/images/complaint/"+d.foto+"' ></a>";
    }else{
      img = "No Image"
    }
    return '<table class="table table-bordered" style="width:450px;">'+
        '<tr>'+
            '<td style="width:80px;">Photo:</td>'+
            '<td>'+img+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Deskripsi:</td>'+
            '<td>'+d.deskripsi+'</td>'+
        '</tr>'+
    '</table>';
  }

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

  function closeStatus(id_complaint){
    $.ajax({
      url: "<?php echo site_url('usercomplaint/changeStatus') ?>",
      type: "POST",
      dataType: "JSON",
      data: {
        id_complaint
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