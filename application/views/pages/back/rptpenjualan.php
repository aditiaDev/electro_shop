<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
				<div class="col-md-4">
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title" id="judul_entry">Cetak Laporan Penjualan</h4>

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
                <form id="FRM_DATA" action="<?php echo base_url('report/ctkPenjualan') ?>" method="POST" target="_blank">
                  <div>
                    <label>
                        Dari
                    </label>
                    <input type="date" name="from" class="form-control rounded-full" />
                  </div>
                  <div>
                    <label>
                        Sampai
                    </label>
                    <input type="date" name="to" class="form-control rounded-full" />
                  </div>
                  <div class="mt-5 text-right">
                    <button class="btn btn-primary rounded-full" id="BTN_PRINT"><i class="fa fa-print"></i> Cetak</button>
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