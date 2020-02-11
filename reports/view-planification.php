<h3 class="sect-title"><span class="iico iico36 iico-root"></span> Reportes <small> :: Planificaciones Ingresadas</small></h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
    <li class="active">Planificaciones Ingresadas</li>
</ol>

<h4 class="sect-subtitle">Planificaciones registradas</h4>

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

    <div class="row">
        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa-check"></i>Buscar</button>
            <span class="ajaxLoader" id="submitLoader"></span>
        </div>
    </div>
</form>

<hr>

<table id="tprogram" class="hover row-border" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Servicio</th>
            <th>Especialidad</th>
            <th>Descripción</th>
            <th>Horas Contratadas</th>
            <th>Médicos Universidad</th>
            <th>Becados</th>
            <th>Horas Disponibles</th>
            <th>Atención Sala</th>
            <th>Consultas Nuevas</th>
            <th>Controles</th>
            <th>Consulta Rend. Especial</th>
            <th>Consultas Abreviadas</th>
            <th>Total Policlínico</th>
            <th>Procedimientos</th>
            <th>Pabellón</th>
            <th>TeleConsultas</th>
            <th>Entrevista Familiar</th>
            <th>Consultoría</th>
            <th>Visitas Domiciliarias</th>
            <th>Intervención Comunitaria</th>
            <th>Sala Exámenes</th>
            <th>Interconsultas Enlace</th>
            <th>Reuniones Clínicas</th>
            <th>Administración</th>
            <th>Visación Interconsultas</th>
            <th>Capacitación</th>
            <th>TOTAL</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="progDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Detalle de Programación :: <small id="c_name"></small></h4>
            </div>
            <div class="modal-body">
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Vacaciones</p>
                    <p class="td-div-i" id="h_vacas"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Permisos</p>
                    <p class="td-div-i" id="h_perm"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Congreso/Capacitación</p>
                    <p class="td-div-i" id="h_cong"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Semanas disponibles</p>
                    <p class="td-div-i" id="h_semd"></p>
                </div>
                
                <div class="td-div no-bottom">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Horas Contratadas</p>
                    <p class="td-div-i" id="h_cont"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Médicos Universidad</p>
                    <p class="td-div-i" id="h_medu"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Becados</p>
                    <p class="td-div-i" id="h_bec"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Total Disponible</p>
                    <p class="td-div-i" id="h_disp"></p>
                </div>

                <div class="td-div no-bottom">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Atención Sala</p>
                    <p class="td-div-i" id="h_asala"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rasala"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Visitas Médicas</p>
                    <p class="td-div-i" id="h_tasala"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Consultas Nuevas</p>
                    <p class="td-div-i" id="h_cnueva"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rcnueva"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Total Consultas</p>
                    <p class="td-div-i" id="h_tcnueva"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Controles</p>
                    <p class="td-div-i" id="h_ctrl"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rctrl"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Total Controles</p>
                    <p class="td-div-i" id="h_tctrl"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Consulta Rend. Especial</p>
                    <p class="td-div-i" id="h_comit"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rcomit"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Total Consulta Rend. Especial</p>
                    <p class="td-div-i" id="h_tcomit"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Consultas Abreviadas</p>
                    <p class="td-div-i" id="h_cabrev"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rcabrev"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Total Consultas</p>
                    <p class="td-div-i" id="h_tcabrev"></p>
                </div>

                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Total Policlínico</p>
                    <p class="td-div-i" id="h_tpoli"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25 no-bottom">
                    <p class="td-div-t">Total Act. Policlínico</p>
                    <p class="td-div-i" id="h_tapoli"></p>
                </div>

                <div class="td-div no-bottom">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Procedimientos</p>
                    <p class="td-div-i" id="h_proc"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rproc"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">T. Procedimientos</p>
                    <p class="td-div-i" id="h_tproc"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Pabellón</p>
                    <p class="td-div-i" id="h_pab"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rpab"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">T. Pabellón</p>
                    <p class="td-div-i" id="h_tpab"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Teleconsulta</p>
                    <p class="td-div-i" id="h_telc"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rtelc"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">T. Teleconsulta</p>
                    <p class="td-div-i" id="h_ttelc"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Entrevistas Fam.</p>
                    <p class="td-div-i" id="h_entf"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rentf"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">T. Entrevistas</p>
                    <p class="td-div-i" id="h_tentf"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Consultoría</p>
                    <p class="td-div-i" id="h_consult"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rconsult"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">T. Consultoría</p>
                    <p class="td-div-i" id="h_tconsult"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Visitas Dom.</p>
                    <p class="td-div-i" id="h_visd"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rvisd"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">T. Visitas</p>
                    <p class="td-div-i" id="h_tvisd"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Intervención Dom.</p>
                    <p class="td-div-i" id="h_idom"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_ridom"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">T. Intervención</p>
                    <p class="td-div-i" id="h_tidom"></p>
                </div>

                <div class="td-div25">
                    <p class="td-div-t">Sala Exámenes</p>
                    <p class="td-div-i" id="h_sexam"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">Rendimiento</p>
                    <p class="td-div-i" id="h_rsexam"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>
                <div class="td-div25">
                    <p class="td-div-t">T. Sala</p>
                    <p class="td-div-i" id="h_tsexam"></p>
                </div>

                <div class="td-div">
                    <p class="td-div-t">Interc. Enlace</p>
                    <p class="td-div-i" id="h_inten"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Reuniones Clínicas</p>
                    <p class="td-div-i" id="h_rclin"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Administración</p>
                    <p class="td-div-i" id="h_admin"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Vis. Interconsultas</p>
                    <p class="td-div-i" id="h_visint"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Capacitación</p>
                    <p class="td-div-i" id="h_capac"></p>
                </div>

                <div class="td-div no-bottom">
                    <p class="td-div-t"></p>
                    <p class="td-div-i"></p>
                </div>

                <div class="td-div no-bottom">
                    <p class="td-div-t">TOTAL</p>
                    <p class="td-div-i" id="h_total"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="reports/view-planification.js"></script>