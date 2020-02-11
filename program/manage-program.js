$(document).ready(function () {
	var tableUsr = $("#tpeople").DataTable({
		"columns": [{width: "100px", className: "text-right"}, null, null, null, null, null, null, {"orderable": false, width: "70px", className: "text-center"}],
		'order': [[2, 'asc']]
	});

	var options = {
		url: 'program/ajax.getProgramByFilters.php',
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
		startDate: '-1y'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gyear').removeClass('has-error').addClass('has-success');
			$('#iconyear').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('#iNperiodo, #iNplanta, #iNcr, #iNserv, #iNesp').change(function () {
		var idn = $(this).attr('id').split('N');
		var val = $.trim($(this).val());

		if (val !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}
	});

	$('#iNcr').change(function () {
		$('#iNserv').html('').append('<option value="">Cargando servicios...</option>');
		$('#iNesp').html('').append('<option value="">Seleccione especialidad</option>');
		$('#gserv, #gesp').removeClass('has-error has-success');

		$.ajax({
			type: "POST",
			url: "program/ajax.getServicios.php",
			dataType: 'json',
			data: {cr: $(this).val()}
		}).done(function (data) {
			$('#iNserv').html('').append('<option value="">TODOS LOS SERVICIOS</option>');

			$.each(data, function (k, v) {
				$('#iNserv').append(
					$('<option></option>').val(v.ser_id).html(v.ser_nombre)
				);
			});
		});
	});

	$('#iNserv').change(function () {
		$('#iNesp').html('').append('<option value="">Cargando especialidades...</option>');
		$('#gesp').removeClass('has-error has-success');

		$.ajax({
			type: "POST",
			url: "program/ajax.getEspecialidades.php",
			dataType: 'json',
			data: {serv: $(this).val()}
		}).done(function (data) {
			$('#iNesp').html('').append('<option value="">TODAS LAS ESPECIALIDADES</option>');

			$.each(data, function (k, v) {
				$('#iNesp').append(
					$('<option></option>').val(v.esp_id).html(v.esp_nombre)
				);
			});
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
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');
		tableUsr.clear();

		if (response !== null) {
			$.each(response, function (k, v) {
				tableUsr.row.add([
					v.per_rut,
					v.per_nombres,
					v.per_profesion,
					v.per_servicio,
					v.per_especialidad,
					v.per_ley,
					v.pes_horas,
					'<a class="peopleProgram btn btn-xs btn-success" href="index.php?section=program&sbs=editprogram&id=' + v.disp_id + '" data-tooltip="tooltip" data-placement="top" title="Editar Programación"><i class="fa fa-pencil"></i></a>'
				]);
			});

		}

		tableUsr.draw();
	}
});