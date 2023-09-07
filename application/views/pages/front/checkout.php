<style>
  .table>thead>tr {
    color: #707070;
    font-weight: 400;
    /* background:repeat-x #F2F2F2; */
    /* background-image:-webkit-linear-gradient(top,#F8F8F8 0,#ECECEC 100%); */
    background-image: -o-linear-gradient(top,#F8F8F8 0,#ECECEC 100%);
    background-image: linear-gradient(to bottom,#F8F8F8 0,#ECECEC 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff8f8f8', endColorstr='#ffececec', GradientType=0)
  }
</style>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb-tree">
					<li><a href="<?php echo base_url('front'); ?>">Home</a></li>
					<li class="active"><a href="javascript;:">All Categories</a></li>
				</ul>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
      <!-- row -->
      <div class="row">
        <form id="FRM_DATA">
          <div class="col-md-6">
            <!-- Billing Details -->
            <div class="billing-details">
              <div class="section-title">
                <h3 class="title">Kirim ke Alamat</h3>
              </div>
              <div class="form-group">
                <label>Nama Penerima</label>
                <input class="input" type="text" name="nm_penerima" placeholder="Nama Penerima">
              </div>
              <div class="form-group">
                <label>Kota Asal</label>
                <select class="form-control" name="kota_asal" required onChange="cekOngkir()">
                  <option value="344">Pati</option>
                </select>
              </div>
              <div class="form-group">
                <label>Provinsi Tujuan</label>
                <select class="form-control select2" name="provinsi_tujuan" required onChange="showKotaTujuan()">
                  <option value="">Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label>Kota Tujuan</label>
                <select class="form-control select2" name="kota_tujuan" required onChange="cekOngkir()">
                  <option value="">Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Kurir</label>
                <select class="form-control" name="kurir" required onChange="cekOngkir()">
                  <option value="">Pilih</option>
                  <option value="jne">JNE</option>
                  <option value="tiki">TIKI</option>
                  <option value="pos">POS INDONESIA</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Layanan</label>
                <select class="form-control select2" name="layanan" required onChange="pilihLayanan()">
                  <option value="">Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Harga</label>
                <input class="input" type="text" name="harga_kirim" readonly value="0">
              </div>
              <div class="form-group">
                <label for="">Estimasi</label>
                <input class="input" type="text" name="estimasi" readonly>
              </div>
              <div class="form-group">
                <label for="">Alamat Lengkap Penerima</label>
                <textarea class="input" name="alamat_penerima"></textarea>
              </div>
            </div>
            <!-- /Billing Details -->
          </div>

          <!-- Order Details -->
          <div class="col-md-6 order-details">
            <div class="section-title text-center">
              <h3 class="title">Keranjang Anda</h3>
            </div>
            <div class="order-summary">
              <table id="tb_item" class="table table-bordered table-hover" style="font-size:12px;">
                <thead>
                  <tr>
                    <th style="width: 170px;">Item</th>
                    <th style="width:70px;">Qty</th>
                    <th>Harga</th>
                    <th style="width:100px;">Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $total=0;
                    foreach($item_order as $item){ 
                  ?>
                    <tr id="row_<?= $item->id_barang ?>">
                      <td><input type="hidden" name="id_barang[]" value="<?= $item->id_barang ?>" ><?= $item->nm_barang ?><button type="button" onClick="deleteRow('<?= $item->id_barang ?>')" class="bootbox-close-button close modClose" >×</button></td>
                      <td style="text-align:right;"><input type="text" name="qty[]" id="qty_<?= $item->id_barang ?>" onChange="subTotal('<?= $item->id_barang ?>')" class="input" value="<?= $item->qty ?>"></td>
                      <td style="text-align:right;" id="harga_<?= $item->id_barang ?>"><input type="hidden" name="harga[]" value="<?= $item->harga?>"><?= rupiah($item->harga,'') ?></td>
                      <td style="text-align:right;" class="subTotal" id="subTotal_<?= $item->id_barang ?>"><?= rupiah($item->sub_total,'') ?></td>
                    </tr>
                  <?php 
                    $total += $item->sub_total;
                    } 
                  ?>
                </tbody>
              </table>
              <div class="order-col">
                <div>Point Anda
                  <input type="checkbox" id="chkPoint" onclick="cekGunakanPoint()" > Gunakan Point?
                </div>
                <div><input type="text" class="form-control" name="jml_point" onChange="changePoint()" value="0" readonly></div>
              </div>
              <div class="order-col">
                <div><strong>TOTAL</strong></div>
                <div><strong class="order-total" id="total_text"><?= rupiah($total,'Rp.') ?></strong></div>
              </div>
            </div>
            
            <a href="javascript:;" id="btnCheckOut" class="primary-btn order-submit">Checkout</a>
          </div>
        </form>
        
        <!-- /Order Details -->
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /SECTION -->

<?php
  function rupiah($angka, $prefix){
	
    $hasil_rupiah = $prefix . number_format($angka,0,',','.');
    return $hasil_rupiah;
   
  }
?>
<script src="<?php echo base_url(); ?>assets/template/front/js/jquery.min.js"></script>
<script>
  // getKota()

  var min_point
  var max_point_pelanggan
  setPoint()
  getPointPelanggan()
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

  function getPointPelanggan(){
    $.ajax({
      url: "<?php echo site_url('pelanggan/getPointPelanggan') ?>",
      type: "POST",
      dataType: "HTML",
      success: function(data){
        console.log(data)
        max_point_pelanggan = data
        // $("[name='jml_point']").val(max_point_pelanggan)
      }
    })
  }

  getProvinsi()

  function deleteRow(id_barang){
    $.ajax({
			url: "<?php echo base_url('front/deleteKeranjang') ?>",
			type: 'POST',
      data: {id_barang},
			dataType: 'json',
			success: function(data){
        toastr.info(data.message)
			}
		});
    
    $("#row_"+id_barang).remove();
    total()
  }

  function getProvinsi(){
    $.ajax({
      url: "<?php echo base_url('ongkir/getProvinsi') ?>",
      type: "POST",
      dataType: "JSON",
      success: function(data){
        // console.log(data['rajaongkir']['results'])
        $.map(data.rajaongkir.results, function (item) {
          // console.log(item)
          let isine = "<option value='"+item.province_id+"'>"+item.province+"</option>"
          $("[name='provinsi_tujuan']").append(isine)
        })
      }
    })
  }

  function getKota(){
    $.ajax({
      url: "<?php echo base_url('ongkir/getKota') ?>",
      type: "POST",
      dataType: "JSON",
      success: function(data){
        // console.log(data['rajaongkir']['results'])
        $.map(data.rajaongkir.results, function (item) {
          // console.log(item)
          let isine = "<option value='"+item.city_id+"'>"+item.city_name+"</option>"
          $("[name='kota_tujuan']").append(isine)
        })
      }
    })
  }

  function cekOngkir(){
    let kota_asal = $("[name='kota_asal']").val()
    let kota_tujuan = $("[name='kota_tujuan']").val()
    let kurir = $("[name='kurir']").val()

    if( kota_asal == "" || kota_tujuan == "" || kurir == "" ) return

    $.ajax({
      url: "<?php echo base_url('ongkir/getHargaOngkir') ?>",
      type: "POST",
      data: {
        kota_asal,
        kota_tujuan,
        kurir
      },
      dataType: "JSON",
      success: function(data){
        datane = data['rajaongkir']['results'][0]['costs']
        // console.log(datane)
        $.map(datane, function (item) {
          console.log(item)
          let isine = "<option value='"+item['cost'][0]['value']+"' estimasi='"+item['cost'][0]['etd']+"'>"+item.service+"</option>"
          $("[name='layanan']").append(isine)
        })
      }
    })
  }

  function showKotaTujuan(){
    $("[name='kota_tujuan']").val('')
    $("[name='kurir']").val('')
    $("[name='layanan']").val('')
    $("[name='harga_kirim']").val('')
    $("[name='estimasi']").val('')

    let isine='<option>Pilih</option>'

    $.ajax({
      url: "<?php echo base_url('ongkir/getKotaByProvinsi') ?>",
      type: "POST",
      data: {
        provinsi_id: $("[name='provinsi_tujuan']").val()
      },
      dataType: "JSON",
      success: function(data){
        // console.log(data['rajaongkir']['results'])
        $.map(data.rajaongkir.results, function (item) {
          // console.log(item)
          isine += "<option value='"+item.city_id+"'>"+item.city_name+" - Kode Pos: "+item.postal_code+"</option>"
          
        })
        $("[name='kota_tujuan']").html(isine)
      }
    })
  }

  function pilihLayanan(){
    let harga = $("[name='layanan']").val()
    $("[name='harga_kirim']").val(harga)

    var element = $("[name='layanan']").find('option:selected'); 
    var myTag = element.attr("estimasi"); 

    $("[name='estimasi']").val(myTag); 

    total()
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
    let harga = $("[name='harga_kirim']").val()
    let jml_point = $("[name='jml_point']").val()
    for (var j = 0; j <= jml_part; j++) {
        subTotal = $(".subTotal").eq(j).text().split('.').join('');
        tot += parseFloat(subTotal);

    }

    tot = tot + parseFloat(harga) - parseFloat(jml_point);

    $("#total_text").text(formatRupiah(tot.toString(), ''));

  }

  $("#btnCheckOut").click(function(){
    event.preventDefault();
    // var $dataElements = $('#tb_item').find('td'),
    // data = [];

    // $.each($dataElements, function(i, elem){
    //     data.push($(elem).html());
    // });
    formData = $("#FRM_DATA").serialize()
    $.ajax({
      url: "<?php echo site_url('front/checkOutSave') ?>",
      type: "POST",
      dataType: "JSON",
      data: formData,
      success: function(data){
        // console.log(data)
        if (data.status == "success") {
          toastr.info(data.message)
          setTimeout(() => {
            window.location="<?php echo base_url('home');?>"
          }, 500);
          
        }else{
          toastr.error(data.message)
        }
      }
    })
  })

  function cekGunakanPoint(){
    if($("#chkPoint").is(":checked") == true){
      // getPointPelanggan()
      $("[name='jml_point']").val(max_point_pelanggan)
      $("[name='jml_point']").attr('readonly', false)
    }else{
      $("[name='jml_point']").attr('readonly', true)
      $("[name='jml_point']").val(0)
    }

    total()
  }

  function changePoint(){
    let jml_point = $("[name='jml_point']").val()
    if(parseFloat(jml_point) > parseFloat(max_point_pelanggan)){
      alert("Point yg anda input melebihi jumlah point pelanggan")
      $("[name='jml_point']").val(max_point_pelanggan)
      
    }
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