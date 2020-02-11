$(document).ready(function () {
    var tableUsr = $("#tpeople").DataTable({
        "columns": [{ width: "100px", className: "text-right" }, null, null, null, null, null, { "orderable": false, width: "70px", className: "text-center" }],
        'order': [[1, 'asc']]
    });

    var options = {
        url: 'program/ajax.getPeopleByDate.php',
        type: 'post',
        dataType: 'json',
        beforeSubmit: validateForm,
        success: showResponse
    };

    $('#submitLoader, #submitLoader2, #btncopy').css('display', 'none');

	$(document).on("focusin", "#iNyear", function () {
		$(this).prop('readonly', true);
	});
	$(document).on("focusout", "#iNyear", function () {
		$(this).prop('readonly', false);
	});

	$('#iNyear').datepicker({
		startView: 2,
		minViewMode: 2,
		startDate: '2019'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gyear').removeClass('has-error').addClass('has-success');
			$('#iconyear').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

    $('#iNperiodo, #iNplanta').change(function () {
        var idn = $(this).attr('id').split('N');

        if ($.trim($(this).val()) !== '') {
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        } else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });


    $('#formNewProgram').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

    function validateForm() {
        var values = true;

        if (values) {
            $('#submitLoader').css('display', 'inline-block');
            return true;
        } else {
			new Noty({
                text: 'Error al consultar datos. <br>Por favor, revise la fecha de consulta.',
                type: 'error'
            }).show();
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
                    v.per_profesion,
                    v.con_descripcion,
                    v.pes_correlativo,
                    v.pes_horas,
                    '<a class="peopleProgram btn btn-xs btn-success" href="index.php?section=program&sbs=createprogram&id=' + v.pes_id + '&date_ini=' + response.fecha_ini + '&date_ter=' + response.fecha_ter + '" data-tooltip="tooltip" data-placement="top" title="Programar"><i class="fa fa-pencil"></i></a>'
                ]);
            });

            $('#btncopy').css('display', 'block');
        }

        tableUsr.draw();
    }
});