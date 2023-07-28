<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Mahir Komputer</title>

		<meta name="description" content="top menu &amp; navigation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/back/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/back/assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/back/assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/back/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />


		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/back/assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/back/assets/css/ace-rtl.min.css" />

		<link rel="stylesheet" href="<?php echo base_url('/assets/toastr/toastr.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('/assets/css/loader.css'); ?>">

		<style>
			.mt-3 {
				margin-top: 0.75rem;
			}

			.mt-5 {
				margin-top: 1.25rem;
			}
			
			.rounded-full {
				border-radius: 9999px!important;
			}

      td.dt-control {
        background: url('<?php echo base_url(); ?>assets/details_open.png') no-repeat center center;
        cursor: pointer
      }

      tr.shown td.dt-control {
        background: url('<?php echo base_url(); ?>assets/details_close.png') no-repeat center center;
      }
		</style>

		<script src="<?php echo base_url(); ?>assets/template/back/assets/js/ace-extra.min.js"></script>


	</head>

	<body class="no-skin">
		<div class="before-loader" id="LOADER" style="display: none;">
        	<div class="loader5" ></div>
     	</div>
		<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="<?php echo base_url("home")?>" class="navbar-brand">
						<small>
							<i class="fa fa-desktop"></i>
							Mahir Comp
						</small>
					</a>

          <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
						<span class="sr-only">Toggle user menu</span>

						<img src="<?php echo base_url(); ?>assets/template/back/assets/images/avatars/user.jpg" alt="Jason's Photo" />
					</button>

					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>
					</button>
					
				</div>

				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
					<ul class="nav ace-nav">

						<li class="light-blue dropdown-modal user-min">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo base_url(); ?>assets/template/back/assets/images/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									Jason
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?php echo base_url("login/logout")?>">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			