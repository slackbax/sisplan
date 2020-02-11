$(document).ready(function () {
    var tableUsr = $("#tpeople").DataTable({
        "columns": [{width: "100px", className: "text-right", "orderable": false}, {width: "20%"}, null, null, null, {"orderable": false, width: "70px", className: "text-center"}],
        'order': [[2, 'asc']]
    });

    var options = {
        url: 'planification/ajax.getPeopleByDate.php',
        type: 'post',
        dataType: 'json',
        beforeSubmit: validateForm,
        success: showResponse
    };

    $('#submitLoader, #submitLoader2, #btncopy').css('display', 'none');

    $(document).on("focusin", "#iNdate", function (event) {
        $(this).prop('readonly', true);
    });
    $(document).on("focusout", "#iNdate", function (event) {
        $(this).prop('readonly', false);
    });

    $('#iNdate').datepicker({
        startView: 1,
        minViewMode: 1,
        startDate: '-1y'
    }).on('changeDate', function () {
        if ($.trim($(this).val()) !== '') {
            $('#gdate').removeClass('has-error').addClass('has-success');
            $('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
        }
    });

    $('#iNplanta').change(function () {
        var idn = $(this).attr('id').split('N');

        if ($.trim($(this).val()) !== '') {
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        } else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });

    $('#btncopy').click(function () {

        swal({
            title: "¿Está seguro que desea copiar la planificación?",
            text: "Esta acción no puede ser revertida. Sólo serán copiadas las planificaciones no ingresadas para este mes.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: "planification/ajax.copyPlanification.php",
                    dataType: 'json',
                    data: {date: $('#iNdate').val(), pl: $('#iNplanta').val()}
                })
                .done(function (data) {
                    if (data.type) {
                        swal({
                            title: "Éxito",
                            text: "La planificación ha sido realizada con éxito. Un total de " + data.msg + " distribuciones fueron copiadas.",
                            html: true,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: true
                        },
                        function () {
                            $('#btnsubmit').click();
                        });
                    }
                    else {
                        
                    }
                });
            }
        });
    });


    $('#formNewProgram').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

    function validateForm(data, jF, o) {
        var values = true;

        if (values) {
            $('#submitLoader').css('display', 'inline-block');
            return true;
        } else {
            noty({
                text: 'Error al consultar datos. <br>Por favor, revise la fecha de consulta.',
                type: 'error'
            });
            return false;
        }
    }

    function showResponse(response) {
        $('#submitLoader').css('display', 'none');
        tableUsr.clear();

        if (response !== null) {

            $.each(response.data, function (k, v) {
                tableUsr.row.add([
                    v.per_rut,
                    v.per_nombres,
                    v.per_ap,
                    v.per_am,
                    v.per_profesion,
                    '<a class="peopleProgram btn btn-xs btn-info" href="index.php?section=planif&sbs=createplanification&id=' + v.per_id + '&date=' + response.fecha + '" data-tooltip="tooltip" data-placement="top" title="Planificar"><i class="glyphicon-pencil no-mr"></i></a>'
                ]);
            });

            $('#btncopy').css('display', 'block');
        }

        tableUsr.draw();
    }

    //Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
});