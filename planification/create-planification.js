$(document).ready( function() {
    var options = {
        url: 'planification/ajax.insertPlanification.php',
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
        minViewMode: 1
    }).on('changeDate', function () {
        if ($.trim($(this).val()) !== '') {
            $('#gdate').removeClass('has-error').addClass('has-success');
            $('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
        }
    });
    
    $('#iNdesc, #iNcr, #iNserv, #iNesp').change( function() {
        var idn = $(this).attr('id').split('N');
        var val = $.trim($(this).val());
        
        if (val !== '') {
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });
    
    $('#iNcr').change( function() {
        $('#iNserv').html('').append('<option value="">Cargando servicios...</option>');
        $('#iNesp').html('').append('<option value="">Seleccione especialidad</option>');
        $('#gserv, #gesp').removeClass('has-error has-success');
        
        $.ajax({
            type        : "POST",
            url         : "planification/ajax.getServicios.php",
            dataType    : 'json',
            data        : { cr: $(this).val() }
        })
        .done( function(data) {
            $('#iNserv').html('').append('<option value="">Seleccione servicio</option>');
    
            $.each(data, function (k, v) {
                $('#iNserv').append(
                    $('<option></option>').val(v.ser_id).html(v.ser_nombre)
                );
            });
        });
    });
    
    $('#iNserv').change( function() {
        $('#iNesp').html('').append('<option value="">Cargando especialidades...</option>');
        $('#gesp').removeClass('has-error has-success');
        
        $.ajax({
            type        : "POST",
            url         : "planification/ajax.getEspecialidades.php",
            dataType    : 'json',
            data        : { serv: $(this).val() }
        })
        .done( function(data) {
            $('#iNesp').html('').append('<option value="">Seleccione especialidad</option>');
    
            $.each(data, function (k, v) {
                $('#iNesp').append(
                    $('<option></option>').val(v.esp_id).html(v.esp_nombre)
                );
            });
        });
    });
    
    $(document).on('keyup', '.input-number', function() {
        var v = this.value;
        if ($.isNumeric(v) === false) {
            this.value = this.value.slice(0,-1);
        }
    });
    
    $('.disp').change( function() {
        var tDisp = 0;
        var idn = $(this).attr('id').split('N');
        $('#g' + idn[1]).removeClass('has-error has-success');
        $('#icon' + idn[1]).removeClass('fa-remove fa-check');
        
        $('.disp').each( function() {
            var val = $.trim($(this).val());

            if (val !== '' && parseInt(val, 10) > 0) {
                tDisp += parseFloat($(this).val());
                $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
                $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
            }
        });
        
        var tmp = Math.round(tDisp/5);
        var semDisp = 50 - tmp;
        
        $('#iNsemdisp').val(semDisp);
    });
    
    $('#iNdisp, #iNuniversidad, #iNbecados').change( function() {
        var tDisp = 0;
        var idn = $(this).attr('id').split('N');
        var val = $.trim($(this).val());
        
        if (val !== '') {
            calTotal(idn[1]);
            
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
        
        $('.disponib').each( function() {
            var val = $.trim($(this).val());
            
            if (val !== '') {
                tDisp += parseFloat($(this).val());
            }
        });
        
        $('#iNtdisponible').val( tDisp.toFixed(2) );
        
        if (tDisp > 0) {
            $('#gtdisponible').addClass('has-success');
        }
        else {
            $('#gtdisponible').removeClass('has-success');
        }
    });

    $('.ind').change( function() {
        var tPoli = 0;
        var idn = $(this).attr('id').split('N');
        var val = $.trim($(this).val());
        
        if (val !== '') {
            calTotal(idn[1]);
            calTHoras();
            
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
        
        if( $('#iN' + idn[1]).hasClass('tpoli') ) {
            
            $('.tpoli').each( function() {
                var val = $.trim($(this).val());
                
                if (val !== '') {
                    tPoli += parseFloat($(this).val());
                }
            });
            
            $('#iNtpoli').val( tPoli.toFixed(2) );
            
            if (tPoli > 0) {
                $('#gtpoli').addClass('has-success');
            }
            else {
                $('#gtpoli').removeClass('has-success');
            }
        }
    });
    
    $('.rend').change( function() {
        var idn = $(this).attr('id').split('Nr');
        var val = $.trim($(this).val());
        
        if (val !== '') {
            calTotal(idn[1]);
            calTHoras();
            
            $('#gr' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#iconr' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#gr' + idn[1]).removeClass('has-success');
            $('#iconr' + idn[1]).removeClass('fa-check');
        }
    });
    
    $('.thor').change( function() {
        var idn = $(this).attr('id').split('N');
        var val = $.trim($(this).val());
        
        if (val !== '') {
            calTHoras();
            
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });
    
    
    $('#formNewProgram').submit( function() {
        $(this).ajaxSubmit(options);
        return false;
    });
    
    function validateForm(data, jF, o) {
        var values = true;
        
        if ($('#iNtdisponible').val() === '0.00' && $('#iNjustif').val() === '') {
            swal({
                title: "Error de Planificación",
                text: "No se ha ingresado una justificación para una planificación con cero horas disponibles.",
                type: "error",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Aceptar",
                closeOnConfirm: true
            });
            
            $('#gjustif').removeClass('has-success').addClass('has-error');
            
            values = false;
        }
        
        $('.ind').each( function() {
            var val = $.trim($(this).val());

            if (val !== '0.00') {
                var idn = $(this).attr('id').split('N');
                var rend = $.trim($('#iNr' + idn[1]).val());
                
                if (rend === '0.00') {
                    $('#gr' + idn[1]).addClass('has-error');
                    
                    swal({
                        title: "Error de Planificación",
                        text: "No se ha ingresado la totalidad de rendimientos para la planificación.",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: true
                    });

                values = false;
                }
            }
        });
        
        if ( $('#iNtdisponible').val() !== $('#iNtotal').val() ) {
            swal({
                title: "Error de Planificación",
                text: "La suma de las horas disponibles no coincide con la suma de distribución horaria.",
                type: "error",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Aceptar",
                closeOnConfirm: true
            });
            
            values = false;
        }

        if (values) {
            $('#submitLoader').css('display', 'inline-block');
            return true;
        }
        else {
            return false;
        }
    }
    
    function showResponse(response) {
        $('#submitLoader').css('display', 'none');

        if (response.type === true) {
            noty({
                text: 'La planificación ha sido guardada con éxito. Volviendo a lista de personas...',
                type: 'success',
                callback: {
                    afterClose: function () {
                        window.location = 'index.php?section=planif&sbs=listpeopleplanif';
                    }
                }
            });
        }
        else {
            noty({
                text: 'Hubo un problema al guardar la planificación. <br>' + response.msg,
                type: 'error'
            });
        }
    }
    
    
    function calTotal(id) {
        var tPoli = 0;
        var ind = parseFloat( $('#iN' + id).val() );
        var ren = parseFloat( $('#iNr' + id).val() );
        total = ind * ren;

        $('#iNt' + id).val( total.toFixed(2) );
        
        if (total > 0) {
            $('#gt' + id).addClass('has-success');
        }
        else {
            $('#gt' + id).removeClass('has-success');
        }
        
        if( $('#iNt' + id).hasClass('tactp') ) {
            
            $('.tactp').each( function() {
                tPoli += parseFloat($(this).val());
            });
            
            $('#iNtapoli').val( tPoli.toFixed(2) );
            
            if (tPoli > 0) {
                $('#gtapoli').addClass('has-success');
            }
            else {
                $('#gtapoli').removeClass('has-success');
            }
        }
    }
    
    function calTHoras() {
        var tHoras = 0;
        
        $('.ind').each( function() {
            var val = $.trim($(this).val());
            
            if (val !== '') {
                tHoras += parseFloat($(this).val());
            }
        });
        
        $('.thor').each( function() {
            var val = $.trim($(this).val());
            
            if (val !== '') {
                tHoras += parseFloat($(this).val());
            }
        });
        
        $('#iNtotal').val( tHoras.toFixed(2) );
        
        if (tHoras > 0) {
            $('#gtotal').addClass('has-success');
        }
        else {
            $('#gtotal').removeClass('has-success');
        }
    }
});