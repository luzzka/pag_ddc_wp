<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// traer id
$id_convocatoria = $_GET["id_convocatoria"];

// recuperar data según el ID

$row = "";

if ($conexion_i->conectar()) {

    $result = $conexion_i->listar_data_convocatoria($id_convocatoria);
    $result2 = $conexion_i->listar_conv_publicaciones($id_convocatoria);

    $conexion_i->desconectar();

    if (!$result) {
        // error al obtener la data de la convocatoria
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit(0);
    }

    // asignar data a row
    $row = mysqli_fetch_row($result);
}
else
{
    // error al conectar con la db, redirigir atras
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit(0);
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <title>Editar Convocatoria</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/principal.css">

    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/alertify.default.min.css">

    <!-- Date Picker -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css"/>

    <link rel="stylesheet" href="css/bootstrap-material-datetimepicker.css" />
    <!--<link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>-->

</head>
<body>

<div class="mdl-grid">

    <form class="mdl-cell mdl-cell--12-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" action="actualizar_conv.php" enctype="multipart/form-data" method="post">

        <input type="hidden" name="id" value="<?php echo $row[0]; ?>">

        <!--<div class="input-group">-->
        <div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="">Tipo de Convocatoria</label>
                <select name="tipo" id="tipo">
                    <option value="0" <?php if ($row[2] == "CAS") echo 'selected'; ?>>CAS</option>
                </select>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="">A&ntilde;o</label>
                <select name="ano" id="ano">
                    <option value="2018" <?php if ($row[3] == "2018") echo 'selected';?>>2018</option>
                    <option value="2017" <?php if ($row[3] == "2017") echo 'selected';?>>2017</option>
                    <option value="2016" <?php if ($row[3] == "2016") echo 'selected';?>>2016</option>
                    <option value="2015" <?php if ($row[3] == "2015") echo 'selected';?>>2015</option>
                    <option value="2014" <?php if ($row[3] == "2014") echo 'selected';?>>2014</option>
                </select>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label for="">Estado</label>
                <select name="estado" id="estado">
                    <option value="0" <?php if ($row[7] == "0") echo 'selected'; ?>>Abierto</option>
                    <option value="1" <?php if ($row[7] == "1") echo 'selected'; ?>>Cerrado</option>
                </select>
            </div>

        </div>

        <!--<div class="input-group">-->
        <div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="nro_conv" name="nro_conv" value="<?php echo $row[4] ?>">
                <label class="mdl-textfield__label" for="nro_conv">N&uacute;mero de Convocatoria</label>
                <span class="mdl-textfield__error">Solo datos num&eacute;ricos!</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="codigo-convocatoria" name="codigo-convocatoria" value="<?php echo $row[5] ?>">
                <label class="mdl-textfield__label" for="codigo-convocatoria">C&oacute;digo de Convocatoria</label>
            </div>

            <input id="documento" type="file" name="documento" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" />
            <label for="documento">
                <i class="material-icons">file_upload</i>
                <span><?php if (is_null($row[6]) || $row[6] == '') echo 'Sin Documento'; else echo $row[6]; ?></span>
            </label>
            <input id="estado_documento" name="estado_documento" type="hidden" value="1" >
            <button id="eliminardoc" class="eliminardoc">
                <i class="material-icons">delete_forever</i>
            </button>
            <div class="mdl-tooltip" data-mdl-for="eliminardoc">Eliminar Documento</div>

        </div>

        <div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-control-wrapper">
                        <input type="text" id="date" name="date" class="form-control floating-label" placeholder="Fecha" value="<?php echo $row[1] ?>">
                    </div>
                </div>
            </div>
        </div>

        <?php

        echo '<br>
                <hr>
                <div class="nuevo-field">
                    <button id="add">
                        <i class="material-icons">add_circle_outline</i>
                    </button>
                    <div class="mdl-tooltip" for="add">
                        A&ntilde;adir
                    </div>
                </div>';
        echo '<input id="deleted" name="deleted" type="hidden" value="">';
        echo '<div class="adjuntos">';
        if (mysqli_num_rows($result2) != 0) {

            $i=0;

            while ($row2 = mysqli_fetch_array($result2, MYSQLI_NUM)) {

                echo '<div id="'.$row2[0].'">
                        <input type="hidden" name="ids[]" value="'.$row2[0].'">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" name="titulo[]" value="'.$row2[2].'">
                            <label class="mdl-textfield__label" for="">T&iacute;tulo...</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" name="detalle[]" value="'.$row2[3].'">
                            <label class="mdl-textfield__label" for="">Detalle...</label>
                        </div>';

                if ( is_null($row2[4]) || $row2[4] == '' ) {
                    echo '<input id="enlace_'.$i.'" type="file" name="enlace[]" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" />
                        <label for="enlace_'.$i.'"><i class="material-icons">file_upload</i><span>Elije el Enlace</span></label>';
                }
                else {
                    echo '<input id="enlace_'.$i.'" type="file" name="enlace[]" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" />
                        <label for="enlace_'.$i.'"><i class="material-icons">file_upload</i><span>'.$row2[4].'</span></label>';
                }

                echo '<button id="el'.$i.'" class="eliminar">
                            <i class="material-icons">cancel</i>
                        </button>
                       <div class="mdl-tooltip" data-mdl-for="el'.$i.'">Eliminar</div>
                    </div>';

                $i++;
            }
        }
        echo '</div>';
        ?>

        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" type="submit">
            GUARDAR
        </button>
        &nbsp;
        <button id="cancelar" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
            Cancelar
        </button>

    </form>

</div>

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/alertify.min.js"></script>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="js/bootstrap-material-datetimepicker.js"></script>

<script>
    $(document).ready(function(){

        $('#date').bootstrapMaterialDatePicker({
            time: false,
            clearButton: true
        });

        var eliminados = [];

        // establecer pdf
        //var ed = $('#estado_documento_old').attr('value');
        var ed = <?php if (is_null($row[6]) || $row[6] == '') echo '0'; else echo '1'; ?>;
        var ss = $('#eliminardoc');

        var sss = ss.prev().prev();

        switch(ed) {
            case '0':
                sss.children('span').text('Sin Documento');

                // oculta boton
                ss.css('display','none');

                //sss.addClass('sin-enlace');
                break;
        }

        ss.click(function(e) {
            e.preventDefault();

            // limpia el texto de documento
            sss.children('span').text('Sin Documento');
            //sss.addClass('sin-enlace');

            // limpia la fila
            $('#documento').val(null);

            // establece estado_documento en 0
            $('#estado_documento').attr('value', 0);

            // oculta boton
            $('#eliminardoc').css('display','none');
        });

        var i = 0;

        var adjuntosDIV = $('.adjuntos');

        var plantilla2 = '<div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" name="titulo[]"><label class="mdl-textfield__label" for="">T&iacute;tulo...</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" name="detalle[]"><label class="mdl-textfield__label" for="">Detalle...</label></div><input type="file" name="enlace[]" placeholder="Seleccione Documento" class="form-control name_list" accept="application/pdf"><button class="eliminar"><i class="material-icons">cancel</i></button></div>';

        adjuntosDIV.find('button.eliminar').click(function (e) {
            e.preventDefault();

            let boton = $(this);
            let id_fila = boton.parent().attr('id');

            alertify.confirm(
                'Web - DDC Cusco',
                '&iquest;Est&aacute; seguro de retirar este elemento?',
                function() {

                    eliminados = eliminados.concat(id_fila);

                    // asign data for eliminados to input hidden
                    $('#deleted').attr('value', eliminados);

                    $("#"+id_fila).remove();

                    alertify.success('Elemento Retirado');
                },
                function(){
                    // -- NO
                }).set('maximizable', false)
                .set('labels', {ok:'Si', cancel:'No'});

        });

        $('#cancelar').click(function(e) {
            e.preventDefault();

            alertify.confirm(
                'Web - DDC Cusco',
                '&iquest;Est&aacute; seguro de salir sin guardar?',
                function() {
                    window.location.replace("index.php");
                },
                function(){
                    // NO
                }).set('maximizable', false)
                .set('labels', {ok:'Si', cancel:'No'});

        });

        $('#add').click(function (e) {

            e.preventDefault();

            plantilla2 = '<div><input type="hidden" name="ids[]" value="-1"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" name="titulo[]"><label class="mdl-textfield__label" for="">T&iacute;tulo...</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" name="detalle[]"><label class="mdl-textfield__label" for="">Detalle...</label></div><input id="enlace'+i+'" type="file" name="enlace[]" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" /><label for="enlace'+i+'"><i class="material-icons">file_upload</i><span>Elije el Enlace</span></label><button id="'+i+'" class="eliminar"><i class="material-icons">cancel</i></button><span class="mdl-tooltip" for="'+i+'">Eliminar</span></div>';

            var el = $(plantilla2);

            el.find('.eliminar').click(function(e) {
                e.preventDefault();

                alertify.confirm(
                    'Web - DDC Cusco',
                    '&iquest;Est&aacute; seguro de retirar este elemento?',
                    function() {
                        el.remove();
                        alertify.success('Elemento Retirado');
                    },
                    function(){
                        // -- NO
                    }).set('maximizable', false)
                    .set('labels', {ok:'Si', cancel:'No'});
            });

            el.appendTo(adjuntosDIV);

            componentHandler.upgradeDom();

            inp();

            i++;

        <?php
            if (mysqli_num_rows($result2) == 0) echo '}).click();';
            else echo '});';
        ?>

        function inp () {
            // INPUTS TYPE FILE
            var inputs = document.querySelectorAll( '.inputfile' );
            Array.prototype.forEach.call( inputs, function( input )
            {
                var label	 = input.nextElementSibling,
                    labelVal = label.innerHTML;

                input.addEventListener( 'change', function( e )
                {
                    var fileName = '';

                    fileName = e.target.value.split( '\\' ).pop();

                    if( fileName )
                        label.querySelector( 'span' ).innerHTML = fileName;
                    else
                        label.innerHTML = labelVal;

                    if (this.id === 'documento') {
                        $('#estado_documento').attr('value', 1);
                        $('#eliminardoc').css('display','inline-block');
                    }
                });
            });
        }

        inp();

    });

</script>
</body>
</html>
