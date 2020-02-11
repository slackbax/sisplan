$(document).ready( function() {
    
    var options = {
        url: 'program/ajax.insertDiagnosis.php',
        type: 'post',
        dataType: 'json',
        beforeSubmit: validateForm,
        success: showResponse
    };
    
    $(document).on('keyup', '.input-number', function() {
        var v = this.value;
        if ($.isNumeric(v) === false) {
            this.value = this.value.slice(0,-1);
        }
    });
    
    $('#submitLoader').css('display', 'none');
    
    $(document).on("focusin", "#iNdate", function () {
        $(this).prop('readonly', true);
    });
    $(document).on("focusout", "#iNdate", function () {
        $(this).prop('readonly', false);
    });
    
    $('#iNdate').datepicker({
        startView: 2,
        minViewMode: 2
    }).on('changeDate', function () {
        $('#gdate').removeClass('has-error').addClass('has-success');
        $('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
            
        if ($.trim($(this).val()) !== '' && $('#iNserv').val() !== '') {
            $.ajax({
                type        : "POST",
                url         : "program/ajax.getEspNoDiagno.php",
                dataType    : 'json',
                data        : { idate: $(this).val(), iserv: $('#iNserv').val() }
            })
            .done(function (data) {
                $('#iNesp').html('').append('<option value="">Seleccione especialidad</option>');

                $.each(data, function (k, v) {
                    $('#iNesp').append(
                        $('<option></option>').val(v.esp_id).html(v.esp_nombre)
                    );
                });
            });
        }
    });
    
    $('#iNserv').change( function() {
        if ($.trim($(this).val()) !== '' && $('#iNdate').val() !== '') {
            $.ajax({
                type        : "POST",
                url         : "program/ajax.getEspNoDiagno.php",
                dataType    : 'json',
                data        : { idate: $('#iNdate').val(), iserv: $(this).val() }
            })
            .done(function (data) {
                $('#iNesp').html('').append('<option value="">Seleccione especialidad</option>');

                $.each(data, function (k, v) {
                    $('#iNesp').append(
                        $('<option></option>').val(v.esp_id).html(v.esp_nombre)
                    );
                });
            });
        }
    });
    
    $('.sum').change( function() {
        var idn = $(this).attr('id').split('N');
        var val = $.trim($(this).val());
        
        if (val !== '') {
            calTotal();
            
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });
    
    $('.sumiq').change( function() {
        var idn = $(this).attr('id').split('N');
        var val = $.trim($(this).val());
        
        if (val !== '') {
            calTotalIQ();
            
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });
    
    $('.sumhes').change( function() {
        var idn = $(this).attr('id').split('N');
        var val = $.trim($(this).val());
        
        if (val !== '') {
            calTotalHes();
            
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });
    

    $('#iNserv, #iNtat, #iNges, #iNesp, #iNtiq, #iNgesiq, #iNespiq, #iNtaa, #iNtac, #iNtpro').change( function() {
        var idn = $(this).attr('id').split('N');
        
        if ($.trim($(this).val()) !== '') {
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        }
        else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });

    $('#btnClear').click( function() {
        $('#gdate, #gserv, #gtat, #gges, #gesp, #gtotal, #gtiq, #ggesiq, #gtotaliq, #gtaa, #gtac, #gtpro, #gtesp').removeClass('has-error').removeClass('has-success');
        $('#icondate, #icontat, #iconges, #icontotal, #icontiq, #icongesiq, #icontotaliq, #icontaa, #icontac, #icontpro, #icontesp').removeClass('fa-remove').removeClass('fa-check');
    });
    
    
    $('#formNewDiagno').submit( function() {
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
            return false;
        }
    }
    
    function showResponse(response) {
        $('#submitLoader').css('display', 'none');

        if (response.type === true) {
			new Noty({
                text: 'El diagnóstico ha sido guardado con éxito.',
                type: 'success'
            }).show();

            $('#formNewDiagno').clearForm();
            $('#btnClear').click();
        }
        else {
			new Noty({
                text: response.msg,
                type: 'error'
            }).show();
        }
    }
    
    function calTotal() {
        var t = 0;
        
        $('.sum').each( function() {
            var val = $.trim($(this).val());
            
            if (val !== '') {
                t += parseInt($(this).val(), 10);
            }
        });
        
        $('#iNtotal').val( number_format(t, 0, '', '.') );
        
        if (t > 0) {
            $('#gtotal').addClass('has-success');
        }
        else {
            $('#gtotal').removeClass('has-success');
        }
    }
    
    function calTotalIQ() {
        var t = 0;
        
        $('.sumiq').each( function() {
            var val = $.trim($(this).val());
            
            if (val !== '') {
                t += parseInt($(this).val(), 10);
            }
        });
        
        $('#iNtotaliq').val( number_format(t, 0, '', '.') );
        
        if (t > 0) {
            $('#gtotaliq').addClass('has-success');
        }
        else {
            $('#gtotaliq').removeClass('has-success');
        }
    }
    
    function calTotalHes() {
        var t = 0;
        
        $('.sumhes').each( function() {
            var val = $.trim($(this).val());
            
            if (val !== '') {
                t += parseInt($(this).val(), 10);
            }
        });
        
        $('#iNtesp').val( number_format(t, 0, '', '.') );
        
        if (t > 0) {
            $('#gtesp').addClass('has-success');
        }
        else {
            $('#gtesp').removeClass('has-success');
        }
    }
});