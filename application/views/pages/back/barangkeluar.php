<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">
      <div class="row">
        <div class="col-md-6">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Input Barang keluar</h4>

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
                <form id="FRM_DATA">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Doc. Tipe</label>
                        <select name="doc_tipe" class="form-control">
                          <option value="RUSAK">Rusak</option>
                          <option value="LAIN-LAIN">Lain-lain</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Barang</label>
                        <div>
                          <input name="id_barang" class="form-control" style="width:80%;float: left;" required>
                          <button type="button" id="btnBarang" class="btn btn-sm btn-secondary"><i class="fa fa-list"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" onchange="cekStock()" onkeypress="return onlyNumberKey(event)" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Harga</label>
                        <input name="harga"  class="form-control" onkeypress="return onlyNumberKey(event)" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Stock</label>
                        <input type="text" class="form-control" name="stock" readonly>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Doc. Referensi</label>
                        <input type="text" class="form-control" name="doc_referensi" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="ket_barang_keluar" rows="3" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="pull-right">
                        <button type="button" class="btn btn-warning" id="btnReset">Reset</button>
                        <button type="button" class="btn btn-info" id="BTN_SAVE">Simpan</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
				</div>
			</div><!-- /.row -->
			<div class="row">
        <div class="col-md-12">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Data Barang keluar</h4>

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
                      <th>ID</th>
                      <th>Item</th>
                      <th>Doc Tipe</th>
                      <th>Tanggal</th>
                      <th>Jumlah</th>
                      <th>Unit</th>
                      <th>Harga</th>
                      <th>Keterangan</th>
                      <th >Action</th>
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

    <!-- Modal barang -->
      <div class="modal fade" id="modal_barang"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document" style="width:700px">
          <!-- <form id="form_item"> -->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered table-hover table-striped" id="tb_select_barang">
                        <thead>
                            <th>ID Barang</th>
                            <th>Nama barang</th>
                            <th>Stock</th>
                            <th>Harga</th>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          <!-- </form> -->
        </div>
      </div>
    <!-- Modal barang -->
	</div>
</div><!-- /.main-content -->


<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script>
var save_method = 'save';
var id_data;
var table_find_barang
  $(document).ready(function () {
    REFRESH_DATA()

    $("#btnBarang").click(function(){
      
      table_find_barang = $('#tb_select_barang').DataTable( {
            "order": [[ 1, "asc" ]],
            "pageLength": 25,
            "autoWidth": false,
            "responsive": true,
            "ajax": {
                "url": "<?php echo site_url('barang/getAllData') ?>",
                "type": "POST",
            },
            "columns": [
                { "data": "id_barang" },{ "data": "nm_barang" }
                ,{ "data": "stock" },{ "data": "harga" }
            ]
        });

      $("#modal_barang").modal('show');
    });

    $('body').on( 'dblclick', '#tb_select_barang tbody tr', function (e) {
        let Rowdata = table_find_barang.row( this ).data();
        let id_barang = Rowdata.id_barang;
        let nm_barang = Rowdata.nm_barang;
        let harga = Rowdata.harga;
        let stock = Rowdata.stock;

        $("[name='id_barang']").val(id_barang);
        $("[name='harga']").val(harga);
        $("[name='stock']").val(stock);

        $('#tb_select_barang').DataTable().destroy();
        
        $('#modal_barang').modal('hide');

        
    });

      $("#btnReset").click(function(){
        $("#FRM_DATA")[0].reset()
        save_method = 'save'
      })

      $("#BTN_SAVE").click(function(){
        event.preventDefault();
        var formData = $("#FRM_DATA").serialize();
        if(save_method == 'save') {
            urlPost = "<?php echo site_url('barangkeluar/saveData') ?>";
        }else{
            urlPost = "<?php echo site_url('barangkeluar/updateData') ?>";
            formData+="&id_barang_keluar="+id_data
        }

        ACTION(urlPost, formData)
        
      })

  });

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    var tb_data =  $("#tb_data").DataTable({
        "order": [[ 0, "desc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('barangkeluar/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "id_barang_keluar", className: "text-center" },
            { "data": null, 
              "render" : function(data){
                return data.id_barang+"</br>"+data.nm_barang
              },
            },
            { "data": "doc_tipe"},
            { "data": "tgl_barang_keluar"},
            { "data": "jumlah"},
            { "data": "unit_pengukuran"},
            { "data": "harga"},
            { "data": "ket_barang_keluar"},
            { "data": null, 
              "render" : function(data){
                return "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_barang_keluar+"\");'>Hapus </button>"
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

      urlPost = "<?php echo site_url('barangkeluar/deleteData') ?>";
      formData = "id_barang_keluar="+id
      ACTION(urlPost, formData)
    }

    function cekStock(){
      let jumlah = $("[name='jumlah']").val()
      let stock = $("[name='stock']").val()

      if($("[name='id_barang']").val() == ""){
        alert("Input Barang")
        $("[name='jumlah']").val("")
        return
      }

      if(parseFloat(jumlah) > parseFloat(stock)){
        alert("Jumlah barang melebihi stock")
        $("[name='jumlah']").val(stock)
        return
      }
    }
</script>