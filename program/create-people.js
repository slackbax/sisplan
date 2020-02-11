$(document).ready(function () {

	var options = {
		url: 'program/ajax.insertPeople.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$('#iNrut').change(function () {
		$('#grut, #gname, #gprofesion, #gespec, #gtcontrato, #gcorr, #ghoras').removeClass('has-success has-error');
		$('#iconrut, #iconname, #iconespec, #iconcorr, #iconhoras').removeClass('fa-remove fa-check');
		$('#iNid, #iNname, #iNprofesion, #iNespec, #iNtcontrato, #iNcorr, #iNhoras').val('');

		if ($('#iNrut').val() !== '') {
			$.ajax({
				url: 'program/ajax.getPeopleByRut.php',
				type: 'post',
				dataType: 'json',
				data: {rut: $("#iNrut").val()}
			}).done(function (d) {
				if (d.per_id !== null) {
					$('#iNid').val(d.per_id);
					$('#iNname').val(d.per_nombres);
					$('#iNprofesion').val(d.per_profid);
					$('#iNespec').val(d.per_sis);
					$('#grut, #gname, #gprofesion, #gespec').addClass('has-success');
					$('#iconrut, #iconname, #iconespec').addClass('fa-check');
				}
			});
		}
	}).Rut({
		on_error: function () {
			swal({
				title: "Error!",
				html: "El RUT ingresado no es válido.",
				type: "error"
			});

			$('#iNrut').val('');
			$('#grut').addClass('has-error');
			$('#iconrut').addClass('fa-remove');
		}, on_success: function () {
			$('#grut').addClass('has-success');
			$('#iconrut').addClass('fa-check');
		}, format_on: 'keyup'
	});

	$('#iNcorr').change(function () {
		var $rut = $('#iNrut'), $con = $('#iNtcontrato');

		if ($rut.val() !== '' && $con.val() !== '' && $(this).val() !== '') {
			$.ajax({
				url: 'program/ajax.getPeopleByRutLey.php',
				type: 'post',
				dataType: 'json',
				data: {rut: $rut.val(), con: $con.val(), corr: $(this).val()}
			}).done(function (d) {
				if (d.per_id !== null) {
					swal({
						title: "Error!",
						html: "El RUT ingresado corresponde a una persona ya registrada bajo este correlativo y modalidad de contrato en este establecimiento.",
						type: "error"
					});

					$('#iNcorr').val('');
					$('#gcorr').addClass('has-error');
					$('#iconcorr').addClass('fa-remove');
				}
			});
		}
	});

	$('#iNname, #iNprofesion, #iNtcontrato, #iNcorr, #iNhoras').change(function () {
		var idn = $(this).attr('id').split('N');

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}
	});

	$('#btnClear').click(function () {
		$('#grut, #gname, #gprofesion, #gespec, #gtcontrato, #gcorr, #ghoras').removeClass('has-error').removeClass('has-success');
		$('#iconrut, #iconname, #iconespec, #iconcorr, #iconhoras').removeClass('fa-remove').removeClass('fa-check');
	});

	$('#formNewPeople').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});

	function validateForm() {
		var values = true;

		if (values) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		} else {
			return false;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type === true) {
			new Noty({
				text: 'La persona ha sido guardada con éxito.',
				type: 'success'
			}).show();

			$('#formNewPeople').clearForm();
			$('#btnClear').click();
		} else {
			new Noty({
				text: 'Hubo un problema al guardar la persona. <br>' + response.msg,
				type: 'error'
			}).show();
		}
	}
});