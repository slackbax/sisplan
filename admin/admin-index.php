<h3 class="sect-title"><span class="iico iico36 iico-panel"></span> Panel de Control</h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
    <li class="active">Panel de Control</li>
</ol>

<div class="row dash-row">
    <div class="col-sm-3">
        <div class="dash-item iico-file-add" id="createfile">
            <p class="di-st">Importación de Datos</p>
            <p class="di-ht">Médicos</p>
        </div>
    </div>
    <!--<div class="col-sm-3">
        <div class="dash-item iico-file-add" id="createfilenm">
            <p class="di-st">Importación de Datos</p>
            <p class="di-ht">no Médicos</p>
        </div>
    </div>-->
</div>
<!--
<div class="row dash-row">
    <div class="col-sm-3">
        <div class="dash-item iico-client-add" id="createpeople">
            <p class="di-st">Creación de Personal</p>
            <p class="di-ht">Médico</p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="dash-item iico-client-view" id="managepeople">
            <p class="di-st">Administración de Personal</p>
            <p class="di-ht">Médico</p>
        </div>
    </div>
    
    <div class="col-sm-3">
        <div class="dash-item iico-client-add" id="createpeoplenm">
            <p class="di-st">Creación de Personal</p>
            <p class="di-ht">no Médico</p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="dash-item iico-client-view" id="managepeoplenm">
            <p class="di-st">Administración de Personal</p>
            <p class="di-ht">no Médico</p>
        </div>
    </div>
</div>
-->
<hr class="dash-hr">

<div class="row dash-row">
    <div class="col-sm-3">
        <div class="dash-item iico-user-add" id="createuser">
            <p class="di-st">Creación de</p>
            <p class="di-ht">Usuarios</p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="dash-item iico-user-view" id="manageuser">
            <p class="di-st">Administración de</p>
            <p class="di-ht">Usuarios</p>
        </div>
    </div>
    
    <div class="col-sm-3">
        <div class="dash-item iico-group-add" id="creategroup">
            <p class="di-st">Creación de</p>
            <p class="di-ht">Grupos</p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="dash-item iico-group-view" id="managegroup">
            <p class="di-st">Administración de</p>
            <p class="di-ht">Grupos</p>
        </div>
    </div>
</div>

<script>
    $(document).ready( function() {
        $('.dash-item').click( function() {
            window.location.href='index.php?section=admin&sbs=' + $(this).attr('id');
        });
    });
</script>