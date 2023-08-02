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
			<!-- ASIDE -->
			<div id="aside" class="col-md-3">
				<!-- aside Widget -->
				<div class="aside">
					<h3 class="aside-title">Categories</h3>
					<div class="checkbox-filter">
					<button type="button" class="btn-danger block" onclick="actKategori('ALL')">ALL</button>
					<?php foreach($kategori as $kat){ ?>
						<button type="button" onclick="actKategori('<?= $kat->id_kategori ?>')" class="btn-sm btn-danger block" style="padding: 5px 10px!important;"><?= $kat->nm_kategori ?></button>
					<?php } ?>
					</div>
				</div>
				<!-- /aside Widget -->

				<!-- aside Widget -->
				<div class="aside">
					<h3 class="aside-title">Brand</h3>
					<div class="checkbox-filter">
						<button type="button" class="btn-danger block" onclick="actMerk('ALL')">ALL</button>
						<?php foreach($merk as $brand){ ?>
						<button type="button" class="btn-sm btn-danger block" style="padding: 5px 10px!important;"><?= $brand->merk ?></button>
						<?php } ?>
					</div>
				</div>
				<!-- /aside Widget -->

				
			</div>
			<!-- /ASIDE -->

			<!-- STORE -->
			<div id="store" class="col-md-9">

				<!-- store products -->
				<div class="row">
					<!-- product -->
					<span id="postsList"></span>

					
					<!-- /product -->

					
				</div>
				<!-- /store products -->

				<!-- store bottom filter -->
				<!-- <div class="store-filter clearfix"> -->
				<div id='pagination'></div>
				<!-- </div> -->
				<!-- /store bottom filter -->
			</div>
			<!-- /STORE -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

		
<script src="<?php echo base_url(); ?>assets/template/front/js/jquery.min.js"></script>
<script>

	$('#pagination').on('click','a',function(e){
		e.preventDefault(); 
		var pageno = $(this).attr('data-ci-pagination-page');
		loadPagination(pageno);
	});

	loadPagination(0);

	function loadPagination(pagno){
		$.ajax({
			url: "<?php echo site_url('/front/loadRecord/') ?>"+pagno,
			type: 'get',
			dataType: 'json',
			success: function(response){
			$('#pagination').html(response.pagination);
				createTable(response.result,response.row);
			}
		});
	}

	function createTable(result,sno){
		sno = Number(sno);var row="";
		for(index in result){
			var content = result[index].nm_barang.replace(/<\/?[^>]+(>|$)/g, "");
			if(content.length > 200)
			content = content.substr(0, 200) + " ...";
			sno+=1;

			row += "<div class='col-md-4 col-xs-6'>"+
						"<div class='product'>"+
							"<div class='product-img'>"+
								"<img style='height: 200px' src='<?php echo base_url(); ?>assets/images/barang/"+result[index].foto_barang+"' >"+
							"</div>"+
							"<div class='product-body'>"+
								"<h3 class='product-name'><a href='<?php echo base_url('dtlProduct'); ?>/"+result[index].id_barang+"'>"+result[index].nm_barang+"</a></h3>"+
								"<h4 class='product-price'>Rp. "+formatRupiah(result[index].harga,'')+"</h4>"+
								"<div class='product-rating'>"+
									"<i class='fa fa-star'></i>"+
									"<i class='fa fa-star'></i>"+
									"<i class='fa fa-star'></i>"+
									"<i class='fa fa-star'></i>"+
									"<i class='fa fa-star'></i>"+
								"</div>"+
							"</div>"+
							"<div class='add-to-cart'>"+
								"<button class='add-to-cart-btn' onclick=\"btnAddChart('"+result[index].id_barang+"', '"+result[index].harga+"')\"><i class='fa fa-shopping-cart'></i> add to cart</button>"+
							"</div>"+
						"</div>"+
					"</div>";

		}
		$('#postsList').html(row)
	}

  function btnAddChart(id_barang, harga){
    event.preventDefault();

    <?php
      if(!$this->session->userdata('id_user')){
        echo "alert('Login Dulu');return;";
      }
    ?>

    $.ajax({
      url: "<?php echo base_url('front/addToChart') ?>",
      type: "POST",
      dataType: "JSON",
      data: {
        id_barang,
        harga
      },
      success: function(data){
        if (data.status == "success") {
          toastr.info(data.message)
          count_chart()
        }else{
          toastr.error(data.message)
        }
      }
    })
  }

  function count_chart(){
    $.ajax({
      url: "<?php echo base_url('front/count_chart') ?>",
      type: "GET",
      dataType: "HTML",
      success: function(data){
        $("#jml_chart").text(data)
      }
    })
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

	