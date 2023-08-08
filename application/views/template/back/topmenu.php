<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse ace-save-state">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>

	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-success">
				<i class="ace-icon fa fa-signal"></i>
			</button>

			<button class="btn btn-info">
				<i class="ace-icon fa fa-pencil"></i>
			</button>

			<button class="btn btn-warning">
				<i class="ace-icon fa fa-users"></i>
			</button>

			<button class="btn btn-danger">
				<i class="ace-icon fa fa-cogs"></i>
			</button>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>

			<span class="btn btn-info"></span>

			<span class="btn btn-warning"></span>

			<span class="btn btn-danger"></span>
		</div>
	</div><!-- /.sidebar-shortcuts -->

	<ul class="nav nav-list">
		<li class="<?= ($this->uri->segment(1) == 'home') ? 'active open' : '' ?> hover">
			<a href="<?php echo base_url("home")?>">
				<i class="menu-icon fa fa-home"></i>
				<span class="menu-text"> Dashboard </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?= ($this->uri->segment(1) == 'master') ? 'active open' : '' ?> hover">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-desktop"></i>
				<span class="menu-text">
					Master Data
				</span>

				<b class="arrow fa fa-angle-down"></b>
			</a>

			<b class="arrow"></b>

			<ul class="submenu">

				<li class="hover">
					<a href="<?php echo base_url("master/user")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						User
					</a>

					<b class="arrow"></b>
				</li>
        <li class="hover">
					<a href="<?php echo base_url("master/pelanggan")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Pelanggan
					</a>

					<b class="arrow"></b>
				</li>
				<li class="hover">
					<a href="<?php echo base_url("master/kategori")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Kategori Barang
					</a>

					<b class="arrow"></b>
				</li>
				<li class="hover">
					<a href="<?php echo base_url("master/barang")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Barang
					</a>

					<b class="arrow"></b>
				</li>

				
			</ul>
		</li>

    <li class="<?= ($this->uri->segment(1) == 'transaksi') ? 'active open' : '' ?> hover">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-shopping-cart"></i>
				<span class="menu-text">
					Transaksi
				</span>

				<b class="arrow fa fa-angle-down"></b>
			</a>

			<b class="arrow"></b>

			<ul class="submenu">

				<li class="hover">
					<a href="<?php echo base_url("transaksi/penjualan")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Penjualan
					</a>

					<b class="arrow"></b>
				</li>

        <li class="hover">
					<a href="<?php echo base_url("transaksi/datapenjualan")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Data Penjualan
					</a>

					<b class="arrow"></b>
				</li>
        <li class="hover">
					<a href="<?php echo base_url("transaksi/barangmasuk")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Barang Masuk
					</a>

					<b class="arrow"></b>
				</li>
        <li class="hover">
					<a href="<?php echo base_url("transaksi/barangkeluar")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Barang Keluar
					</a>

					<b class="arrow"></b>
				</li>
			</ul>
		</li>

    <li class="<?= ($this->uri->segment(1) == 'complaint') ? 'active open' : '' ?> hover">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-comments-o"></i>
				<span class="menu-text">
					Complaint
				</span>

				<b class="arrow fa fa-angle-down"></b>
			</a>

			<b class="arrow"></b>

			<ul class="submenu">

				<li class="hover">
					<a href="<?php echo base_url("complaint/usercomplaint")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Customer Complaint
					</a>

					<b class="arrow"></b>
				</li>

        <li class="hover">
					<a href="<?php echo base_url("complaint/grafikcomplaint")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Grafik Complaint
					</a>

					<b class="arrow"></b>
				</li>
			</ul>
		</li>

    <li class="<?= ($this->uri->segment(1) == 'laporan') ? 'active open' : '' ?> hover">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-book"></i>
				<span class="menu-text">
					Laporan
				</span>

				<b class="arrow fa fa-angle-down"></b>
			</a>

			<b class="arrow"></b>

			<ul class="submenu">

				<li class="hover">
					<a href="<?php echo base_url("laporan/penjualan")?>">
						<i class="menu-icon fa fa-caret-right"></i>
						Laporan Penjualan
					</a>

					<b class="arrow"></b>
				</li>
			</ul>
		</li>


	</ul><!-- /.nav-list -->
</div>