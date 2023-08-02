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

        <div class="col-md-7">
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
              <select class="form-control select2" name="kota_asal" required></select>
            </div>
            <div class="form-group">
              <label>Kota Asal</label>
              <select class="form-control select2" id="kota_tujuan" required></select>
            </div>
            <div class="form-group">
              <label for="">Kurir</label>
              <select class="form-control" name="kurir" required>
                <option value="jne">JNE</option>
                <option value="tiki">TIKI</option>
                <option value="pos">POS INDONESIA</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Layanan</label>
              <input class="input" type="text" name="layanan" >
            </div>
            <div class="form-group">
              <label for="">Harga</label>
              <input class="input" type="text" name="harga" >
            </div>
            <div class="form-group">
              <label for="">Estimasi</label>
              <input class="input" type="text" name="estimasi" >
            </div>
            <div class="form-group">
              <label for="">Alamat Lengkap Penerima</label>
              <textarea class="input" name="alamat_penerima"></textarea>
            </div>
          </div>
          <!-- /Billing Details -->
        </div>

        <!-- Order Details -->
        <div class="col-md-5 order-details">
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
                    <td><?= $item->nm_barang ?><button type="button" onClick="deleteRow('<?= $item->id_barang ?>')" class="bootbox-close-button close modClose" >×</button></td>
                    <td style="text-align:right;"><input type="text" name="qty[]" id="qty_<?= $item->id_barang ?>" onChange="subTotal('<?= $item->id_barang ?>')" class="input" value="<?= $item->qty ?>"></td>
                    <td style="text-align:right;" id="harga_<?= $item->id_barang ?>"><?= rupiah($item->harga,'') ?></td>
                    <td style="text-align:right;" class="subTotal" id="subTotal_<?= $item->id_barang ?>"><?= rupiah($item->sub_total,'') ?></td>
                  </tr>
                <?php 
                  $total += $item->sub_total;
                  } 
                ?>
              </tbody>
            </table>
            <div class="order-col">
              <div><strong>TOTAL</strong></div>
              <div><strong class="order-total" id="total_text"><?= rupiah($total,'Rp.') ?></strong></div>
            </div>
          </div>
          
          <a href="#" class="primary-btn order-submit">Checkout</a>
        </div>
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
    total()
    $("#row_"+id_barang).remove();
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