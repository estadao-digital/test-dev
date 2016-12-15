var carroUtil = {
    templateCarro:
        '<div class="col grade_1_de_6">'+
            '<div class="caixa_carro">'+
                '<div class="id_carro">#ID#</div>'+
                '<strong>Marca:</strong> #MARCA#<br>'+
                '<strong>Modelo:</strong> #MODELO#<br>'+
                '<strong>Ano:</strong> #ANO#<br>'+
                '<a class="editarCarro" data-id="#ID#" data-marca="#MARCA#" data-modelo="#MODELO#" data-ano="#ANO#" href="javascript:void(0)"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a> | '+
                '<a class="apagarCarro" data-id="#ID#" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i> Apagar</a>'+
            '</div>'+
        '</div>',

    init: function() {
        this.mostraCarros();
        this.gatilhoNovoCarro();
        this.gatilhoSalvarCarro();
    },

    mostraCarros: function() {
        $("#lista-carros").empty();

        $.ajax({
            dataType: 'json',
            url: 'carros/',
            success: function(dadosJson) {
                var currSec = 0;
                var i = 1;
                var htmlCarros = '';

                $("#lista-carros").append('<div class="sec grupo" id="sec'+currSec+'">');
                $.each(dadosJson, function( idx, carro ) {
                    var mapaVars = {
                        '#MARCA#': carro.marca,
                        '#MODELO#': carro.modelo,
                        '#ANO#': carro.ano,
                        '#ID#': carro.id
                    };
                    item = carroUtil.templateCarro.replace(/#MARCA#|#MODELO#|#ANO#|#ID#/gi, function(matched){
                        return mapaVars[matched];
                    });
                    htmlCarros += item;
                    //$("#lista-carros").append(item);
                    if(i == 6) {
                        $("#lista-carros").append('<div class="sec grupo" id="sec'+currSec+'"><div>');
                        $("#sec"+currSec).html(htmlCarros);
                        htmlCarros = '';
                        i = 1;
                        currSec++;
                    } else {
                        i++;
                    }
                });

                if (htmlCarros !== '') {
                    $("#lista-carros").append('<div class="sec grupo" id="sec'+currSec+'"><div>');
                    $("#sec"+currSec).html(htmlCarros);
                } else {
                    $("#sec"+currSec).remove();
                }
                carroUtil.gatilhoEditaCarro();
                carroUtil.gatilhoDeletaCarro();

            }
        });
    },

    gatilhoNovoCarro: function() {
        $('#novo-carro').on('click', function(){
            $('#titulo-caixa-carro').html('<strong>Novo Carro</strong>');
            $('#acao').val('novo');
            $("#marca").val($("#marca option:first").val());
            $('#modelo').val('');
            $('#ano').val('');
            $('#insere-edita-carro').show();
            carroUtil.gatilhoSalvarCarro();
        });
    },

    gatilhoEditaCarro: function() {
        $('.editarCarro').off();
        $('.editarCarro').on('click', function(){
            $('#titulo-caixa-carro').html('<strong>Editar Carro :: '+$(this).data('id')+'</strong>');
            $('#acao').val('atualizar');
            $('#id-carro').val($(this).data('id'));
            $("#marca").val($(this).data('marca'));
            $('#modelo').val($(this).data('modelo'));
            $('#ano').val($(this).data('ano'));

            $('#insere-edita-carro').show();
            carroUtil.gatilhoSalvarCarro();
        });
    },

    gatilhoDeletaCarro: function() {
        $('.apagarCarro').off();
        $('.apagarCarro').on('click', function(){
            var idCarro = $(this).data('id');
            var r = confirm("Deseja deletar o carro de id: "+idCarro+" ?");
            if (r === true) {
                $.ajax({
                    url: '/carros/'+idCarro,
                    type: 'DELETE',
                    success: function() {
                        carroUtil.mostraCarros();
                    }
                });
            }
        });
    },

    gatilhoSalvarCarro: function() {
        $('#salvarCarro').off();
        $('#salvarCarro').on('click', function(){
            var acao = $('#acao').val();
            switch (acao) {
                case 'atualizar':
                    var idCarro = $('#id-carro').val();
                    var dados = JSON.stringify({
                        'marca' : $("#marca").val(),
                        'modelo' : $('#modelo').val(),
                        'ano' : $('#ano').val()
                    });
                    $.ajax({
                        url: '/carros/'+idCarro,
                        type: 'PUT',
                        dataType: 'json',
                        data: dados,
                        success: function() {
                            $('#insere-edita-carro').hide();
                            carroUtil.mostraCarros();
                            carroUtil.mostraMensagem('Carro '+idCarro+' Atualizado!');
                        }
                    });
                    break;
                case 'novo':
                    var dadosNovo = {
                        'marca' : $("#marca").val(),
                        'modelo' : $('#modelo').val(),
                        'ano' : $('#ano').val()
                    };
                    $.ajax({
                        url: '/carros/',
                        method: "POST",
                        data: dadosNovo,
                        success: function() {
                            $('#insere-edita-carro').hide();
                            carroUtil.mostraCarros();
                            carroUtil.mostraMensagem('Novo Carro Inserido');
                        }
                    });
                    break;
                default:
                    break;
            }
        });
    },

    mostraMensagem: function(mensagem){
        $("#resultado").html('<stong>'+mensagem+'</stong>');
        $("#ultimo-resultado").show();
        setTimeout(function(){
            $("#resultado").empty();
            $("#ultimo-resultado").hide();
        }, 5000);
    }
};

jQuery(document).ready(function($) {
    carroUtil.init();
});
