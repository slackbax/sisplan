$(document).ready(function () {

	$('table').tooltip({
		html: true,
		selector: '[data-tooltip=tooltip]'
	});

	$('body').tooltip({
		html: true,
		selector: '[rel=tooltip]'
	});

	$('#btn-help').click(function () {
		swal({
			title: "¿Necesita ayuda?",
			html: 'Para cualquier duda o sugerencia, puede contactar a soporte de la aplicación al anexo 410405 o al e-mail <a href="mailto:soportedesarrollo@ssconcepcion.cl">soportedesarrollo@ssconcepcion.cl</a>',
			type: "warning",
			showCancelButton: false,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Aceptar'
		});
	});

	$('#btn-logout').click(function () {
		swal({
			title: "¿Está seguro de querer salir?",
			text: "Esta acción cerrará su sesión en el sistema.",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Sí"
		}).then((result) => {
			if(result.value) {
				$.ajax({
					type: "POST",
					url: "src/logout.php",
					data: {src: 'btn'}
				}).done(function (msg) {
					if (msg === 'true') {
						window.location.replace('index.php');
					}
				});
			}
		});
	});

	$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue'
	});
});