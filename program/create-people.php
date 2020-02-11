<?php include("class/classPersona.php") ?>
<?php include("class/classProfesion.php") ?>

<section class="content-header">
	<h1>Programación Anual
		<small><i class="fa fa-angle-right"></i> Creación de Personal</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Creación de personal</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formNewPeople">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Información General</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="grut">
						<label class="control-label" for="irut">RUT *</label>
						<input type="text" class="form-control" id="iNrut" name="irut" placeholder="12345678-9" maxlength="12" required>
						<i class="fa form-control-feedback" id="iconrut"></i>
						<input type="hidden" id="iNid" name="iid">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gname">
						<label class="control-label" for="iname">Nombre completo *</label>
						<input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre completo de la persona" required>
						<i class="fa form-control-feedback" id="iconname"></i>
						<p class="help-block">Ingresar en orden APELLIDO PATERNO + APELLIDO MATERNO + NOMBRES</p>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gprofesion">
						<label class="control-label" for="iprofesion">Profesión *</label>
						<select class="form-control" id="iNprofesion" name="iprofesion">
							<option value="">Seleccione profesión</option>
							<?php $pro = new Profesion() ?>
							<?php $p = $pro->getAll() ?>
							<?php foreach ($p as $aux => $es): ?>
								<option value="<?php echo $es->prof_id ?>"><?php echo $es->prof_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-xs-6 has-feedback" id="gespec">
						<label class="control-label" for="iespec">Especialidad SIS</label>
						<input type="text" class="form-control" id="iNespec" name="iespec" placeholder="Ingrese especialidad según SIS">
						<i class="fa form-control-feedback" id="iconespec"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gtcontrato">
						<label class="control-label" for="itcontrato">Tipo de Contrato *</label>
						<select class="form-control" id="iNtcontrato" name="itcontrato">
							<option value="">Seleccione tipo</option>
							<option value="1">LEY 15076</option>
							<option value="2">LEY 18834</option>
							<option value="3">LEY 19664</option>
							<option value="4">HONORARIOS</option>
						</select>
					</div>

					<div class="form-group col-xs-6 has-feedback" id="gcorr">
						<label class="control-label" for="icorr">Correlativo *</label>
						<input type="text" class="form-control" id="iNcorr" name="icorr" placeholder="Ingrese correlativo del contrato" required>
						<i class="fa form-control-feedback" id="iconcorr"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="ghoras">
						<label class="control-label" for="ihoras">Número de horas *</label>
						<input type="text" class="form-control" id="iNhoras" name="ihoras" placeholder="Ingrese cantidad de horas de contrato" required>
						<i class="fa form-control-feedback" id="iconhoras"></i>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar datos</button>
				<button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
				<span class="ajaxLoader" id="submitLoader"></span>
			</div>
		</div>
	</form>
</section>

<script src="program/create-people.js"></script>