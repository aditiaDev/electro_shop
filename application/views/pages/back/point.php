<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
        <div class="col-md-8">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Konfigurasi Point</h4>

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
                      <th>Penambahan Point (%)</th>
                      <th>Min Penggunaan Point</th>
                      <th>Action</th>
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
                        Penambahan Point (%)
                    </label>
                    <input type="number" min="0" max="100" name="potongan_point" class="form-control rounded-full" />
                  </div>

                  <div class="mt-3">
                    <label>
                        Minimal Penggunaan Point
                    </label>
                    <input type="text" name="min_point" class="form-control rounded-full" />
                  </div>
                  
                  <div class="mt-5 text-right">
                    <button class="btn bg-secondary rounded-full" id="BTN_BATAL">Batal</button>
                    <button class="btn btn-primary rounded-full" style="display:none" id="BTN_SAVE">Simpan</button>
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
var tb_data

  $(document).ready(function () {
    REFRESH_DATA()

      $("#BTN_SAVE").click(function(){
        event.preventDefault();
        var formData = $("#FRM_DATA").serialize();
        if(save_method == 'save') {
            urlPost = "<?php echo site_url('point/saveData') ?>";
        }else{
            urlPost = "<?php echo site_url('point/updateData') ?>";
            formData+="&id="+id_data
        }

        ACTION(urlPost, formData)
        
      })

      $("#BTN_BATAL").click(function(){
        event.preventDefault();
        $("#FRM_DATA")[0].reset()
        if( tb_data.rows().count() > 0 ){
          $("#BTN_SAVE").css('display', 'none')
        }else{
          $("#BTN_SAVE").css('display', 'unset')
        }
        $("#judul_entry").text('Tambah Data')
        save_method = 'save'
      })
  });

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    tb_data =  $("#tb_data").DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('point/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "potongan_point", className: "text-center"},
            { "data": null, 
              "render" : function(data){
                return formatRupiah(data.min_point, "")
              },
              className: "text-center"
            },
            { "data": null, 
              "render" : function(data){
                return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'>Edit </button> "+
                  "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id+"\");'>Hapus </button>"
              },
              className: "text-center"
            },
        ]
      }
    )

    setTimeout(() => {
          if( tb_data.rows().count() > 0 ){
            $("#BTN_SAVE").css('display', 'none')
          }else{
            $("#BTN_SAVE").css('display', 'unset')
          }
        }, 1000);
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
      $("#BTN_SAVE").css('display', 'unset')
      id_data = data.id;
      $("#judul_entry").text('Edit Data')
      $("[name='potongan_point']").val(data.potongan_point)
      $("[name='min_point']").val(data.min_point)
    }

    function deleteData(id){
      if(!confirm('Delete this data?')) return

      urlPost = "<?php echo site_url('point/deleteData') ?>";
      formData = "id="+id
      ACTION(urlPost, formData)
    }

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split   		= number_string.split(','),
      sisa     		= split[0].length % 3,
      rupiah     		= split[0].substr(0, sisa),
      ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
    }
</script>