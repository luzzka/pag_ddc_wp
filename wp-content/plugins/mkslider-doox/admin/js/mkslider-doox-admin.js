(function($) {
    'use strict';
    $(document).ready(function() {

        jQuery("#chb_descripcion").click(function(event) {
            if (jQuery(this).prop('checked')) {
                /*mostrar la descipcion*/
                jQuery(".mksdescripcion").show();
            } else {
                /*ocultar la descripcion*/
                jQuery(".mksdescripcion").hide();
            }

        });

        jQuery("#slt_sld").change(function(event) {
            var val = jQuery(this).val();
            if (val != 0) {
                window.location.replace(val);
            }
        });

        jQuery(".buEliminarSlider").click(function(event) {
            event.preventDefault();
            var id = jQuery(this).data("iden");
            if (confirm('Esta seguro de eliminar este item?')) {
                jQuery('#wpwrap').block({
                    message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },
                    overlayCSS: {
                        backgroundColor: '#fff'
                    }
                });

                jQuery.ajax({
                        url: mkJS.ajaxurl,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'eliminarsl',
                            iden: id
                        },
                    })
                    .done(function(rpta) {
                        if (rpta.eliminado = 1) {
                            window.location.replace(rpta.url);
                        } else {
                            /*mostrar el mensaje*/
                            jQuery(".mnserror_ajax_slider").html(rpta.mensaje);
                            jQuery(".mnserror_ajax_slider").show();
                        }
                        jQuery('#wpwrap').unblock();
                    })
                    .fail(function() {
                        jQuery('#wpwrap').unblock();
                    });

            }
        });

        jQuery(".bu_editar_slider").click(function(event) {
            event.preventDefault();
            var iden = jQuery("#txthid").val();
            jQuery('#wpwrap').block({
                message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                },
                overlayCSS: {
                    backgroundColor: '#fff'
                }
            });

            jQuery.ajax({
                    url: mkJS.ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action: 'displaytems',
                        iden: iden
                    },
                })
                .done(function(rpta) {
                    if (rpta.recuperado == 1) {
                        jQuery(".listadoItems").html(rpta.listado);
                        jQuery("#actionItem").val("a");
                        jQuery("#txtTituloSlider").val("");
                        jQuery("#txaDescription").val("");
                        jQuery("#txtEnlace").val("");
                        jQuery("#imagenSlider").val("");
                        jQuery(".mkaddimage").show();
                        jQuery(".delimage").hide();
                        jQuery(".tableEditNewSlider").html("Agregar item");
                        jQuery(".butActionSlider").html("Crear");
                        jQuery(".mksecundario").show();
                        jQuery(".butCancelEditar").hide();
                        jQuery(".mnserror_ajax_item").hide();
                    } else {
                        /*mostrar el mensaje*/
                        jQuery(".mnserror_ajax_slider").html(rpta.mensaje);
                        jQuery(".mnserror_ajax_slider").show();
                    }
                    jQuery('#wpwrap').unblock();
                })
                .fail(function() {
                    /*mostrar el mensaje*/
                    jQuery(".mnserror_ajax_slider").html('Error de conexion');
                    jQuery(".mnserror_ajax_slider").show();
                    jQuery('#wpwrap').unblock();
                });

        });

        jQuery(".butActionSlider").click(function(event) {
            event.preventDefault();
            var action = jQuery("#actionItem").val(),
                titulo = jQuery("#txtTituloSlider").val(),
                descripcion = jQuery("#txaDescription").val(),
                enlace = jQuery("#txtEnlace").val(),
                imagen = jQuery("#imagenSlider").val(),
                item = jQuery("#idItem").val(),
                iden = jQuery("#txthid").val();

            jQuery('#wpwrap').block({
                message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                },
                overlayCSS: {
                    backgroundColor: '#fff'
                }
            });

            $.ajax({
                    url: mkJS.ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action: 'editaritem',
                        cambio: action,
                        titulo: titulo,
                        descripcion: descripcion,
                        enlace: enlace,
                        imagen: imagen,
                        iditem: item,
                        idslider: iden
                    },
                })
                .done(function(rpta) {
                    if (rpta.modificado == 1) {
                        jQuery(".listadoItems").html(rpta.listado);
                        if (action == 'a') {
                            /*limpiar los valores*/
                            jQuery("#txtTituloSlider").val("");
                            jQuery("#txaDescription").val("");
                            jQuery("#txtEnlace").val("");
                            jQuery("#imagenSlider").val("");
                            jQuery(".mkaddimage").show();
                            jQuery(".delimage").hide();
                            jQuery(".tableEditNewSlider").html("Agregar item");
                            jQuery(".butActionSlider").html("Crear");
                            jQuery(".butCancelEditar").hide();
                        }
                    }
                    /*mostrar el mensaje*/
                    jQuery(".mnserror_ajax_item").html(rpta.mensaje);
                    jQuery(".mnserror_ajax_item").show();
                    jQuery('#wpwrap').unblock();
                })
                .fail(function() {
                    /*mostrar el mensaje*/
                    jQuery(".mnserror_ajax_item").html("Error de conexion");
                    jQuery(".mnserror_ajax_item").show();
                    jQuery('#wpwrap').unblock();
                });


        });
        jQuery(".butCancelEditar").click(function(event) {
            event.preventDefault();
            jQuery(".itemslider").show();
            jQuery(this).hide();
            jQuery("#actionItem").val("a");
            jQuery("#txtTituloSlider").val("");
            jQuery("#txaDescription").val("");
            jQuery("#txtEnlace").val("");
            jQuery("#imagenSlider").val("");
            jQuery(".mkaddimage").show();
            jQuery(".delimage").hide();
            jQuery(".tableEditNewSlider").html("Agregar item");
            jQuery(".butActionSlider").html("Crear");
            jQuery(".mnserror_ajax_item").hide();
        });

        jQuery("body").delegate('.mkeditar', 'click', function(event) {
            event.preventDefault();
            var iden = jQuery(this).data("iden"),
                sld = jQuery(this).data("idensl");

            jQuery('#wpwrap').block({
                message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                },
                overlayCSS: {
                    backgroundColor: '#fff'
                }
            });

            $.ajax({
                    url: mkJS.ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action: 'recuperaritem',
                        iden: iden,
                        slider: sld
                    },
                })
                .done(function(rpta) {
                    if (rpta.recuperado == 1) {
                        jQuery("#actionItem").val("e");
                        jQuery("#idItem").val(iden);
                        jQuery("#txtTituloSlider").val(rpta.item.titulo);
                        jQuery("#txaDescription").val(rpta.item.descripcion);
                        jQuery("#txtEnlace").val(rpta.item.enlace);
                        jQuery(".mkaddimage").hide();
                        jQuery("#imagenSlider").val(rpta.item.imagen);
                        jQuery("#mk_imagen_muestra").attr("src", rpta.item.imagen);
                        jQuery(".delimage").show();
                        jQuery(".tableEditNewSlider").html("Actualizar item");
                        jQuery(".butActionSlider").html("Guardar");
                        jQuery(".butCancelEditar").show();
                        jQuery(".mnserror_ajax_item").hide();
                        /*ocultar los items*/
                        jQuery(".itemslider").hide();
                        jQuery(".itemslider_" + iden).show();
                    } else {
                        window.location.replace(rpta.url);
                    }
                    jQuery('#wpwrap').unblock();
                })
                .fail(function() {
                    jQuery('#wpwrap').unblock();
                });


        });

        jQuery("body").delegate('.mkeliminar', 'click', function(event) {
            event.preventDefault();
            var iden = jQuery(this).data("iden"),
                sld = jQuery(this).data("idensl");
            if (confirm("Esta Ud. seguro de eliminar el item?")) {
                jQuery('#wpwrap').block({
                    message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },
                    overlayCSS: {
                        backgroundColor: '#fff'
                    }
                });
                $.ajax({
                        url: mkJS.ajaxurl,
                        type: 'post',
                        dataType: 'json',
                        data: {
                            action: 'eliminaritem',
                            iden: iden,
                            slider: sld
                        },
                    })
                    .done(function(rpta) {
                        if (rpta.eliminado == 1) {
                            jQuery(".itemslider_" + iden).remove();
                        jQuery(".butCancelEditar").hide();
                            jQuery("#actionItem").val("a");
                            jQuery("#txtTituloSlider").val("");
                            jQuery("#txaDescription").val("");
                            jQuery("#txtEnlace").val("");
                            jQuery("#imagenSlider").val("");
                            jQuery(".mkaddimage").show();
                            jQuery(".delimage").hide();
                            jQuery(".tableEditNewSlider").html("Agregar item");
                            jQuery(".butActionSlider").html("Crear");
                            jQuery(".mnserror_ajax_item").hide();
                        }
                        jQuery('#wpwrap').unblock();
                    })
                    .fail(function() {
                        jQuery('#wpwrap').unblock();
                    });

            }
        });

        jQuery(".bu_editar_side").click(function(event) {
            event.preventDefault();
            var iden = jQuery("#txthid").val();
            jQuery('#wpwrap').block({
                message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                },
                overlayCSS: {
                    backgroundColor: '#fff'
                }
            });

            jQuery.ajax({
                    url: mkJS.ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action: 'displaytemside',
                        iden: iden
                    },
                })
                .done(function(rpta) {
                    if (rpta.recuperado == 1) {
                        jQuery(".listadoItems").html(rpta.listado);
                        jQuery("#actionItem").val("a");
                        jQuery("#txtTituloSlider").val("");
                        jQuery("#txtEnlace").val("");
                        jQuery("#imagenSlider").val("");
                        jQuery(".mkaddimage").show();
                        jQuery(".delimage").hide();
                        jQuery(".tableEditNewSlider").html("Agregar item");
                        jQuery(".butActionSidebar").html("Crear");
                        jQuery(".mksecundario").show();
                        jQuery(".butCancelEditarSidebar").hide();
                        jQuery(".mnserror_ajax_item").hide();
                    } else {
                        /*mostrar el mensaje*/
                        jQuery(".mnserror_ajax_slider").html(rpta.mensaje);
                        jQuery(".mnserror_ajax_slider").show();
                    }
                    jQuery('#wpwrap').unblock();
                })
                .fail(function() {
                    /*mostrar el mensaje*/
                    jQuery(".mnserror_ajax_slider").html('Error de conexion');
                    jQuery(".mnserror_ajax_slider").show();
                    jQuery('#wpwrap').unblock();
                });

        });

        jQuery("body").delegate('.mkeditarsidebar', 'click', function(event) {
            event.preventDefault();
            var iden = jQuery(this).data("iden"),
                sld = jQuery(this).data("idensl");

            jQuery('#wpwrap').block({
                message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                },
                overlayCSS: {
                    backgroundColor: '#fff'
                }
            });

            $.ajax({
                    url: mkJS.ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action: 'recuperaritemsidebar',
                        iden: iden,
                        slider: sld
                    },
                })
                .done(function(rpta) {
                    if (rpta.recuperado == 1) {
                        jQuery("#actionItem").val("e");
                        jQuery("#idItem").val(iden);
                        jQuery("#txtTituloSlider").val(rpta.item.titulo);
                        jQuery("#txtEnlace").val(rpta.item.enlace);
                        jQuery(".mkaddimage").hide();
                        jQuery("#imagenSlider").val(rpta.item.imagen);
                        jQuery("#mk_imagen_muestra").attr("src", rpta.item.imagen);
                        jQuery(".delimage").show();
                        jQuery(".tableEditNewSlider").html("Actualizar item");
                        jQuery(".butActionSidebar").html("Guardar");
                        jQuery(".butCancelEditarSidebar").show();
                        jQuery(".mnserror_ajax_item").hide();
                        /*ocultar los items*/
                        jQuery(".itemslider").hide();
                        jQuery(".itemslider_" + iden).show();
                    } else {
                        window.location.replace(rpta.url);
                    }
                    jQuery('#wpwrap').unblock();
                })
                .fail(function() {
                    jQuery('#wpwrap').unblock();
                });


        });

        jQuery("body").delegate('.mkeliminarsidebar', 'click', function(event) {
            event.preventDefault();
            var iden = jQuery(this).data("iden"),
                sld = jQuery(this).data("idensl");
            if (confirm("Esta Ud. seguro de eliminar el item?")) {
                jQuery('#wpwrap').block({
                    message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },
                    overlayCSS: {
                        backgroundColor: '#fff'
                    }
                });
                $.ajax({
                        url: mkJS.ajaxurl,
                        type: 'post',
                        dataType: 'json',
                        data: {
                            action: 'eliminaritemsidebar',
                            iden: iden,
                            slider: sld
                        },
                    })
                    .done(function(rpta) {
                        if (rpta.eliminado == 1) {
                            jQuery(".itemslider_" + iden).remove();
                            jQuery(".butCancelEditarSidebar").hide();
                            jQuery("#actionItem").val("a");
                            jQuery("#txtTituloSlider").val("");
                            jQuery("#txtEnlace").val("");
                            jQuery("#imagenSlider").val("");
                            jQuery(".mkaddimage").show();
                            jQuery(".delimage").hide();
                            jQuery(".tableEditNewSlider").html("Agregar item");
                            jQuery(".butActionSidebar").html("Crear");
                            jQuery(".mnserror_ajax_item").hide();
                        }
                        jQuery('#wpwrap').unblock();
                    })
                    .fail(function() {
                        jQuery('#wpwrap').unblock();
                    });

            }
        });

        jQuery(".buEliminarSidebar").click(function(event) {
            event.preventDefault();
            var id = jQuery(this).data("iden");
            if (confirm('Esta seguro de eliminar este item?')) {
                jQuery('#wpwrap').block({
                    message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },
                    overlayCSS: {
                        backgroundColor: '#fff'
                    }
                });

                jQuery.ajax({
                        url: mkJS.ajaxurl,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'eliminarslsidebar',
                            iden: id
                        },
                    })
                    .done(function(rpta) {
                        if (rpta.eliminado = 1) {
                            window.location.replace(rpta.url);
                        } else {
                            /*mostrar el mensaje*/
                            jQuery(".mnserror_ajax_slider").html(rpta.mensaje);
                            jQuery(".mnserror_ajax_slider").show();
                        }
                        jQuery('#wpwrap').unblock();
                    })
                    .fail(function() {
                        jQuery('#wpwrap').unblock();
                    });

            }
        });

        jQuery(".butActionSidebar").click(function(event) {
            event.preventDefault();
            var action = jQuery("#actionItem").val(),
                titulo = jQuery("#txtTituloSlider").val(),
                enlace = jQuery("#txtEnlace").val(),
                imagen = jQuery("#imagenSlider").val(),
                item = jQuery("#idItem").val(),
                iden = jQuery("#txthid").val();

            jQuery('#wpwrap').block({
                message: '<img src="' + mkJS.pluginfile + 'css/loading.gif" alt="Cargando" />',
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                },
                overlayCSS: {
                    backgroundColor: '#fff'
                }
            });

            $.ajax({
                    url: mkJS.ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action: 'editaritemsidebar',
                        cambio: action,
                        titulo: titulo,
                        enlace: enlace,
                        imagen: imagen,
                        iditem: item,
                        idslider: iden
                    },
                })
                .done(function(rpta) {
                    if (rpta.modificado == 1) {
                        jQuery(".listadoItems").html(rpta.listado);
                        if (action == 'a') {
                            /*limpiar los valores*/
                            jQuery("#txtTituloSlider").val("");
                            jQuery("#txtEnlace").val("");
                            jQuery("#imagenSlider").val("");
                            jQuery(".mkaddimage").show();
                            jQuery(".delimage").hide();
                            jQuery(".tableEditNewSlider").html("Agregar item");
                            jQuery(".butActionSidebar").html("Crear");
                            jQuery(".butCancelEditarSidebar").hide();
                        }
                    }
                    /*mostrar el mensaje*/
                    jQuery(".mnserror_ajax_item").html(rpta.mensaje);
                    jQuery(".mnserror_ajax_item").show();
                    jQuery('#wpwrap').unblock();
                })
                .fail(function() {
                    /*mostrar el mensaje*/
                    jQuery(".mnserror_ajax_item").html("Error de conexion");
                    jQuery(".mnserror_ajax_item").show();
                    jQuery('#wpwrap').unblock();
                });


        });

        jQuery(".butCancelEditarSidebar").click(function(event) {
            event.preventDefault();
            jQuery(".itemslider").show();
            jQuery(this).hide();
            jQuery("#actionItem").val("a");
            jQuery("#txtTituloSlider").val("");
            jQuery("#txtEnlace").val("");
            jQuery("#imagenSlider").val("");
            jQuery(".mkaddimage").show();
            jQuery(".delimage").hide();
            jQuery(".tableEditNewSlider").html("Agregar item");
            jQuery(".butActionSlider").html("Crear");
            jQuery(".mnserror_ajax_item").hide();
        });

    });

})(jQuery);