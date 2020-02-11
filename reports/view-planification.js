$(document).ready( function() {
    var tableProg = $("#tprogram").DataTable({
        "columns": [ { "width": "320px" }, null,
                    null, null,
                    { className: "text-center" }, { "visible": false },
                    { "visible": false }, { className: "text-center" },
                    { "visible": false }, { "visible": false }, 
                    { "visible": false }, { "visible": false },
                    { "visible": false }, { className: "text-center" },
                    { "visible": false }, { "visible": false },
                    { "visible": false }, { "visible": false },
                    { "visible": false }, { "visible": false },
                    { "visible": false }, { "visible": false },
                    { "visible": false }, { "visible": false },
                    { "visible": false }, { "visible": false },
                    { "visible": false }, { className: "text-center" },
                    { "orderable": false, width: "50px", className: "text-center" } ],
        'order': [[ 0, 'asc' ]],
        'buttons': [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11,
                                12, 13, 14, 15, 16, 17, 18, 19, 20, 21,
                                22, 23, 24, 25, 26, 27 ]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 13, 27 ]
                }
            }
        ]
    });
    
    var options = {
        url: 'reports/ajax.getServerPlanification.php',
        type: 'post',
        dataType: 'json',
        beforeSubmit: validateForm,
        success: showResponse
    };
    
    $('#submitLoader').css('display', 'none');
    
    $(document).on("focusin", "#iNdate", function (event) {
        $(this).prop('readonly', true);
    });
    $(document).on("focusout", "#iNdate", function (event) {
        $(this).prop('readonly', false);
    });
    
    $('#iNdate').datepicker({
        startView: 1,
        minViewMode: 1,
    }).on('changeDate', function () {
        if ($.trim($(this).val()) !== '') {
            $('#gdate').removeClass('has-error').addClass('has-success');
            ;
            $('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
        }
    });
    
    $("#tprogram").on('click', '.programModal', function() {
        var fid = $(this).attr('id').split("_").pop();
        
        $('.td-div-i').each( function() {
            $(this).html('');
        });

        $.ajax( {
            url:        'reports/ajax.getPlanification.php',
            type:       'POST',
            dataType:   'json',
            data:       { id: fid }
        })
        .done( function(d) {
            console.log(d);
            
            $('#h_cont').html(d.th1['dh_cantidad']);
            $('#h_medu').html(d.th2['dh_cantidad']);
            $('#h_bec').html(d.th3['dh_cantidad']);
            $('#h_disp').html(d.tdisp);
            
            $('#h_asala').html(d.th4['dh_cantidad']);
            $('#h_rasala').html(d.th4['dh_rendimiento']);
            $('#h_tasala').html(d.th4['dh_total']);
            
            $('#h_cnueva').html(d.th5['dh_cantidad']);
            $('#h_rcnueva').html(d.th5['dh_rendimiento']);
            $('#h_tcnueva').html(d.th5['dh_total']);
            
            $('#h_ctrl').html(d.th6['dh_cantidad']);
            $('#h_rctrl').html(d.th6['dh_rendimiento']);
            $('#h_tctrl').html(d.th6['dh_total']);
            
            $('#h_comit').html(d.th7['dh_cantidad']);
            $('#h_rcomit').html(d.th7['dh_rendimiento']);
            $('#h_tcomit').html(d.th7['dh_total']);
            
            $('#h_cabrev').html(d.th8['dh_cantidad']);
            $('#h_rcabrev').html(d.th8['dh_rendimiento']);
            $('#h_tcabrev').html(d.th8['dh_total']);

            $('#h_tpoli').html(d.tpoli);
            $('#h_tapoli').html(d.tapoli);
            
            $('#h_proc').html(d.th9['dh_cantidad']);
            $('#h_rproc').html(d.th9['dh_rendimiento']);
            $('#h_tproc').html(d.th9['dh_total']);
            
            $('#h_pab').html(d.th10['dh_cantidad']);
            $('#h_rpab').html(d.th10['dh_rendimiento']);
            $('#h_tpab').html(d.th10['dh_total']);
            
            $('#h_telc').html(d.th11['dh_cantidad']);
            $('#h_rtelc').html(d.th11['dh_rendimiento']);
            $('#h_ttelc').html(d.th11['dh_total']);
            
            $('#h_entf').html(d.th12['dh_cantidad']);
            $('#h_rentf').html(d.th12['dh_rendimiento']);
            $('#h_tentf').html(d.th12['dh_total']);
            
            $('#h_consult').html(d.th13['dh_cantidad']);
            $('#h_rconsult').html(d.th13['dh_rendimiento']);
            $('#h_tconsult').html(d.th13['dh_total']);
            
            $('#h_visd').html(d.th14['dh_cantidad']);
            $('#h_rvisd').html(d.th14['dh_rendimiento']);
            $('#h_tvisd').html(d.th14['dh_total']);
            
            $('#h_idom').html(d.th15['dh_cantidad']);
            $('#h_ridom').html(d.th15['dh_rendimiento']);
            $('#h_tidom').html(d.th15['dh_total']);
            
            $('#h_sexam').html(d.th16['dh_cantidad']);
            $('#h_rsexam').html(d.th16['dh_rendimiento']);
            $('#h_tsexam').html(d.th16['dh_total']);
            
            $('#h_inten').html(d.th17['dh_cantidad']);
            $('#h_rclin').html(d.th18['dh_cantidad']);
            $('#h_admin').html(d.th19['dh_cantidad']);
            $('#h_visint').html(d.th20['dh_cantidad']);
            $('#h_capac').html(d.th21['dh_cantidad']);
            
            $('#h_total').html(d.total);
        });
    });
    
    $('#formNewProgram').submit( function() {
        $(this).ajaxSubmit(options);
        return false;
    });
    
    function validateForm(data, jF, o) {
        var values = true;

        if (values) {
            $('#submitLoader').css('display', 'inline-block');
            return true;
        }
        else {
            noty({
                text: 'Error al consultar datos. <br>Por favor, revise la fecha de consulta.',
                type: 'error'
            });
            return false;
        }
    }
    
    function showResponse(response) {
        $('#submitLoader').css('display', 'none');
        tableProg.clear();
        
        if (response !== null) {

            $.each(response.data, function(k, v){
                tableProg.row.add( [
                    v[0], v[1], v[2], v[3], v[4], v[5], v[6], v[7], v[8], v[9], v[10],
                    v[11], v[12], v[13], v[14], v[15], v[16], v[17], v[18], v[19], v[20],
                    v[21], v[22], v[23], v[24], v[25], v[26], v[27], v[28]
                ] );
            });
        }
        
        tableProg.draw();
    }

    //Check to see if the window is top if not then display button
    $(window).scroll( function() {
        if ($(this).scrollTop() > 200) {
            $('.scrollToTop').fadeIn();
        } 
        else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click( function() {
        $('html, body').animate({scrollTop : 0}, 800);
        return false;
    });
});