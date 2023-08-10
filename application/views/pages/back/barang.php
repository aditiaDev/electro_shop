<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
        <div class="col-md-12">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Data Barang</h4>

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
              <button class="btn btn-sm btn-primary" style="margin-bottom: 10px;" id="add_data"><i class="bi bi-cloud-plus-fill"></i> Tambah</button>
                <table id="tb_data" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Kategori</th>
                      <th>ID Barang</th>
                      <th>Nama Barang</th>
                      <th>Merk</th>
                      <th>Harga</th>
                      <th>Unit</th>
                      <th>Berat (Kg)</th>
                      <th>Stock</th>
                      <!-- <th>Foto</th> -->
                      <th width="20%">Keterangan</th>
                      <th width="9%">Action</th>
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
                    <label>Kategori</label>
                    <select name="id_kategori" id="" class="form-control">
                      <option value="" disabled selected> - Pilih - </option>
                      <?php
                        foreach($kategori as $kat){
                          echo "<option value='".$kat->id_kategori."'>".$kat->nm_kategori."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" name="nm_barang" >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Berat Barang (Kg)</label>
                    <input type="text" class="form-control" name="berat_barang" >
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
                    <label>Stok</label>
                    <input type="text" class="form-control" name="stock" onkeypress="return onlyNumberKey(event)" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Unit Pengukuran</label>
                    <select name="unit_pengukuran" id="" class="form-control">
                      <option value="" disabled selected> - Pilih - </option>
                      <?php
                        foreach($unit as $uom){
                          echo "<option value='".$uom->unit_pengukuran."'>".$uom->unit_pengukuran." - ".$uom->deskripsi."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Merk</label>
                    <input type="text" class="form-control" name="merk" >
                  </div>
                </div>
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
                    <label id="lbl_foto">Keterangan</label>
                    <textarea name="ket_barang" rows="5" class="form-control"></textarea>
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
    var save_method;
    var id_data;
    var tb_data;

    $(function(){
      REFRESH_DATA()

      $("[name='src_jenis']").change(function(){
        REFRESH_DATA()
      })

      $("#btnBatal").click(function(){
        $("#modal_add").modal('hide')
      })

      $("#add_data").click(function(){
        $("#FRM_DATA")[0].reset()
        $("[name='no_induk']").attr('readonly', false)
        save_method = "save"
        $("#modal_add .modal-title").text('Tambah Data')
        $("#modal_add").modal('show')
      })

      $("#FRM_DATA").on('submit', function(event){
        event.preventDefault();
        let formData = new FormData(this);

        
        if(save_method == 'save') {
            urlPost = "<?php echo site_url('barang/saveData') ?>";
        }else{
            urlPost = "<?php echo site_url('barang/updateData/') ?>"+id_data;
        }
        // console.log(formData)
        ACTION(urlPost, formData)
        // $("#modal_add").modal('hide')
      })

    })

    function REFRESH_DATA(){
      $('#tb_data').DataTable().destroy();
      tb_data =  $("#tb_data").DataTable({
          "order": [[ 1, "asc" ], [ 2, "asc" ]],
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('barang/getAllData') ?>",
              "type": "POST",
              "data": {
                "id_kategori" : $("[name='src_kategori']").val(),
              }
          },
          "createdRow": function( row, data, dataIndex){
            console.log($(row))
                if( parseInt(data.stock) <= parseInt(data.min_stock)){

                    $(row).css({"background-color":"yellow"});

                }
            },
          "columns": [
              {
                "className":      'dt-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
              },
              { "data": "nm_kategori" },
              { "data": "id_barang" },
              { "data": "nm_barang"},
              { "data": "merk"},
              { "data": "harga"},
              { "data": "unit_pengukuran"},
              { "data": "berat_barang"},
              { "data": "stock"},
              { "data": "ket_barang"},
              // { "data": "foto"},
              { "data": null, 
                "render" : function(data){
                  return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'><i class='fa fa-pencil-square-o'></i> </button> "+
                    "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_barang+"\");'><i class='fa fa-trash'></i> </button>"
                },
                className: "text-center"
              },
          ]
        }
      )
    }

    function format ( d ) {
      // `d` is the original data object for the row
      console.log(d)
      if(d.foto_barang){
        img = "<a target='_blank' href='<?php echo base_url() ?>assets/images/barang/"+d.foto_barang+"'><img  style='max-width: 120px;' class='img-fluid' src='<?php echo base_url() ?>assets/images/barang/"+d.foto_barang+"' ></a>";
      }else{
        img = "No Image"
      }
      return '<table class="table table-bordered" style="width:450px;">'+
          '<tr>'+
              '<td style="width:80px;">Photo:</td>'+
              '<td>'+img+'</td>'+
          '</tr>'+
          '<tr>'+
              '<td>Harga:</td>'+
              '<td>'+d.harga+'</td>'+
          '</tr>'+
          '<tr>'+
              '<td>Stock:</td>'+
              '<td>'+d.stock+'</td>'+
          '</tr>'+
      '</table>';
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

    function editData(data, index){
      console.log(data)
      save_method = "edit"
      id_data = data.id_barang;
      $("[name='foto']").val('')
      $("#lbl_foto").text("Ganti Foto")
      $("#modal_add .modal-title").text('Edit Data')
      $("[name='id_barang']").val(data.id_barang)
      $("[name='nm_barang']").val(data.nm_barang)
      $("[name='harga']").val(data.harga.replaceAll(".",""))
      $("[name='stock']").val(data.stock)
      $("[name='id_kategori']").val(data.id_kategori)
      $("[name='ket_barang']").val(data.ket_barang)
      $("[name='merk']").val(data.merk)
      $("[name='unit_pengukuran']").val(data.unit_pengukuran)
      $("[name='berat_barang']").val(data.berat_barang)

      $("#modal_add").modal('show')
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

    function deleteData(id){
      if(!confirm('Delete this data?')) return

      urlPost = "<?php echo site_url('barang/deleteData') ?>";
      formData = "id_barang="+id
      
      $.ajax({
          url: urlPost,
          type: "POST",
          data: formData,
          dataType: "JSON",
          success: function(data){
            // console.log(data)
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