/*
	TXT by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

(function($) {

	skel
		.breakpoints({
			desktop: '(min-width: 737px)',
			tablet: '(min-width: 737px) and (max-width: 1200px)',
			mobile: '(max-width: 736px)'
		})
		.viewport({
			breakpoints: {
				tablet: {
					width: 1080
				}
			}
		});

	$(function() {

		var	$window = $(window),
			$body = $('body');

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');

			$window.on('load', function() {
				$body.removeClass('is-loading');
			});

		// Fix: Placeholder polyfill.
			$('form').placeholder();

		// Prioritize "important" elements on mobile.
			skel.on('+mobile -mobile', function() {
				$.prioritize(
					'.important\\28 mobile\\29',
					skel.breakpoint('mobile').active
				);
			});

		// CSS polyfills (IE<9).
			if (skel.vars.IEVersion < 9)
				$(':last-child').addClass('last-child');

		// Dropdowns.
			$('#nav > ul').dropotron({
				mode: 'fade',
				noOpenerFade: true,
				speed: 300,
				alignment: 'center'
			});

		// Off-Canvas Navigation.

			// Title Bar.
				$(
					'<div id="titleBar">' +
						'<a href="#navPanel" class="toggle"></a>' +
						'<span class="title">' + $('#logo').html() + '</span>' +
					'</div>'
				)
					.appendTo($body);

			// Navigation Panel.
				$(
					'<div id="navPanel">' +
						'<nav>' +
							$('#nav').navList() +
						'</nav>' +
					'</div>'
				)
					.appendTo($body)
					.panel({
						delay: 500,
						hideOnClick: true,
						hideOnSwipe: true,
						resetScroll: true,
						resetForms: true,
						side: 'left',
						target: $body,
						visibleClass: 'navPanel-visible'
					});

			// Fix: Remove navPanel transitions on WP<10 (poor/buggy performance).
				if (skel.vars.os == 'wp' && skel.vars.osVersion < 10)
					$('#titleBar, #navPanel, #page-wrapper')
						.css('transition', 'none');

	});

})(jQuery);

function postCambiosRally() {

    var data = $( "#formRally" ).serialize();
    var url = baseUrl + "/saveCambiosRally";

    $.ajax({
        url: url,
        type: "POST",
        dataType:"json",
        data: data,
        success: function (data) {

            console.log(data);

            if(data.err)
            {
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Error',
                    message: data.msg
                });
            }
            else if(data.nuevoRally == 1) {
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_PRIMARY,
                    title: "Cambios realizados correctamente",
                    message: "El Rally ha sido actualizado",
                    buttons: [{
                        label: 'Cerrar',
                        action: function(dialogItself){
                            dialogItself.close();
                            window.location.href = baseUrl + "/editaRally/"+ data.codRally;
                        }
                    }]
                });
			}
            else {
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_INFO,
                    title: "Cambios realizados correctamente",
                    message: "El Rally ha sido actualizado",
                    buttons: [{
                        label: 'Cerrar',
                        action: function(dialogItself){
                            dialogItself.close();
                        }
                    }]
                });
            }

        },
        error: function(jqXHR,error, errorThrown) {
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: "Error",
                message: "Error en el sistema, contacte con el administrador",
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialogItself){
                        dialogItself.close();

                    }
                }]
            });
            console.log("err...");
            console.log(error);
            console.log(errorThrown);
        }
    });
}

function verTramos(codRally) {

    var url = baseUrl + "/verTramos/"+codRally;

    $.ajax({
        url: url,
        type: "GET",
        dataType:"json",
        success: function (data) {

            console.log(data);

            $('<div></div>').load('remote.html')

            var tramos = '<table class="table table-striped">';
            tramos += '<thead>';
            tramos += '<tr>';
            tramos += '<th>codTramo</th>';
            tramos += '<th>Kilometros totales</th>';
            tramos += '<th>Dificultad</th>';
            tramos += '</tr>';
            tramos += '</thead>';
            tramos += '<tbody>';
            $.each(data.tramos, function( index, value ) {
                tramos += '<tr>';
                tramos += '<td>'+value.codTramo+'</td>';
                tramos += '<td>'+value.totalKms+'</td>';
                tramos += '<td>'+value.dificultad+'</td>';
                tramos += '</tr>';
            });
            tramos += '</tbody>';
            tramos += '</table>';

            if(data.err)
            {
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Error',
                    message: data.msg
                });
            }
            else {
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_INFO,
                    title: "Tramos del Rally "+data.codRally,
                    message: tramos,
                    buttons: [{
                        label: 'Cerrar',
                        action: function(dialogItself){
                            dialogItself.close();
                        }
                    }]
                });
            }

        },
        error: function(jqXHR,error, errorThrown) {
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: "Error",
                message: "Error en el sistema, contacte con el administrador",
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialogItself){
                        dialogItself.close();

                    }
                }]
            });
            console.log("err...");
            console.log(error);
            console.log(errorThrown);
        }
    });
}

function addTramo() {

    var data = $( "#formRally" ).serialize();
    var url = baseUrl + "/addTramo";

    $.ajax({
        url: url,
        type: "POST",
        dataType:"json",
        data: data,
        success: function (data) {

            console.log(data);

            if(data.err)
            {
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Error',
                    message: data.msg
                });
            }
            else {
                $('#tramos > tbody:last-child').hide().append(
                    '<tr id="'+data.codTramo+'">'
                    +'<td>'+data.codTramo+'</td>'
                    +'<td>'+data.totalKms+'</td>'
                	+'<td>'+data.dificultad+'</td>'
                    +'<td><button onclick="eliminarTramo(\''+data.codTramo+'\');" class="btn btn-danger" type="button">Eliminar tramo</button></td>'
                    +'</tr>').fadeIn();

                /*BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_INFO,
                    title: "Cambios realizados correctamente",
                    message: "El Rally ha sido actualizado",
                    buttons: [{
                        label: 'Cerrar',
                        action: function(dialogItself){
                            dialogItself.close();
                        }
                    }]
                });*/
            }

        },
        error: function(jqXHR,error, errorThrown) {
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: "Error",
                message: "Error en el sistema, contacte con el administrador",
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialogItself){
                        dialogItself.close();

                    }
                }]
            });
            console.log("err...");
            console.log(error);
            console.log(errorThrown);
        }
    });
}

function eliminarTramo(codTramo) {

    var url = baseUrl + "/eliminarTramo";
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url: url,
        type: "POST",
        dataType:"json",
        data: {"codTramo":codTramo, _token : _token},
        success: function (data) {

            console.log(data);

            if(data.err)
            {
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Error',
                    message: data.err
                });
            }
            else {
                $('#'+data).fadeOut(300, function() { $(this).remove();});
            }

        },
        error: function(jqXHR,error, errorThrown) {
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: "Error",
                message: "Error en el sistema, contacte con el administrador",
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialogItself){
                        dialogItself.close();

                    }
                }]
            });
            console.log("err...");
            console.log(error);
            console.log(errorThrown);
        }
    });
}

function eliminarRally(codRally) {

    var url = baseUrl + "/eliminarRally";
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url: url,
        type: "POST",
        dataType:"json",
        data: {"codRally":codRally, _token : _token},
        success: function (data) {

            console.log(data);

            if(data.err)
            {
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Error',
                    message: data.err
                });
            }
            else {
                BootstrapDialog.confirm({
                    title: 'Borrar Rally',
                    message: 'Vas a borrar este Rally, ¿Estas seguro?',
                    type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                    closable: true, // <-- Default value is false
                    draggable: true, // <-- Default value is false
                    btnCancelLabel: 'Cancelar', // <-- Default value is 'Cancel',
                    btnOKLabel: 'Borrar!', // <-- Default value is 'OK',
                    btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
                    callback: function(result) {
                        // result will be true if button was click, while it will be false if users close the dialog directly.
                        if(result) {
                            $('#'+data).fadeOut(300, function() { $(this).remove();});
                        }else {
                            return false;
                        }
                    }
                });

            }

        },
        error: function(jqXHR,error, errorThrown) {
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: "Error",
                message: "Error en el sistema, contacte con el administrador",
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialogItself){
                        dialogItself.close();

                    }
                }]
            });
            console.log("err...");
            console.log(error);
            console.log(errorThrown);
        }
    });
}