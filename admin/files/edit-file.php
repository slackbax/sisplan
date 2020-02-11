<?php include("../class/classFile.php") ?>
<?php $fl = new File() ?>
<?php $file = $fl->get($id) ?>
<?php $tmp = explode('/', $file->arc_path) ?>
<?php $namefile = $tmp[1] ?>

<h3 class="sect-title"><h3 class="sect-title"><span class="iico iico36 iico-root"></span> Archivos <small> :: Edición de Archivo</small></h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
    <li><a href="index.php?section=admin">Panel de Control</a></li>
    <li><a href="index.php?section=admin&sbs=managefile">Administración de Documentos</a></li>
    <li class="active">Edición de archivo</li>
</ol>

<form role="form" id="formNewFile">
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="gname">
            <label class="control-label" for="iname">Nombre *</label>
            <input type="text" class="form-control input-sm" id="iNname" name="iname" placeholder="Ingrese nombre del documento" maxlength="256" required value="<?php echo $file->arc_nombre ?>">
            <i class="fa form-control-feedback" id="iconname"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-6 has-feedback" id="gdescrip">
            <label class="control-label" for="idescrip">Descripción *</label>
            <input type="text" class="form-control input-sm" id="iNdescrip" name="idescrip" placeholder="Ingrese una descripción para el documento" maxlength="1024" required value="<?php echo $file->arc_descripcion ?>">
            <i class="fa form-control-feedback" id="icondescrip"></i>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-xs-6">
            <label class="control-label" for="idocument">Archivo *</label>
            <div class="controls">
                <input name="idocument" class="form-control input-sm" id="idocument" type="text" value="<?php echo $namefile ?>" readonly>
            </div>
        </div>
    </div>

    <input name="iid" id="iid" type="hidden" value="<?php echo $id ?>">
    
    <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
    <hr>
    <div class="row">
        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i>Guardar</button> <button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
            <span class="ajaxLoader" id="submitLoader"></span>
        </div>
    </div>

</form>

<script src="admin/files/edit-file.js"></script>