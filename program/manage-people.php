<section class="content-header">
	<h1>Programación Anual
		<small><i class="fa fa-angle-right"></i> Contratos Registrados</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Contratos Registrados</li>
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
					<div class="form-group col-xs-4 has-feedback" id="gplanta">
						<label class="control-label" for="iplanta">Planta</label>
						<select class="form-control" id="iNplanta" name="iplanta">
							<option value="">TODAS</option>
							<option value="0">MÉDICA</option>
							<option value="1">NO MÉDICA</option>
							<option value="2">ODONTOLÓGICA</option>
						</select>
					</div>
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
			<h3 class="box-title" id="table-title-f">Contratos registrados</h3>
		</div>

		<div class="box-body">
			<table id="tpeople" class="table table-hover table-striped">
				<thead>
				<tr>
					<th>RUT</th>
					<th>Nombre</th>
					<th>Profesión</th>
					<th>Ley</th>
					<th>Establecimiento</th>
					<th>Correlativo</th>
					<th>Horas</th>
				</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script src="program/manage-people.js"></script>