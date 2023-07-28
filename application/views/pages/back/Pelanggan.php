<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
        <div class="col-md-9">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Data Pelanggan</h4>

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
                      <th>ID Pelanggan</th>
                      <th>ID User</th>
                      <th>Nama Pelanggan</th>
                      <th>No Handphone</th>
                      <th width="20%">Alamat</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Tgl Daftar</th>
                      <th width="13%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
				</div>
				<div class="col-md-3">
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
                    <label>Nama Pengguna</label>
                    <input type="text" name="nm_pengguna" class="form-control rounded-full" >
                  </div>
                  <div class="mt-3">
                    <label>
                        Username
                    </label>
                    <input type="text" name="username" class="form-control rounded-full" />
                  </div>
                  <div class="mt-3">
                    <label>
                        Password
                    </label>
                    <input type="password" name="password" class="form-control rounded-full" />
                  </div>
                  <div class="mt-3">
                    <label>
                        Level
                    </label>
                    <select name="level" class="form-control rounded-full" style="height: 40px;padding-left: 10px;">
                      <option value="PELANGGAN">PELANGGAN</option>
                      <option value="KASIR">KASIR</option>
                      <option value="PEMILIK">PEMILIK</option>
                    </select>
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
            urlPost = "<?php echo site_url('pelanggan/saveData') ?>";
        }else{
            urlPost = "<?php echo site_url('pelanggan/updateData') ?>";
            formData+="&id_pelanggan="+id_data
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
            "url": "<?php echo site_url('pelanggan/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "id_pelanggan", className: "text-center" },
            { "data": "id_user", className: "text-center" },
            { "data": "nm_pelanggan"},
            { "data": "no_pelanggan"},
            { "data": "alamat"},
            { "data": "username"},
            { "data": "password"},
            { "data": "tgl_register"},
            { "data": null, 
              "render" : function(data){
                return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'>Edit </button> "+
                  "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_pelanggan+"\");'>Hapus </button>"
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
      id_data = data.id_user;
      $("#judul_entry").text('Edit Data')
      $("[name='nm_pengguna']").val(data.nm_pengguna)
      $("[name='username']").val(data.username)
      $("[name='password']").val(data.password)
      $("[name='level']").val(data.level)
    }

    function deleteData(id){
      if(!confirm('Delete this data?')) return

      urlPost = "<?php echo site_url('pelanggan/deleteData') ?>";
      formData = "id_pelanggan="+id
      ACTION(urlPost, formData)
    }
</script>