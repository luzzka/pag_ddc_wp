// Add Convocatoria
$('#add-base').click(function (e) {
    e.preventDefault();

    window.location = "../convocatorias2/crear_base.html";
});

$('#ordenar-base').click(function (e) {
    e.preventDefault();

    window.location = "../convocatorias2/frm_reorder_bases.php";
});

let tablaBases = jQuery('.tablaBases');

// Publicar
tablaBases.find('button.publicado').click(function () {
    let id = $(this).parent().parent().attr('data-id');

    window.location = "../convocatorias2/base_pub.php?id_base="+id;
    console.log(id);
});

// No Publicar
tablaBases.find('button.nopublicado').click(function () {
    let id = $(this).parent().parent().attr('data-id');

    window.location = "../convocatorias2/base_pub.php?id_base="+id;
    console.log(id);
});

// Editar Convocatoria
tablaBases.find('button.editar').click(function () {
    let id = $(this).parent().parent().attr('data-id');

    window.location = "../convocatorias2/frm_editar_base.php?id_base="+id;
    // console.log(id);
});

// Eliminar Convocatoria
tablaBases.find('button.eliminar[type=submit]').click(function (e) {
    e.preventDefault();
    let boton = $(this);
    let formulario = boton.parent();

    alertify.confirm(
        'Web - DDC Cusco',
        '&iquest;Est&aacute; seguro de eliminar este elemento?',
        function() {
            formulario.submit();
        },
        function(){
            // NO
        }).set('maximizable', false)
        .set('labels', {ok:'Si', cancel:'No'});
});

// asignar tooltips a todos los elementos que contengan el atributo 'data-tooltip'
let templateHtml = "<span class=\"mdl-tooltip\" for=\"\"></span>"; // texto html del elemento span que contendra el tooltip
tablaBases.find('[data-tooltip]') // encontrar elementos con el atributo 'data-tooltip'
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