<style>
  .block {
    display: block;
    width: 100%;
    border: none;
    background-color: #04AA6D;
    padding: 14px 28px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
  }

  .block:hover {
    background-color: #ddd;
    color: black;
  }

  .modClose {
    float: right;
    font-size: 34px;
    color: #f5002b;
    text-shadow: 0 1px 0 #fff;
    opacity: 1;
    filter: alpha(opacity=20);
  }
</style>

<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
        <form id="FRM_DATA">
          <div class="col-md-5" style="padding-left: 1px;padding-right: 1px;">
            <div style="overflow-y: auto;height:400px;">
              <table id="tb_item" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th style="width: 270px;">Item</th>
                    <th style="width:80px;">Qty</th>
                    <th>Harga</th>
                    <th style="width:100px;">Sub Total</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
            <div>
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td  style="width: 220px;font-size: 18px;font-weight: bold;">Total</td>
                    <td colspan="2" style="text-align:right;padding-right: 25px;font-weight: bold;font-family: fantasy;font-size: 18px;" id="total_text">0</td>
                  </tr>
                  <tr>
                    <td>Pelanggan</td>
                    <td>
                      <input type="text" class="form-control" value="GUEST" name="id_pelanggan" style="float:left;width:70%;" placeholder="Kode Pelanggan">
                      <button type="button" class="btn btn-sm btn-secondary" id="BTN_PELANGGAN" ><i class="fa fa-list"></i></button>
                    </td>
                    <td id="nm_pelanggan" style="font-size:15px;">Non Member</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Point Pelanggan</td>
                    <td><input type="number" name="jml_point" onchange="diskon_calculate()" readonly class="form-control" value="0"></td>
                  </tr>
                  <tr>
                    <td  style="width: 220px;font-size: 20px;font-weight: bold;">Order Value</td>
                    <td colspan="2" style="color:red;text-align:right;padding-right: 25px;font-weight: bold;font-family: fantasy;font-size: 25px;" id="order_text">0</td>
                  </tr>
                  <tr>
                    <td  style="width: 220px;font-size: 18px;font-weight: bold;">Bayar</td>
                    <td colspan="2"><input type="text" name="bayar"  class="form-control"></td>
                  </tr>
                  <tr>
                    <td  style="width: 220px;font-size: 18px;font-weight: bold;">Kembali</td>
                    <td colspan="2" style="text-align:right;padding-right: 25px;font-weight: bold;font-family: fantasy;font-size: 18px;" id="kembali_text">0</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div>
              <div class="col-md-4" style="padding: 0px;">
                <button class="btn btn-warning btn-block"  id="btnCancel"><i class="ace-icon fa fa-times bigger-160"></i> Cancel</button>
              </div>
              <div class="col-md-4" style="padding: 0px;">
                <button class="btn btn-light btn-block" id="btnPrint"><i class="ace-icon fa fa-print bigger-160"></i> Print</button>
              </div>
              <div class="col-md-4" style="padding: 0px;">
                <button class="btn btn-danger btn-block" id="btnPay"><i class="ace-icon fa fa-shopping-cart bigger-160"></i> Pay</button>
              </div>
            </div>
          </div> 
        </form>
        <div class="col-md-2" style="overflow-y: auto;height:550px;padding-left: 1px;padding-right: 1px;">
        <button type="button" class="btn-danger block" onclick="actKategori('ALL')">ALL</button>
          <?php foreach($kategori as $kat){ ?>
            <button type="button" class="btn-danger block" onclick="actKategori('<?= $kat->id_kategori ?>')"><?= $kat->nm_kategori ?></button>
          <?php } ?>
        </div> 
        <div class="col-md-5" style="padding-left: 1px;padding-right: 1px;">
          <div class="input-group">
            <input type="text" class="form-control" name="keywords" placeholder="Cari Barang">
            <div class="input-group-btn">
              <button type="button" class="btn btn-default no-border btn-sm" id="btnSearch">
                <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
              </button>
            </div>
          </div>
          <div>
            <ul class="ace-thumbnails clearfix" id="item_data">

            </ul>
          </div>
        </div> 
      </div> 
    </div> 
  </div> 


  <!-- Modal Pelanggan -->
    <div class="modal fade" id="modal_pelanggan"  role="dialog"  aria-hidden="true">
      <div class="modal-dialog" role="document" style="width:700px">
        <!-- <form id="form_item"> -->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Pilih Pelanggan</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-hover table-striped" id="tb_select_pelanggan">
                      <thead>
                          <th>ID Pelanggan</th>
                          <th>Nama</th>
                          <th>Jumlah Point</th>
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
  <!-- Modal Pelanggan -->

  <!-- Modal Cetak -->
  <div class="modal fade" id="modal_cetak"  role="dialog"  aria-hidden="true">
      <div class="modal-dialog" role="document" style="width:700px">
        <!-- <form id="form_item"> -->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Masukkan No Penjualan</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <input type="text" class="form-control" name="no_nota" placeholder="No NOTA">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" id="okPrint">OK</button>
            </div>
          </div>
        <!-- </form> -->
      </div>
    </div>
  <!-- Modal Cetak -->

</div> 

<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script>
  var min_point
  var max_point_pelanggan
  setPoint()
  function setPoint(){
    $.ajax({
      url: "<?php echo site_url('pelanggan/minPoint') ?>",
      type: "POST",
      dataType: "HTML",
      success: function(data){
        console.log(data)
        min_point = data
      }
    })
  }

  function actKategori(id_kategori){
    $.ajax({
      url: "<?php echo site_url('barang/getByKategori') ?>",
      type: "POST",
      data: {
        id_kategori
      },
      dataType: "HTML",
      success: function(data){
        console.log(data)
        $("#item_data").html(data)
      }
    })
  }
  var noRow=0
  function addItem(id_barang){

    var ITEM_NO = $(".i_barang");

    for (var i = 0; i <ITEM_NO.length; i++) {
      if ($(".i_barang").eq(i).text() == id_barang) {
        let jml = parseFloat( $("[name='qty[]']").eq(i).val() )
        $("[name='qty[]']").eq(i).val(jml+1)
        subTotal(i)
        return
      }
    }

    $.ajax({
      url: "<?php echo site_url('barang/getBarangById') ?>",
      type: "POST",
      data: {
        id_barang
      },
      // dataType: "JSON",
      success: function(data){
        console.log(data)
        var t_data;
        datane = $.parseJSON(data);
        data = datane['data'];
        
        $.each(data, function(index,array){
          //console.log(index);
          
          t_data += '<tr id="row_'+noRow+'">'+
                      '<td ><span class="i_barang"><input type="hidden" name="id_barang[]" value="'+array['id_barang']+'" >'+array['id_barang']+'</span><button type="button" onClick="deleteRow(\''+noRow+'\')" class="bootbox-close-button close modClose" >×</button><br>'+array['nm_barang']+'</td>'+
                      '<td><input type="text" name="qty[]" id="qty_'+noRow+'" onChange="subTotal(\''+noRow+'\')" class="form-control qty" value="1"></td>'+
                      '<td style="text-align:right;" id="harga_'+noRow+'" class="harga"><input type="hidden" name="harga[]" value="'+array['harga']+'" >'+formatRupiah(array['harga'], '')+'</td>'+
                      '<td style="text-align:right;" id="subTotal_'+noRow+'" class="subTotal">'+formatRupiah(array['harga'], '')+'</td>'+
                    '</tr>'

                    noRow = noRow+1;
        });
        $("#tb_item tbody").append(t_data);
        total()
      }
    })
  }

  function subTotal(id){
    // console.log(id)
    let qty = $("#qty_"+id).val().split('.').join('');
    let harga = $("#harga_"+id).text().split('.').join('');
    

    let subTotal = ( parseFloat(qty) * parseFloat(harga) ) 
    $("#subTotal_"+id).text(formatRupiah(subTotal.toString(), ''))

    total()
  }

  function total(){
    var tot=0; var subTotal=0;
    var jml_part = $("[name='qty[]']").length - 1;
    for (var j = 0; j <= jml_part; j++) {
        subTotal = $(".subTotal").eq(j).text().split('.').join('');
        tot += parseFloat(subTotal);

    }

    $("#total_text").text(formatRupiah(tot.toString(), ''));
    $("#order_text").text(formatRupiah(tot.toString(), ''));
  }

  function diskon_calculate(){
    
    let tot_barang = $("#total_text").text().split('.').join('');
    let jml_point = $("[name='jml_point']").val()

    if( jml_point > max_point_pelanggan ){
      alert("Point yg anda input melebihi jumlah point pelanggan")
      $("[name='jml_point']").val(max_point_pelanggan)
      return
    }

    let order_value = parseFloat(tot_barang) - parseFloat(jml_point)
    $("#order_text").text(formatRupiah(order_value.toString(), ''));
  }

  $("[name='bayar']").change(function(){
    $(this).val(formatRupiah($(this).val().toString(), ''))

    let bayar = $(this).val().split('.').join('');

    let order_val = $("#order_text").text().split('.').join('');

    let kembali = parseFloat(bayar) - parseFloat(order_val)
    $("#kembali_text").text(formatRupiah(kembali.toString(), ''));
  })

  $("#btnSearch").click(function(){
    $.ajax({
      url: "<?php echo site_url('barang/getByName') ?>",
      type: "POST",
      data: {
        search : $("[name='keywords']").val()
      },
      dataType: "HTML",
      success: function(data){
        // console.log(data)
        $("#item_data").html(data)
      }
    })
  })

  function deleteRow(id){
    $("#row_"+id).remove();
    total()
  }

  $("#BTN_PELANGGAN").click(function(){
    
    table_find_pelanggan = $('#tb_select_pelanggan').DataTable( {
          "order": [[ 1, "asc" ]],
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('pelanggan/getPelanggan') ?>",
              "type": "POST",
          },
          "columns": [
              { "data": "id_pelanggan" },{ "data": "nm_pelanggan" },{ "data": "jml_point" }
          ]
      });

    $("#modal_pelanggan").modal('show');
  });

  $('body').on( 'dblclick', '#tb_select_pelanggan tbody tr', function (e) {
      let Rowdata = table_find_pelanggan.row( this ).data();
      let id_pelanggan = Rowdata.id_pelanggan;
      let nm_pelanggan = Rowdata.nm_pelanggan;
      let jml_point = Rowdata.jml_point;

      max_point_pelanggan = Rowdata.jml_point;

      if(jml_point >= min_point){
        $("[name='jml_point']").attr('readonly', false)
      }else{
        $("[name='jml_point']").attr('readonly', true)
      }

      $("[name='id_pelanggan']").val(id_pelanggan);
      $("#nm_pelanggan").text(nm_pelanggan);
      $("[name='jml_point']").val(jml_point);

      diskon_calculate()

      $('#tb_select_pelanggan').DataTable().destroy();
      
      $('#modal_pelanggan').modal('hide');

      
  });

  $("#btnPay").click(function(){
    event.preventDefault()

    if($("[name='qty[]']").length == 0){
      alert("Belum ada Item di keranjang")
      return
    }

    if($("[name='bayar']").val() == ""){
      alert("Input Uang Pembayaran")
      return
    }

    let tot_biaya_barang = $("#total_text").text().split('.').join('');
    let tot_akhir = $("#order_text").text().split('.').join('');
    let frmData = $("#FRM_DATA").serialize()
    frmData+="&tot_biaya_barang="+tot_biaya_barang+"&tot_akhir="+tot_akhir

    $.ajax({
      url: "<?php echo site_url('penjualan/saveCheckout') ?>",
      type: "POST",
      dataType: "JSON",
      data: frmData,
      beforeSend: function () {
        $("#LOADER").show();
      },
      complete: function () {
        $("#LOADER").hide();
      },
      success: function(data){
        // console.log(data)
        if (data.status == "success") {
          toastr.info(data.message)
          afterSave()
          setTimeout(() => {
            cetak(data.id)
          }, 1000);
          
        }else{
          toastr.error(data.message)
        }
      }
    })
  })

  function afterSave(){
    $("[name='qty[]']").attr('disabled',true)
    $("#BTN_PELANGGAN").attr('disabled',true)
    $("[name='jml_point']").attr('disabled',true)
    $("[name='bayar']").attr('disabled',true)
    $("#btnPay").attr('disabled',true)
  }

  $("#btnPrint").click(function(){
    event.preventDefault()
    $("#modal_cetak").modal('show')
  })

  $("#okPrint").click(function(){
    event.preventDefault()
    if($("[name='no_nota']").val() == ""){
      alert('Masukkan No Nota')
      return
    }

    let id_penjualan = $("[name='no_nota']").val()
    cetak(id_penjualan)
  })

  function cetak(id){
    var form = document.createElement("form");
    $(form).attr("action", "<?php echo site_url('report/ctkStruk') ?>")
            .attr("method", "post")
            .attr("target", "_blank");
    $(form).html('<input type="hidden" name="id_penjualan" value="'+id+'" />');
    document.body.appendChild(form);
    $(form).submit();
    document.body.removeChild(form);
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