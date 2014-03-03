var basePath;

if(!basePath) alert("O endereço base < basePath > não foi informado! ");


$(window).load(function()
{
    setupUrls();


    calcMediaFinalMgr();
});




function calcMediaFinal()
{
    //calcula a média final caso esta exista
    avaliacaoTotal = $('input[name="avaliacao_total"]');

    elements = $('.ONRelationBlock').find('span');

    total = 0;
    $(elements).each(function() {
        total += parseFloat($(this).text());
    });

    $(avaliacaoTotal).val(total);
}

function calcMediaFinalMgr()
{
    avaliacaoTotal = $('input[name="avaliacao_total"]');

    if($(avaliacaoTotal).val()) {

        calcMediaFinal();

        $(avaliacaoTotal).on('blur', function() {
            calcMediaFinal();
        });
    }
}

function setupUrls()
{
    $('button[name=recuperarSenha]').click(function(){
        window.location=basePath + "/usuarios/recuperarsenha";
    });

    $('button[name=usuario-perfil]').click(function(){
        window.location=basePath + "/usuarios/perfil";
    });

    $('button[name=voltar]').click(function(){
        history.back()
    });
}

// Change the collapse icon on collapse panels.
$(document).ready(function(){
    $('#collapseFiltros').on('show.bs.collapse', function () {
        $("#linkFiltros").removeClass("glyphicon-collapse-down");
        $("#linkFiltros").addClass("glyphicon-collapse-up");
    });

    $('#collapseFiltros').on('hidden.bs.collapse', function () {
        $("#linkFiltros").removeClass("glyphicon-collapse-up");
        $("#linkFiltros").addClass("glyphicon-collapse-down");
    });

    $('.menuToogle').mouseover(function(){
        $(this).click();
    });

    $('.dropdown-nested').click(function(event){
      event.stopPropagation();
      var dropdown = $(this).children('.dropdown-menu');
      dropdown.toggle();
     });
});
