$(document).ready( function() {
    var tableUsers = $('#tusers').DataTable({
        'columns' : [
            null,
            null,
            null,
            null,
            null,
            null
        ],
        'order' : [[1, 'asc'], [2, 'asc'], [0, 'asc']],
        'pageLength' : 5,
        'lengthChange' : false,
        'buttons' : [],
		serverSide: true,
		ajax: {
			url: 'main/ajax.getServerUsers.php',
			type: 'GET',
			length: 5
		}
    });
});