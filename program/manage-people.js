$(document).ready(function () {
	var tableUsr = $("#tpeople").DataTable({
		"columns": [{ width: "100px", className: "text-right" }, null, null, null, null, null, null],
		'order': [[1, 'asc']],
		'serverSide': true,
		ajax: {
			url: 'program/ajax.getServerContratos.php',
			type: 'GET',
			length: 20
		}
	});

	$('#submitLoader').css('display', 'none');

	$('#btnsubmit').click(function () {
		tableUsr.ajax.url('program/ajax.getServerContratos.php?iplanta=' + $('#iNplanta').val()).load();
	});
});