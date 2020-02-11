<?php include("class/classPersona.php") ?>
<?php include("class/classEspecialidad.php") ?>
<?php include("class/classServicio.php") ?>
<?php include("class/classActividadProgramable.php") ?>
<?php $s = new Servicio() ?>

<section class="content-header">
	<h1>Programación Anual
		<small><i class="fa fa-angle-right"></i> Ingreso de Diagnóstico Anual</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de Diagnóstico anual</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formNewDiagno">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Información General</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="gdate">
						<label class="control-label" for="idate">Período *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="yyyy" placeholder="AAAA" required>
						</div>
						<i class="fa form-control-feedback" id="icondate"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gserv">
						<label class="control-label" for="iserv">Servicio *</label>
						<select class="form-control" id="iNserv" name="iserv">
							<option value="">Seleccione servicio</option>
							<?php $ser = $s->getAll() ?>
							<?php foreach ($ser as $se): ?>
								<option value="<?php echo $se->ser_id ?>"><?php echo $se->ser_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gesp">
						<label class="control-label" for="iesp">Especialidad *</label>
						<select class="form-control" id="iNesp" name="iesp">
							<option value="">Seleccione especialidad</option>
						</select>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Brecha anual para la especialidad año anterior</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="gtat">
						<label class="control-label" for="itat">Total Consultas + Controles *</label>
						<input type="text" class="form-control input-number sum" id="iNtat" name="itat" placeholder="Ingrese el número de C+C" required>
						<i class="fa form-control-feedback" id="icontat"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gges">
						<label class="control-label" for="iges">Total Lista de Espera *</label>
						<input type="text" class="form-control input-number sum" id="iNges" name="iges" placeholder="Ingrese la lista de espera" required>
						<i class="fa form-control-feedback" id="iconges"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gtotal">
						<label class="control-label" for="itotal">Total Anual C+C</label>
						<input type="text" class="form-control input-number" id="iNtotal" name="itotal" value="0" disabled>
						<i class="fa form-control-feedback" id="icontotal"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="gtiq">
						<label class="control-label" for="itiq">Total Int. Quirúrgicas *</label>
						<input type="text" class="form-control input-number sumiq" id="iNtiq" name="itiq" placeholder="Ingrese el número de IQ" required>
						<i class="fa form-control-feedback" id="icontiq"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="ggesiq">
						<label class="control-label" for="igesiq">Total Lista de Espera *</label>
						<input type="text" class="form-control input-number sumiq" id="iNgesiq" name="igesiq" placeholder="Ingrese la lista de espera IQ" required>
						<i class="fa form-control-feedback" id="icongesiq"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gtotaliq">
						<label class="control-label" for="itotaliq">Total Anual IQ</label>
						<input type="text" class="form-control input-number" id="iNtotaliq" name="itotaliq" value="0" disabled>
						<i class="fa form-control-feedback" id="icontotaliq"></i>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Horas anuales de especialidad año anterior</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="gtaa">
						<label class="control-label" for="itaa">Total Horas At. Abierta *</label>
						<input type="text" class="form-control input-number sumhes" id="iNtaa" name="itaa" placeholder="Ingrese el número de horas para atención abierta" required>
						<i class="fa form-control-feedback" id="icontaa"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gtac">
						<label class="control-label" for="itac">Total Horas At. Cerrada *</label>
						<input type="text" class="form-control input-number sumhes" id="iNtac" name="itac" placeholder="Ingrese el número de horas para atención cerrada" required>
						<i class="fa form-control-feedback" id="icontac"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gtpro">
						<label class="control-label" for="itpro">Total Horas Procedimiento *</label>
						<input type="text" class="form-control input-number sumhes" id="iNtpro" name="itpro" placeholder="Ingrese el número de horas para procedimientos" required>
						<i class="fa form-control-feedback" id="icontpro"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gtesp">
						<label class="control-label" for="itesp">Total Horas Especialidad</label>
						<input type="text" class="form-control input-number" id="iNtesp" name="itesp" value="0" disabled>
						<i class="fa form-control-feedback" id="icontesp"></i>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
				<button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
				<span class="ajaxLoader" id="submitLoader"></span>
			</div>
		</div>
	</form>
</section>

<script src="program/create-diagnosis.js"></script>