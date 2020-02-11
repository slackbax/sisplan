$(document).ready( function() {
    
    var options = {
        url: 'admin/people/ajax.insertPeople.php',
        type: 'post',
        dataType: 'json',
        beforeSubmit: validateForm,
        success: showResponse
    };
    
    $('#submitLoader').css('display', 'none');
    
    $('#iNrut').blur( function() {
        $('#grut').removeClass('has-success has-error');
        $('#iconrut').removeClass('fa-remove fa-check');
        
        if ($(this).val() !== '') {
            $.ajax({
                url: 'admin/clients/ajax.getPeopleByRut.php',
                type: 'post',
                dataType: 'json',
                data: { rut: $(this).val() }
            })
            .done( function(d) {
                if (d.cli_id !== null) {
                    swal("Error!", "El RUT ingresado corresponde a una persona ya registrada.", "error");
                    $('#iNrut').val('');
                    $('#grut').addClass('has-error');
                    $('#iconrut').addClass('fa-remove');
                }
            });
        }
    })
    .Rut({
        on_error: function() {
            swal("Error!", "El RUT ingresado no es válido.", "error");
            $('#iNrut').val('');
            $('#grut').addClass('has-error');
            $('#iconrut').addClass('fa-remove');
        },
        on_success: function() {
            $('#grut').addClass('has-success');
            $('#iconrut').addClass('fa-check');
        },
        format_on: 'keyup'
    });
    
    $('#iNespecialidad').change( function() {
        $('#iNsubesp').html('').append('<option value="">Cargando sub-especialidades...</option>');
        
        $.ajax({
            type        : "POST",
            url         : "admin/people/ajax.getSubesp.php",
            dataType    : 'json',
            data        : { id: $(this).val() }
        })
        .done(function (data) {
            $('#iNsubesp').html('').append('<option value="">Seleccione sub-especialidad</option>');

            $.each(data, function (k, v) {
                $('#iNsubesp').append(
                    $('<option></option>').val(v.sesp_id).html(v.sesp_descripcion)
                );
            });
        });
    });

    $('#iNname, #iNap, #iNam, #iNespecialidad, #iNsubesp').change( function() {
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
        $('#grut, #gname, #gap, #gam, #gespecialidad, #gsubesp').removeClass('has-error').removeClass('has-success');
        $('#iconrut, #iconname, #iconap, #iconam').removeClass('fa-remove').removeClass('fa-check');
    });
    
    
    $('#formNewPeople').submit( function() {
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
            noty({
                text: 'La persona ha sido guardado con éxito.',
                type: 'success'
            });

            $('#formNewPeople').clearForm();
            $('#btnClear').click();
        }
        else {
            noty({
                text: 'Hubo un problema al guardar la persona. <br>' + response.msg,
                type: 'error'
            });
        }
    }
});