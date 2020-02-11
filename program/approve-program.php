<?php include("class/classEstablecimiento.php") ?>
<?php include("class/classActividadProgramable.php") ?>
<?php $e = new Establecimiento() ?>
<?php $a = new ActividadProgramable() ?>

<section class="content-header">
	<h1>Programación Anual
		<small><i class="fa fa-angle-right"></i> Programaciones Aprobadas</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Programaciones Aprobadas</li>
	</ol>
</section>

<section class="content container-fluid">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Filtros de búsqueda</h3>
		</div>

		<form role="form" id="formNewProgram">
			<div class="box-body">
				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="gyear">
						<label class="control-label" for="iyear">Año de Planificación *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNyear" name="iyear" data-date-format="yyyy" placeholder="AAAA" required>
						</div>
						<i class="fa form-control-feedback" id="iconyear"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-4 has-feedback" id="gperiodo">
						<label class="control-label" for="iperiodo">Periodo *</label>
						<select class="form-control" id="iNperiodo" name="iperiodo" required>
							<option value="">Seleccione un periodo de programación</option>
							<option value="01">PROGRAMACIÓN INICIO DE AÑO</option>
							<option value="04">REPROGRAMACIÓN MARZO</option>
							<option value="07">REPROGRAMACIÓN JUNIO</option>
							<option value="10">REPROGRAMACIÓN SEPTIEMBRE</option>
						</select>
					</div>

					<div class="form-group col-xs-4 has-feedback" id="gplanta">
						<label class="control-label" for="iplanta">Planta *</label>
						<select class="form-control" id="iNplanta" name="iplanta" required>
							<option value="">Seleccione una planta</option>
							<option value="0">MÉDICA</option>
							<option value="1">NO MÉDICA</option>
							<option value="2">ODONTOLÓGICA</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-4 has-feedback" id="gappr">
						<label class="control-label" for="iappr">Aprobación</label>
						<select class="form-control" id="iNappr" name="iappr">
							<option value="">TODAS</option>
							<option value="0">APROBADA</option>
							<option value="1">SIN APROBAR</option>
						</select>
					</div>
					<?php if ($_admin): ?>
						<div class="form-group col-xs-4 has-feedback" id="gest">
							<label class="control-label" for="iest">Establecimiento</label>
							<select class="form-control" id="iNest" name="iest">
								<option value="">TODOS</option>
								<?php $est = $e->getAll() ?>
								<?php foreach ($est as $es): ?>
									<option value="<?php echo $es->est_id ?>"><?php echo $es->est_nombre ?></option>
								<?php endforeach ?>
							</select>
						</div>
					<?php endif ?>
				</div>
			</div>

			<div class="box-footer">
				<button type="button" class="btn btn-primary" id="btnsubmit">
					<i class="fa fa-search"></i> Buscar
				</button>
				<span class="ajaxLoader" id="submitLoader"></span>
			</div>
		</form>
	</div>

	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title" id="table-title-f">Programaciones registradas</h3>
		</div>

		<?php $act = $a->getNoPoli() ?>

		<div class="box-body table-responsive">
			<table id="tprogram" class="table table-hover table-striped">
				<thead>
				<tr>
					<th>Nombre</th>
					<th>Servicio</th>
					<th>Especialidad</th>
					<th>Descripción</th>
					<th>Corte</th>
					<th>Horas Contratadas</th>
					<th>Médicos Universidad</th>
					<th>Becados</th>
					<th>Horas Disponibles</th>
					<th>Consultas Nuevas</th>
					<th>Controles</th> <!-- 10 -->
					<th>Consultas Abreviadas</th>
					<th>Total Policlínico</th>
					<?php foreach ($act as $i => $k): ?>
						<th><?php echo $k->acp_descripcion ?></th>
					<?php endforeach ?>
					<th>TOTAL</th>
				</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script src="program/approve-program.js"></script>