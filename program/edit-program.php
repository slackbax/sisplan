<?php include("class/classParametro.php") ?>
<?php include("class/classPersonaEstablecimiento.php") ?>
<?php include("class/classDistribucionProg.php") ?>
<?php include("class/classDistHorasProg.php") ?>
<?php include("class/classDiagnostico.php") ?>
<?php include("class/classPersona.php") ?>
<?php include("class/classCr.php") ?>
<?php include("class/classServicio.php") ?>
<?php include("class/classEspecialidad.php") ?>
<?php include("class/classJustificacion.php") ?>
<?php include("class/classActividadProgramable.php") ?>

<?php $para = new Parametro() ?>
<?php $pe = new PersonaEstablecimiento() ?>
<?php $di = new DistribucionProg() ?>
<?php $dh = new DistHorasProg() ?>
<?php $dg = new Diagnostico() ?>
<?php $p = new Persona() ?>
<?php $cr = new Cr() ?>
<?php $ser = new Servicio() ?>
<?php $es = new Especialidad() ?>
<?php $js = new Justificacion() ?>
<?php $acp = new ActividadProgramable() ?>
<?php $disp = $di->get($id) ?>
<?php $pes = $pe->get($disp->disp_pesid) ?>
<?php $t_date = explode('-', $disp->disp_fecha_ini) ?>
<?php $t_par = $para->get($t_date[0]) ?>
<?php $WEEKS = $t_par->par_semanas ?>
<?php $per = $p->get($pes->per_id) ?>
<?php $serv = $ser->get($disp->disp_serid) ?>

<?php $sem_disp = $WEEKS - (($disp->disp_vacaciones + $disp->disp_permisos + $disp->disp_congreso + $disp->disp_descanso) / 5) ?>

<section class="content-header">
	<h1>Programación Anual
		<small><i class="fa fa-angle-right"></i> Edición de Programación</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="index.php?section=program&sbs=manageprogram">Programaciones Registradas</a></li>
		<li class="active">Edición de programación</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formNewProgram">
		<input type="hidden" id="weeks" value="<?php echo $WEEKS ?>">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Datos Personales</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-4">
						<label class="control-label">Nombre</label>
						<p class="form-control-static"><?php echo $per->per_nombres ?></p>
						<input type="hidden" id="iid" name="id" value="<?php echo $id ?>">
					</div>

					<div class="form-group col-sm-8">
						<label class="control-label">Profesión</label>
						<p class="form-control-static"><?php echo $per->per_profesion ?></p>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-4">
						<label class="control-label">Ley (correlativo)</label>
						<p class="form-control-static"><?php echo $pes->con_descripcion ?> (<?php echo $pes->pes_correlativo ?>)</p>
					</div>

					<div class="form-group col-sm-8">
						<label class="control-label">Especialidad SIS</label>
						<p class="form-control-static"><?php echo $per->per_sis ?></p>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Datos de Programación</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-5 has-feedback has-success" id="gdate">
						<label class="control-label" for="idate">Período de Programación *</label>
						<div class="input-group input-daterange">
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="mm/yyyy" placeholder="MM/YYYY" value="<?php echo getDateMonthToForm($disp->disp_fecha_ini) ?>" required>
							<span class="input-group-addon">hasta</span>
							<input type="text" class="form-control" id="iNdate_t" name="idate_t" data-date-format="mm/yyyy" placeholder="MM/YYYY" value="<?php echo getDateMonthToForm($disp->disp_fecha_ter) ?>" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback has-success" id="gdesc">
						<label class="control-label" for="idesc">Descripción *</label>
						<input type="text" class="form-control" id="iNdesc" name="idesc" placeholder="Ingrese descripción para la programación" value="<?php echo $disp->disp_descripcion ?>" maxlength="64" required>
						<i class="fa form-control-feedback fa-check" id="icondesc"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback has-success" id="gcr">
						<label class="control-label" for="icr">Centro de Responsabilidad *</label>
						<select class="form-control" id="iNcr" name="icr" required>
							<option value="">Seleccione CR</option>
							<?php $cen = $cr->getAll() ?>
							<?php foreach ($cen as $c): ?>
								<option value="<?php echo $c->cr_id ?>" <?php if ($c->cr_id == $serv->cr_id): ?>selected<?php endif ?>><?php echo $c->cr_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-6 has-feedback has-success" id="gserv">
						<label class="control-label" for="iserv">Servicio *</label>
						<select class="form-control" id="iNserv" name="iserv" required>
							<option value="">Seleccione servicio</option>
							<?php $se = $ser->getByCR($serv->cr_id) ?>
							<?php foreach ($se as $s): ?>
								<option value="<?php echo $s->ser_id ?>" <?php if ($s->ser_id == $serv->ser_id): ?>selected<?php endif ?>><?php echo $s->ser_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback has-success" id="gesp">
						<label class="control-label" for="iesp">Especialidad *</label>
						<select class="form-control" id="iNesp" name="iesp" required>
							<option value="">Seleccione especialidad</option>
							<?php $esp = $es->getByServicio($serv->ser_id) ?>
							<?php foreach ($esp as $e): ?>
								<option value="<?php echo $e->esp_id ?>" <?php if ($e->esp_id == $disp->disp_espid): ?>selected<?php endif ?>><?php echo $e->esp_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6">
						<p>
							<label class="label-checkbox">
								<input type="checkbox" class="minimal" name="igeneral"<?php if ($disp->disp_med_general): ?> checked<?php endif ?>> Médico General
							</label>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback<?php if ($disp->disp_observaciones !== ''): ?> has-success<?php endif ?>" id="gobserv">
						<label class="control-label" for="iobserv">Observaciones</label>
						<input type="text" class="form-control" id="iNobserv" name="iobserv" placeholder="Ingrese observación (Liberado de guardia / PAO)" maxlength="64" value="<?php echo $disp->disp_observaciones ?>">
						<i class="fa form-control-feedback<?php if ($disp->disp_observaciones !== ''): ?> fa-check<?php endif ?>" id="iconobserv"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-2 has-feedback<?php echo ($disp->disp_vacaciones >= 0) ? ' has-success' : '' ?>" id="gvacaciones">
						<label class="control-label" for="ivacaciones">Vacaciones *</label>
						<input type="text" class="form-control input-number disp" id="iNvacaciones" name="ivacaciones" placeholder="Ingrese días de vacaciones" value="<?php echo $disp->disp_vacaciones ?>" required>
						<i class="fa form-control-feedback<?php echo ($disp->disp_vacaciones > 0) ? ' fa-check' : '' ?>" id="iconvacaciones"></i>
					</div>

					<div class="form-group col-sm-2 has-feedback<?php echo ($disp->disp_permisos >= 0) ? ' has-success' : '' ?>" id="gpermiso">
						<label class="control-label" for="ipermiso">Permisos *</label>
						<input type="text" class="form-control input-number disp" id="iNpermiso" name="ipermiso" placeholder="Ingrese días de permiso" value="<?php echo $disp->disp_permisos ?>" required>
						<i class="fa form-control-feedback<?php echo ($disp->disp_permisos > 0) ? ' fa-check' : '' ?>" id="iconpermiso"></i>
					</div>

					<div class="form-group col-sm-2 has-feedback<?php echo ($disp->disp_congreso >= 0) ? ' has-success' : '' ?>" id="gcongreso">
						<label class="control-label" for="icongreso">Congreso *</label>
						<input type="text" class="form-control input-number disp" id="iNcongreso" name="icongreso" placeholder="Ingrese días de congresos" value="<?php echo $disp->disp_congreso ?>" required>
						<i class="fa form-control-feedback<?php echo ($disp->disp_congreso > 0) ? ' fa-check' : '' ?>" id="iconcongreso"></i>
					</div>

					<div class="form-group col-sm-2 has-feedback<?php echo ($disp->disp_descanso >= 0) ? ' has-success' : '' ?>" id="gdescanso">
						<label class="control-label" for="idescanso">Descanso comp. *</label>
						<input type="text" class="form-control input-number disp" id="iNdescanso" name="idescanso" placeholder="Ingrese días de descansos" value="<?php echo $disp->disp_descanso ?>" required>
						<i class="fa form-control-feedback<?php echo ($disp->disp_descanso > 0) ? ' fa-check' : '' ?>" id="icondescanso"></i>
					</div>

					<div class="form-group col-sm-3 col-sm-offset-1" id="gsemdisp">
						<label class="control-label" for="isemdisp">Semanas disponibles</label>
						<input type="text" class="form-control input-number" id="iNsemdisp" name="isemdisp" tabindex="-1" value="<?php echo $sem_disp ?>" disabled>
					</div>
				</div>
			</div>

			<?php if ($per->per_prid == 4 or $per->per_prid == 14 or $per->per_prid == 16): ?>
				<?php $tmp = explode('-', $disp->disp_fecha_ini) ?>
				<?php $date_d = $tmp[0] . '-01-01' ?>
				<?php $diag = $dg->getByEspDate($_SESSION['prm_estid'], $disp->disp_espid, $disp->disp_serid, $date_d) ?>

				<div class="box-header with-border">
					<h3 class="box-title">Diagnóstico Especialidad</h3>
				</div>

				<div class="box-body">
					<div class="row">
						<div class="form-group col-sm-2" id="gtat">
							<label class="control-label" for="itat">Total Cons. + Cont.</label>
							<div class="input-group">
								<span class="input-group-addon">A</span>
								<input type="text" class="form-control input-number" id="iNtat" name="itat" value="<?php echo number_format($diag->dia_total_esp, 0, '', '.') ?>" disabled>
							</div>
						</div>

						<div class="form-group col-sm-2" id="gges">
							<label class="control-label" for="iges">Total Lista de Espera</label>
							<div class="input-group">
								<span class="input-group-addon">B</span>
								<input type="text" class="form-control input-number" id="iNges" name="iges" value="<?php echo number_format($diag->dia_lista, 0, '', '.') ?>" disabled>
							</div>
						</div>

						<div class="form-group col-sm-2 has-success" id="gtotalan">
							<label class="control-label" for="itotalan">Total Anual</label>
							<div class="input-group">
								<span class="input-group-addon">A + B</span>
								<input type="text" class="form-control input-number" id="iNtotalan" name="itotalan" value="<?php echo number_format($diag->dia_total_esp + $diag->dia_lista, 0, '', '.') ?>" disabled>
							</div>
						</div>

						<?php $p_cc = $di->getProgrammedCC($_SESSION['prm_estid'], $disp->disp_espid, $disp->disp_pesid) ?>
						<?php
						$total_cc = 0;
						foreach ($p_cc as $k => $v):
							$total = $WEEKS - round(($v->vacas + $v->permisos + $v->congreso) / 5);

							$tot_anual = $total * $v->disponibles;
							$total_cc += $tot_anual;
						endforeach;
						?>

						<div class="form-group col-sm-2 has-success" id="gtotalesp">
							<label class="control-label" for="itotalesp">Total Programado Esp.</label>
							<div class="input-group">
								<span class="input-group-addon">D</span>
								<input type="text" class="form-control input-number" id="iNtotalesp" name="itotalesp" value="<?php echo number_format(round($total_cc), 0, '', '.') ?>" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontotalesp"></i>
						</div>

						<?php $br_cc = $total_cc - $diag->dia_total_esp + $diag->dia_lista ?>

						<div class="form-group col-sm-3 col-sm-offset-1<?php echo ($br_cc >= 0) ? ' has-success' : ' has_error' ?>" id="gbrecha">
							<label class="control-label" for="ibrecha">Brecha Calculada C+C</label>
							<div class="input-group">
								<span class="input-group-addon">D - (A + B)</span>
								<input type="text" class="form-control input-number" id="iNbrecha" name="ibrecha" value="<?php echo number_format(round($br_cc), 0, '', '.') ?>" disabled>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-2" id="gtiq">
							<label class="control-label" for="itiq">Total Interv. Quir.</label>
							<div class="input-group">
								<span class="input-group-addon">A</span>
								<input type="text" class="form-control input-number" id="iNtiq" name="itiq" value="<?php echo number_format($diag->dia_total_esp_iq, 0, '', '.') ?>" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontiq"></i>
						</div>

						<div class="form-group col-sm-2" id="ggesiq">
							<label class="control-label" for="igesiq">Total Lista de Espera</label>
							<div class="input-group">
								<span class="input-group-addon">B</span>
								<input type="text" class="form-control input-number" id="iNgesiq" name="igesiq" value="<?php echo number_format($diag->dia_lista_iq, 0, '', '.') ?>" disabled>
							</div>
							<i class="fa form-control-feedback" id="icongesiq"></i>
						</div>

						<div class="form-group col-sm-2 has-success" id="gtotalaniq">
							<label class="control-label" for="itotalaniq">Total Anual</label>
							<div class="input-group">
								<span class="input-group-addon">A + B</span>
								<input type="text" class="form-control input-number" id="iNtotalaniq" name="itotalaniq" value="<?php echo number_format($diag->dia_total_esp_iq + $diag->dia_lista_iq, 0, '', '.') ?>" disabled>
							</div>
						</div>

						<?php $p_iq = $di->getProgrammedIQ($_SESSION['prm_estid'], $disp->disp_espid, $disp->disp_pesid) ?>
						<?php
						$total_iq = 0;
						foreach ($p_iq as $k => $v):
							$total = $WEEKS - round(($v->vacas + $v->permisos + $v->congreso) / 5);

							$tot_anual = $total * $v->disponibles;
							$total_iq += $tot_anual;
						endforeach;
						?>

						<div class="form-group col-sm-2 has-success" id="gtotalespiq">
							<label class="control-label" for="itotalespiq">Total Programado Esp.</label>
							<div class="input-group">
								<span class="input-group-addon">D</span>
								<input type="text" class="form-control input-number" id="iNtotalespiq" name="itotalespiq" value="<?php echo number_format(round($total_iq), 0, '', '.') ?>" disabled>
							</div>
						</div>

						<?php $br_iq = $total_iq - $diag->dia_total_esp_iq + $diag->dia_lista_iq ?>

						<div class="form-group col-sm-3 col-sm-offset-1<?php echo ($br_iq >= 0) ? ' has-success' : ' has_error' ?>" id="gbrechaiq">
							<label class="control-label" for="ibrechaiq">Brecha Calculada IQ</label>
							<div class="input-group">
								<span class="input-group-addon">D - (A + B)</span>
								<input type="text" class="form-control input-number" id="iNbrechaiq" name="ibrechaiq" value="<?php echo number_format(round($br_iq), 0, '', '.') ?>" disabled>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-2 has-warning" id="gtatc">
							<label class="control-label" for="itiq">Total Horas At. Cerrada</label>
							<div class="input-group">
								<span class="input-group-addon">A</span>
								<input type="text" class="form-control input-number" id="iNtatc" name="itatc" value="<?php echo number_format($diag->dia_disp_atc, 0, '', '.') ?>" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontatc"></i>
						</div>

						<div class="form-group col-sm-2 has-warning" id="gtata">
							<label class="control-label" for="itata">Total Horas At. Abierta</label>
							<div class="input-group">
								<span class="input-group-addon">B</span>
								<input type="text" class="form-control input-number" id="iNtata" name="itata" value="<?php echo number_format($diag->dia_disp_ata, 0, '', '.') ?>" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontata"></i>
						</div>

						<div class="form-group col-sm-2 has-warning" id="gtpro">
							<label class="control-label" for="itpro">Total Horas Proced.</label>
							<div class="input-group">
								<span class="input-group-addon">C</span>
								<input type="text" class="form-control input-number" id="iNtpro" name="itpro" value="<?php echo number_format($diag->dia_disp_pro, 0, '', '.') ?>" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontpro"></i>
						</div>

						<?php $p_hrs = $di->getProgrammedEsp($_SESSION['prm_estid'], $disp->disp_espid, $disp->disp_pesid); ?>
						<?php
						$total_disp = 0;
						foreach ($p_hrs as $k => $v):
							$total = $WEEKS - round(($v->vacas + $v->permisos + $v->congreso) / 5);

							$tot_anual = $total * $v->disponibles;
							$total_disp += $tot_anual;
						endforeach;
						?>

						<div class="form-group col-sm-2 has-success" id="gthpro">
							<label class="control-label" for="ithpro">Total Horas Programadas Esp.</label>
							<div class="input-group">
								<span class="input-group-addon">D</span>
								<input type="text" class="form-control input-number" id="iNthpro" name="ithpro" value="<?php echo number_format(round($total_disp), 0, '', '.') ?>" disabled>
							</div>
						</div>

						<?php $br_esp = $diag->dia_disp_atc + $diag->dia_disp_ata + $diag->dia_disp_pro - $total_disp ?>

						<div class="form-group col-sm-3 col-sm-offset-1<?php echo ($br_esp <= 0) ? ' has-success' : ' has_error' ?>" id="gthesp">
							<label class="control-label" for="ithesp">Total Horas Esp. Disponibles</label>
							<div class="input-group">
								<span class="input-group-addon">A + B + C - D</span>
								<input type="text" class="form-control input-number" id="iNthesp" name="ithesp" value="<?php echo number_format(round($br_esp), 0, '', '.') ?>" disabled>
							</div>
						</div>
					</div>
				</div>
			<?php endif ?>
			<div class="box-header with-border">
				<h3 class="box-title">Justificaciones</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gjustif">
						<label class="control-label" for="ijustif">Justificación para programación nula</label>
						<select class="form-control" id="iNjustif" name="ijustif">
							<option value="">Seleccione una justificación</option>
							<?php $jus = $js->getAll() ?>
							<?php foreach ($jus as $j): ?>
								<option value="<?php echo $j->jus_id ?>" <?php if ($j->jus_id == $disp->disp_jusid): ?>selected<?php endif ?>><?php echo $j->jus_descripcion ?></option>
							<?php endforeach ?>
						</select>
						<span id="helpBlock" class="help-block">Obligatoria sólo en el caso de programar una distribución con cero horas disponibles.</span>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Horas Semanales</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-3">
						<label class="control-label" for="disp">Horas Contrato</label>
						<input type="text" class="form-control input-number" value="<?php echo number_format($pes->pes_horas, 2, '.', '') ?>" disabled>
					</div>
				</div>

				<div class="row">
					<?php $h_sem = 0 ?>
					<?php $dh_d = $dh->getByDistTH($disp->disp_id, 1) ?>
					<?php $h_disp = $dh_d->dhp_cantidad ?>
					<?php $h_sem += $dh_d->dhp_cantidad ?>
					<div class="form-group col-sm-3 has-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' has-success' : '' ?>" id="gdisp">
						<label class="control-label" for="disp">Horas Disponibles *</label>
						<input type="text" class="form-control input-number disponib" id="iNdisp" name="disp" value="<?php echo number_format($dh_d->dhp_cantidad, 2, '.', '') ?>" required>
						<i class="fa form-control-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' fa-check' : '' ?>" id="icondisp"></i>
					</div>

					<?php $dh_d = $dh->getByDistTH($disp->disp_id, 2) ?>
					<?php $h_sem += $dh_d->dhp_cantidad ?>
					<div class="form-group col-sm-3 has-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' has-success' : '' ?>" id="guniversidad">
						<label class="control-label" for="universidad">Médico Universidad</label>
						<input type="text" class="form-control input-number disponib" id="iNuniversidad" name="universidad" value="<?php echo $dh_d->dhp_cantidad ?>">
						<i class="fa form-control-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' fa-check' : '' ?>" id="iconuniversidad"></i>
					</div>

					<?php $dh_d = $dh->getByDistTH($disp->disp_id, 3) ?>
					<?php $h_sem += $dh_d->dhp_cantidad ?>
					<div class="form-group col-sm-3 has-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' has-success' : '' ?>" id="gbecados">
						<label class="control-label" for="becados">Becados</label>
						<input type="text" class="form-control input-number disponib" id="iNbecados" name="becados" value="<?php echo $dh_d->dhp_cantidad ?>">
						<i class="fa form-control-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' fa-check' : '' ?>" id="iconbecados"></i>
					</div>

					<div class="form-group col-sm-3<?php echo ($h_sem > 0) ? ' has-success' : '' ?>" id="gtdisponible">
						<label class="control-label" for="disponible">Horas Semanales Disp.</label>
						<input type="text" class="form-control input-number" tabindex="-1" id="iNtdisponible" name="tdisponible" value="<?php echo number_format($h_sem, 2, '.', '') ?>" disabled>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Actividades Policlínico</h3>
			</div>

			<div class="box-body">
				<?php $total_horas = 0; ?>
				<?php $total_horas_poli = 0; ?>
				<?php $total_act_poli = 0; ?>
				<?php $total_anual = 0; ?>

				<!-- Consultas, Controles, Consultas abreviadas -->
				<?php $t_p = $ta_p = $ts_p = 0 ?>
				<?php $arr = array(4, 5, 21) ?>
				<?php foreach ($arr as $i): ?>
					<?php $a = $acp->get($i) ?>

					<?php $dh_d = $dh->getByDistTH($disp->disp_id, $i) ?>
					<?php $total_horas += $dh_d->dhp_cantidad ?>
					<?php $total_horas_poli += $dh_d->dhp_cantidad ?>
					<div class="row">
						<div class="form-group col-sm-3 has-feedback<?php if ($dh_d->dhp_cantidad > 0): ?> has-success<?php endif ?>" id="gact<?php echo $a->acp_id ?>">
							<label class="control-label" for="iacp<?php echo $a->acp_id ?>"><?php echo $a->acp_descripcion ?></label>
							<input type="text" class="form-control input-number ind tpoli" id="iNact<?php echo $a->acp_id ?>" name="iact<?php echo $a->acp_id ?>" value="<?php echo number_format($dh_d->dhp_cantidad, 2, '.', '') ?>">
							<i class="fa form-control-feedback<?php if ($dh_d->dhp_cantidad > 0): ?> fa-check<?php endif ?>" id="iconact<?php echo $a->acp_id ?>"></i>
						</div>

						<?php $div_horas = ($h_disp == 0) ? 0 : $dh_d->dhp_cantidad / $h_disp ?>
						<?php $percent = number_format($div_horas, 2, '.', ',') ?>
						<div class="form-group col-sm-2 has-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="gpact<?php echo $a->acp_id ?>">
							<label class="control-label" for="pact<?php echo $a->acp_id ?>">% Asignado</label>
							<input type="text" class="form-control input-number" id="iNpact<?php echo $a->acp_id ?>" tabindex="-1" name="pact<?php echo $a->acp_id ?>" value="<?php echo number_format($percent, 2, '.', '') ?>" disabled>
							<i class="fa form-control-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="iconpact<?php echo $a->acp_id ?>"></i>
						</div>

						<div class="form-group col-sm-2 has-feedback<?php if ($dh_d->dhp_rendimiento > 0): ?> has-success<?php endif ?>" id="gract<?php echo $a->acp_id ?>">
							<label class="control-label" for="ract<?php echo $a->acp_id ?>">Rendimiento</label>
							<input type="text" class="form-control input-number rend" id="iNract<?php echo $a->acp_id ?>" name="ract<?php echo $a->acp_id ?>" value="<?php echo $dh_d->dhp_rendimiento ?>">
							<i class="fa form-control-feedback<?php if ($dh_d->dhp_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconract<?php echo $a->acp_id ?>"></i>
						</div>

						<?php $t = $dh_d->dhp_cantidad * $dh_d->dhp_rendimiento ?>
						<?php $total_act_poli += $t ?>
						<div class="form-group col-sm-2 col-sm-offset-1<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtact<?php echo $a->acp_id ?>">
							<label class="control-label" for="tact<?php echo $a->acp_id ?>">Total</label>
							<input type="text" class="form-control input-number tactp" tabindex="-1" id="iNtact<?php echo $a->acp_id ?>" name="tact<?php echo $a->acp_id ?>" value="<?php echo number_format($t, 2, '.', ',') ?>" disabled>
						</div>

						<?php $tot_anual = $t * $sem_disp ?>
						<?php $total_anual += $tot_anual ?>
						<?php //$total_act_brecha = $total_anual ?>
						<div class="form-group col-sm-2<?php if ($tot_anual > 0): ?> has-success<?php endif ?>" id="gtaact<?php echo $a->acp_id ?>">
							<label class="control-label" for="taact<?php echo $a->acp_id ?>">Total Anual</label>
							<input type="text" class="form-control input-number tanual" tabindex="-1" id="iNtaact<?php echo $a->acp_id ?>" name="taact<?php echo $a->acp_id ?>" value="<?php echo number_format($tot_anual, 2, '.', ',') ?>" disabled>
						</div>
					</div>
				<?php endforeach ?>

				<!-- TOTAL POLICLINICO -->
				<div class="row">
					<div class="form-group col-sm-3<?php echo ($total_horas_poli > 0) ? ' has-success' : '' ?>" id="gtpoli">
						<label class="control-label" for="tpoli">Total Policlínico</label>
						<input type="text" class="form-control input-number" id="iNtpoli" tabindex="-1" name="tpoli" value="<?php echo number_format($total_horas_poli, 2, '.', '') ?>" disabled>
					</div>

					<div class="form-group col-sm-2 col-sm-offset-5<?php echo ($total_act_poli > 0) ? ' has-success' : '' ?>" id="gtapoli">
						<label class="control-label" for="tapoli">Total</label>
						<input type="text" class="form-control input-number" id="iNtapoli" tabindex="-1" name="tapoli" value="<?php echo number_format($total_act_poli, 2, '.', '') ?>" disabled>
					</div>

					<div class="form-group col-sm-2<?php echo ($total_anual > 0) ? ' has-success' : '' ?>" id="gtaapoli">
						<label class="control-label" for="taapoli">Total Anual</label>
						<input type="text" class="form-control input-number" tabindex="-1" id="iNtaapoli" name="taapoli" value="<?php echo number_format(round($total_anual), 0, '', '.') ?>" disabled>
					</div>
				</div>
			</div>

			<div id="activ-med">
				<?php if ($per->per_prid == 4 or $per->per_prid == 14 or $per->per_prid == 16): ?>
					<div class="box-header with-border">
						<h3 class="box-title">Otras actividades</h3>
					</div>

					<div class="box-body">
						<?php for ($i = 6; $i < 21; $i++): ?>
							<?php $a = $acp->get($i) ?>

							<?php $dh_d = $dh->getByDistTH($disp->disp_id, $i) ?>
							<?php $total_horas += $dh_d->dhp_cantidad ?>
							<div class="row">
								<div class="form-group col-sm-3 has-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' has-success' : '' ?>" id="gact<?php echo $a->acp_id ?>">
									<label class="control-label" for="iacp<?php echo $a->acp_id ?>"><?php echo $a->acp_descripcion ?></label>
									<input type="text" class="form-control input-number ind ind-proc" id="iNact<?php echo $a->acp_id ?>" name="iact<?php echo $a->acp_id ?>" value="<?php echo $dh_d->dhp_cantidad ?>">
									<i class="fa form-control-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' fa-check' : '' ?>" id="iconact<?php echo $a->acp_id ?>"></i>
								</div>

								<?php $div_horas = ($h_disp == 0) ? 0 : $dh_d->dhp_cantidad / $h_disp ?>
								<?php $percent = number_format($div_horas, 2, '.', ',') ?>
								<div class="form-group col-sm-2 has-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="gpact<?php echo $a->acp_id ?>">
									<label class="control-label" for="pact<?php echo $a->acp_id ?>">% Asignado</label>
									<input type="text" class="form-control input-number" id="iNpact<?php echo $a->acp_id ?>" tabindex="-1" name="pact<?php echo $a->acp_id ?>" value="<?php echo $percent ?>" disabled>
									<i class="fa form-control-feedback<?php echo ($percent > 0) ? ' fa-check' : '' ?>" id="iconpact<?php echo $a->acp_id ?>"></i>
								</div>

								<?php if ($a->acp_rendimiento): ?>
									<div class="form-group col-sm-2 has-feedback<?php echo ($dh_d->dhp_rendimiento > 0) ? ' has-success' : '' ?>" id="gract<?php echo $a->acp_id ?>">
										<label class="control-label" for="ract<?php echo $a->acp_id ?>">Rendimiento</label>
										<input type="text" class="form-control input-number rend" id="iNract<?php echo $a->acp_id ?>" name="ract<?php echo $a->acp_id ?>" value="<?php echo $dh_d->dhp_rendimiento ?>">
										<i class="fa form-control-feedback<?php echo ($dh_d->dhp_rendimiento > 0) ? ' fa-check' : '' ?>" id="iconract<?php echo $a->acp_id ?>"></i>
									</div>

									<?php $t = $dh_d->dhp_cantidad * $dh_d->dhp_rendimiento ?>
									<div class="form-group col-sm-2 col-sm-offset-1<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtact<?php echo $a->acp_id ?>">
										<label class="control-label" for="tact<?php echo $a->acp_id ?>">Total</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtact<?php echo $a->acp_id ?>" name="tact<?php echo $a->acp_id ?>" value="<?php echo number_format($t, 2, '.', ',') ?>" disabled>
									</div>

									<?php $ts = $t * $sem_disp ?>
									<div class="form-group col-sm-2<?php if ($ts > 0): ?> has-success<?php endif ?>" id="gtaact<?php echo $a->acp_id ?>">
										<label class="control-label" for="taact<?php echo $a->acp_id ?>">Total Anual</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtaact<?php echo $a->acp_id ?>" name="taact<?php echo $a->acp_id ?>" value="<?php echo number_format($ts, 2, '.', ',') ?>" disabled>
									</div>
								<?php endif ?>
							</div>
						<?php endfor ?>

						<?php for ($i = 22; $i < 55; $i++): ?>
							<?php $a = $acp->get($i) ?>

							<?php $dh_d = $dh->getByDistTH($disp->disp_id, $i) ?>
							<?php $total_horas += $dh_d->dhp_cantidad ?>
							<div class="row">
								<div class="form-group col-sm-3 has-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' has-success' : '' ?>" id="gact<?php echo $a->acp_id ?>">
									<label class="control-label" for="iacp<?php echo $a->acp_id ?>"><?php echo $a->acp_descripcion ?></label>
									<input type="text" class="form-control input-number ind ind-proc" id="iNact<?php echo $a->acp_id ?>" name="iact<?php echo $a->acp_id ?>" value="<?php echo $dh_d->dhp_cantidad ?>">
									<i class="fa form-control-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' fa-check' : '' ?>" id="iconact<?php echo $a->acp_id ?>"></i>
								</div>

								<?php $div_horas = ($h_disp == 0) ? 0 : $dh_d->dhp_cantidad / $h_disp ?>
								<?php $percent = number_format($div_horas, 2, '.', ',') ?>
								<div class="form-group col-sm-2 has-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="gpact<?php echo $a->acp_id ?>">
									<label class="control-label" for="pact<?php echo $a->acp_id ?>">% Asignado</label>
									<input type="text" class="form-control input-number" id="iNpact<?php echo $a->acp_id ?>" tabindex="-1" name="pact<?php echo $a->acp_id ?>" value="<?php echo $percent ?>" disabled>
									<i class="fa form-control-feedback<?php echo ($percent > 0) ? ' fa-check' : '' ?>" id="iconpact<?php echo $a->acp_id ?>"></i>
								</div>

								<?php if ($a->acp_rendimiento): ?>
									<div class="form-group col-sm-2 has-feedback<?php echo ($dh_d->dhp_rendimiento > 0) ? ' has-success' : '' ?>" id="gract<?php echo $a->acp_id ?>">
										<label class="control-label" for="ract<?php echo $a->acp_id ?>">Rendimiento</label>
										<input type="text" class="form-control input-number rend" id="iNract<?php echo $a->acp_id ?>" name="ract<?php echo $a->acp_id ?>" value="<?php echo $dh_d->dhp_rendimiento ?>">
										<i class="fa form-control-feedback<?php echo ($dh_d->dhp_rendimiento > 0) ? ' fa-check' : '' ?>" id="iconract<?php echo $a->acp_id ?>"></i>
									</div>

									<?php $t = $dh_d->dhp_cantidad * $dh_d->dhp_rendimiento ?>
									<div class="form-group col-sm-2 col-sm-offset-1<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtact<?php echo $a->acp_id ?>">
										<label class="control-label" for="tact<?php echo $a->acp_id ?>">Total</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtact<?php echo $a->acp_id ?>" name="tact<?php echo $a->acp_id ?>" value="<?php echo number_format($t, 2, '.', ',') ?>" disabled>
									</div>

									<?php $ts = $t * $sem_disp ?>
									<div class="form-group col-sm-2<?php if ($ts > 0): ?> has-success<?php endif ?>" id="gtaact<?php echo $a->acp_id ?>">
										<label class="control-label" for="taact<?php echo $a->acp_id ?>">Total Anual</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtaact<?php echo $a->acp_id ?>" name="taact<?php echo $a->acp_id ?>" value="<?php echo number_format($ts, 2, '.', ',') ?>" disabled>
									</div>
								<?php endif ?>
							</div>
						<?php endfor ?>
					</div>
				<?php endif ?>

				<?php if ($per->per_prid != 4 and $per->per_prid != 14 and $per->per_prid != 16): ?>
					<div class="box-header with-border">
						<h3 class="box-title">Actividades No Médicos</h3>
					</div>

					<div class="box-body">
						<?php for ($i = 55; $i < 128; $i++): ?>
							<?php $a = $acp->get($i) ?>

							<?php $dh_d = $dh->getByDistTH($disp->disp_id, $i) ?>
							<?php $total_horas += $dh_d->dhp_cantidad ?>
							<div class="row">
								<div class="form-group col-sm-3 has-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' has-success' : '' ?>" id="gact<?php echo $a->acp_id ?>">
									<label class="control-label" for="iacp<?php echo $a->acp_id ?>"><?php echo $a->acp_descripcion ?></label>
									<input type="text" class="form-control input-number ind ind-proc" id="iNact<?php echo $a->acp_id ?>" name="iact<?php echo $a->acp_id ?>" value="<?php echo $dh_d->dhp_cantidad ?>">
									<i class="fa form-control-feedback<?php echo ($dh_d->dhp_cantidad > 0) ? ' fa-check' : '' ?>" id="iconact<?php echo $a->acp_id ?>"></i>
								</div>

								<?php $div_horas = ($h_disp == 0) ? 0 : $dh_d->dhp_cantidad / $h_disp ?>
								<?php $percent = number_format($div_horas, 2, '.', ',') ?>
								<div class="form-group col-sm-2 has-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="gpact<?php echo $a->acp_id ?>">
									<label class="control-label" for="pact<?php echo $a->acp_id ?>">% Asignado</label>
									<input type="text" class="form-control input-number" id="iNpact<?php echo $a->acp_id ?>" tabindex="-1" name="pact<?php echo $a->acp_id ?>" value="<?php echo $percent ?>" disabled>
									<i class="fa form-control-feedback<?php echo ($percent > 0) ? ' fa-check' : '' ?>" id="iconpact<?php echo $a->acp_id ?>"></i>
								</div>

								<?php if ($a->acp_rendimiento): ?>
									<div class="form-group col-sm-2 has-feedback<?php echo ($dh_d->dhp_rendimiento > 0) ? ' has-success' : '' ?>" id="gract<?php echo $a->acp_id ?>">
										<label class="control-label" for="ract<?php echo $a->acp_id ?>">Rendimiento</label>
										<input type="text" class="form-control input-number rend" id="iNract<?php echo $a->acp_id ?>" name="ract<?php echo $a->acp_id ?>" value="<?php echo $dh_d->dhp_rendimiento ?>">
										<i class="fa form-control-feedback<?php echo ($dh_d->dhp_rendimiento > 0) ? ' fa-check' : '' ?>" id="iconract<?php echo $a->acp_id ?>"></i>
									</div>

									<?php $t = $dh_d->dhp_cantidad * $dh_d->dhp_rendimiento ?>
									<div class="form-group col-sm-2 col-sm-offset-1<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtact<?php echo $a->acp_id ?>">
										<label class="control-label" for="tact<?php echo $a->acp_id ?>">Total</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtact<?php echo $a->acp_id ?>" name="tact<?php echo $a->acp_id ?>" value="<?php echo number_format($t, 2, '.', ',') ?>" disabled>
									</div>

									<?php $ts = $t * $sem_disp ?>
									<div class="form-group col-sm-2<?php if ($ts > 0): ?> has-success<?php endif ?>" id="gtaact<?php echo $a->acp_id ?>">
										<label class="control-label" for="taact<?php echo $a->acp_id ?>">Total Anual</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtaact<?php echo $a->acp_id ?>" name="taact<?php echo $a->acp_id ?>" value="<?php echo number_format($ts, 2, '.', ',') ?>" disabled>
									</div>
								<?php endif ?>
							</div>
						<?php endfor ?>
					</div>
				<?php endif ?>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Totales</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-3<?php echo ($total_horas > 0) ? ' has-success' : '' ?>" id="gtotal">
						<label class="control-label" for="total">Total</label>
						<input type="text" class="form-control input-number" tabindex="-1" id="iNtotal" name="total" value="<?php echo number_format($total_horas, 2, '.', '') ?>" readonly>
					</div>
					<?php if ($per->per_prid == 4 or $per->per_prid == 14 or $per->per_prid == 16): ?>
						<div class="form-group col-sm-2 col-sm-offset-3<?php echo ($br_cc >= 0) ? ' has-success' : ' has_error' ?>" id="gbrecha">
							<label class="control-label" for="ibrecha">Brecha Calculada C+C</label>
							<input type="text" class="form-control input-number" id="iNbrecha2" name="ibrecha2" value="<?php echo number_format(round($br_cc), 0, '', '.') ?>" disabled>
						</div>
						<?php $total_act_brecha = 0 ?>
						<div class="form-group col-sm-2" id="gactanuales">
							<label class="control-label" for="iactanuales">Actividades Anuales</label>
							<input type="text" class="form-control input-number" id="iNactanuales" name="iactanuales" value="<?php echo number_format(round($total_act_brecha), 0, '', '.') ?>" disabled>
						</div>

						<?php $br_pro = $br_cc + $total_act_brecha ?>

						<div class="form-group col-sm-2<?php echo ($br_pro >= 0) ? ' has-success' : ' has-error' ?>" id="gbrproy">
							<label class="control-label" for="ibrproy">Brecha Proyectada C+C</label>
							<input type="text" class="form-control input-number" id="iNbrproy" name="ibrproy" value="<?php echo number_format(round($br_pro), 0, '', '.') ?>" disabled>
						</div>
					<?php endif ?>
				</div>
				<?php if ($per->per_prid == 4 or $per->per_prid == 14 or $per->per_prid == 16): ?>
					<div class="row">
						<div class="form-group col-sm-2 col-sm-offset-6<?php echo ($br_iq >= 0) ? ' has-success' : ' has_error' ?>" id="gbrechaiq2">
							<label class="control-label" for="ibrechaiq2">Brecha Calculada IQ</label>
							<input type="text" class="form-control input-number" id="iNbrechaiq2" name="ibrechaiq2" value="<?php echo number_format(round($br_iq), 0, '', '.') ?>" disabled>
						</div>

						<?php $total_act_brecha_iq = 0 ?>

						<div class="form-group col-sm-2" id="gactanualesiq">
							<label class="control-label" for="iactanualesiq">Actividades Anuales</label>
							<input type="text" class="form-control input-number" id="iNactanualesiq" name="iactanualesiq" value="<?php echo number_format(round($total_act_brecha_iq), 0, '', '.') ?>" disabled>
						</div>

						<?php $br_pro_iq = $br_iq + $total_act_brecha_iq ?>

						<div class="form-group col-sm-2<?php echo ($br_pro_iq >= 0) ? ' has-success' : ' has-error' ?>" id="gbrproyiq">
							<label class="control-label" for="ibrproyiq">Brecha Proyectada IQ</label>
							<input type="text" class="form-control input-number" id="iNbrproyiq" name="ibrproyiq" value="<?php echo number_format(round($br_pro_iq), 0, '', '.') ?>" disabled>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-2 col-sm-offset-6<?php echo ($br_esp < 0) ? ' has-success' : ' has-error' ?>" id="gthesp2">
							<label class="control-label" for="ithesp2">Horas Disp. Especialidad</label>
							<input type="text" class="form-control input-number" id="iNthesp2" name="ithesp2" value="<?php echo number_format(round($br_esp), 0, '', '.') ?>" disabled>
						</div>

						<div class="form-group col-sm-2" id="gthanual">
							<label class="control-label" for="ithanual">Horas Anuales</label>
							<input type="text" class="form-control input-number" id="iNthanual" name="ithanual" value="0" disabled>
						</div>

						<div class="form-group col-sm-2" id="gtotproy">
							<label class="control-label" for="itotproy">Horas Disp. Proyectadas</label>
							<input type="text" class="form-control input-number" id="iNtotproy" name="itotproy" value="0" disabled>
						</div>
					</div>
				<?php endif ?>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar datos</button>
				<button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
				<span class="ajaxLoader" id="submitLoader"></span>
			</div>
		</div>
	</form>
</section>

<script src="program/edit-program.js"></script>