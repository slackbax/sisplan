<h3 class="sect-title"><span class="iico iico36 iico-root"></span> Planificación Mensual <small> :: Ingreso de Planificación</small></h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
    <li class="active">Personas Registradas</li>
</ol>

<form role="form" id="formNewProgram">
    <div class="row">
        <div class="form-group col-xs-3 has-feedback" id="gdate">
            <label class="control-label" for="idate">Mes de Planificación *</label>
            <div class="input-group input-group-sm">
                <i class="input-group-addon fa fa-calendar"></i>
                <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="mm/yyyy" placeholder="MM/AAAA" required>
            </div>
            <i class="form-control-feedback" id="icondate"></i>
        </div>
        
        <div class="form-group col-xs-4 has-feedback" id="gplanta">
            <label class="control-label" for="iplanta">Planta *</label>
            <select class="form-control input-sm" id="iNplanta" name="iplanta" required>
                <option value="">Seleccione una planta</option>
                <option value="0">MÉDICA</option>
                <option value="1">NO MÉDICA</option>
                <option value="2">ODONTOLÓGICA</option>
            </select>
        </div>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" id="iNnoprog" name="inoprog"> Mostrar sólo personal no programado en el período
        </label>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa-check"></i>Buscar</button>
            <span class="ajaxLoader" id="submitLoader"></span>
        </div>
    </div>
</form>

<hr>

<h4 class="sect-subtitle">Personas registradas disponibles para planificación</h4>

<div class="row">
    <div class="form-group col-xs-4 col-xs-offset-4">
        <button type="button" class="btn btn-block btn-primary" id="btncopy"><i class="glyphicon-plus"></i>Copiar planificación anterior</button>
        <span class="ajaxLoader" id="submitLoader2"></span>
    </div>
</div>

<table id="tpeople" class="hover row-border" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>RUT</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Profesión</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
    </tbody>
</table>

<script src="planification/list-people.js"></script>