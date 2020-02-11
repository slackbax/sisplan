<h3 class="sect-title"><span class="iico iico36 iico-root"></span> Archivos <small> :: Importación de Datos Médicos</small></h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
    <li><a href="index.php?section=admin">Panel de Control</a></li>
    <li class="active">Importación de Datos Médicos</li>
</ol>

<form role="form" id="formNewFile">
    <div class="row">
        <div class="form-group col-xs-3 has-feedback" id="gdate">
            <label class="control-label" for="idate">Mes de Programación *</label>
            <div class="input-group input-group-sm">
                <i class="input-group-addon fa fa-calendar"></i>
                <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="mm/yyyy" placeholder="MM/AAAA">
                <input type="hidden" id="iNtplanta" name="itplanta" value="1">
            </div>
            <i class="fa form-control-feedback" id="icondate"></i>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-12">
            <label class="control-label" for="idocument">Archivo *</label>
            <div class="controls">
                <input name="idocument[]" class="multi" id="idocument" type="file" size="16" accept="xlsx" maxlength="1">
                <p class="help-block">Formatos admitidos: xlsx</p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-12">
            <label class="control-label" for="iresult">Resultado</label>
            <div class="controls">
                <div style="min-height: 200px; border:1px solid #ccc; padding: 5px;" id="iNresult"></div>
            </div>
        </div>
    </div>
    
    <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
    <hr>
    <div class="row">
        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i>Guardar</button> <button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
            <span class="ajaxLoader" id="submitLoader"></span>
        </div>
    </div>

</form>

<script src="admin/files/create-file.js"></script>