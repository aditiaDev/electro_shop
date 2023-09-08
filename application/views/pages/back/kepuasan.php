<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
        <div class="col-md-12">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Data Feedback Customer</h4>

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
                      <th>ID Penilaian</th>
                      <th>Tgl Penilaian</th>
                      <th>ID Penjualan</th>
                      <th>Nilai</th>
                      <th>Masukan</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
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
var save_method = 'save';
var id_data;

  $(document).ready(function () {
    REFRESH_DATA()

  });

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    var tb_data =  $("#tb_data").DataTable({
        "order": [[ 0, "desc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('kepuasan/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "id_penilaian", className: "text-center" },
            { "data": "tgl_penilaian"},
            { "data": "id_penjualan", className: "text-center" },
            { "data": "nilai"},
            { "data": "masukan"},
        ]
      }
    )
  }

  
</script>