$(document).ready( function() {
    
    var options = {
        url: 'admin/files/ajax.insertFile.php',
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
        
        $.ajax({
            url: 'admin/files/ajax.getImportByDate.php',
            type: 'post',
            dataType: 'text',
            data: { pl: 1, date: $('#iNdate').val() }
        })
        .done( function(d) {
            if (parseInt(d, 10) > 0) {
                swal({
                    title: "La importación para la fecha elegida ya existe. ¿Está seguro que desea reemplazarla?",
                    text: "Esta acción borrará toda la programación de la fecha ingresada con anterioridad.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sí",
                    closeOnConfirm: true 
                }, function(confirm) {
                    if (!confirm) {
                        $('#iNdate').val('');
                        $('#gdate').removeClass('has-error has-success');
                        $('#icondate').removeClass('fa-remove fa-check');
                    }
                });
            }
        });
        
    });
    
    $('#iNdate').datepicker({
        startView: 1,
        minViewMode: 1,
        startDate: '-2m'
    }).on('changeDate', function () {
        if ($.trim($(this).val()) !== '') {
            $('#gdate').removeClass('has-error').addClass('has-success');
            $('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
        }
    });
    
    
    $('#formNewFile').submit( function() {
        $(this).ajaxSubmit(options);
        return false;
    });
    
    function validateForm(data, jF, o) {
        var files = true;
        var fieldVal = $(".multi").val();
        if (!fieldVal) files = false;

        if (files) {
            $('#submitLoader').css('display', 'inline-block');
            return true;
        }
        else {
            noty({
                text: 'Error al registrar documento. <br>Por favor, agregue al menos un archivo al formulario.',
                type: 'error'
            });
            return false;
        }
    }
    
    function showResponse(response) {
        $('#submitLoader').css('display', 'none');

        if (response.type === true) {
            noty({
                text: 'Los datos han sido importados con éxito.',
                type: 'success'
            });
            
            $('input:file').MultiFile('reset');
            $('#iNdate').val('');
            $('#gdate').removeClass('has-error has-success');
            $('#icondate').removeClass('fa-remove fa-check');
            $('#iNresult').html(response.msg);
        }
        else {
            noty({
                text: 'Hubo un problema al guardar el documento. <br>' + response.msg,
                type: 'error'
            });
        }
    }
});