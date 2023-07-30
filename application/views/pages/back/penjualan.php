<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
        <div class="col-md-12">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Header Data</h4>

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
                <table class="table" border="1">
                  <tbody>
                    <tr>
                      <td style="width: 100px;font-weight: bold;">ID Penjualan</td>
                      <td style="width: 200px;"><input type="text" class="form-control" name="id_penjualan" readonly></td>
                      <td style="width: 100px;font-weight: bold;">Tanggal</td>
                      <td style="width: 300px;"><input type="text" class="form-control" name="tgl_penjualan"></td>
                      <td style="font-weight: bold;">Total Belanja</td>
                      <td style="font-weight: bold;font-family: fantasy;font-size: 35px;">RP. 1.000.000,00</td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">Pelanggan</td>
                      <td>
                        <select name="id_pelanggan" id="" class="form-control"></select>
                      </td>
                      <td style="text-align:right;font-weight: bold;" >Diskon</td>
                      <td><input type="text" class="form-control" name="diskon"></td>
                      <td style="font-weight: bold;">Uang Pelanggan</td>
                      <td ><input type="text" class="form-control" name="bayar"></td>
                    </tr>
                    <tr>
                      <td style="text-align:right;font-weight: bold;" colspan="3">Total Barang</td>
                      <td><input type="text" class="form-control" name="tot_biaya_barang"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
				</div>
			</div><!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Item Data</h4>

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
                <div class="row">
                  <button style="margin-left: 10px;" type="button" id="ADD_ITEM" class="btn btn-sm btn-info" ><i class="fa fa-plus"></i></button>
                </div>

                <div class="row mt-3">
                  <div class="col-xs-12 col-lg-12">
                    <div style="position: relative;height: 400px;overflow: auto;display: block;">
                      <table class="table table-bordered" id="tb_item_detail" style="font-size: 12px;">
                        <thead>
                          <td></td>
                          <th style="width: 60px;">Srl</th>
                          <th style="width: 170px;">Code Barang</th>
                          <th style="width: 60px;"></th>
                          <th style="width: 250px;">Description</th>
                          <th style="width: 170px;">Jumlah</th>
                          <th style="width: 200px;">Harga</th>
                          <th style="width: 90px;">Unit</th>
                          <th >Diskon</th>
                          <th >Sub Total</th>
                        </thead>
                        <tbody >
                            
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
				</div>
			</div><!-- /.row -->


      <!-- Modal Select Item No -->
        <div class="modal fade" id="modal_ITEM"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document" style="width:900px">
            <!-- <form id="form_item"> -->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Cari Barang</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover table-striped" id="tb_select_item">
                          <thead>
                              <th>Code Barang</th>
                              <th>Description</th>
                              <th>Foto</th>
                              <th>Stok</th>
                              <th>Unit</th>
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
      <!-- Modal Select Item No -->

		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->

<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script>
  ACTION_MENU()
  function ACTION_MENU(){
      var html_menu = 
                      '<div class="navbar-custom-menu" style="float:left;margin-top: 10px;">'+
                          '<ul class="nav navbar-nav">'+
                              '<li>'+
                                  '<button id="btn_new" class="btn btn-light btn-xs"><i class="fa fa-plus"></i> New</button>'+
                              '</li>'+
                              '<li style="padding-left:10px">'+
                                  '<button id="btn_edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</button>'+
                              '</li>'+
                              '<li style="padding-left:10px">'+
                                  '<button id="btn_delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>'+
                              '</li>'+
                              '<li style="padding-left:10px">'+
                                  '<button id="btn_find" class="btn btn-xs btn-default"><i class="fa fa-search" style="font-size: 16px;"></i> Find</button>'+
                              '</li>'+
                              '<li style="padding-left:10px">'+
                                  '<button id="btn_print" class="btn btn-xs btn-default"><i class="fa fa-print" style="font-size: 16px;"></i> Print</button>'+
                              '</li>'+
                              '<li style="padding-left:10px">'+
                                  '<button id="btn_refresh" class="btn btn-xs btn-default"><i class="fa fa-undo" style="font-size: 16px;"></i> Refresh</button>'+
                              '</li>'+
                              '<li style="padding-left:10px">'+
                                  '<button id="btn_save" class="btn btn-xs btn-info"><i class="fa fa-save"></i> Save</button>'+
                              '</li>'+
                              '<li style="padding-left:10px">'+
                                  '<button id="btn_cancel" class="btn btn-xs btn-warning"><i class="fa fa-warning" ></i> Cancel</button>'+
                              '</li>'+
                      '</div>';

      $("#navbar").append(html_menu);
  }
</script>