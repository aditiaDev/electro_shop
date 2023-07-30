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
          <table id="tb_item" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Item</th>
                <th style="width:80px;">Qty</th>
                <th>Harga</th>
                <th>Sub Total</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
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
          t_data += '<tr>'+
                      '<td>'+noRow+'</td>'+
                      '<td>'+array['id_barang']+'<button type="button" class="bootbox-close-button close modClose" >×</button><br>'+array['nm_barang']+'</td>'+
                      '<td><input type="text" name="qty" class="form-control" value="1"></td>'+
                      '<td>'+array['harga']+'</td>'+
                      '<td>'+array['harga']+'</td>'+
                    '</tr>'
        });
        $("#tb_item tbody").append(t_data);
      }
    })
  }
</script>