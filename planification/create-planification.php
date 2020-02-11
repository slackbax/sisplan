<?php include ("class/classPersona.php") ?>
<?php include ("class/classCr.php") ?>
<?php include ("class/classEspecialidad.php") ?>
<?php include ("class/classDistribucion.php") ?>
<?php include ("class/classDistHoras.php") ?>
<?php include ("class/classJustificacion.php") ?>
<?php $p = new Persona() ?>
<?php $cr = new Cr() ?>
<?php $es = new Especialidad() ?>
<?php $di = new Distribucion() ?>
<?php $dh = new DistHoras() ?>
<?php $js = new Justificacion() ?>
<?php $per = $p->get($id) ?>
<?php $today = $date ?>
<?php $num_d = $di->getCountByPerDate($id, $_SESSION['prm_estid'], $today) ?>

<h3 class="sect-title"><span class="iico iico36 iico-root"></span> Planificación Mensual <small> :: Ingreso de Planificación</small></h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
    <li><a href="index.php?section=planif&sbs=listpeopleplanif">Personas Registradas</a></li>
    <li class="active">Ingreso de Planificación</li>
</ol>

<?php if ($num_d == 0): ?>
<form role="form" id="formNewProgram">
    <h5>Datos Contractuales</h5>
    <div class="row">
        <div class="form-group col-xs-6">
            <label class="control-label">Nombre</label>
            <p class="form-control-static"><?php echo $per->per_nombres . ' ' . $per->per_ap . ' ' . $per->per_am ?></p>
            <input type="hidden" id="iid" name="id" value="<?php echo $id ?>">
        </div>
    </div>    
    
    <h5>Datos de Planificación</h5>
    <div class="row">
        <div class="form-group col-xs-3 has-feedback has-success" id="gdate">
            <label class="control-label" for="idate">Mes de Planificación *</label>
            <div class="input-group input-group-sm">
                <i class="input-group-addon fa fa-calendar"></i>
                <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="mm/yyyy" placeholder="MM/AAAA" value="<?php echo getDateMonthToForm($date) ?>" required>
            </div>
            <i class="form-control-feedback fa-check" id="icondate"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="gdesc">
            <label class="control-label" for="idesc">Descripción *</label>
            <input type="text" class="form-control input-sm" id="iNdesc" name="idesc" placeholder="Ingrese descripción para la planificación" required>
            <i class="form-control-feedback" id="icondesc"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="gcr">
            <label class="control-label" for="icr">Centro de Responsabilidad *</label>
            <select class="form-control input-sm" id="iNcr" name="icr" required>
                <option value="">Seleccione CR</option>
                <?php $cen = $cr->getAll() ?>
                <?php foreach ($cen as $c): ?>
                <option value="<?php echo $c->cr_id ?>"><?php echo $c->cr_nombre ?></option>
                <?php endforeach ?>
            </select>
        </div>
        
        <div class="form-group col-xs-6 has-feedback" id="gserv">
            <label class="control-label" for="iserv">Servicio *</label>
            <select class="form-control input-sm" id="iNserv" name="iserv" required>
                <option value="">Seleccione servicio</option>
            </select>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="gesp">
            <label class="control-label" for="iesp">Especialidad *</label>
            <select class="form-control input-sm" id="iNesp" name="iesp" required>
                <option value="">Seleccione especialidad</option>
            </select>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-3 has-feedback" id="gvacaciones">
            <label class="control-label" for="ivacaciones">Días de vacaciones *</label>
            <input type="text" class="form-control input-sm input-number disp" id="iNvacaciones" name="ivacaciones" placeholder="Ingrese días de vacaciones" required>
            <i class="form-control-feedback" id="iconvacaciones"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback" id="gpermiso">
            <label class="control-label" for="ipermiso">Días de permiso *</label>
            <input type="text" class="form-control input-sm input-number disp" id="iNpermiso" name="ipermiso" placeholder="Ingrese días de permiso" required>
            <i class="form-control-feedback" id="iconpermiso"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback" id="gcongreso">
            <label class="control-label" for="icongreso">Días de congreso *</label>
            <input type="text" class="form-control input-sm input-number disp" id="iNcongreso" name="icongreso" placeholder="Ingrese días de congresos" required>
            <i class="form-control-feedback" id="iconcongreso"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback" id="gsemdisp">
            <label class="control-label" for="isemdisp">Semanas disponibles</label>
            <input type="text" class="form-control input-sm input-number" id="iNsemdisp" name="isemdisp" value="0" tabindex="-1" readonly>
            <i class="form-control-feedback" id="iconsemdisp"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-3" id="gvacacionesp">
            <label class="control-label" for="ivacacionesp">Vacaciones programadas</label>
            <input type="text" class="form-control input-sm input-number" id="iNvacacionesp" name="ivacacionesp" value="0" tabindex="-1" disabled>
        </div>
        
        <div class="form-group col-xs-3" id="gpermisop">
            <label class="control-label" for="ipermisop">Permiso programados</label>
            <input type="text" class="form-control input-sm input-number" id="iNpermisop" name="ipermisop" value="0" tabindex="-1" disabled>
        </div>
        
        <div class="form-group col-xs-3" id="gcongresop">
            <label class="control-label" for="icongresop">Congreso programados</label>
            <input type="text" class="form-control input-sm input-number" id="iNcongresop" name="icongresop" value="0" tabindex="-1" disabled>
        </div>
        
        <div class="form-group col-xs-3" id="gsemdispp">
            <label class="control-label" for="isemdispp">Semanas programadas</label>
            <input type="text" class="form-control input-sm input-number" id="iNsemdispp" name="isemdispp" value="0" tabindex="-1" disabled>
        </div>
    </div>
    
    <hr>
    
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="gjustif">
            <label class="control-label" for="ijustif">Justificación para planificación nula</label>
            <select class="form-control input-sm" id="iNjustif" name="ijustif">
                <option value="">Seleccione una justificación</option>
                <?php $jus = $js->getAll() ?>
                <?php foreach ($jus as $j): ?>
                <option value="<?php echo $j->jus_id ?>"><?php echo $j->jus_descripcion ?></option>
                <?php endforeach ?>
            </select>
            <span id="helpBlock" class="help-block">Obligatoria sólo en el caso de programar una distribución con cero horas disponibles.</span>
        </div>
    </div>
    
    <h5>Horas Semanales</h5>
    <div class="row">
        <?php $h_sem = 0 ?>
        <?php $d = $dh->getByPerTHDate($id, 1, $today) ?>
        <?php $h_sem += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gdisp">
            <label class="control-label" for="disp">Horas Disponibles *</label>
            <input type="text" class="form-control input-sm input-number disponib" id="iNdisp" name="disp" value="<?php echo $d->dh_cantidad ?>" required>
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="icondisp"></i>
        </div>
        
        <?php $d = $dh->getByPerTHDate($id, 2, $today) ?>
        <?php $h_sem += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="guniversidad">
            <label class="control-label" for="universidad">Médico Universidad</label>
            <input type="text" class="form-control input-sm input-number disponib" id="iNuniversidad" name="universidad" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconuniversidad"></i>
        </div>
        
        <?php $d = $dh->getByPerTHDate($id, 3, $today) ?>
        <?php $h_sem += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gbecados">
            <label class="control-label" for="becados">Becados</label>
            <input type="text" class="form-control input-sm input-number disponib" id="iNbecados" name="becados" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconbecados"></i>
        </div>
        
        <div class="form-group col-xs-3<?php if ($h_sem > 0): ?> has-success<?php endif ?>" id="gtdisponible">
            <label class="control-label" for="disponible">Horas Semanales Disp.</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtdisponible" name="tdisponible" value="<?php echo number_format($h_sem, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    
    <h5>Distribución Horas Semanales</h5>
    <!-- ATENCION SALA -->
    <div class="row">
        <?php $h_tot = 0 ?>
        <?php $d = $dh->getByPerTHDate($id, 4, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gsala">
            <label class="control-label" for="sala">Atención Sala</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNsala" name="sala" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconsala"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grsala">
            <label class="control-label" for="rsala">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrsala" name="rsala" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrsala"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtsala">
            <label class="control-label" for="tsala">Nº Visitas Médicas</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtsala" name="tsala" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- CONSULTAS NUEVAS -->
    <div class="row">
        <?php $t_p = $ta_p = 0 ?>
        <?php $d = $dh->getByPerTHDate($id, 5, $today) ?>
        <?php $t_p += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gconsultasn">
            <label class="control-label" for="consultasn">Consultas Nuevas</label>
            <input type="text" class="form-control input-sm input-number ind tpoli" id="iNconsultasn" name="consultasn" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconconsultasn"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grconsultasn">
            <label class="control-label" for="rconsultasn">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrconsultasn" name="rconsultasn" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrconsultasn"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <?php $ta_p += $t ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtconsultasn">
            <label class="control-label" for="tconsultasn">Total Consultas Nuevas</label>
            <input type="text" class="form-control input-sm input-number tactp" tabindex="-1" id="iNtconsultasn" name="tconsultasn" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- CONTROLES -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 6, $today) ?>
        <?php $t_p += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gcontroles">
            <label class="control-label" for="controles">Controles</label>
            <input type="text" class="form-control input-sm input-number ind tpoli" id="iNcontroles" name="controles" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconcontroles"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grcontroles">
            <label class="control-label" for="rcontroles">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrcontroles" name="rcontroles" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrcontroles"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <?php $ta_p += $t ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtcontroles">
            <label class="control-label" for="tcontroles">Total Controles</label>
            <input type="text" class="form-control input-sm input-number tactp" tabindex="-1" id="iNtcontroles" name="tcontroles" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- COMITE -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 7, $today) ?>
        <?php $t_p += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gcomite">
            <label class="control-label" for="comite">Comité</label>
            <input type="text" class="form-control input-sm input-number ind tpoli" id="iNcomite" name="comite" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconcomite"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grcomite">
            <label class="control-label" for="rcomite">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrcomite" name="rcomite" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrcomite"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <?php $ta_p += $t ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtcomite">
            <label class="control-label" for="tcomite">Total Comité</label>
            <input type="text" class="form-control input-sm input-number tactp" tabindex="-1" id="iNtcomite" name="tcomite" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- CONSULTA ABREVIADA -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 8, $today) ?>
        <?php $t_p += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gconsultaa">
            <label class="control-label" for="consultaa">Consulta Abreviada</label>
            <input type="text" class="form-control input-sm input-number ind tpoli" id="iNconsultaa" name="consultaa" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconconsultaa"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grconsultaa">
            <label class="control-label" for="rconsultaa">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrconsultaa" name="rconsultaa" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrconsultaa"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <?php $ta_p += $t ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtconsultaa">
            <label class="control-label" for="tcomite">Total Consulta Abreviada</label>
            <input type="text" class="form-control input-sm input-number tactp" tabindex="-1" id="iNtconsultaa" name="tconsultaa" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- TOTAL POLICLINICO -->
    <div class="row">
        <?php $h_tot += $t_p ?>
        <div class="form-group col-xs-3<?php if ($t_p > 0): ?> has-success<?php endif ?>" id="gtpoli">
            <label class="control-label" for="tpoli">Total Policlínico</label>
            <input type="text" class="form-control input-number" id="iNtpoli" tabindex="-1" name="tpoli" value="<?php echo number_format($t_p, 2, '.', ',') ?>" readonly>
        </div>
        
        <div class="form-group col-xs-3 col-xs-offset-6<?php if ($ta_p > 0): ?> has-success<?php endif ?>" id="gtapoli">
            <label class="control-label" for="tapoli">Total Actividades Policlínico</label>
            <input type="text" class="form-control input-number" id="iNtapoli" tabindex="-1" name="tapoli" value="<?php echo number_format($ta_p, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    
    <hr>
    <!-- PROCEDIMIENTOS -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 9, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gprocedimiento">
            <label class="control-label" for="procedimiento">Procedimientos</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNprocedimiento" name="procedimiento" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconprocedimiento"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grprocedimiento">
            <label class="control-label" for="rconsultaa">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrprocedimiento" name="rprocedimiento" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrprocedimiento"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtprocedimiento">
            <label class="control-label" for="tprocedimiento">Total Procedimientos</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtprocedimiento" name="tprocedimiento" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- PABELLON -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 10, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gpabellon">
            <label class="control-label" for="pabellon">Pabellón</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNpabellon" name="pabellon" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconpabellon"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grpabellon">
            <label class="control-label" for="rpabellon">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrpabellon" name="rpabellon" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrpabellon"></i>
        </div>
		<?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtpabellon">
            <label class="control-label" for="tpabellon">Total Pabellón</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtpabellon" name="tpabellon" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- TELECONSULTA -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 11, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gteleconsulta">
            <label class="control-label" for="eleconsulta">Teleconsultas</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNteleconsulta" name="eleconsulta" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconteleconsulta"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grteleconsulta">
            <label class="control-label" for="rteleconsulta">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrteleconsulta" name="releconsulta" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrteleconsulta"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtteleconsulta">
            <label class="control-label" for="teleconsulta">Total Teleconsultas</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtteleconsulta" name="teleconsulta" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- ENTREVISTA FAMILIAR -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 12, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gentrevista">
            <label class="control-label" for="entrevista">Entrevistas Familiares</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNentrevista" name="entrevista" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconentrevista"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grentrevista">
            <label class="control-label" for="rentrevista">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrentrevista" name="rentrevista" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrentrevista"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtentrevista">
            <label class="control-label" for="tentrevista">Total Entrevistas</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtentrevista" name="tentrevista" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- CONSULTORIA -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 13, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gconsultoria">
            <label class="control-label" for="consultoria">Consultoría</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNconsultoria" name="consultoria" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconconsultoria"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grconsultoria">
            <label class="control-label" for="rconsultoria">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrconsultoria" name="rconsultoria" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrconsultoria"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtconsultoria">
            <label class="control-label" for="tconsultoria">Total Consultoría</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtconsultoria" name="tconsultoria" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- VISITAS DOMICILIARIAS -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 14, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gvisitas">
            <label class="control-label" for="visitas">Visitas Domiciliarias</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNvisitas" name="visitas" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconvisitas"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grvisitas">
            <label class="control-label" for="rvisitas">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrvisitas" name="rvisitas" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrvisitas"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtvisitas">
            <label class="control-label" for="tvisitas">Total Visitas Domiciliarias</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtvisitas" name="tvisitas" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- INTERVENCION COMUNITARIA -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 15, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gintcomunitaria">
            <label class="control-label" for="intcomunitaria">Intervención Comunitaria</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNintcomunitaria" name="intcomunitaria" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconintcomunitaria"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grintcomunitaria">
            <label class="control-label" for="rintcomunitaria">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrintcomunitaria" name="rintcomunitaria" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrintcomunitaria"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtintcomunitaria">
            <label class="control-label" for="tintcomunitaria">Total Intervención Comunitaria</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtintcomunitaria" name="tintcomunitaria" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- SALA EXAMENES -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 16, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gsalaexam">
            <label class="control-label" for="salaexam">Sala Exámenes</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNsalaexam" name="salaexam" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconsalaexam"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grsalaexam">
            <label class="control-label" for="rsalaexam">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrsalaexam" name="rsalaexam" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrsalaexam"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtsalaexam">
            <label class="control-label" for="tsalaexam">Total Sala Exámenes</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtsalaexam" name="tsalaexam" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <!-- OTROS -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 17, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gintenlace">
            <label class="control-label" for="intenlace">Interconsultas Enlace</label>
            <input type="text" class="form-control input-sm input-number thor" id="iNintenlace" name="intenlace" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconintenlace"></i>
        </div>
    </div>
    
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 18, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="greclinicas">
            <label class="control-label" for="reclinicas">Reuniones Clínicas</label>
            <input type="text" class="form-control input-sm input-number thor" id="iNreclinicas" name="reclinicas" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconreclinicas"></i>
        </div>
    </div>
    
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 19, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gadmin">
            <label class="control-label" for="admin">Administración</label>
            <input type="text" class="form-control input-sm input-number thor" id="iNadmin" name="admin" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconadmin"></i>
        </div>
    </div>
    
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 20, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gvisacion">
            <label class="control-label" for="visacion">Visación Interconsultas</label>
            <input type="text" class="form-control input-sm input-number thor" id="iNvisacion" name="visacion" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconvisacion"></i>
        </div>
    </div>
    
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 21, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gcapacitacion">
            <label class="control-label" for="capacitacion">Capacitación</label>
            <input type="text" class="form-control input-sm input-number thor" id="iNcapacitacion" name="capacitacion" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconcapacitacion"></i>
        </div>
    </div>
    
    <?php if ($per->per_prid != 6): ?>
    <!-- GIMNASIO -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 22, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="ggimnasio">
            <label class="control-label" for="gimnasio">Gimnasio</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNgimnasio" name="gimnasio" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="icongimnasio"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grgimnasio">
            <label class="control-label" for="rgimnasio">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrgimnasio" name="rgimnasio" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrgimnasio"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtgimnasio">
            <label class="control-label" for="tgimnasio">Total Gimnasio</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtgimnasio" name="tgimnasio" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    
    <!-- EDUCACION -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 23, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="geducacion">
            <label class="control-label" for="educacion">Educación/Conserjería</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNeducacion" name="educacion" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconeducacion"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="greducacion">
            <label class="control-label" for="reducacion">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNreducacion" name="reducacion" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconreducacion"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gteducacion">
            <label class="control-label" for="teducacion">Total Educación</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNteducacion" name="teducacion" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    
    <!-- INTERVENCION -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 24, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gintervencion">
            <label class="control-label" for="intervencion">Intervención Grupal</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNintervencion" name="intervencion" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconintervencion"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grintervencion">
            <label class="control-label" for="rintervencion">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrintervencion" name="rintervencion" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrintervencion"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtintervencion">
            <label class="control-label" for="tintervencion">Total Intervención</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtintervencion" name="tintervencion" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    
    <!-- TALLERES -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 25, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gtalleres">
            <label class="control-label" for="talleres">Talleres Grupales</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNtalleres" name="talleres" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="icontalleres"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grtalleres">
            <label class="control-label" for="rtalleres">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrtalleres" name="rtalleres" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrtalleres"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gttalleres">
            <label class="control-label" for="ttalleres">Total Talleres</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNttalleres" name="ttalleres" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    
    <!-- VIDA DIARIA -->
    <div class="row">
        <?php $d = $dh->getByPerTHDate($id, 26, $today) ?>
        <?php $h_tot += $d->dh_cantidad ?>
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_cantidad > 0): ?> has-success<?php endif ?>" id="gvida">
            <label class="control-label" for="vida">Actividades Vida Diaria</label>
            <input type="text" class="form-control input-sm input-number ind" id="iNvida" name="vida" value="<?php echo $d->dh_cantidad ?>">
            <i class="form-control-feedback<?php if ($d->dh_cantidad > 0): ?> fa-check<?php endif ?>" id="iconvida"></i>
        </div>
        
        <div class="form-group col-xs-3 has-feedback<?php if ($d->dh_rendimiento > 0): ?> has-success<?php endif ?>" id="grvida">
            <label class="control-label" for="rvida">Rendimiento</label>
            <input type="text" class="form-control input-sm input-number rend" id="iNrvida" name="rvida" value="<?php echo $d->dh_rendimiento ?>">
            <i class="form-control-feedback<?php if ($d->dh_rendimiento > 0): ?> fa-check<?php endif ?>" id="iconrvida"></i>
        </div>
        <?php $t = $d->dh_cantidad * $d->dh_rendimiento ?>
        <div class="form-group col-xs-3 col-xs-offset-3<?php if ($t > 0): ?> has-success<?php endif ?>" id="gtvida">
            <label class="control-label" for="tvida">Total Actividades</label>
            <input type="text" class="form-control input-sm input-number" tabindex="-1" id="iNtvida" name="tvida" value="<?php echo number_format($t, 2, '.', ',') ?>" readonly>
        </div>
    </div>
    <?php endif ?>
    
    <hr>
    
    <div class="row">
        <div class="form-group col-xs-3<?php if ($h_tot > 0): ?> has-success<?php endif ?>" id="gtotal">
            <label class="control-label" for="total">Total</label>
            <input type="text" class="form-control input-number" tabindex="-1" id="iNtotal" name="total" value="<?php echo number_format($h_tot, 2, '.', ',') ?>">
        </div>
    </div>
    
    <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa-check"></i>Guardar</button> <button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
            <span class="ajaxLoader" id="submitLoader"></span>
        </div>
    </div>
</form>
<?php else: ?>

<div class="bs-callout bs-callout-danger">
    <h3>Error de planificación</h3>
    <p>Ha intentado ingresar una planificación ya existente. Por favor, vuelva a la lista de personas disponibles y elija otra fecha y/o persona.</p>
    <p><a href="index.php?section=planif&sbs=listpeople" class="btn btn-default" id="btnback">Volver a la lista</a> <a href="index.php" class="btn btn-info" id="btnback">Volver al inicio</a></p>
</div>

<?php endif ?>

<script src="planification/create-planification.js"></script>