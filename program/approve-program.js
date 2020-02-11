$(document).ready(function () {
	var tableProg = $("#tprogram").DataTable({
		"columns": [
			{"width": "320px"}, null,
			null, null,
			{className: "text-center"}, {className: "text-center"},
			{"visible": false}, {"visible": false},
			{className: "text-center"}, //horas disponibles
			{"visible": false},
			{"visible": false}, //10
			{"visible": false},
			{className: "text-center"}, //total policlinico 12
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false}, //30
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, // 40
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, {"visible": false},
			{"visible": false}, {"visible": false}, // 60
			{className: "text-center"}, //total
			{"orderable": false, width: "50px", className: "text-center"}], //62
		'order': [[0, 'asc']]/*,
		'buttons': [
			{
				extend: 'excel',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11,
						12, 13, 14, 15, 16, 17, 18, 19, 20, 21,
						22, 23, 24, 25, 26, 27, 28, 29, 30, 31,
						32, 33, 34, 35, 36]
				}
			}
		]
		*/
	});

	$('#submitLoader').css('display', 'none');

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

	$('#iNperiodo, #iNplanta, #iNappr, #iNest').change(function () {
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

	$("#tprogram").on('click', '.approve', function () {
		var fid = $(this).attr('id').split("_").pop();

		swal({
			title: "¿Está seguro de ejecutar la aprobación?",
			text: "Esta acción aprobará definitivamente la programación asociada a este funcionario.",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Sí"
		}).then(function (result) {
			if (!result.dismiss) {
				$.ajax({
					type: 'POST',
					url: "program/ajax.approveProgram.php",
					dataType: 'json',
					data: {id: fid}
				}).done(function (msg) {
					if (msg.type) {
						new Noty({
							text: 'La aprobación ha sido guardada con éxito.',
							type: 'success'
						}).show();
					} else {
						new Noty({
							text: 'Error al registrar aprobación. <br>Por favor, inténtelo más tarde.',
							type: 'error'
						}).show();
					}

					$('#btnsubmit').click();
				});
			}
		});
	});

	$('#btnsubmit').click(function () {
		tableProg.ajax.url('program/ajax.getServerApproveProgram.php?iyear=' + $('#iNyear').val() + '&iperiodo=' + $('#iNperiodo').val() + '&iplanta=' + $('#iNplanta').val() + '&iappr=' + $('#iNappr').val() + '&iest=' + $('#iNest').val()).load();
	});
});