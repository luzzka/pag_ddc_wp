<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if (!$conexion_i->verifica_loggeo()) {
	echo 'ACCESO RESTRINGIDO';
	exit;
}

function redirigir_con_mensaje ($page, $type, $message) {
	$_SESSION['message'] = [$type, $message];
	header('Location: ' . $page);
	exit;
}

$id_convocatoria = $_GET["id"];

$row = '';

if ($conexion_i->conectar()) {
	$result = $conexion_i->getdata_procesos($id_convocatoria);
	$conexion_i->desconectar();
} else redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al conectar con la BD');

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title>Editar Procesos</title>

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/principal.css">

	<link rel="stylesheet" href="css/alertify.min.css">
	<link rel="stylesheet" href="css/alertify.default.min.css">

    <!--getmdl-select-->
    <link rel="stylesheet" href="css/getmdl-select.min.css">

<!--	<link rel="stylesheet" href="/wp-content/themes/colormag/style.css">-->

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />

	<style>
		/* Estado de Tramite */
		.encabezado-procesos {
			background-color: #770a29;
		}
		.imprimir_hdr {
			position: absolute;
			top: 6px;
			right: 12px;
		}

		.imprimir_hdr:hover {
			cursor: pointer;
		}

		.tabla {
			border-spacing: 0;
			vertical-align: middle;
		}

		/* Convocatorias 3 */

		.tabla tbody tr td img {
			width: 60px !important;
			max-width: 60px;
		}

		th, td {
			border: 1px solid #EAEAEA;
			padding: 6px 10px;
		}


		/* .encabezado-procesos td {
			height: 60px;
				position: relative;
		}

		.encabezado-procesos td p {
			margin: 0;
				position: absolute;
				top: 50%;
				left: 50%;
				-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
		} */

		.img-no-bottom {
			margin-bottom: 0px;
		}

		.img-6-bottom {
			margin-bottom: 6px;
		}

		.contenedor {
			height: 200px;
			line-height: 200px;
			text-align: center;
		}

		.contenedor-hijo {
			display: inline-block;
			vertical-align: middle;
			line-height: normal;
		}

		.no-margin-b {
			margin-bottom: 0 !important;
		}

        .selected_row {
            background-color: #e0e0e0 !important;
        }

        .mdl-checkbox.is-upgraded {
            padding-left: 6px;
        }

        input[type="text"] {
            text-transform: uppercase;
        }

	</style>

</head>
<body>

<div class="mdl-grid">

	<div class="mdl-cell mdl-cell--1-col mdl-cell--1-col-tablet"></div>

	<div class="mdl-cell mdl-cell--10-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" >

        <div class="cabecera-procesos">

            <button id="home-convocatorias" class="home-convocatorias mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                <i class="material-icons">keyboard_return</i> Regresar a Convocatorias
            </button>

            <form id="form_elimina_p" action="elimina_procesos.php" method="post">

                <input type="hidden" id="id_procesos" name="id_procesos">
                <input type="hidden" id="id_convocatoria" name="id_convocatoria" value="<?php echo $id_convocatoria ?>">

                <div class="boton-top-d mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
                    <input type="text" value="" class="mdl-textfield__input" id="select-global" readonly>
                    <input type="hidden" value="" name="select-global">
                    <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                    <label for="select-global" class="mdl-textfield__label">Agregar Doc. Global</label>
                    <ul for="select-global" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                        <li class="mdl-menu__item" data-val="1" >Comunicados</li>
                        <li class="mdl-menu__item" data-val="2" >Ev. Curricular</li>
                        <li class="mdl-menu__item" data-val="3" >Ev. Técnica</li>
                        <li class="mdl-menu__item" data-val="4" >Finales</li>
                    </ul>
                </div>

                <button disabled id="eliminar-proceso" class="eliminar-proceso mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                    <i class="material-icons">delete</i> Eliminar
                </button>

            </form>

        </div>

        <hr style="margin-left: 12px; margin-right: 12px;">

<!--        <div class="cabecera-procesos">-->
<!---->
<!--            <h5 style="float: left;">CUARTA CONVOCATORIA</h5>-->
<!---->
<!--            <h5 style="float: right">ESTADO : VIGENTE</h5>-->
<!---->
<!--        </div>-->

		<div class="contenedor-tabla">
			<table style="width: 100% !important;" class="tabla no-margin-b" border="0" align="center">
				<tbody id="cuerpo">
				<tr class="encabezado-procesos">
                    <td rowspan="2" id="td_select"></td>
                    <td style="width: 144px;" rowspan="2" id="td_n">
						<p style="text-align: center;" align="center"><span style="color: #ffffff;"><strong>N°</strong></span></p>
					</td>
					<td rowspan="2" id="td_puesto">
						<p style="text-align: center;" align="center"><span style="color: #ffffff;"><strong>Puesto</strong></span></p>
					</td>
					<td rowspan="2">
						<p style="text-align: center;" align="center"><span style="color: #ffffff;"><strong>Perfil</strong></span></p>
					</td>
					<td style="width: 102px;" rowspan="2">
						<p style="text-align: center;" align="center"><span style="color: #ffffff;"><strong>Comunicados</strong></span></p>
					</td>
					<td colspan="3">
						<p style="text-align: center;" align="center"><span style="color: #ffffff;"><strong>Resultados</strong></span></p>
					</td>
				</tr>
				<tr class="encabezado-procesos">
					<td style="text-align: center;">
						<p style="text-align: center;" align="center"><span style="color: #ffffff;"><strong>Evaluación Curricular</strong></span></p>
					</td>
					<td style="text-align: center;">
						<p style="text-align: center;" align="center"><span style="color: #ffffff;"><strong>Evaluación Técnica</strong></span></p>
					</td>
					<td style="text-align: center;">
						<p style="text-align: center;" align="center"><span style="color: #ffffff;"><strong>Finales</strong></span></p>
					</td>
				</tr>

				<?php
				if ( $result->num_rows > 0) {
					if ($conexion_i->conectar()) {
						$i = 0;
                        $alt='img';
						foreach ($result as $row) {
						    $data_ruta = mysqli_fetch_row( $conexion_i->getdata_ruta($row['id']) );

							echo '<tr data-id="'.$row['id'].'">';

							echo '<td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check" for="checkbox-'.$row['id'].'">
                                <input type="checkbox" id="checkbox-'.$row['id'].'" class="mdl-checkbox__input">
                            </label></td>';

							echo '<td>
                                    <p style="text-align: center;" align="center">'.$row['numero'].'</p>
                                </td>';

							echo '<td>
                                    <p style="text-align: center;" align="center"><span style="text-transform: uppercase; font-family: \'Arial Narrow\',\'sans-serif\'; font-size: 11pt;">'. strtoupper($row['puesto']).'</span></p>
                                </td>';

                            for ($i=0; $i <= 4; $i++ ) {
	                            echo '<td class="fila-proceso" data-id-doc="'.$i.'">';
	                            $docs = $conexion_i->getdata_docs_proceso($row['id'], $i);
	                            if ($docs->num_rows > 0) {
	                                // import_export
	                                $count = 1;
		                            foreach ($docs as $d) {

                                      switch ($i) {
	                                      case 0:
	                                          $alt = 'perfil';
		                                      break;
                                          case 1:
	                                          $alt = 'comunicado';
                                            break;
                                          case 2:
	                                          $alt = 'ev_curricular';
                                            break;
	                                      case 3:
                                              $alt = 'ev_tecnica';
		                                      break;
	                                      case 4:
                                              $alt = 'final';
		                                      break;
                                      }

		                                if ($docs->num_rows == $count) {
                                            echo '<a href="/documentos/convocatorias_cas/'.$data_ruta[0].'/'.str_replace(' ', '_', $data_ruta[1]).'/'.preg_replace('/[^A-Za-z0-9\-]/', '', $data_ruta[2]).'/'.$d['nombre_pdf'].'">
                                                    <img src="/wp-content/uploads/2017/07/active_pdf.png" alt="'.$alt.'" class="img-no-bottom">
                                                </a>';
                                            echo '<br>';
                                            echo '<button class="editar inferior" data-tooltip="Editar">
                                                      <i class="material-icons">edit</i>
                                                  </button>';

                                            if ($count>1) {
                                                echo '<button class="ordenar inferior" data-tooltip="Ordenar">
                                                      <i class="material-icons">import_export</i>
                                                  </button>';
                                            }

                                        }
                                        else {
	                                        echo '<a href="/documentos/convocatorias_cas/'.$data_ruta[0].'/'.str_replace(' ', '_', $data_ruta[1]).'/'.preg_replace('/[^A-Za-z0-9\-]/', '', $data_ruta[2]).'/'.$d['nombre_pdf'].'">
                                                <img src="/wp-content/uploads/2017/07/active_pdf.png" alt="'.$alt.'" class="img-6-bottom">
                                            </a><br>';
                                        }
                                        $count++;
		                            }
	                            }
	                            else {
		                              echo '<button class="anadir inferior" data-tooltip="Añadir Documento">
                                            <i class="material-icons">add_circle_outline</i>
                                          </button>';
	                            }
	                            echo '</td>';
                            }

                            echo '</tr>';
						}
						$conexion_i->desconectar();
					}
				}

                echo '<tr id="fila-anadir-proceso">
                        <td colspan="8">
                            <button class="anadir-proceso inferior" data-tooltip="Añadir Proceso">
                                <i class="material-icons">add_circle_outline</i>
                            </button>
                        </td>
                    </tr>'; ?>

				</tbody>
			</table>
		</div>
	</div>

	<div class="mdl-cell mdl-cell--1-col mdl-cell--1-col-tablet"></div>
</div>

<script defer src="js/getmdl-select.min.js"></script>

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="js/alertify.min.js"></script>

<script>
    $(document).ready(function() {
        alertify.set('notifier','position', 'top-right');
        // Show message when this page is called from other
			<?php
			if (isset($_SESSION['message'])) {
				switch ($_SESSION['message'][0]) {
					case 0:
						echo 'alertify.success(\''.$_SESSION['message'][1].'\');';
						break;
					case 1:
						echo 'alertify.error(\''.$_SESSION['message'][1].'\');';
						break;
					case 2:
						echo 'alertify.warning(\''.$_SESSION['message'][1].'\');';
						break;
					case 3:
						echo 'alertify.message(\''.$_SESSION['message'][1].'\');';
						break;
				}
				// clear the value so that it doesn't display again
				unset($_SESSION['message']);
			}
			?>

    });
</script>

<script>
    $(document).ready(function() {

        let i = 0;

        // let nuevosDIV = $('#cuerpo');
        let fila_anadir = $('#fila-anadir-proceso');

        $('.boton-top-d').click(function () {

            let tipo = $('input[name="select-global"]').val();

            if ( tipo !== null && tipo !== '') {
                window.location = "frm_editar_docs_global.php?id=<?php echo $id_convocatoria ?>&tipo="+tipo;
            }


        });

        $('.anadir-proceso').click(function (e) {

            e.preventDefault();

            $width_puesto = $('#td_puesto').width();
            $width_n = $('#td_n').width();

            plantilla = `<tr>
                            <td>
                            </td>
                            <td>
                                <div class="mdl-textfield mdl-js-textfield" style="width: `+$width_n+`px;">
                                <input class="mdl-textfield__input" type="text" id="lbl1_`+i+`" autocomplete="off">
                                <label class="mdl-textfield__label" for="lbl1_`+i+`">PROCESO CAS N°...</label>
                            </div>
                            </td>
                            <td>
                                <div class="mdl-textfield mdl-js-textfield" style="width: `+$width_puesto+`px">
                                    <input class="mdl-textfield__input" type="text" id="lbl2_`+i+`" autocomplete="off">
                                    <label class="mdl-textfield__label" for="lbl2_`+i+`">SERVICIO DE...</label>
                                </div>
                            </td>
                            <td colspan="5" data-i="`+i+`">
                                <button class="guardar mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
                                    Guardar
                                </button>

                                <button class="cancelar mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                                    Cancelar
                                </button>
                            </td>
                        </tr>`;

            let el = $(plantilla);

            el.find('.guardar').click(function(e) {

                // Get data
                let boton = $(this);
                let current_i = boton.parent().attr('data-i');

                let numero = $('#lbl1_'+current_i).val();
                let puesto = $('#lbl2_'+current_i).val();

                // Validaciones
                // si los campos estan vacios
                if ((numero === '' || numero === null) && (puesto === '' || puesto === null)) {
                    alertify.alert(
                        'Web - DDC Cusco',
                        'Debe ingresar el numero y puesto del proceso');
                }
                else {
                    // Guardar AJAX
                    $.ajax({
                        type: 'POST',
                        url: 'crea_proceso.php',
                        datatype:"JSON",
                        data: {
                            numero: numero.toUpperCase(),
                            puesto: puesto.toUpperCase(),
                            id_convocatoria: <?php echo $id_convocatoria ?>,
                        },
                        success: function(data) {

                            const data2 = [];
                            data2.push(JSON.parse(data));

                            if (data2[0].estado) {
                                alertify.success('Proceso creado correctamente');

                                // crear checkbox
                                let c_select = `<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-g-`+i+`">
                                                  <input type="checkbox" id="checkbox-g-`+i+`" class="mdl-checkbox__input">
                                                </label>`;

                                // crear <p> y botones con la data insertada
                                let p_nro = '<p style="text-align: center;" align="center">'+numero.toUpperCase()+'</p>';
                                let p_puesto = '<p style="text-align: center;" align="center"><span style="text-transform: uppercase; font-family: "Arial Narrow","sans-serif"; font-size: 11pt;">'+puesto.toUpperCase()+'</span></p>';

                                let botones = '';

                                for (let ii = 0; ii <= 4; ii++) {
                                    botones += `<td class="fila-proceso" data-id-doc="`+ii+`" >
                                                    <button id="require-tooltip-`+i+`-`+ii+`" class="anadir inferior">
                                                        <i class="material-icons">add_circle_outline</i>
                                                    </button>
                                                    <div class="mdl-tooltip" data-mdl-for="require-tooltip-`+i+`-`+ii+`">
                                                        Añadir documento
                                                    </div>
                                                </td>`;
                                }

                                boton.parent().parent().attr('data-id', data2[0].valor);

                                // set <p> text to elements
                                let a1 = boton.parent().parent().children().eq(0);
                                let a = boton.parent().parent().children().eq(1);
                                let b = boton.parent().parent().children().eq(2);

                                a1.prepend(c_select);
                                a.prepend(p_nro);
                                b.prepend(p_puesto);
                                b.after(botones);

                                // eliminar textboxs
                                $('#lbl1_'+current_i).parent().remove();
                                $('#lbl2_'+current_i).parent().remove();
                                $('[data-i='+current_i+"]").remove();

                                let tabla = jQuery('.tabla');

                                // tabla.find(".mdl-checkbox__input").off('click').on('click', function() {
                                tabla.find(".mdl-checkbox__input").unbind('click').click( function() {

                                    let nro_checked = get_nro_checked();

                                    hab_deshab($(this));

                                    if (nro_checked > 0) {
                                        $('.eliminar-proceso').removeAttr("disabled");
                                    }
                                    else {
                                        $('.eliminar-proceso').attr("disabled", "disabled");
                                    }

                                });

                                tabla.find('button.anadir').click(function () {
                                    let id_proceso = $(this).parent().parent().attr('data-id');
                                    let tipo = $(this).parent().attr('data-id-doc');

                                    window.location = "frm_editar_doc.php?id_proceso="+id_proceso+"&tipo="+tipo;
                                });

                                tabla.find('[data-id]')
                                    .each(function (i, e) {
                                        // numero
                                        let element0 = $(e).children().eq(1);
                                        let proceso_a = element0.find('p').text();

                                        // element0.click(function () {});

                                        element0.dblclick(function () {

                                            let id_proceso = $(this).parent().attr('data-id');
                                            proceso_a = $(this).text();
                                            console.log(proceso_a);

                                            alertify.prompt( 'Editar - Web - DDC Cusco', 'N° del Proceso', proceso_a
                                                , function(evt, value) {
                                                    // validaciones
                                                    if (value === '' || value == null) {
                                                        // valor en blanco
                                                        alertify.error('Número de proceso vacío.')
                                                    }
                                                    else {
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'actualiza_nro.php',
                                                            datatype:"JSON",
                                                            data: {
                                                                numero: value,
                                                                id_proceso: id_proceso,
                                                            },
                                                            success: function(data) {

                                                                const data2 = [];
                                                                data2.push(JSON.parse(data));

                                                                if (data2[0].estado) {
                                                                    alertify.success('Edición correcta');
                                                                }
                                                                else {
                                                                    alertify.error('Error : '+data2[0].valor);
                                                                }

                                                                // reemplazar proceso
                                                                element0.find('p').text(value);

                                                            },
                                                            error: function (jqXHR, status, err) {
                                                                alertify.error('Ocurrió un error inesperado');
                                                            }
                                                        });
                                                    }
                                                }
                                                , function () {
                                                    // NO
                                                }
                                            )}
                                        );

                                        // puesto
                                        let element1 = $(e).children().eq(2);

                                        let puesto_a = element1.find('p').text();

                                        // element1.click(function () {});

                                        element1.dblclick(function () {

                                            let id_proceso = $(this).parent().attr('data-id');

                                            alertify.prompt( 'Editar - Web - DDC Cusco',
                                                'Puesto',
                                                puesto_a.toUpperCase(),
                                                function (evt, value) {
                                                    // validaciones
                                                    if (value === '' || value == null) {
                                                        // valor en blanco
                                                        alertify.error('Campo "puesto" vacío.')
                                                    }
                                                    else {
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'actualiza_puesto.php',
                                                            datatype:"JSON",
                                                            data: {
                                                                puesto: value.toUpperCase(),
                                                                id_proceso: id_proceso,
                                                            },
                                                            success: function(data) {

                                                                const data2 = [];
                                                                data2.push(JSON.parse(data));

                                                                if (data2[0].estado) {
                                                                    alertify.success('Edición correcta');
                                                                }
                                                                else {
                                                                    alertify.error('Error : '+data2[0].valor);
                                                                }

                                                                // reemplazar puesto
                                                                element1.find('p').text(value);

                                                            },
                                                            error: function (jqXHR, status, err) {
                                                                alertify.error('Ocurrió un error inesperado');
                                                            }
                                                        });
                                                    }
                                                },
                                                function () {
                                                    // NO
                                                });
                                        });
                                    });

                            }
                            else {
                                alertify.error('Error : ' + data2[0].valor);
                            }
                        },
                        error: function (jqXHR, status, err) {
                            // alert("Local error callback.");
                            alertify.error('Ocurrió un error inesperado');
                        },
                        complete: function () {
                            componentHandler.upgradeDom();
                        }
                    });
                }
            });

            el.find('.cancelar').click(function(e) {

                alertify.confirm(
                    'Web - DDC Cusco',
                    '&iquest;Est&aacute; seguro de retirar este elemento?',
                    function() {
                        el.remove();
                        alertify.success('Elemento retirado');
                    },
                    function(){
                        // -- NO
                    }).set('maximizable', false)
                    .set('labels', {ok:'Si', cancel:'No'});

            });

            el.insertBefore(fila_anadir);

            i++;

            componentHandler.upgradeDom();

        });

        $('#home-convocatorias').click(function (e) {
            e.preventDefault();

            window.location.replace("index.php");
        });

        $('#guardar').click(function (e) {
            e.preventDefault();

            let boton = $(this);
            let formulario = boton.parent();

            // Validaciones del Formulario
            // if(document.getElementById("imagen").value !== "") {
            //     formulario.submit();
            // } else alertify.alert('Web - PeruInkaTrips', 'Debe seleccionar una imagen !');
        });

        // Cancelar
        $('#cancelar').click(function(e) {
            e.preventDefault();

            // comprobar iterando en los input text
            // let elements = document.getElementById("formulario").elements;
            //
            // let comprueba = false;
            //
            // for (let i = 0, element; element = elements[i++];) {
            //     if ( element.name === "titulo" ||
            //         element.name === "enlace" ||
            //         element.name === "documento" ) {
            //
            //         console.log(element.name);
            //
            //         if (element.value !== '')
            //         {
            //             comprueba = true;
            //             break;
            //         }
            //     }
            // }
            //
            // if (comprueba) {
            //
            //     alertify.confirm(
            //         'Web - DDC Cusco',
            //         '&iquest;Est&aacute; seguro de descartar este formulario?',
            //         function() {
            //             window.location.replace("index.php");
            //         },
            //         function(){
            //             // alertify.error('Cancel')
            //             // return false;
            //         }).set('maximizable', false)
            //         .set('labels', {ok:'Si', cancel:'No'});
            //
            // }
            // else {
            window.location = 'index.php';
            // }

        });

        function get_nro_checked() {
            return $('.mdl-checkbox__input:checkbox:checked').length;
        }

        function hab_deshab(obj) {
            if (obj.parent().parent().parent().hasClass('selected_row')) obj.parent().parent().parent().removeClass('selected_row');
            else obj.parent().parent().parent().addClass('selected_row');
        }

        let elems = [];

        function set_selected_data_to_arrays() {

            let array_id_tours = $('.mdl-checkbox__input:checkbox:checked');

            elems = [];

            for (let i = 0; i < array_id_tours.length; i++) {
                nombre_item = parseInt($(array_id_tours.get(i)).parent().parent().parent().attr('data-id'));
                elems.push( nombre_item );
            }

            $('#id_procesos').val(JSON.stringify(elems)); //store array
        }

        // Selectable
        $(".mdl-checkbox__input").click(function(event) {

            let nro_checked = get_nro_checked();

            hab_deshab($(this));

            if (nro_checked > 0) {
                $('.eliminar-proceso').removeAttr("disabled");
            }
            else {
                $('.eliminar-proceso').attr("disabled", "disabled");
            }
        });

        $("#eliminar-proceso").click(function(e) {
            e.preventDefault();

            set_selected_data_to_arrays();

            alertify.confirm(
                'Web - DDC Cusco',
                '¿Está seguro de eliminar los elementos seleccionados?',
                function() {
                    $('#form_elimina_p').submit();
                },
                function() {
                    // -- NO
                }).set('maximizable', false)
                .set('labels', {ok:'Si', cancel:'No'});
        });


        let tabla = jQuery('.tabla');

        tabla.find('[data-id]')
            .each(function (i, e) {
                // numero
                let element0 = $(e).children().eq(1);
                // let proceso_a = element0.find('p').text();

                // element0.click(function () {});

                element0.dblclick(function () {

                    let id_proceso = $(this).parent().attr('data-id');
                    let proceso_a = $(this).text().trim();

                    alertify.prompt( 'Editar - Web - DDC Cusco', 'N° del Proceso', proceso_a
                        , function(evt, value) {
                            // validaciones
                            if (value === '' || value == null) {
                                // valor en blanco
                                alertify.error('Número de proceso vacío.')
                            }
                            else {
                                $.ajax({
                                    type: 'POST',
                                    url: 'actualiza_nro.php',
                                    datatype:"JSON",
                                    data: {
                                        numero: value.toUpperCase(),
                                        id_proceso: id_proceso,
                                    },
                                    success: function(data) {

                                        const data2 = [];
                                        data2.push(JSON.parse(data));

                                        if (data2[0].estado) {
                                            alertify.success('Edición correcta');
                                        }
                                        else {
                                            alertify.error('Error : '+data2[0].valor);
                                        }

                                        // reemplazar proceso
                                        element0.find('p').text(value.toUpperCase());

                                    },
                                    error: function (jqXHR, status, err) {
                                        alertify.error('Ocurrió un error inesperado');
                                    }
                                });
                            }
                        }
                        , function () {
                            // NO
                        }
                    )}
                );

                // puesto
                let element1 = $(e).children().eq(2);

                // let puesto_a = element1.find('p').text();

                // element1.click(function () {});

                element1.dblclick(function () {

                    let id_proceso = $(this).parent().attr('data-id');
                    let puesto_a = $(this).text().trim();

                    alertify.prompt('Editar - Web - DDC Cusco', 'Puesto', puesto_a
                        , function (evt, value) {
                            // validaciones
                            if (value === '' || value == null) {
                                // valor en blanco
                                alertify.error('Campo "puesto" vacío.')
                            }
                            else {
                                $.ajax({
                                    type: 'POST',
                                    url: 'actualiza_puesto.php',
                                    datatype:"JSON",
                                    data: {
                                        puesto: value.toUpperCase(),
                                        id_proceso: id_proceso,
                                    },
                                    success: function(data) {

                                        const data2 = [];
                                        data2.push(JSON.parse(data));

                                        if (data2[0].estado) {
                                            alertify.success('Edición correcta');
                                        }
                                        else {
                                            alertify.error('Error : '+data2[0].valor);
                                        }

                                        // reemplazar puesto
                                        element1.find('p').text(value.toUpperCase());

                                    },
                                    error: function (jqXHR, status, err) {
                                        alertify.error('Ocurrió un error inesperado');
                                    }
                                });
                            }
                        }
                        , function () {
                            // NO
                        });
                });
            });

        // Editar Documentos
        tabla.find('button.editar').click(function () {
            let id_proceso = $(this).parent().parent().attr('data-id');
            let tipo = $(this).parent().attr('data-id-doc');

            window.location = "frm_editar_doc.php?id_proceso="+id_proceso+"&tipo="+tipo;
        });

        // Ordenar Documentos
        tabla.find('button.ordenar').click(function () {
            let id_proceso = $(this).parent().parent().attr('data-id');
            let tipo = $(this).parent().attr('data-id-doc');

            window.location = "frm_reorder_docs.php?id_proceso="+id_proceso+"&tipo="+tipo;
            // console.log(id);
        });

        tabla.find('button.anadir').click(function () {
            let id_proceso = $(this).parent().parent().attr('data-id');
            let tipo = $(this).parent().attr('data-id-doc');

            window.location = "frm_editar_doc.php?id_proceso="+id_proceso+"&tipo="+tipo;
        });

        // asignar tooltips a todos los elementos que contengan el atributo 'data-tooltip'
        let templateHtml = "<span class=\"mdl-tooltip\" for=\"\"></span>"; // texto html del elemento span que contendra el tooltip
        tabla.find('[data-tooltip]') // encontrar elementos con el atributo 'data-tooltip'
            .each(function (i, e) {
                let id = 'require-tooltip-' + i; // generar id dinamicamente de acuerdo al indice (el cual es unico en este grupo de elementos)
                let element = $(e); // crear referencia jQuery al elemento actual
                if (element.attr('id'))
                    id = element.attr('id'); // si el elemento ya tiene un atributo id, asignar este id a la variable 'id'
                else
                    element.attr('id', id); // caso contrario asignar el id generado como atributo id del elemento
                let template = $(templateHtml); // crear elemento jQuery a partir del texto html
                template.attr('for', id); // asignar atributo 'for'
                template.text($(e).attr('data-tooltip')); // insertar como texto del span (el cual sera el texto del tooltip) el valor del atributo 'data-tooltip' del elemento actual
                element.after(template); // insertar el elemento 'template' despues del elemento actual
            });
    });
</script>
</body>
</html>