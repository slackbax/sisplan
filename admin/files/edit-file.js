$(document).ready(function () {

	var options = {
		url: 'admin/files/ajax.editFile.php',
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

	$(document).on("focusin", "#iNdatec", function (event) {
		$(this).prop('readonly', true);
	});
	$(document).on("focusout", "#iNdatec", function (event) {
		$(this).prop('readonly', false);
	});

	$('#iNdate').datepicker({
		endDate: '+1d'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdate').removeClass('has-error').addClass('has-success');
			;
			$('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('#iNdatec').datepicker({
		startView: 1,
		minViewMode: 1,
		startDate: '+1m'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdatec').removeClass('has-error').addClass('has-success');
			;
			$('#icondatec').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('#iNname, #iNversion, #iNcode, #iNdate, #iNdatec, #iNambito, #iNsambito, #iNtcar, #iNtcode').change(function () {
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

	$('#iNambito').change(function () {
		$('#iNsambito').html('').append('<option value="">Cargando sub-ámbitos...</option>');
		$('#gsambito').removeClass('has-error').removeClass('has-success');
		$('#iNtcar').html('').append('<option value="">Seleccione tipo</option>');
		$('#gtcar').removeClass('has-error').removeClass('has-success');
		$('#iNtcode').html('').append('<option value="">Seleccione código</option>');
		$('#gtcode').removeClass('has-error').removeClass('has-success');
		$('#iNdescription').val('');

		$('.ipv_check').each(function () {
			$(this).prop('checked', false);
		});

		$.ajax({
			type: "POST",
			url: "admin/files/ajax.getSubambitos.php",
			dataType: 'json',
			data: {am: $(this).val()}
		})
			.done(function (data) {
				$('#iNsambito').html('').append('<option value="">Seleccione sub-ámbito</option>');

				$.each(data, function (k, v) {
					$('#iNsambito').append(
						$('<option></option>').val(v.samb_id).html(v.samb_sigla + ' - ' + v.samb_nombre)
					);
				});
			});
	});

	$('#iNsambito').change(function () {
		$('#iNtcar').html('').append('<option value="">Cargando tipo...</option>');
		$('#gtcar').removeClass('has-error').removeClass('has-success');
		$('#iNtcode').html('').append('<option value="">Seleccione código</option>');
		$('#gtcode').removeClass('has-error').removeClass('has-success');
		$('#iNdescription').val('');

		$('.ipv_check').each(function () {
			$(this).prop('checked', false);
		});

		$.ajax({
			type: "POST",
			url: "admin/files/ajax.getTipoCaracts.php",
			dataType: 'json',
			data: {sa: $(this).val()}
		})
			.done(function (data) {
				$('#iNtcar').html('').append('<option value="">Seleccione tipo</option>');

				$.each(data, function (k, v) {
					$('#iNtcar').append(
						$('<option></option>').val(v.tcar_id).html(v.tcar_nombre)
					);
				});
			});
	});

	$('#iNtcar').change(function () {
		$('#iNtcode').html('').append('<option value="">Cargando códigos...</option>');
		$('#gtcode').removeClass('has-error').removeClass('has-success');
		$('#iNdescription').val('');

		$('.ipv_check').each(function () {
			$(this).prop('checked', false);
		});

		$.ajax({
			type: "POST",
			url: "admin/files/ajax.getCodigos.php",
			dataType: 'json',
			data: {sa: $('#iNsambito').val(), tc: $(this).val()}
		})
			.done(function (data) {
				$('#iNtcode').html('').append('<option value="">Seleccione código</option>');

				$.each(data, function (k, v) {
					$('#iNtcode').append(
						$('<option></option>').val(v.cod_id).html(v.cod_descripcion)
					);
				});
			});
	});

	$('#iNtcode').change(function () {
		$('#iNdescription').val('');

		$('.ipv_check').each(function () {
			$(this).prop('checked', false);
		});

		if ($(this).val() !== '') {
			$.ajax({
				type: "POST",
				url: "admin/files/ajax.getCaracteristica.php",
				dataType: 'json',
				data: {sa: $('#iNsambito').val(), cod: $(this).val()}
			})
				.done(function (data) {
					$('#iind').val(data.ind_id);
					$('#iNdescription').val(data.samb_sigla + ' ' + data.cod_descripcion + '\n- ' + data.ind_descripcion);

					$.each(data.pvs, function (k, v) {
						$('#ipvs_' + v.pv_id).prop('checked', true);
					});
				});
		}
	});

	$('#btnClear').click(function () {
		$('#gname, #gversion, #gcode, #gdate, #gdatec, #gambito, #gsambito, #gtcar, #gtcode').removeClass('has-error').removeClass('has-success');
		$('#iconname, #iconversion, #iconcode, #icondate, #icondatec, #iconambito, #iconsambito, #icontcar, #icontcode').removeClass('fa-remove').removeClass('fa-check');
	});


	$('#formEditFile').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});

	function validateForm(data, jF, o) {
		var files = true;

		if (files) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		}
		else {
			new Noty({
				text: '<b>¡Error!</b><br>Por favor, agregue al menos un archivo al formulario.',
				type: 'error'
			}).show();

			return false;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type === true) {
			new Noty({
				text: '<b>¡Éxito!</b><br> El archivo ha sido guardado correctamente.',
				type: 'success'
			}).show();
		}
		else {
			new Noty({
				text: '<b>¡Error!</b><br>' + response.msg,
				type: 'error'
			}).show();
		}
	}
});