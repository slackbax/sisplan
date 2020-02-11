<?php session_start() ?>
<?php $_login = false ?>
<?php $_admin = false ?>

<?php require("class/classMyDBC.php") ?>
<?php require("src/Random/random.php") ?>
<?php require("class/classCounter.php") ?>
<?php require("src/sessionControl.php") ?>
<?php require("src/fn.php") ?>

<?php extract($_GET) ?>
<?php if (isset($_SESSION['prm_userid'])): $_login = true; endif ?>
<?php if (isset($_SESSION['prm_useradmin']) and $_SESSION['prm_useradmin']): $_admin = true; endif ?>

<!DOCTYPE html>

<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SISPlan</title>

	<link rel="apple-touch-icon" sizes="57x57" href="dist/img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="dist/img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="dist/img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="dist/img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="dist/img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="dist/img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="dist/img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="dist/img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="dist/img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="dist/img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="dist/img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="dist/img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="dist/img/favicon/favicon-16x16.png">
	<link rel="manifest" href="dist/img/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="dist/img/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<!-- Responsivness -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<!-- daterange picker -->
	<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
	<!-- MultiFile -->
	<link rel="stylesheet" href="bower_components/multifile/jquery.MultiFile.css">
	<!-- SweetAlert -->
	<link rel="stylesheet" href="bower_components/sweetalert2/dist/sweetalert2.css">
	<!-- Noty -->
	<link rel="stylesheet" href="bower_components/noty/lib/noty.css">
	<!-- fullCalendar -->
	<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
	<link rel="stylesheet" href="bower_components/fullcalendar-scheduler/dist/scheduler.min.css">
	<!-- signaturePad -->
	<!-- <link rel="stylesheet" href="bower_components/signature_pad/css/signature-pad.css"> -->
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/iCheck/all.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/SISPlan.css">
	<link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- jQuery UI 1.12.1 -->
	<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
	<script>$.widget.bridge('uibutton', $.ui.button); $.widget.bridge('uitooltip', $.ui.tooltip);</script>
	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<?php if (isset($_SESSION['prm_userid'])): ?>
	<body class="hold-transition skin-blue sidebar-mini fixed">
	<div class="wrapper">

		<header class="main-header">
			<a href="index.php" class="logo">
				<span class="logo-mini"><b>S</b>PL</span>
				<span class="logo-lg">
					<b>S</b>ISPlan
				</span>
			</a>

			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown messages-menu">
							<a href="#" id="btn-help" class="dropdown-toggle" data-toggle="dropdown">
								Ayuda
							</a>
						</li>

						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="dist/img/<?php echo $_SESSION['prm_userpic'] ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['prm_userfname'] . ' ' . $_SESSION['prm_userlnamep'] ?></span>
							</a>
							<ul class="dropdown-menu">

								<li class="user-header">
									<img src="dist/img/<?php echo $_SESSION['prm_userpic'] ?>" class="img-circle" alt="User Image">
									<p>
										<?php echo $_SESSION['prm_userfname'] . ' ' . $_SESSION['prm_userlnamep'] ?>
									</p>
								</li>

								<li class="user-footer">
									<div class="pull-left">
										<a href="index.php?section=adminusers&sbs=editprofile" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Ver perfil</a>
									</div>
									<div class="pull-right">
										<a href="index.php?section=adminusers&sbs=changepass" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Cambiar contraseña</a>
									</div>
								</li>

								<li class="user-footer">
									<button type="button" id="btn-logout" class="btn btn-warning btn-flat btn-block">
										<i class="fa fa-power-off"></i> Salir
									</button>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<aside class="main-sidebar">

			<section class="sidebar">

				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">PRINCIPAL</li>
					<li<?php if (!isset($section) or $section == 'home' or $section == 'adminusers' or $section == 'forgotpass'): ?> class="active"<?php endif ?>>
						<a href="index.php?section=home">
							<i class="fa fa-home"></i> <span>Inicio</span>
						</a>
					</li>

					<?php include('class/classMenu.php'); ?>
					<?php $m = new Menu(); ?>
					<?php $men = $m->getByProfile($_SESSION['prm_rol']['per']) ?>

					<?php foreach ($men as $mn): ?>
						<?php if ($mn->men_tipo == 1 and $mn->men_parent == ''): ?>
							<li<?php if (isset($section) and $section == $mn->men_section): ?> class="active"<?php endif ?>>
								<a href="index.php?section=<?php echo $mn->men_link ?>">
									<i class="fa <?php echo $mn->men_icon ?>"></i>
									<span><?php echo $mn->men_descripcion ?></span>
								</a>
							</li>

						<?php elseif ($mn->men_tipo == 2): ?>
							<li class="treeview<?php if (isset($section) and $section == $mn->men_section): ?>  active<?php endif ?>">
								<a href="#">
									<i class="fa <?php echo $mn->men_icon; ?>"></i>
									<span><?php echo $mn->men_descripcion ?></span>
									<span class="pull-right-container">
                            		<i class="fa fa-angle-left pull-right"></i>
                        			</span>
								</a>
								<ul class="treeview-menu">
									<?php $subm = $m->getChildByProfile($mn->men_id, $_SESSION['prm_rol']['per']) ?>
									<?php foreach ($subm as $smn): ?>
										<li<?php if (isset($sbs) and $sbs == $smn->men_link): ?> class="active"<?php endif ?>>
											<a href="index.php?section=<?php echo $mn->men_section ?>&sbs=<?php echo $smn->men_link ?>">
												<i class="fa fa-circle-o text-teal"></i>
												<span class="menu-item"><?php echo $smn->men_descripcion ?></span>
											</a>
										</li>
									<?php endforeach ?>
								</ul>
							</li>
						<?php endif ?>
					<?php endforeach ?>

					<?php if ($_admin): ?>
						<li class="header">PANEL DE CONTROL</li>
						<li class="treeview<?php if (isset($section) and $section == 'users'): ?> active<?php endif ?>">
							<a href="#">
								<i class="fa fa-user"></i>
								<span>Usuarios</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li<?php if (isset($sbs) and $sbs == 'createuser'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=users&sbs=createuser">
										<i class="fa fa-circle-o text-red"></i>Creación de Usuarios
									</a>
								</li>
								<li<?php if (isset($sbs) and $sbs == 'manageusers'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=users&sbs=manageusers">
										<i class="fa fa-circle-o text-red"></i>Ver Usuarios Creados
									</a>
								</li>
							</ul>
						</li>

						<li class="treeview<?php if (isset($section) and $section == 'groups'): ?> active<?php endif ?>">
							<a href="#">
								<i class="fa fa-users"></i>
								<span>Grupos</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li<?php if (isset($sbs) and $sbs == 'creategroup'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=groups&sbs=creategroup">
										<i class="fa fa-circle-o text-red"></i>Creación de Grupo
									</a>
								</li>
								<li<?php if (isset($sbs) and $sbs == 'managegroups'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=groups&sbs=managegroups">
										<i class="fa fa-circle-o text-red"></i>Ver Grupos Creados
									</a>
								</li>
							</ul>
						</li>
					<?php endif ?>
				</ul>
			</section>
		</aside>

		<div class="content-wrapper main">
			<?php include('src/routes.php'); ?>
		</div>

	</div>

	<!-- REQUIRED JS SCRIPTS -->
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- DataTables -->
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="bower_components/jszip/dist/jszip.min.js"></script>
	<script src="bower_components/pdfmake/build/pdfmake.min.js"></script>
	<script src="bower_components/pdfmake/build/vfs_fonts.js"></script>
	<script src="bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="bower_components/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	<!-- jQueryForm -->
	<script src="bower_components/jquery-form/dist/jquery.form.min.js"></script>
	<!-- AutoComplete -->
	<script src="bower_components/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- date-range-picker -->
	<script src="bower_components/moment/min/moment.min.js"></script>
	<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap datepicker -->
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
	<!-- bootstrap time picker -->
	<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<!-- SweetAlert -->
	<script src="bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
	<!-- Noty -->
	<script src="bower_components/noty/lib/noty.js"></script>
	<!-- CKEditor -->
	<script src="bower_components/ckeditor/ckeditor.js"></script>
	<!-- fullCalendar -->
	<script src="bower_components/moment/moment.js"></script>
	<script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
	<script src='bower_components/fullcalendar/dist/locale/es.js'></script>
	<script src="bower_components/fullcalendar-scheduler/dist/scheduler.min.js"></script>
	<!-- Slimscroll -->
	<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="bower_components/fastclick/lib/fastclick.js"></script>
	<!-- MultiFile -->
	<script src="bower_components/multifile/jquery.MultiFile.min.js"></script>
	<!-- signaturePad -->
	<!-- <script src="bower_components/signature_pad/js/signature_pad.js"></script> -->
	<!-- iCheck -->
	<script src="plugins/iCheck/icheck.min.js"></script>
	<!-- SISGDoc App -->
	<script src="dist/js/sisplan.min.js"></script>
	<script src="dist/js/jquery.Rut.min.js"></script>
	<script src="dist/js/fn.js"></script>

	<script src="dist/js/index.js"></script>
	</body>
<?php elseif (isset($section) and $section == 'forgotpass'): ?>
	<?php include('admin/users/retrieve-password.php') ?>
<?php else: ?>
	<?php include('src/login.php') ?>
<?php endif ?>
</html>