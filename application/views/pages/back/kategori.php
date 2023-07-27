<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
        <div class="col-md-8">
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
                      <th>ID Kategori</th>
                      <th>Nama Kategori</th>
                      <th width="20%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
				</div>
				<div class="col-md-4">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title" id="judul_entry">Tambah Data</h4>

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
                <form id="FRM_DATA" method="post">
                  <div>
                    <label>
                        Nama Kategori
                    </label>
                    <input type="text" name="nm_kategori" class="form-control rounded-full" />
                  </div>
                  
                  <div class="mt-5 text-right">
                    <button class="btn bg-secondary rounded-full" id="BTN_BATAL">Batal</button>
                    <button class="btn btn-primary rounded-full" id="BTN_SAVE">Simpan</button>
                  </div>
                </form>
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

      $("#BTN_SAVE").click(function(){
        event.preventDefault();
        var formData = $("#FRM_DATA").serialize();
        if(save_method == 'save') {
            urlPost = "<?php echo site_url('kategori/saveData') ?>";
        }else{
            urlPost = "<?php echo site_url('kategori/updateData') ?>";
            formData+="&id_user="+id_data
        }

        ACTION(urlPost, formData)
        
      })

      $("#BTN_BATAL").click(function(){
        event.preventDefault();
        $("#FRM_DATA")[0].reset()
        $("#judul_entry").text('Tambah Data')
        save_method = 'save'
      })
  });

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    var tb_data =  $("#tb_data").DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('kategori/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "id_kategori", className: "text-center" },
            { "data": "nm_kategori"},
            { "data": null, 
              "render" : function(data){
                return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'>Edit </button> "+
                  "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_kategori+"\");'>Hapus </button>"
              },
              className: "text-center"
            },
        ]
      }
    )
  }

  function ACTION(urlPost, formData){
      $.ajax({
          url: urlPost,
          type: "POST",
          data: formData,
          dataType: "JSON",
          beforeSend: function () {
            $("#LOADER").show();
          },
          complete: function () {
            $("#LOADER").hide();
          },
          success: function(data){
            console.log(data)
            if (data.status == "success") {
              toastr.info(data.message)
              REFRESH_DATA()
              $("#FRM_DATA")[0].reset()
              $("#judul_entry").text('Tambah Data')
              save_method = 'save'

            }else{
              toastr.error(data.message)
            }
          }
      })
    }

    function editData(data, index){
      console.log(data)
      save_method = "edit"
      id_data = data.id_kategori;
      $("#judul_entry").text('Edit Data')
      $("[name='nm_kategori']").val(data.nm_kategori)
    }

    function deleteData(id){
      if(!confirm('Delete this data?')) return

      urlPost = "<?php echo site_url('kategori/deleteData') ?>";
      formData = "id_kategori="+id
      ACTION(urlPost, formData)
    }
</script>