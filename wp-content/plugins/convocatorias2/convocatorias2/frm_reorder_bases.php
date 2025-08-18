<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if ($conexion_i->conectar()) {
    $result = $conexion_i->lista_bases_publicadas();
    $conexion_i->desconectar();
    ?>

    <!DOCTYPE html>
    <html lang="es-ES">
    <head>
        <title>Reordenamiento de Bases de Convocatorias</title>

        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />

        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

        <link rel="stylesheet" href="css/bases.css">
        <link rel="stylesheet" href="css/principal.css">
        <link rel="stylesheet" href="css/style.css">

        <link rel="stylesheet" href="css/alertify.min.css">
        <link rel="stylesheet" href="css/alertify.default.min.css">

        <style>
            tbody>tr {cursor: move;}
            img {
                width: auto !important;
                height: auto !important;
            }
        </style>
    </head>
    <body>

    <br>

    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">

        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-tablet"></div>

            <form action="registro_orden_bases.php" class="mdl-cell mdl-cell--8-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" method="post">

                <div class="mdl-grid">

                    <div class="h-scroll" style="width: 100%;margin-top: 10px; overflow-x: scroll;">
                        <table class="tablaBases mdl-data-table mdl-js-data-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr>
                                <th style="text-align: center">Icon.</th>
                                <th style="text-align: center">Nombre</th>
                                <th style="text-align: center">Estado</th>
                            </tr>
                            </thead>
                            <tbody id="selections">

                            <?php

                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_row($result)) { ?>
                                    <tr class="selection">
                                        <input name="ids[]" type="hidden" value="<?php echo $row[0]; ?>">
                                        <td style="text-align: center"><img src="icons/<?php echo $row[2] ?>"></td>
                                        <td style="text-align: left">
                                            <a style="color: black;"><?php echo $row[3] ?></a>
                                        </td>
                                        <td style="text-align: center">
                                            <button class="publicado2 inferior">
                                                <i class="material-icons">check_circle</i>
                                            </button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            else echo '<td colspan="3" style="text-align: center">SIN RESULTADOS</td>';
                            ?>

                            </tbody>
                        </table>


                    </div>
                    <br>
                </div>

                <button id="guardar" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" type="submit">
                    Guardar
                </button>
                &nbsp;
                <button id="cancelar" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                    Cancelar
                </button>

            </form>

            </div>

            <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-tablet"></div>
        </div>

    </div>

    <!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="js/Sortable.min.js"></script>
    <script src="js/alertify.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#cancelar').click(function (e) {
                e.preventDefault();

                var boton = $(this);
                var formulario = boton.parent();

                alertify.confirm(
                    'Web - DDC Cusco',
                    '¿Está seguro de salir sin guardar los cambios?',
                    function() {
                        window.location = "../convocatorias2/bases.php";
                    },
                    function(){
                        // NO
                    }).set('maximizable', false)
                    .set('labels', {ok:'Si', cancel:'No'});
            });

            Sortable.create(selections, {
                animation: 150
            });

        });
    </script>
    </body>
    </html>

<?php } else echo 'Error al conectar con la Base de Datos';