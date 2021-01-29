<?php include("class/classParametro.php") ?>
<?php include("class/classPersona.php") ?>
<?php include("class/classPersonaEstablecimiento.php") ?>
<?php include("class/classCr.php") ?>
<?php include("class/classServicio.php") ?>
<?php include("class/classEspecialidad.php") ?>
<?php include("class/classDistribucionProg.php") ?>
<?php include("class/classDistHorasProg.php") ?>
<?php include("class/classJustificacion.php") ?>
<?php include("class/classActividadProgramable.php") ?>

<?php $para = new Parametro() ?>
<?php $p = new Persona() ?>
<?php $pe = new PersonaEstablecimiento() ?>
<?php $cr = new Cr() ?>
<?php $se = new Servicio() ?>
<?php $es = new Especialidad() ?>
<?php $di = new DistribucionProg() ?>
<?php $dh = new DistHorasProg() ?>
<?php $js = new Justificacion() ?>
<?php $acp = new ActividadProgramable() ?>
<?php $t_date = explode('-', $date_ini) ?>
<?php $t_par = $para->get($t_date[0]) ?>
<?php $WEEKS = $t_par->par_semanas ?>
<?php $perest = $pe->get($id) ?>
<?php $per = $p->get($perest->per_id) ?>
<?php $prev = date('Y-m-d', strtotime('-3 month', strtotime($date_ini))); ?>
<?php $dis = $di->getByPerDate($id, $prev, $date_ter) ?>
<?php $cre = $cr->getByService($dis->disp_serid) ?>

<section class="content-header">
	<h1>Programación Anual
		<small><i class="fa fa-angle-right"></i> Ingreso de Programación</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="index.php?section=program&sbs=listpeople">Personas Registradas</a></li>
		<li class="active">Ingreso de Programación</li>
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
						<p class="form-control-static"><?php echo $perest->con_descripcion ?> (<?php echo $perest->pes_correlativo ?>)</p>
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
					<div class="form-group col-sm-6 has-feedback has-success" id="gdate">
						<label class="control-label" for="idate">Período de Programación *</label>
						<div class="input-group input-daterange">
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="mm/yyyy" placeholder="MM/YYYY" value="<?php echo getDateMonthToForm($date_ini) ?>" required>
							<span class="input-group-addon">hasta</span>
							<input type="text" class="form-control" id="iNdate_t" name="idate_t" data-date-format="mm/yyyy" placeholder="MM/YYYY" value="<?php echo getDateMonthToForm($date_ter) ?>" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback<?php if ($dis->disp_descripcion !== ''): ?> has-success<?php endif ?>" id="gdesc">
						<label class="control-label" for="idesc">Descripción *</label>
						<input type="text" class="form-control" id="iNdesc" name="idesc" placeholder="Ingrese descripción para la programación" maxlength="64" value="<?php echo $dis->disp_descripcion ?>" required>
						<i class="fa form-control-feedback<?php if ($dis->disp_descripcion !== ''): ?> fa-check<?php endif ?>" id="icondesc"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback<?php if ($dis->disp_serid !== null): ?> has-success<?php endif ?>" id="gcr">
						<label class="control-label" for="icr">Centro de Responsabilidad *</label>
						<select class="form-control" id="iNcr" name="icr" required>
							<option value="">Seleccione CR</option>
							<?php $cen = $cr->getAll() ?>
							<?php foreach ($cen as $c): ?>
								<option value="<?php echo $c->cr_id ?>"<?php if ($c->cr_id == $cre->cr_id): ?> selected<?php endif ?>><?php echo $c->cr_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-6 has-feedback<?php if ($dis->disp_serid !== null): ?> has-success<?php endif ?>" id="gserv">
						<label class="control-label" for="iserv">Servicio *</label>
						<select class="form-control" id="iNserv" name="iserv" required>
							<option value="">Seleccione servicio</option>
							<?php if ($dis->disp_serid !== ''): ?>
								<?php $ser = $se->getByCR($cre->cr_id) ?>
								<?php foreach ($ser as $s): ?>
									<option value="<?php echo $s->ser_id ?>"<?php if ($s->ser_id == $dis->disp_serid): ?> selected<?php endif ?>><?php echo $s->ser_nombre ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gesp">
						<label class="control-label" for="iesp">Especialidad *</label>
						<select class="form-control" id="iNesp" name="iesp" required>
							<option value="">Seleccione especialidad</option>
							<?php if ($dis->disp_espid !== ''): ?>
								<?php $esp = $es->getByServicio($dis->disp_serid) ?>
								<?php foreach ($esp as $e): ?>
									<option value="<?php echo $e->esp_id ?>"><?php echo $e->esp_nombre ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6">
						<p>
							<label class="label-checkbox">
								<input type="checkbox" class="minimal" name="igeneral"> Médico General
							</label>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback<?php if ($dis->disp_observaciones !== ''): ?> has-success<?php endif ?>" id="gobserv">
						<label class="control-label" for="iobserv">Observaciones</label>
						<input type="text" class="form-control" id="iNobserv" name="iobserv" placeholder="Ingrese observación (Liberado de guardia / PAO)" maxlength="64" value="<?php echo $dis->disp_observaciones ?>">
						<i class="fa form-control-feedback<?php if ($dis->disp_observaciones !== ''): ?> fa-check<?php endif ?>" id="iconobserv"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-2 has-feedback<?php if ($dis->disp_vacaciones > 0): ?> has-success<?php endif ?>" id="gvacaciones">
						<label class="control-label" for="ivacaciones">Vacaciones *</label>
						<input type="text" class="form-control input-number disp" id="iNvacaciones" name="ivacaciones" placeholder="Ingrese días de vacaciones" value="<?php echo $dis->disp_vacaciones ?>" required>
						<i class="fa form-control-feedback<?php if ($dis->disp_vacaciones > 0): ?> fa-check<?php endif ?>" id="iconvacaciones"></i>
					</div>

					<div class="form-group col-sm-2 has-feedback<?php if ($dis->disp_permisos > 0): ?> has-success<?php endif ?>" id="gpermiso">
						<label class="control-label" for="ipermiso">Permisos *</label>
						<input type="text" class="form-control input-number disp" id="iNpermiso" name="ipermiso" placeholder="Ingrese días de permiso" value="<?php echo $dis->disp_permisos ?>" required>
						<i class="fa form-control-feedback<?php if ($dis->disp_permisos > 0): ?> fa-check<?php endif ?>" id="iconpermiso"></i>
					</div>

					<div class="form-group col-sm-2 has-feedback<?php if ($dis->disp_congreso > 0): ?> has-success<?php endif ?>" id="gcongreso">
						<label class="control-label" for="icongreso">Congreso *</label>
						<input type="text" class="form-control input-number disp" id="iNcongreso" name="icongreso" placeholder="Ingrese días de congresos" value="<?php echo $dis->disp_congreso ?>" required>
						<i class="fa form-control-feedback<?php if ($dis->disp_congreso > 0): ?> fa-check<?php endif ?>" id="iconcongreso"></i>
					</div>

					<div class="form-group col-sm-2 has-feedback<?php if ($dis->disp_congreso > 0): ?> has-success<?php endif ?>" id="gdescanso">
						<label class="control-label" for="idescanso">Descanso comp. *</label>
						<input type="text" class="form-control input-number disp" id="iNdescanso" name="idescanso" placeholder="Ingrese días de descanso" value="<?php echo $dis->disp_descanso ?>" required>
						<i class="fa form-control-feedback<?php if ($dis->disp_descanso > 0): ?> fa-check<?php endif ?>" id="icondescanso"></i>
					</div>

					<?php $total_dias = $dis->disp_vacaciones + $dis->disp_permisos + $dis->disp_congreso + $dis->disp_descanso ?>
					<?php $sem_disp = $WEEKS - ($total_dias / 5) ?>

					<div class="form-group col-sm-3 col-sm-offset-1" id="gsemdisp">
						<label class="control-label" for="isemdisp">Semanas disponibles</label>
						<input type="text" class="form-control input-number" id="iNsemdisp" name="isemdisp" value="<?php echo $sem_disp ?>" tabindex="-1" disabled>
					</div>
				</div>
			</div>

			<?php if ($per->per_prid == 4 or $per->per_prid == 14 or $per->per_prid == 16): ?>
				<div class="box-header with-border">
					<h3 class="box-title">Diagnóstico Especialidad</h3>
				</div>

				<div class="box-body">
					<div class="row">
						<div class="form-group col-sm-2" id="gtat">
							<label class="control-label" for="itat">Total Cons. + Cont.</label>
							<div class="input-group">
								<span class="input-group-addon">A</span>
								<input type="text" class="form-control input-number" id="iNtat" name="itat" value="0" disabled>
							</div>
						</div>

						<div class="form-group col-sm-2" id="gges">
							<label class="control-label" for="iges">Total Lista de Espera</label>
							<div class="input-group">
								<span class="input-group-addon">B</span>
								<input type="text" class="form-control input-number" id="iNges" name="iges" value="0" disabled>
							</div>
						</div>

						<div class="form-group col-sm-2 has-success" id="gtotalan">
							<label class="control-label" for="itotalan">Total Anual</label>
							<div class="input-group">
								<span class="input-group-addon">A + B</span>
								<input type="text" class="form-control input-number" id="iNtotalan" name="itotalan" value="0" disabled>
							</div>
						</div>

						<div class="form-group col-sm-2 has-success" id="gtotalesp">
							<label class="control-label" for="itotalesp">Total Programado</label>
							<div class="input-group">
								<span class="input-group-addon">D</span>
								<input type="text" class="form-control input-number" id="iNtotalesp" name="itotalesp" value="0" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontotalesp"></i>
						</div>

						<div class="form-group col-sm-3 col-sm-offset-1" id="gbrecha">
							<label class="control-label" for="ibrecha">Brecha Calculada C+C</label>
							<div class="input-group">
								<span class="input-group-addon">D - (A + B)</span>
								<input type="text" class="form-control input-number" id="iNbrecha" name="ibrecha" value="0" disabled>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-2" id="gtiq">
							<label class="control-label" for="itiq">Total Interv. Quir.</label>
							<div class="input-group">
								<span class="input-group-addon">A</span>
								<input type="text" class="form-control input-number" id="iNtiq" name="itiq" value="0" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontiq"></i>
						</div>

						<div class="form-group col-sm-2" id="ggesiq">
							<label class="control-label" for="igesiq">Total Lista de Espera</label>
							<div class="input-group">
								<span class="input-group-addon">B</span>
								<input type="text" class="form-control input-number" id="iNgesiq" name="igesiq" value="0" disabled>
							</div>
							<i class="fa form-control-feedback" id="icongesiq"></i>
						</div>

						<div class="form-group col-sm-2 has-success" id="gtotalaniq">
							<label class="control-label" for="itotalaniq">Total Anual</label>
							<div class="input-group">
								<span class="input-group-addon">A + B</span>
								<input type="text" class="form-control input-number" id="iNtotalaniq" name="itotalaniq" value="0" disabled>
							</div>
						</div>

						<div class="form-group col-sm-2 has-success" id="gtotalespiq">
							<label class="control-label" for="itotalespiq">Total Programado</label>
							<div class="input-group">
								<span class="input-group-addon">D</span>
								<input type="text" class="form-control input-number" id="iNtotalespiq" name="itotalespiq" value="0" disabled>
							</div>
						</div>

						<div class="form-group col-sm-3 col-sm-offset-1" id="gbrechaiq">
							<label class="control-label" for="ibrechaiq">Brecha Calculada IQ</label>
							<div class="input-group">
								<span class="input-group-addon">D - (A + B)</span>
								<input type="text" class="form-control input-number" id="iNbrechaiq" name="ibrechaiq" value="0" disabled>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-2" id="gtatc">
							<label class="control-label" for="itiq">Total Horas At. Cerrada</label>
							<div class="input-group">
								<span class="input-group-addon">A</span>
								<input type="text" class="form-control input-number" id="iNtatc" name="itatc" value="0" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontatc"></i>
						</div>

						<div class="form-group col-sm-2" id="gtata">
							<label class="control-label" for="itata">Total Horas At. Abierta</label>
							<div class="input-group">
								<span class="input-group-addon">B</span>
								<input type="text" class="form-control input-number" id="iNtata" name="itata" value="0" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontata"></i>
						</div>

						<div class="form-group col-sm-2" id="gtpro">
							<label class="control-label" for="itpro">Total Horas Proced.</label>
							<div class="input-group">
								<span class="input-group-addon">C</span>
								<input type="text" class="form-control input-number" id="iNtpro" name="itpro" value="0" disabled>
							</div>
							<i class="fa form-control-feedback" id="icontpro"></i>
						</div>

						<div class="form-group col-sm-2 has-success" id="gthpro">
							<label class="control-label" for="ithpro">Total Horas Programadas</label>
							<div class="input-group">
								<span class="input-group-addon">D</span>
								<input type="text" class="form-control input-number" id="iNthpro" name="ithpro" value="0" disabled>
							</div>
						</div>

						<div class="form-group col-sm-3 col-sm-offset-1" id="gthesp">
							<label class="control-label" for="ithesp">Total Horas Disponibles</label>
							<div class="input-group">
								<span class="input-group-addon">A + B + C - D</span>
								<input type="text" class="form-control input-number" id="iNthesp" name="ithesp" value="0" disabled>
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
								<option value="<?php echo $j->jus_id ?>"><?php echo $j->jus_descripcion ?></option>
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
						<input type="text" class="form-control input-number" value="<?php echo number_format($perest->pes_horas, 2, '.', '') ?>" disabled>
					</div>
				</div>

				<div class="row">
					<?php $h_sem = 0 ?>
					<?php $d = $dh->getByPerTHDate($id, 1, $prev) ?>
					<?php $h_disponibles = $d->dh_cantidad ?>
					<?php $h_sem += $d->dh_cantidad ?>
					<div class="form-group col-sm-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gdisp">
						<label class="control-label" for="disp">Horas Disponibles *</label>
						<input type="text" class="form-control input-number disponib" id="iNdisp" name="disp" value="<?php echo $d->dh_cantidad ?>" required>
						<i class="fa form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="icondisp"></i>
					</div>

					<?php $d = $dh->getByPerTHDate($id, 2, $prev) ?>
					<?php $h_sem += $d->dh_cantidad ?>
					<div class="form-group col-sm-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="guniversidad">
						<label class="control-label" for="universidad">Médico Universidad</label>
						<input type="text" class="form-control input-number disponib" id="iNuniversidad" name="universidad" value="<?php echo $d->dh_cantidad ?>">
						<i class="fa form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconuniversidad"></i>
					</div>

					<?php $d = $dh->getByPerTHDate($id, 3, $prev) ?>
					<?php $h_sem += $d->dh_cantidad ?>
					<div class="form-group col-sm-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gbecados">
						<label class="control-label" for="becados">Becados</label>
						<input type="text" class="form-control input-number disponib" id="iNbecados" name="becados" value="<?php echo $d->dh_cantidad ?>">
						<i class="fa form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconbecados"></i>
					</div>

					<div class="form-group col-sm-3<?php if ($h_sem > 0): ?> has-success<?php endif ?>" id="gtdisponible">
						<label class="control-label" for="disponible">Horas Semanales Disp.</label>
						<input type="text" class="form-control input-number" tabindex="-1" id="iNtdisponible" name="tdisponible" value="<?php echo number_format($h_sem, 2, '.', ',') ?>" disabled>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Actividades Policlínico</h3>
			</div>

			<div class="box-body">
				<!-- Consultas, Controles, Consultas abreviadas -->
				<?php $t_p = $ta_p = $ts_p = 0 ?>
				<?php $exceptions = array(4, 5, 21) ?>
				<?php foreach ($exceptions as $i): ?>
					<?php $a = $acp->get($i) ?>

					<?php $d = $dh->getByPerTHDate($id, $i, $prev) ?>
					<?php $t_p += $d->dh_cantidad ?>
					<div class="row">
						<div class="form-group col-sm-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gact<?php echo $a->acp_id ?>">
							<label class="control-label" for="iacp<?php echo $a->acp_id ?>"><?php echo $a->acp_descripcion ?></label>
							<input type="text" class="form-control input-number ind tpoli" id="iNact<?php echo $a->acp_id ?>" name="iact<?php echo $a->acp_id ?>" value="<?php echo $d->dh_cantidad ?>">
							<i class="fa form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconact<?php echo $a->acp_id ?>"></i>
						</div>

						<?php $div_horas = ($h_disponibles == 0) ? 0 : $d->dh_cantidad / $h_disponibles ?>
						<?php $percent = number_format($div_horas, 2, '.', ',') ?>
						<div class="form-group col-sm-2 has-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="gpact<?php echo $a->acp_id ?>">
							<label class="control-label" for="pact<?php echo $a->acp_id ?>">% Asignado</label>
							<input type="text" class="form-control input-number" id="iNpact<?php echo $a->acp_id ?>" tabindex="-1" name="pact<?php echo $a->acp_id ?>" value="<?php echo $percent ?>" disabled>
							<i class="fa form-control-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="iconpact<?php echo $a->acp_id ?>"></i>
						</div>

						<div class="form-group col-sm-2 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="gract<?php echo $a->acp_id ?>">
							<label class="control-label" for="ract<?php echo $a->acp_id ?>">Rendimiento</label>
							<input type="text" class="form-control input-number rend" id="iNract<?php echo $a->acp_id ?>" name="ract<?php echo $a->acp_id ?>" value="<?php echo $d->dh_rendimiento ?>">
							<i class="fa form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconract<?php echo $a->acp_id ?>"></i>
						</div>

						<?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
						<?php $ta_p += $t ?>
						<div class="form-group col-sm-2 col-sm-offset-1<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtact<?php echo $a->acp_id ?>">
							<label class="control-label" for="tact<?php echo $a->acp_id ?>">Total</label>
							<input type="text" class="form-control input-number tactp" tabindex="-1" id="iNtact<?php echo $a->acp_id ?>" name="tact<?php echo $a->acp_id ?>" value="<?php echo number_format($t, 2, '.', ',') ?>" disabled>
						</div>

						<?php $ts = $t * $sem_disp ?>
						<?php $ts_p += $ts ?>
						<div class="form-group col-sm-2<?php if ($ts > 0): ?> has-success<?php endif ?>" id="gtaact<?php echo $a->acp_id ?>">
							<label class="control-label" for="taact<?php echo $a->acp_id ?>">Total Anual</label>
							<input type="text" class="form-control input-number tanual" tabindex="-1" id="iNtaact<?php echo $a->acp_id ?>" name="taact<?php echo $a->acp_id ?>" value="<?php echo number_format($ts, 2, '.', ',') ?>" disabled>
						</div>
					</div>
				<?php endforeach ?>

				<!-- TOTAL POLICLINICO -->
				<?php $h_tot = 0 ?>
				<?php $h_tot += $t_p ?>
				<div class="row">
					<div class="form-group col-sm-3<?php if ($t_p > 0): ?> has-success<?php endif ?>" id="gtpoli">
						<label class="control-label" for="tpoli">Total Policlínico</label>
						<input type="text" class="form-control input-number" id="iNtpoli" tabindex="-1" name="tpoli" value="<?php echo number_format($t_p, 2, '.', ',') ?>" readonly>
					</div>

					<div class="form-group col-sm-2 col-sm-offset-5<?php if ($ta_p > 0): ?> has-success<?php endif ?>" id="gtapoli">
						<label class="control-label" for="tapoli">Total</label>
						<input type="text" class="form-control input-number" id="iNtapoli" tabindex="-1" name="tapoli" value="<?php echo number_format($ta_p, 2, '.', ',') ?>" readonly>
					</div>

					<?php $taa_p = $ta_p * $sem_disp ?>
					<div class="form-group col-sm-2<?php if ($taa_p > 0): ?> has-success<?php endif ?>" id="gtaapoli">
						<label class="control-label" for="taapoli">Total Anual</label>
						<input type="text" class="form-control input-number" tabindex="-1" id="iNtaapoli" name="taapoli" value="<?php echo number_format($taa_p, 2, '.', ',') ?>" readonly>
					</div>
				</div>
			</div>

			<div id="activ-med">
				<?php if ($per->per_prid == 4 or $per->per_prid == 14 or $per->per_prid == 16): ?>
					<div class="box-header with-border">
						<h3 class="box-title">Otras actividades</h3>
					</div>

                    <div class="box-body">
                        <?php $act_list = $acp->getByType(1, $exceptions) ?>
                        <?php foreach ($act_list as $ind => $act): ?>
                            <?php $d = $dh->getByPerTHDate($id, $act->acp_id, $prev) ?>
                            <?php $h_tot += $d->dh_cantidad ?>
                            <div class="row">
                                <div class="form-group col-sm-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gact<?php echo $act->acp_id ?>">
                                    <label class="control-label" for="iacp<?php echo $act->acp_id ?>"><?php echo $act->acp_descripcion ?></label>
                                    <input type="text" class="form-control input-number ind" id="iNact<?php echo $act->acp_id ?>" name="iact<?php echo $act->acp_id ?>" value="<?php echo $d->dh_cantidad ?>">
                                    <i class="fa form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconact<?php echo $act->acp_id ?>"></i>
                                </div>

                                <?php $div_horas = ($h_disponibles == 0) ? 0 : $d->dh_cantidad / $h_disponibles ?>
                                <?php $percent = number_format($div_horas, 2, '.', ',') ?>
                                <div class="form-group col-sm-2 has-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="gpact<?php echo $act->acp_id ?>">
                                    <label class="control-label" for="pact<?php echo $act->acp_id ?>">% Asignado</label>
                                    <input type="text" class="form-control input-number" id="iNpact<?php echo $act->acp_id ?>" tabindex="-1" name="pact<?php echo $act->acp_id ?>" value="<?php echo $percent ?>" disabled>
                                    <i class="fa form-control-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="iconpact<?php echo $act->acp_id ?>"></i>
                                </div>

                                <?php if ($act->acp_rendimiento): ?>
                                    <div class="form-group col-sm-2 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="gract<?php echo $act->acp_id ?>">
                                        <label class="control-label" for="ract<?php echo $act->acp_id ?>">Rendimiento</label>
                                        <input type="text" class="form-control input-number rend" id="iNract<?php echo $act->acp_id ?>" name="ract<?php echo $act->acp_id ?>" value="<?php echo $d->dh_rendimiento ?>">
                                        <i class="fa form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconract<?php echo $act->acp_id ?>"></i>
                                    </div>

                                    <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
                                    <div class="form-group col-sm-2 col-sm-offset-1<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtact<?php echo $act->acp_id ?>">
                                        <label class="control-label" for="tact<?php echo $act->acp_id ?>">Total</label>
                                        <input type="text" class="form-control input-number" tabindex="-1" id="iNtact<?php echo $act->acp_id ?>" name="tact<?php echo $act->acp_id ?>" value="<?php echo number_format($t, 2, '.', ',') ?>" disabled>
                                    </div>

                                    <?php $ts = $t * $sem_disp ?>
                                    <div class="form-group col-sm-2<?php if ($ts > 0): ?> has-success<?php endif ?>" id="gtaact<?php echo $act->acp_id ?>">
                                        <label class="control-label" for="taact<?php echo $act->acp_id ?>">Total Anual</label>
                                        <input type="text" class="form-control input-number" tabindex="-1" id="iNtaact<?php echo $act->acp_id ?>" name="taact<?php echo $act->acp_id ?>" value="<?php echo number_format($ts, 2, '.', ',') ?>" disabled>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>

					<!--<div class="box-body">
						<?php /*for ($i = 6; $i < 21; $i++): */?>
							<?php /*$a = $acp->get($i) */?>
							<?php /*$d = $dh->getByPerTHDate($id, $i, $prev) */?>
							<?php /*$h_tot += $d->dh_cantidad */?>
							<div class="row">
								<div class="form-group col-sm-3 has-feedback<?php /*if ($d->dh_cantidad > 0): */?> has-success<?php /*endif */?>" id="gact<?php /*echo $a->acp_id */?>">
									<label class="control-label" for="iacp<?php /*echo $a->acp_id */?>"><?php /*echo $a->acp_descripcion */?></label>
									<input type="text" class="form-control input-number ind" id="iNact<?php /*echo $a->acp_id */?>" name="iact<?php /*echo $a->acp_id */?>" value="<?php /*echo $d->dh_cantidad */?>">
									<i class="fa form-control-feedback<?php /*if ($d->dh_cantidad > 0): */?> fa-check<?php /*endif */?>" id="iconact<?php /*echo $a->acp_id */?>"></i>
								</div>

								<?php /*$div_horas = ($h_disponibles == 0) ? 0 : $d->dh_cantidad / $h_disponibles */?>
								<?php /*$percent = number_format($div_horas, 2, '.', ',') */?>
								<div class="form-group col-sm-2 has-feedback<?php /*if ($percent > 0): */?> has-success<?php /*endif */?>" id="gpact<?php /*echo $a->acp_id */?>">
									<label class="control-label" for="pact<?php /*echo $a->acp_id */?>">% Asignado</label>
									<input type="text" class="form-control input-number" id="iNpact<?php /*echo $a->acp_id */?>" tabindex="-1" name="pact<?php /*echo $a->acp_id */?>" value="<?php /*echo $percent */?>" disabled>
									<i class="fa form-control-feedback<?php /*if ($percent > 0): */?> has-success<?php /*endif */?>" id="iconpact<?php /*echo $a->acp_id */?>"></i>
								</div>

								<?php /*if ($a->acp_rendimiento): */?>
									<div class="form-group col-sm-2 has-feedback<?php /*if ($d->dh_rendimiento > 0): */?> has-success<?php /*endif */?>" id="gract<?php /*echo $a->acp_id */?>">
										<label class="control-label" for="ract<?php /*echo $a->acp_id */?>">Rendimiento</label>
										<input type="text" class="form-control input-number rend" id="iNract<?php /*echo $a->acp_id */?>" name="ract<?php /*echo $a->acp_id */?>" value="<?php /*echo $d->dh_rendimiento */?>">
										<i class="fa form-control-feedback<?php /*if ($d->dh_rendimiento > 0): */?> fa-check<?php /*endif */?>" id="iconract<?php /*echo $a->acp_id */?>"></i>
									</div>

									<?php /*$t = $d->dh_cantidad * $d->dh_rendimiento */?>
									<div class="form-group col-sm-2 col-sm-offset-1<?php /*if ($t > 0): */?> has-success<?php /*endif */?>" id="gtact<?php /*echo $a->acp_id */?>">
										<label class="control-label" for="tact<?php /*echo $a->acp_id */?>">Total</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtact<?php /*echo $a->acp_id */?>" name="tact<?php /*echo $a->acp_id */?>" value="<?php /*echo number_format($t, 2, '.', ',') */?>" disabled>
									</div>

									<?php /*$ts = $t * $sem_disp */?>
									<div class="form-group col-sm-2<?php /*if ($ts > 0): */?> has-success<?php /*endif */?>" id="gtaact<?php /*echo $a->acp_id */?>">
										<label class="control-label" for="taact<?php /*echo $a->acp_id */?>">Total Anual</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtaact<?php /*echo $a->acp_id */?>" name="taact<?php /*echo $a->acp_id */?>" value="<?php /*echo number_format($ts, 2, '.', ',') */?>" disabled>
									</div>
								<?php /*endif */?>
							</div>
						<?php /*endfor */?>

						<?php /*for ($i = 22; $i < 55; $i++): */?>
							<?php /*$a = $acp->get($i) */?>
							<?php /*$d = $dh->getByPerTHDate($id, $i, $prev) */?>
							<?php /*$h_tot += $d->dh_cantidad */?>
							<div class="row">
								<div class="form-group col-sm-3 has-feedback<?php /*if ($d->dh_cantidad > 0): */?> has-success<?php /*endif */?>" id="gact<?php /*echo $a->acp_id */?>">
									<label class="control-label" for="iacp<?php /*echo $a->acp_id */?>"><?php /*echo $a->acp_descripcion */?></label>
									<input type="text" class="form-control input-number ind" id="iNact<?php /*echo $a->acp_id */?>" name="iact<?php /*echo $a->acp_id */?>" value="<?php /*echo $d->dh_cantidad */?>">
									<i class="fa form-control-feedback<?php /*if ($d->dh_cantidad > 0): */?> fa-check<?php /*endif */?>" id="iconact<?php /*echo $a->acp_id */?>"></i>
								</div>

								<?php /*$div_horas = ($h_disponibles == 0) ? 0 : $d->dh_cantidad / $h_disponibles */?>
								<?php /*$percent = number_format($div_horas, 2, '.', ',') */?>
								<div class="form-group col-sm-2 has-feedback<?php /*if ($percent > 0): */?> has-success<?php /*endif */?>" id="gpact<?php /*echo $a->acp_id */?>">
									<label class="control-label" for="pact<?php /*echo $a->acp_id */?>">% Asignado</label>
									<input type="text" class="form-control input-number" id="iNpact<?php /*echo $a->acp_id */?>" tabindex="-1" name="pact<?php /*echo $a->acp_id */?>" value="<?php /*echo $percent */?>" disabled>
									<i class="fa form-control-feedback<?php /*if ($percent > 0): */?> has-success<?php /*endif */?>" id="iconpact<?php /*echo $a->acp_id */?>"></i>
								</div>

								<?php /*if ($a->acp_rendimiento): */?>
									<div class="form-group col-sm-2 has-feedback<?php /*if ($d->dh_rendimiento > 0): */?> has-success<?php /*endif */?>" id="gract<?php /*echo $a->acp_id */?>">
										<label class="control-label" for="ract<?php /*echo $a->acp_id */?>">Rendimiento</label>
										<input type="text" class="form-control input-number rend" id="iNract<?php /*echo $a->acp_id */?>" name="ract<?php /*echo $a->acp_id */?>" value="<?php /*echo $d->dh_rendimiento */?>">
										<i class="fa form-control-feedback<?php /*if ($d->dh_rendimiento > 0): */?> fa-check<?php /*endif */?>" id="iconract<?php /*echo $a->acp_id */?>"></i>
									</div>

									<?php /*$t = $d->dh_cantidad * $d->dh_rendimiento */?>
									<div class="form-group col-sm-2 col-sm-offset-1<?php /*if ($t > 0): */?> has-success<?php /*endif */?>" id="gtact<?php /*echo $a->acp_id */?>">
										<label class="control-label" for="tact<?php /*echo $a->acp_id */?>">Total</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtact<?php /*echo $a->acp_id */?>" name="tact<?php /*echo $a->acp_id */?>" value="<?php /*echo number_format($t, 2, '.', ',') */?>" disabled>
									</div>

									<?php /*$ts = $t * $sem_disp */?>
									<div class="form-group col-sm-2<?php /*if ($ts > 0): */?> has-success<?php /*endif */?>" id="gtaact<?php /*echo $a->acp_id */?>">
										<label class="control-label" for="taact<?php /*echo $a->acp_id */?>">Total Anual</label>
										<input type="text" class="form-control input-number" tabindex="-1" id="iNtaact<?php /*echo $a->acp_id */?>" name="taact<?php /*echo $a->acp_id */?>" value="<?php /*echo number_format($ts, 2, '.', ',') */?>" disabled>
									</div>
								<?php /*endif */?>
							</div>
						<?php /*endfor */?>
					</div>-->
				<?php endif ?>

				<?php if ($per->per_prid != 4 and $per->per_prid != 14 and $per->per_prid != 16): ?>
					<div class="box-header with-border">
						<h3 class="box-title">Actividades No Médicos</h3>
					</div>

					<div class="box-body">
						<?php for ($i = 55; $i < 128; $i++): ?>
							<?php $a = $acp->get($i) ?>
							<?php $d = $dh->getByPerTHDate($id, $i, $prev) ?>
							<?php $h_tot += $d->dh_cantidad ?>
							<div class="row">
								<div class="form-group col-sm-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gact<?php echo $a->acp_id ?>">
									<label class="control-label" for="iacp<?php echo $a->acp_id ?>"><?php echo $a->acp_descripcion ?></label>
									<input type="text" class="form-control input-number ind" id="iNact<?php echo $a->acp_id ?>" name="iact<?php echo $a->acp_id ?>" value="<?php echo $d->dh_cantidad ?>">
									<i class="fa form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconact<?php echo $a->acp_id ?>"></i>
								</div>

								<?php $div_horas = ($h_disponibles == 0) ? 0 : $d->dh_cantidad / $h_disponibles ?>
								<?php $percent = number_format($div_horas, 2, '.', ',') ?>
								<div class="form-group col-sm-2 has-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="gpact<?php echo $a->acp_id ?>">
									<label class="control-label" for="pact<?php echo $a->acp_id ?>">% Asignado</label>
									<input type="text" class="form-control input-number" id="iNpact<?php echo $a->acp_id ?>" tabindex="-1" name="pact<?php echo $a->acp_id ?>" value="<?php echo $percent ?>" disabled>
									<i class="fa form-control-feedback<?php if ($percent > 0): ?> has-success<?php endif ?>" id="iconpact<?php echo $a->acp_id ?>"></i>
								</div>

								<?php if ($a->acp_rendimiento): ?>
									<div class="form-group col-sm-2 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="gract<?php echo $a->acp_id ?>">
										<label class="control-label" for="ract<?php echo $a->acp_id ?>">Rendimiento</label>
										<input type="text" class="form-control input-number rend" id="iNract<?php echo $a->acp_id ?>" name="ract<?php echo $a->acp_id ?>" value="<?php echo $d->dh_rendimiento ?>">
										<i class="fa form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconract<?php echo $a->acp_id ?>"></i>
									</div>

									<?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
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
					<div class="form-group col-sm-3<?php if ($h_tot > 0): ?> has-success<?php endif ?>" id="gtotal">
						<label class="control-label" for="total">Total</label>
						<input type="text" class="form-control input-number" tabindex="-1" id="iNtotal" name="total" value="<?php echo number_format($h_tot, 2, '.', ',') ?>" readonly>
					</div>
					<?php if ($per->per_prid == 4 or $per->per_prid == 14 or $per->per_prid == 16): ?>
						<div class="form-group col-sm-2 col-sm-offset-3" id="gbrecha">
							<label class="control-label" for="ibrecha">Brecha Calculada C+C</label>
							<input type="text" class="form-control input-number" id="iNbrecha2" name="ibrecha2" value="0" disabled>
						</div>

						<div class="form-group col-sm-2" id="gactanuales">
							<label class="control-label" for="iactanuales">Actividades Anuales</label>
							<input type="text" class="form-control input-number" id="iNactanuales" name="iactanuales" value="0" disabled>
						</div>

						<div class="form-group col-sm-2" id="gbrproy">
							<label class="control-label" for="ibrproy">Brecha Proyectada C+C</label>
							<input type="text" class="form-control input-number" id="iNbrproy" name="ibrproy" value="0" disabled>
						</div>
					<?php endif ?>
				</div>
				<?php if ($per->per_prid == 4 or $per->per_prid == 14 or $per->per_prid == 16): ?>
					<div class="row">
						<div class="form-group col-sm-2 col-sm-offset-6" id="gbrechaiq2">
							<label class="control-label" for="ibrechaiq2">Brecha Calculada IQ</label>
							<input type="text" class="form-control input-number" id="iNbrechaiq2" name="ibrechaiq2" value="0" disabled>
						</div>

						<div class="form-group col-sm-2" id="gactanualesiq">
							<label class="control-label" for="iactanualesiq">Actividades Anuales</label>
							<input type="text" class="form-control input-number" id="iNactanualesiq" name="iactanualesiq" value="0" disabled>
						</div>

						<div class="form-group col-sm-2" id="gbrproyiq">
							<label class="control-label" for="ibrproyiq">Brecha Proyectada IQ</label>
							<input type="text" class="form-control input-number" id="iNbrproyiq" name="ibrproyiq" value="0" disabled>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-2 col-sm-offset-6" id="gthesp2">
							<label class="control-label" for="ithesp2">Horas Disp. Especialidad</label>
							<input type="text" class="form-control input-number" id="iNthesp2" name="ithesp2" value="0" disabled>
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

<script src="program/create-program.js"></script>