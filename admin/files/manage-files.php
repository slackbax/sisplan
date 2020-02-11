<?php include("class/classFile.php") ?>
<?php $fl = new File() ?>

<h3 class="sect-title"><span class="iico iico36 iico-panel"></span> Panel de Control <small> :: Administración de Documentos</small></h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
    <li><a href="index.php?section=admin">Panel de Control</a></li>
    <li class="active">Administración de Documentos</li>
</ol>

<?php $files = $fl->getAll(); ?>

<h4 class="sect-subtitle">Documentos de acreditación registrados</h4>
<table id="tfiles" class="display hover row-border" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Subido el</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($files as $aux => $f): ?>
        <tr>
            <td><span class="iico iico16 iico-<?php echo getExtension($f->arc_ext) ?>-min"></span><?php echo $f->arc_nombre ?></td>
            <td><?php echo getDateBD($f->arc_fecha) ?></td>
            <td>
                <button id="id_<?php echo $f->arc_id ?>" data-toggle="modal" data-target="#fileDetail" class="fileModal btn btn-xs btn-info" data-tooltip="tooltip" data-placement="top" title="Ver detalles"><i class="fa fa-search-plus"></i></button>
                <a class="fileEdit btn btn-xs btn-info" href="index.php?section=admin&sbs=editfile&id=<?php echo $f->arc_id ?>" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
                <button id="del_<?php echo $f->arc_id ?>" class="fileDelete btn btn-xs btn-danger" data-tooltip="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-remove"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="fileDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Información de Archivo <small id="f_name"></small></h4>
            </div>
            <div class="modal-body">
                <div class="row td-div">
                    <p class="col-xs-3 td-div-t">Publicado el</p>
                    <p class="col-xs-9 td-div-i" id="f_date"></p>
                </div>
                <div class="row td-div">
                    <p class="col-xs-3 td-div-t">Tipo</p>
                    <p class="col-xs-9 td-div-i" id="f_type"></p>
                </div>
                <div class="row td-div no-bottom">
                    <p class="col-xs-3 td-div-t">Subido por</p>
                    <p class="col-xs-9 td-div-i" id="f_user"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a id="f_path" href="" class="btn btn-primary btnModal" target="_blank">Descargar</a>
            </div>
        </div>
    </div>
</div>

<script src="admin/files/manage-files.js"></script>