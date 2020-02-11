$(document).ready(function () {
	function validateForm() {
		var values = true;

		if ($('#iNtdisponible').val() === '0.00' && $('#iNjustif').val() === '') {
			swal({
				title: "Error de Programación",
				text: "No se ha ingresado una justificación para una programación con cero horas disponibles.",
				type: "error",
				showCancelButton: false,
				confirmButtonText: "Aceptar"
			});

			$('#gjustif').removeClass('has-success').addClass('has-error');

			values = false;
		}

		$('.ind').each(function () {
			var val = $.trim($(this).val());

			if (val !== '0.00') {
				var idn = $(this).attr('id').split('N');
				var rend = $.trim($('#iNr' + idn[1]).val());

				if (rend === '0.00') {
					$('#gr' + idn[1]).addClass('has-error');
					$('#iconr' + idn[1]).addClass('fa-remove');

					swal({
						title: "Error de Programación",
						text: "No se ha ingresado la totalidad de rendimientos para la programación.",
						type: "error",
						showCancelButton: false,
						confirmButtonText: "Aceptar"
					});

					values = false;
				}
			}
		});

		$('.ind-proc').each(function () {
			var val = $.trim($(this).val());
			var idn = $(this).attr('id').split('N');

			if (val !== '0.00') {
				var obs = $.trim($('#iNo' + idn[1]).val());
				if (obs === '') {
					$('#go' + idn[1]).addClass('has-error');
					$('#icono' + idn[1]).addClass('fa-remove');

					swal({
						title: "Error de Programación",
						text: "No se ha ingresado la totalidad de nombres de procedimientos para la programación.",
						type: "error",
						showCancelButton: false,
						confirmButtonText: "Aceptar"
					});

					values = false;
				}
			}
		});

		if ($('#iNtdisponible').val() !== $('#iNtotal').val()) {
			swal({
				title: "Error de Programación",
				text: "La suma de las horas disponibles no coincide con la suma de distribución horaria.",
				type: "error",
				showCancelButton: false,
				confirmButtonText: "Aceptar"
			});

			values = false;
		}

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
				text: 'La programación ha sido guardada con éxito. Volviendo a lista de personas...',
				type: 'success',
				callbacks: {
					afterClose: function () {
						window.location = 'index.php?section=program&sbs=listpeople';
					}
				}
			}).show();
		} else {
			new Noty({
				text: 'Hubo un problema al guardar la programación. <br>' + response.msg,
				type: 'error'
			}).show();
		}
	}

	function calTotal(id) {
		var tPoli = 0;
		var tAPoli = 0;
		var ind = parseFloat($('#iN' + id).val());
		var ren = parseFloat($('#iNr' + id).val());
		if (isNaN(ren)) {
			ren = 1;
		}
		var total = ind * ren;

		var hDispA = parseFloat($.trim($('#iNsemdisp').val()));
		var anual = total * hDispA;

		$('#iNt' + id).val(total.toFixed(2));
		$('#iNta' + id).val(anual.toFixed(2));

		if ($('#iNbrproy').val() !== undefined) {
			calBrecha();
		}

		if (total > 0) {
			$('#gt' + id).addClass('has-success');
			$('#gta' + id).addClass('has-success');
		} else {
			$('#gt' + id).removeClass('has-success');
			$('#gta' + id).removeClass('has-success');
		}

		if ($('#iNt' + id).hasClass('tactp')) {

			$('.tactp').each(function () {
				tPoli += parseFloat($(this).val());
				tAPoli += parseFloat($(this).val()) * hDispA;
			});

			$('#iNtapoli').val(tPoli.toFixed(2));
			$('#iNtaapoli').val(tAPoli.toFixed(2));

			if (tPoli > 0) {
				$('#gtapoli, #gtaapoli').addClass('has-success');
			} else {
				$('#gtapoli, #gtaapoli').removeClass('has-success');
			}
		}
	}

	function calTHoras(id) {
		var tHoras = 0;

		$('.ind').each(function () {
			var val = $.trim($(this).val());

			if (val !== '') {
				tHoras += parseFloat($(this).val());
			}
		});

		$('.thor').each(function () {
			var val = $.trim($(this).val());

			if (val !== '') {
				tHoras += parseFloat($(this).val());
			}
		});

		$('#iNtotal').val(tHoras.toFixed(2));

		if (tHoras > 0) {
			$('#gtotal').removeClass('has-success has-error').addClass('has-success');

			var hDisp = parseFloat($('#iNdisp').val());

			if (parseFloat(tHoras.toFixed(2)) > hDisp) {
				swal({
					title: "Error de Programación",
					text: "La suma de horas programadas (" + tHoras.toFixed(2) + ") es mayor que las horas disponibles ingresadas (" + hDisp + ").",
					type: "error",
					showCancelButton: false,
					confirmButtonText: "Aceptar"
				});

				$('#gtotal').removeClass('has-success has-error').addClass('has-error');
				$('#g' + id).removeClass('has-success has-error').addClass('has-error');
				$('#icon' + id).removeClass('fa-check fa-remove').addClass('fa-remove');
			} else {
				$('#g' + id).removeClass('has-success has-error').addClass('has-success');
				$('#icon' + id).removeClass('fa-check fa-remove').addClass('fa-check');
			}
		} else {
			$('#gtotal').removeClass('has-success has-error');
		}
	}

	function calBrecha() {
		$('#gbrproy, #gbrproyiq').removeClass('has-success has-error');
		var tActiv = 0;

		$('.tanual').each(function () {
			var val = $.trim($(this).val());

			if (val !== '') {
				tActiv += parseInt($(this).val(), 10);
			}
		});

		$('#iNactanuales').val(number_format(tActiv, 0, '', '.'));
		var bForm = parseInt($('#iNbrecha').val().replace('.', ''), 10);
		var bProy = tActiv + bForm;
		$('#iNbrproy').val(number_format(bProy, 0, '', '.'));

		if (bProy > 0) {
			$('#gbrproy').addClass('has-success');
		} else {
			$('#gbrproy').addClass('has-error');
		}

		var tIQ = parseInt($('#iNtapabellon').val(), 10);
		$('#iNactanualesiq').val(number_format($('#iNtapabellon').val(), 0, '', '.'));
		var bFormIQ = parseInt($('#iNbrechaiq').val().replace('.', ''), 10);
		var bProyIQ = tIQ + bFormIQ;
		$('#iNbrproyiq').val(number_format(bProyIQ, 0, '', '.'));

		if (bProyIQ >= 0) {
			$('#gbrproyiq').addClass('has-success');
		} else {
			$('#gbrproyiq').addClass('has-error');
		}
	}

	function setFormEsp(e) {
		if (e === '69') {
			$('#activ-med, #activ-rehab').css('display', 'none');
			$('#activ-radio').css('display', 'block');
			$('#activ-radio .input-number').each(function () {
				$(this).prop('disabled', false);
			});

			$('#activ-med .input-number, #activ-rehab .input-number').each(function () {
				$(this).val('0.00').prop('disabled', true);
			});
			$('#activ-med .form-group, #activ-rehab .form-group').each(function () {
				$(this).removeClass('has-success');
			});
			$('#activ-med .form-control-feedback, #activ-rehab .form-control-feedback').each(function () {
				$(this).removeClass('fa-check');
			});
		} else if (e === '16') {
			$('#activ-med, #activ-radio').css('display', 'none');
			$('#activ-rehab').css('display', 'block');
			$('#activ-rehab .input-number').each(function () {
				$(this).prop('disabled', false);
			});

			$('#activ-med .input-number, #activ-radio .input-number').each(function () {
				$(this).val('0.00').prop('disabled', true);
			});
			$('#activ-med .form-group, #activ-radio .form-group').each(function () {
				$(this).removeClass('has-success');
			});
			$('#activ-med .form-control-feedback, #activ-radio .form-control-feedback').each(function () {
				$(this).removeClass('fa-check');
			});
		} else {
			$('#activ-radio, #activ-rehab').css('display', 'none');
			$('#activ-med').css('display', 'block');
			$('#activ-med .input-number').each(function () {
				$(this).prop('disabled', false);
			});

			$('#activ-radio .input-number, #activ-rehab .input-number').each(function () {
				$(this).val('0.00').prop('disabled', true);
			});
			$('#activ-radio .form-group, #activ-rehab .form-group').each(function () {
				$(this).removeClass('has-success');
			});
			$('#activ-radio .form-control-feedback, #activ-rehab .form-control-feedback').each(function () {
				$(this).removeClass('fa-check');
			});

			switch (e) {
				case '42':
					$('#procOrtodoncia').css('display', 'block');
					break;
				case '43':
					$('#procMaxilofacial').css('display', 'block');
					break;
				case '44':
					$('#procEndodoncia').css('display', 'block');
					break;
				case '45':
					$('#procRehabProtesisFija').css('display', 'block');
					break;
				case '46':
					$('#procRehabProtesisRemov').css('display', 'block');
					break;
				case '47':
					$('#procPeriodoncia').css('display', 'block');
					break;
				case '48':
					$('#procRadiologia').css('display', 'block');
					break;
				case '49':
					$('#procImplantologia').css('display', 'block');
					break;
				case '50':
					$('#procTrastornos').css('display', 'block');
					break;
				case '51':
					$('#procOdontopediatria').css('display', 'block');
					break;
				default:
					break;
			}
		}
	}

	var options = {
		url: 'program/ajax.insertProgram.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');
	//setFormEsp('1');

	$('#gdate .input-daterange').each(function () {
		$(this).datepicker({
			startView: 2,
			minViewMode: 1,
			startDate: '-1y',
			endDate: '+2y',
			format: 'mm/yyyy'
		}).on('changeDate', function () {
			if ($.trim($("#iNdate").val()) !== '' && $.trim($("#iNdate_t").val()) !== '') {
				$('#gdate').removeClass('has-error').addClass('has-success');
			}
		});
	});

	$('#iNdesc, #iNcr, #iNserv, #iNesp, #iNobserv').change(function () {
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
		$('#iNtat, #iNtiq, #iNges, #iNgesiq, #iNtotalan, #iNtotalaniq, #iNtotalesp, #iNtotalespiq, #iNbrecha, #iNbrecha2, #iNbrechaiq, #iNbrechaiq2').val(0);
		$('#gtat, #gtiq, #gges, #ggesiq, #gprog, #gprogiq, #gtotalesp, #gtotalespiq, #gbrecha, #gbrecha2, #gbrechaiq, #gbrechaiq2').removeClass('has-error');

		$.ajax({
			type: "POST",
			url: "program/ajax.getServicios.php",
			dataType: 'json',
			data: {cr: $(this).val()}
		}).done(function (data) {
			$('#iNserv').html('').append('<option value="">Seleccione servicio</option>');

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
		$('#iNtat, #iNtiq, #iNges, #iNgesiq, #iNtotalan, #iNtotalaniq, #iNtotalesp, #iNtotalespiq, #iNbrecha, #iNbrecha2, #iNbrechaiq, #iNbrechaiq2').val(0);
		$('#gtat, #gtiq, #gges, #ggesiq, #gprog, #gprogiq, #gtotalesp, #gtotalespiq, #gbrecha, #gbrecha2, #gbrechaiq, #gbrechaiq2').removeClass('has-error');

		$.ajax({
			type: "POST",
			url: "program/ajax.getEspecialidades.php",
			dataType: 'json',
			data: {serv: $(this).val()}
		}).done(function (data) {
			$('#iNesp').html('').append('<option value="">Seleccione especialidad</option>');

			$.each(data, function (k, v) {
				$('#iNesp').append(
					$('<option></option>').val(v.esp_id).html(v.esp_nombre)
				);
			});
		});
	});

	$('#iNesp').change(function () {
		$('#iNtat, #iNtiq, #iNges, #iNgesiq, #iNtotalan, #iNtotalaniq, #iNtotalesp, #iNtotalespiq, #iNbrecha, #iNbrecha2, #iNbrechaiq, #iNbrechaiq2').val(0);
		$('#gtat, #gtiq, #gges, #ggesiq, #gprog, #gprogiq, #gtotalesp, #gtotalespiq, #gbrecha, #gbrecha2, #gbrechaiq, #gbrechaiq2').removeClass('has-error');

		$('.proces').each(function () {
			$(this).css('display', 'none');
		});
		$('.proces .input-number').each(function () {
			$(this).val('0.00');
		});
		calTHoras();

		$('.proces .form-group').each(function () {
			$(this).removeClass('has-success');
		});
		$('.proces .fa').each(function () {
			$(this).removeClass('fa-check');
		});

		if ($(this).val() !== '') {
			$.ajax({
				type: "POST",
				url: "program/ajax.getBrecha.php",
				dataType: 'json',
				data: {d: $('#iNdate').val(), esp: $(this).val(), serv: $('#iNserv').val(), pes: $('#iid').val()}
			}).done(function (data) {
				if (data.dia_id !== null) {
					$('#iNtat').val(number_format(data.dia_total_esp, 0, '', '.'));
					$('#iNges').val(number_format(data.dia_lista, 0, '', '.'));

					$('#iNtiq').val(number_format(data.dia_total_esp_iq, 0, '', '.'));
					$('#iNgesiq').val(number_format(data.dia_lista_iq, 0, '', '.'));

					var total_an = parseInt(data.dia_total_esp, 10) + parseInt(data.dia_lista, 10);
					$('#iNtotalan').val(number_format(total_an, 0, '', '.'));
					$('#iNtotalesp').val(number_format(data.total_cc, 0, '', '.'));
					var totaliq_an = parseInt(data.dia_total_esp_iq, 10) + parseInt(data.dia_lista_iq, 10);
					$('#iNtotalaniq').val(number_format(totaliq_an, 0, '', '.'));
					$('#iNtotalespiq').val(number_format(data.total_iq, 0, '', '.'));

					var brecha = parseInt(data.total_cc, 10) - total_an;
					$('#iNbrecha, #iNbrecha2').val(number_format(brecha, 0, '', '.'));
					if (brecha < 0) {
						$('#gbrecha, #gbrecha2').addClass('has-error');
					}

					var brecha_iq = parseInt(data.total_iq, 10) - totaliq_an;
					$('#iNbrechaiq, #iNbrechaiq2').val(number_format(brecha_iq, 0, '', '.'));
					if (brecha_iq < 0) {
						$('#gbrechaiq, #gbrechaiq2').addClass('has-error');
					}

					$('#iNtatc').val(number_format(data.dia_disp_atc, 0, '', '.'));
					$('#iNtata').val(number_format(data.dia_disp_ata, 0, '', '.'));
					$('#iNtpro').val(number_format(data.dia_disp_pro, 0, '', '.'));
					$('#iNthpro').val(number_format(data.total_disp, 0, '', '.'));
					$('#gtatc, #gtata, #gtpro').addClass('has-warning');
					var total_hesp = parseInt(data.dia_disp_atc, 10) + parseInt(data.dia_disp_ata, 10) + parseInt(data.dia_disp_pro, 10) - parseInt(data.total_disp, 10);
					$('#iNthesp, #iNthesp2').val(number_format(total_hesp, 0, '', '.'));
					$('#gthesp, #gthesp2').addClass('has-success');
				} else {
					swal({
						title: "Atención",
						text: "No se ha ingresado el diagnóstico anual para la especialidad escogida.",
						type: "warning",
						showCancelButton: false,
						confirmButtonText: "Aceptar"
					});
				}

				$.ajax({
					type: "POST",
					url: "program/ajax.getIfProgrammed.php",
					dataType: 'json',
					data: {d_ini: $('#iNdate').val(), d_ter: $('#iNdate_t').val(), esp: $('#iNesp').val(), per: $('#iid').val()}
				}).done(function (data) {
					if (data > 0) {
						swal({
							title: "Error",
							text: "La especialidad escogida ya ha sido programada para el período. Por favor escoja una especialidad diferente.",
							type: "error",
							showCancelButton: false,
							confirmButtonText: "Aceptar"
						});

						$('#iNesp').val('');
						$('#gesp').removeClass('has-success');
						$('#iNtat, #iNges, #iNtotalan, #iNtotalesp, #iNbrecha, #iNbrecha2, #iNtiq, #iNgesiq, #iNtotalaniq, #iNtotalespiq, #iNbrechaiq, #iNbrechaiq2').val(0);
						$('#gbrecha, #gbrecha2, #gbrechaiq, #gbrechaiq2').removeClass('has-error has-success');
					}
				});
			});
		} else {
			$('#iNtat, #iNges, #iNtotalan, #iNtotalesp, #iNbrecha, #iNtiq, #iNgesiq, #iNtotalaniq, #iNtotalespiq, #iNbrechaiq').val(0);
		}

		//setFormEsp($(this).val());
	});

	$(document).on('keyup', '.input-number', function () {
		var v = this.value;
		if ($.isNumeric(v) === false) {
			this.value = this.value.slice(0, -1);
		}
	});

	$('.disp').change(function () {
		var tDisp = 0;
		var idn = $(this).attr('id').split('N');
		$('#g' + idn[1]).removeClass('has-error has-success');
		$('#icon' + idn[1]).removeClass('fa-remove fa-check');

		$('.disp').each(function () {
			var val = $.trim($(this).val());

			if (val !== '' && parseInt(val, 10) > 0) {
				tDisp += parseFloat($(this).val());
				$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
				$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
			}
		});

		var tmp = tDisp / 5;
		var semDisp = parseFloat($('#weeks').val()) - tmp;

		$('#iNsemdisp').val(semDisp);
	});

	$('#iNdisp, #iNuniversidad, #iNbecados').change(function () {
		var tDisp = 0;
		var idn = $(this).attr('id').split('N');
		var val = $.trim($(this).val());

		if (val !== '') {
			calTotal(idn[1]);

			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}

		$('.disponib').each(function () {
			var val = $.trim($(this).val());

			if (val !== '') {
				tDisp += parseFloat($(this).val());
			}
		});

		$('#iNtdisponible').val(tDisp.toFixed(2));

		if (tDisp > 0) {
			$('#gtdisponible').addClass('has-success');
		} else {
			$('#gtdisponible').removeClass('has-success');
		}

		if (idn[1] === 'disp' && $('#iNbrproy').val() !== undefined) {
			var totAnual = parseFloat($('#iNsemdisp').val()) * parseInt($(this).val(), 10);
			$('#iNthanual').val(number_format(totAnual, 2, '', '.'));
			var totDisp = parseInt($('#iNthesp2').val().replace('.', ''), 10) - totAnual;
			$('#iNtotproy').val(number_format(totDisp, 2, '', '.'));

			if (totDisp >= 0) {
				$('#gtotproy').addClass('has-success');
			} else {
				$('#gtotproy').addClass('has-error');
			}
		}
	});

	$('.ind').change(function () {
		var tPoli = 0;
		var idn = $(this).attr('id').split('N');
		var val = $.trim($(this).val());
		var hDisp = $.trim($('#iNdisp').val());

		if (val !== '') {
			calTotal(idn[1]);
			calTHoras(idn[1]);

			var perc = parseFloat(val) / parseFloat(hDisp);
			$('#iNp' + idn[1]).val(perc.toFixed(2));
			$('#gp' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#iconp' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}

		if ($('#iN' + idn[1]).hasClass('tpoli')) {
			$('.tpoli').each(function () {
				var val = $.trim($(this).val());

				if (val !== '') {
					tPoli += parseFloat($(this).val());
				}
			});

			$('#iNtpoli').val(tPoli.toFixed(2));

			if (tPoli > 0) {
				$('#gtpoli').addClass('has-success');
			} else {
				$('#gtpoli').removeClass('has-success');
			}
		}
	});

	$('.rend').change(function () {
		var idn = $(this).attr('id').split('Nr');
		var val = $.trim($(this).val());

		if (val !== '') {
			calTotal(idn[1]);
			calTHoras(idn[1]);

			$('#gr' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#iconr' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#gr' + idn[1]).removeClass('has-success');
			$('#iconr' + idn[1]).removeClass('fa-check');
		}
	});

	$('.obs').change(function () {
		var idn = $(this).attr('id').split('No');
		var val = $.trim($(this).val());

		if (val !== '') {
			$('#go' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icono' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#go' + idn[1]).removeClass('has-success');
			$('#icono' + idn[1]).removeClass('fa-check');
		}
	});

	$('.thor').change(function () {
		var idn = $(this).attr('id').split('N');
		var val = $.trim($(this).val());
		var hDisp = $.trim($('#iNdisp').val());

		if (val !== '') {
			calTHoras(idn[1]);

			var perc = parseFloat(val) / parseFloat(hDisp);
			$('#iNp' + idn[1]).val(perc.toFixed(2));
			$('#gp' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#iconp' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}
	});

	$('#formNewProgram').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});