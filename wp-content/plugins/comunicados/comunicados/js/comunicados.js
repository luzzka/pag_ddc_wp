// Add Comunicado
$('#add-comunicado').click(function (e) {
    e.preventDefault();

    window.location = "crear_comunicado.html";
});

// Ordenar Comunicados
$('#ordenar-comunicados').click(function (e) {
    e.preventDefault();

    window.location = "frm_reorder_comunicados.php";
});

var tabla = jQuery('.tablaComunicados');

// Publicar
tabla.find('button.publicado').click(function () {
    var id = $(this).parent().parent().attr('data-id');

    window.location = "cambia_estado.php?id="+id;
});

// No Publicar
tabla.find('button.nopublicado').click(function () {
    var id = $(this).parent().parent().attr('data-id');

    window.location = "cambia_estado.php?id="+id;
});

// Editar Comunicado
tabla.find('button.editar').click(function () {
    var id = $(this).parent().parent().attr('data-id');

    window.location = "frm_editar_comunicado.php?id="+id;
    // console.log(id);
});

// Eliminar Comunicado
tabla.find('button.eliminar[type=submit]').click(function (e) {
    e.preventDefault();
    var boton = $(this);
    var formulario = boton.parent();

    alertify.confirm(
        'Web - DDC Cusco',
        '&iquest;Est&aacute; seguro de eliminar el comunicado?',
        function() {
            formulario.submit();
        },
        function(){
            // NO
        }).set('maximizable', false)
        .set('labels', {ok:'Si', cancel:'No'});
});

// asignar tooltips a todos los elementos que contengan el atributo 'data-tooltip'
var templateHtml = "<span class=\"mdl-tooltip\" for=\"\"></span>"; // texto html del elemento span que contendra el tooltip
tabla.find('[data-tooltip]') // encontrar elementos con el atributo 'data-tooltip'
    .each(function (i, e) {
        var id = 'require-tooltip-' + i; // generar id dinamicamente de acuerdo al indice (el cual es unico en este grupo de elementos)
        var element = $(e); // crear referencia jQuery al elemento actual
        if (element.attr('id'))
            id = element.attr('id'); // si el elemento ya tiene un atributo id, asignar este id a la variable 'id'
        else
            element.attr('id', id); // caso contrario asignar el id generado como atributo id del elemento
        var template = $(templateHtml); // crear elemento jQuery a partir del texto html
        template.attr('for', id); // asignar atributo 'for'
        template.text($(e).attr('data-tooltip')); // insertar como texto del span (el cual sera el texto del tooltip) el valor del atributo 'data-tooltip' del elemento actual
        element.after(template); // insertar el elemento 'template' despues del elemento actual
    });