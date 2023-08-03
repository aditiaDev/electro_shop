<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
				<div class="col-xs-12 col-sm-10 col-sm-offset-1">
          <button class="btn btn-info btn-sm" id="btnBalas" style="margin-bottom: 10px;">Balas</button>
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
</div><!-- /.main-content -->
<script src="<?php echo base_url(); ?>assets/template/back/assets/js/jquery-2.1.4.min.js"></script>
<script>
  $(function(){
    $("#btnBalas").click(function(){
      $("#modal_add").modal('show')
    })

    $("#BTN_SAVE").click(function(){
      event.preventDefault()
      let formData = $("#FRM_DATA").serialize();
      formData+="&id_complaint=<?= $this->uri->segment(2) ?>"
      let urlPost = "<?php echo site_url('usercomplaint/saveComplaint') ?>";

      $.ajax({
          url: urlPost,
          type: "POST",
          data: formData,
          dataType: "JSON",
          success: function(data){
            // console.log(data)
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