<?php include ("class/classPersona.php") ?>
<?php include ("class/classEspecialidad.php") ?>
<?php include ("class/classSubespecialidad.php") ?>

<h3 class="sect-title"><span class="iico iico36 iico-panel"></span> Panel de Control <small> :: Creación de Contrato</small></h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
    <li><a href="index.php?section=admin">Panel de Control</a></li>
    <li class="active">Creación de Contrato</li>
</ol>

<form role="form" id="formNewPeople">
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="grut">
            <label class="control-label" for="irut">RUT *</label>
            <input type="text" class="form-control input-sm" id="iNrut" name="irut" placeholder="12345678-9" maxlength="12" required>
            <i class="fa form-control-feedback" id="iconrut"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-12 has-feedback" id="gname">
            <label class="control-label" for="iname">Nombre *</label>
            <input type="text" class="form-control input-sm" id="iNname" name="iname" placeholder="Ingrese nombre de la persona" required>
            <i class="fa form-control-feedback" id="iconname"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="gap">
            <label class="control-label" for="iap">Apellido Paterno *</label>
            <input type="text" class="form-control input-sm" id="iNap" name="iap" placeholder="Ingrese apellido paterno de la persona" required>
            <i class="fa form-control-feedback" id="iconap"></i>
        </div>
        
        <div class="form-group col-xs-6 has-feedback" id="gam">
            <label class="control-label" for="iam">Apellido Materno *</label>
            <input type="text" class="form-control input-sm" id="iNam" name="iam" placeholder="Ingrese apellido materno de la persona" required>
            <i class="fa form-control-feedback" id="iconam"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="gespecialidad">
            <label class="control-label" for="iespecialidad">Especialidad *</label>
            <select class="form-control input-sm" id="iNespecialidad" name="iespecialidad">
                <option value="">Seleccione especialidad</option>
                <?php $esp = new Especialidad() ?>
                <?php $e = $esp->getAll() ?>
                <?php foreach ($e as $aux => $es): ?>
                <option value="<?php echo $es->esp_id ?>"><?php echo $es->esp_descripcion ?></option>
                <?php endforeach ?>
            </select>
        </div>
        
        <div class="form-group col-xs-6 has-feedback" id="gsubesp">
            <label class="control-label" for="isubesp">Sub-especialidad *</label>
            <select class="form-control input-sm" id="iNsubesp" name="isubesp">
                <option value="">Seleccione subesp</option>
            </select>
        </div>
    </div>
    
    <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i>Guardar</button> <button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
            <span class="ajaxLoader" id="submitLoader"></span>
        </div>
    </div>
</form>

<script src="admin/contracts/create-contract.js"></script>