$(document).ready( function() {
    var tableUsr = $("#tfiles").DataTable({
        "columns": [ null, { className: "text-center" }, { "orderable": false, width: "70px", className: "text-center" } ],
        "lengthMenu": [ [20, 40, 60, -1], [20, 40, 60, "Todo"] ]
    });

    $(".fileModal").tooltip();
    $(".fileEdit").tooltip();
    $(".fileDelete").tooltip();

    $("#tfiles").on('click', '.fileModal', function() {
        var fid = $(this).attr('id').split("_").pop();
        $("#f_name").html( '' );
        $("#f_date").html( '' );
        $("#f_type").html( '' );
        $("#f_user").html( '' );
        $("#f_path").attr( 'href', null );

        $.ajax( {
            url:        'admin/files/ajax.getFile.php',
            type:       'POST',
            dataType:   'json',
            data:       { id: fid }
        })
        .done( function(d) {
            console.log(d);
            if (d.arc_id !== null) {
                $("#f_name").html( ':: ' + d.arc_nombre );
                $("#f_date").html( getDateBD(d.arc_fecha) );
                $("#f_type").html( getExt(d.arc_path) );
                $("#f_user").html( d.arc_user );
                $("#f_path").attr( 'href', d.arc_path );
            }
        });
    });

    $("#tfiles").on('click', '.fileDelete', function() {
        var uid = $(this).attr('id').split("_").pop();
        $(this).parent().parent().addClass('selected');

        swal({
            title: "¿Está seguro de querer eliminar el documento?",
            text: "Esta acción borrará todos los registros relacionados al documento.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí",
            closeOnConfirm: true 
        }, function(confirm) {
            if (confirm) {
                $.ajax( {
                    url:        'admin/files/ajax.delFile.php',
                    type:       'POST',
                    dataType:   'json',
                    data:       { id: uid }
                })
                .done( function(response) {
                    console.log(response);

                    if (response.type === true) {
						new Noty({
							text: '<b>¡Éxito!</b><br> El documento ha sido eliminado correctamente.',
							type: 'success'
						}).show();
                        tableUsr.row('.selected').remove().draw( false );
                    }
                    else {
						new Noty({
							text: '<b>¡Error!</b><br>' + response.msg,
							type: 'error'
						}).show();
                        tableUsr.$('tr.selected').removeClass('selected');
                    }
                });
            }
            else {
                tableUsr.$('tr.selected').removeClass('selected');
            }
        });
    });
});