<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
				<div class="col-12">
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
	</div>
</div><!-- /.main-content -->
<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script>
  var tb_data;

  $(function(){
  REFRESH_DATA()

  })

 function REFRESH_DATA(){
   $('#tb_data').DataTable().destroy();
   tb_data =  $("#tb_data").DataTable({
       "order": [[ 0, "asc" ]],
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