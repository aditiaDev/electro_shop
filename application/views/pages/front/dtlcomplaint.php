<style>
  .timeline-container {
    position: relative;
    padding-top: 4px;
    margin-bottom: 32px;
  }

  .timeline-label {
    display: block;
    clear: both;
    margin: 0 0 18px 34px;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 8px;
  }

  .timeline-info {
    float: left;
    width: 60px;
    text-align: center;
    position: relative;
  }

  .timeline-container:first-child:before {
      border-top-width: 1px;
  }
  .timeline-container:before {
      content: "";
      display: block;
      position: absolute;
      left: 28px;
      top: 0;
      bottom: 0;
      border: 1px solid #E2E3E7;
      background-color: #E7EAEF;
      width: 4px;
      border-width: 0 1px;
  }

  .timeline-item .transparent.widget-box {
    border-left: 3px solid #DAE1E5;
  }
  .timeline-item .widget-box {
      margin: 0 0 0 60px;
      position: relative;
      max-width: none;
  }
  .timeline-item .widget-box {
      background-color: #F2F6F9;
      color: #595C66;
  }
  .widget-box.transparent {
      border-width: 0;
  }
  .widget-box {
      padding: 0;
      box-shadow: none;
      margin: 3px 0;
      border: 1px solid #CCC;
  }
  .progress, .widget-box {
      -webkit-box-shadow: none;
  }

  .timeline-item .transparent .widget-header {
      background-color: #ECF1F4;
      border-bottom-width: 0;
  }
  .widget-box.transparent>.widget-header-small {
      padding-left: 1px;
  }
  .widget-box.transparent>.widget-header {
      background: 0 0;
      border-width: 0;
      border-bottom: 1px solid #DCE8F1;
      color: #4383B4;
      padding-left: 3px;
  }
  .widget-box.transparent>.widget-header, .widget-header-flat {
      filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  }
  .widget-header-small {
      min-height: 31px;
      padding-left: 10px;
  }
  .widget-header {
      -webkit-box-sizing: content-box;
      -moz-box-sizing: content-box;
      box-sizing: content-box;
      position: relative;
      min-height: 38px;
      background: repeat-x #f7f7f7;
      background-image: -webkit-linear-gradient(top,#FFF 0,#EEE 100%);
      background-image: -o-linear-gradient(top,#FFF 0,#EEE 100%);
      background-image: linear-gradient(to bottom,#FFF 0,#EEE 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffeeeeee', GradientType=0);
      color: #669FC7;
      border-bottom: 1px solid #DDD;
      padding-left: 12px;
  }

  .widget-box.transparent>.widget-body {
      border-width: 0;
      background-color: transparent;
  }
  .timeline-item .widget-body {
      background-color: transparent;
  }
  .widget-body {
      background-color: #FFF;
  }

  .timeline-item .widget-main {
      margin: 0;
      position: relative;
      max-width: none;
      border-bottom-width: 0;
  }

  .widget-main {
      padding: 12px;
  }
  *, :after, :before {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
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
    <button class="btn btn-info btn-sm" id="btnBalas">Balas</button>
    <div id="timeline-1">
      <div class="row">
        <div class="col-sm-12 col-md-12">
          <div class="timeline-container">
            <?php
            // print_r($data);
            foreach($data as $row){
            ?>
              <div class="timeline-items">
                <div class="timeline-item clearfix">
                  <div class="timeline-info">
                    <img alt="Susan't Avatar" src="<?= base_url() ?>assets/template/back/assets/images/avatars/<?= $row->avatar ?>" />
                    <span class="label label-info label-sm"><?= date('d-m-y', strtotime($row->tgl_jawab)) ?></span>
                  </div>

                  <div class="widget-box transparent">
                    <div class="widget-header widget-header-small">
                      <h5 class="widget-title smaller">
                        <span class="grey"><?= $row->oleh ?></span>
                      </h5>

                      <span class="widget-toolbar no-border">
                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                        <?= date('H:i', strtotime($row->tgl_jawab)) ?>
                      </span>
                    </div>

                    <div class="widget-body">
                      <div class="widget-main">
                        <?= $row->deskripsi ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- /.timeline-items -->
            <?php } ?>
          </div><!-- /.timeline-container -->

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
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Pesan</label>
                          <textarea name="deskripsi" rows="5" class="form-control"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="BTN_SAVE">Balas</button>
                  </div>
                </form>
              </div>
            </div>
          </div><!-- End Basic Modal-->
        </div>
      </div>
    </div>
	</div>
	<!-- /container -->


</div>
<!-- /SECTION -->

		
<script src="<?php echo base_url(); ?>assets/template/front/js/jquery.min.js"></script>
<script>
  $(function(){
    $("#btnBalas").click(function(){
      $("#modal_add").modal('show')
    })

    $("#BTN_SAVE").click(function(){
      let formData = $("#FRM_DATA").serialize();
      formData+="&id_complaint=<?= $this->uri->segment(2) ?>"
      let urlPost = "<?php echo site_url('complaint/saveComplaint') ?>";

      $.ajax({
          url: urlPost,
          type: "POST",
          data: formData,
          dataType: "JSON",
          success: function(data){
            console.log(data)
            if (data.status == "success") {
              toastr.info(data.message)
              setTimeout(() => {
                location.reload();
              }, 500);
              

            }else{
              toastr.error(data.message)
            }
          }
      })
    })
  })
</script>