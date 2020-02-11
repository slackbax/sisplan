<body class="hold-transition">
<div class="col-xs-8 col-xs-offset-2">
	<section class="content-header">
		<h1><i class="fa fa-check-circle-o"></i> Recuperación de Contraseña</h1>

		<ol class="breadcrumb">
			<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
			<li class="active">Recuperación de contraseña</li>
		</ol>
	</section>

	<section class="content container-fluid">
		<form role="form" id="formChangePass">
			<div class="callout callout-warning">
				<h4>¿Olvidó su contraseña?</h4>
				<p>Ingrese su nombre de usuario y una nueva contraseña será enviada a su correo. Luego podrá cambiarla en el menú de usuario en la barra superior, si así lo desea.</p>
			</div>

			<div class="box box-default">
				<div class="box-body">
					<div class="row">
						<div class="form-group col-xs-6 col-xs-offset-3 has-feedback" id="gusername">
							<label for="iusername">Nombre de usuario</label>
							<input type="text" class="form-control" id="iNusername" name="iusername" placeholder="Ingrese su nombre de usuario" maxlength="16" required>
							<i class="fa form-control-feedback" id="iconusername"></i>
						</div>
					</div>
				</div>

				<div class="box-footer text-center">
					<button type="submit" class="btn btn-lg btn-danger" id="btnsubmit"><i class="fa fa-check"></i> Enviar a mi correo</button>
					<span class="ajaxLoader" id="submitLoader"></span>
				</div>
			</div>
		</form>
	</section>
</div>

<!-- jQueryForm -->
<script src="bower_components/jquery-form/dist/jquery.form.min.js"></script>
<!-- Noty -->
<script src="bower_components/noty/lib/noty.js"></script>
<script src="dist/js/fn.js"></script>
<script src="admin/users/retrieve-password.js"></script>
</body>