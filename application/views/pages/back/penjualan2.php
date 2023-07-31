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
        <div class="col-md-5" style="padding-left: 1px;padding-right: 1px;">
          <div style="overflow-y: auto;height:400px;">
            <table id="tb_item" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="width: 320px;">Item</th>
                  <th style="width:80px;">Qty</th>
                  <th>Harga</th>
                  <th>Sub Total</th>
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
                  <td style="width: 320px;">Total</td>
                  <td style="text-align:right;padding-right: 25px;" id="total_text">0</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div> 
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
              <button type="button" class="btn btn-default no-border btn-sm">
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
</div> 

<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script>

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
          noRow = noRow+1;
          t_data += '<tr id="row_'+noRow+'">'+
                      '<td>'+array['id_barang']+'<button type="button" onClick="deleteRow(\''+noRow+'\')" class="bootbox-close-button close modClose" >×</button><br>'+array['nm_barang']+'</td>'+
                      '<td><input type="text" name="qty[]" id="qty_'+noRow+'" onChange="subTotal(\''+noRow+'\')" class="form-control qty" value="1"></td>'+
                      '<td style="text-align:right;" id="harga_'+noRow+'" class="harga">'+formatRupiah(array['harga'], '')+'</td>'+
                      '<td style="text-align:right;" id="subTotal_'+noRow+'" class="subTotal">'+formatRupiah(array['harga'], '')+'</td>'+
                    '</tr>'
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

    let subTotal = parseFloat(qty) * parseFloat(harga)
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

  }

  function deleteRow(id){
    $("#row_"+id).remove();
    total()
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