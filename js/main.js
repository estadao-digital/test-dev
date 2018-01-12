/* A Funcao abaixo faz com que o clique no menu reset ele para que a navegacao fique mais intuitiva*/
$('.navbar-nav li a').click(function () {
    if (screen.width <= 991) {
        $('.navbar-toggler').click();
    }
});

/* Assim que a pagina carrega eu abro por padrao a pagina de compra que lista todos os carros*/
$(document).ready(function () {
    $.get("compra.html", function (data) {
        $('#content').html(data);
        loadCars();
        loadModal();
    }).fail(function () {
        alert("erro ao carregar atualize a pagina");
    })
});

function loadModal() {
    $.get("modal.html", function (data) {
        /*Coloco o modal junto com o conteudo*/
        $('#content').append(data);
        /* Pego todas as marcas existentes */
        var marcas = JSON.parse(GetMarcaCode());
        /* Transformo esse objeto em um select*/
        var selectMarca = objTOSelect(marcas);
        /*Coloco o select dentro da div*/
        $('#select-beast').append(selectMarca);
        /*Inicio o plugin do select para a marca*/
        $('#select-beast').selectize();
        /*Incio o plugin do select para o modelo */
        $('#select-Model').selectize();
        /*Incio o plugin do select para o ano*/
        $('#select-year').selectize();

        /*Quando o select da marca muda atualizamos o select*/
        $('#select-beast').change(function () {
            /*Pego a marca e coloco como uma variavel*/
            var marca = $(this).val();
            /*Pego todas os modelos apartir da marca que foi selecionada*/
            var models = JSON.parse(GetModelCode(marca, ''));
            /*transforo esse objeto em um select*/
            var selectModel = objTOSelect(models.modelos)
            /*Limpo a div do modelo */
            $('#modelgroup').html('')
            /*Faco o update da div no local correto com as informacoes dinamicas*/
            updatamodal($('#modelgroup'), 'select-Model', 'Modelo', 'Selecione uma marca antes', 'Selecione um modelo...');
            /*coloco as opcoes obtidas*/
            $('#select-Model').append(selectModel);
            /*Incio o plugin do select para o modelo*/
            $('#select-Model').selectize();
            /*Quando o select do modelo muda atualizamos o select*/
            $('#select-Model').change(function () {
                /*Pego a modelo e coloco como uma variavel*/
                var model = $(this).val();
                /*transforo esse objeto em um select*/
                var selectyears = objTOSelect(models.anos)
                console.log(models.anos);
                /*Limpo a div do ano */
                $('#yeargroup').html('')
                /*Faco o update da div no local correto com as informacoes dinamicas*/
                updatamodal($('#yeargroup'), 'select-year', 'Ano', 'Selecione um modelo antes', 'Selecione um ano...');
                /*coloco as opcoes obtidas*/
                $('#select-year').append(selectyears);
                /*Incio o plugin do select para o ano*/
                $('#select-year').selectize({
                    delimiter: ',',
                    persist: false,
                    create: function (input) {
                        return {
                            value: input,
                            text: input
                        }
                    }
                });
            })
        })
        /***** Quando tudo foi feito vamos salvar esses dados*/
        $('#saveImage').click(function () {
            if (sessionStorage.getItem('edit')) {
                alert(sessionStorage.getItem('edit'));
                $.ajax({
                    url: '/api/carros/' + sessionStorage.getItem('edit'),
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        'Marca': $('#select-beast').text(),
                        'Modelo': $('#select-Model').text(),
                        'Ano': $('#select-year').val()
                    },
                    success: function (result) {
                        alert('carro editado com sucesso');
                        sessionStorage.removeItem('edit')
                        loadCars();
                    }

                });
            } else {
                $.post("/api/carros", {
                    'Marca': $('#select-beast').text(),
                    'Modelo': $('#select-Model').text(),
                    'Ano': $('#select-year').val()
                }, function (result) {
                    alert('carro criado com sucesso');
                    loadCars();
                });
            }
        })
    })

}

/* A funcao abaixo eu pego todos os carros ja cadastrados e exibo eles na pagina de compra*/
function loadCars() {
    /* Aqui busco na api de carros todos os carros */
    $.getJSON("/api/carros", function (data) {
        $('.itemlist').html('');
        var item = '<!--- Lista dinamica --->';
        /* Como a resposta esta em um json faco um each para pegar cada uma*/
        $.each(data, function (index, value) {
            /*alimento as tags da pagina de modelo*/
            $.get("itemtemplate.html", function (data2) {
                var thisitem = data2;
                /*Nesse caso criei um sistema de tags para que o codigo possa ficar dinamico alimeto as principais informacoes*/
                thisitem = thisitem.replace(new RegExp('{marca-model}', 'g'), value.carros.Marca + ' / ' + value.carros.Modelo);
                thisitem = thisitem.replace(new RegExp('{model}', 'g'), value.carros.Modelo);
                thisitem = thisitem.replace(new RegExp('{marca}', 'g'), value.carros.Marca);
                thisitem = thisitem.replace(new RegExp('{year}', 'g'), value.carros.Ano);
                thisitem = thisitem.replace(new RegExp('{id}', 'g'), index);
                /*EXTRA eu insiro a imagem obtida pelo Crawler veja a funcao GetCarImg*/
                thisitem = thisitem.replace(new RegExp('{img}', 'g'), GetCarImg(value.carros.Marca + '+' + value.carros.Modelo + '+' + value.carros.Ano));
                $('.itemlist').append(thisitem)
            })
        });
    });
}


function updatamodal(div, id, title, placeholder, first) {
    var html = '<label for="' + id + '">' + title + '</label>\n' +
        '<select id="' + id + '" placeholder="' + placeholder + '">\n' +
        '<option value="">' + first + '</option>\n' +
        '</select>';
    div.html(html)
}

function objTOSelect(obj) {
    var select = ''

    $.each(obj, function (index, value) {
        select = select + '<option value="' + value.codigo + '">' + value.nome + '</option>';
    })
    return select;
}


function GetCarImg(cardata) {
    /*Função simples que obtem a imagem do carro apartir de uma busca no google com as informacoes do carro*/
    /*Veja o arquivo php para ver como foi feito*/
    var result = null;
    var scriptUrl = "/api/extra.php?img=" + cardata;
    $.ajax({
        url: scriptUrl,
        type: 'get',
        dataType: 'html',
        async: false,
        success: function (data) {
            result = data;
        }
    });
    return result;
}

function GetMarcaCode(marca) {
    /*Funcao para obter todas as marcas apartir do que for enviado*/
    var result = null;
    var scriptUrl = "/api/extra.php?marca=" + marca;
    $.ajax({
        url: scriptUrl,
        type: 'get',
        dataType: 'html',
        async: false,
        success: function (data) {
            result = data;
        }
    });
    return result;
}

function GetModelCode(marcaCode, model) {
    /*Funcao para obter todos os modelos apartir do que for enviado*/
    var result = null;
    var scriptUrl = "/api/extra.php?marca=" + marcaCode + '&model=' + model;
    $.ajax({
        url: scriptUrl,
        type: 'get',
        dataType: 'html',
        async: false,
        success: function (data) {
            result = data;
        }
    });
    return result;
}

function GetCarDetails(marcaCode, model, year) {
    /*Funcao para obter todos os dados do carro*/
    var result = null;
    var scriptUrl = "/api/extra.php?marca=" + marcaCode + '&model=' + model + "&ano=" + year;
    $.ajax({
        url: scriptUrl,
        type: 'get',
        dataType: 'html',
        async: false,
        success: function (data) {
            result = data;
        }
    });
    return result;
}

/* Funçoes da compra*/

/* Abro os produtto que foi clicado*/
function OpenProduct(i) {
    var thisdiv = '.product-id-' + i;
    var marca = $('.product-id-' + i + ' .product-marca-model').data('marca');
    var marcaCode = GetMarcaCode(marca)
    var model = $('.product-id-' + i + ' .product-marca-model').data('model');
    var year = $('.product-id-' + i + ' .product-year').data('year');
    var id = i;
    var img = $('.product-id-' + i + ' .product-image').data('img');
    fillmodal(marca, marcaCode, model, year, id, img)
}

/*Preencho o modal com os dados do carro*/
function fillmodal(marca, marcaCode, model, year, id, img) {
    $.get("modalcompra.html", function (data) {
        var ad = GetCarDetails(marcaCode, GetModelCode(marcaCode, model), year);
        console.log(ad)
        var details = JSON.parse(ad);
        data = data.replace(new RegExp('{marca}', 'g'), marca);
        data = data.replace(new RegExp('{valor}', 'g'), details.Valor);
        data = data.replace(new RegExp('{fuel}', 'g'), details.Combustivel);
        data = data.replace(new RegExp('{fipeCode}', 'g'), details.CodigoFipe);
        data = data.replace(new RegExp('{refmes}', 'g'), details.MesReferencia);
        data = data.replace(new RegExp('{type}', 'g'), details.TipoVeiculo);
        data = data.replace(new RegExp('{fuelCode}', 'g'), details.SiglaCombustivel);
        data = data.replace(new RegExp('{marcacode}', 'g'), marcaCode);
        data = data.replace(new RegExp('{model}', 'g'), model);
        data = data.replace(new RegExp('{year}', 'g'), year);
        data = data.replace(new RegExp('{id}', 'g'), id);
        data = data.replace(new RegExp('{img}', 'g'), img);
        $('#modal-compra').html(data);

        $('#editar').click(function () {
            console.log(ad);
            $('.go-back').click();
            $('.vender').click();
            sessionStorage.setItem('edit', id);
        });
        $('#apagar').click(function () {
            $.ajax({
                url: '/api/carros/' + id,
                type: 'DELETE',
                success: function (result) {
                    alert('removido com sucesso');
                    $('.go-back').click();
                    loadCars();
                }
            });
        })
    }).fail(function () {
        alert("erro ao carregar atualize a pagina");
    })
}

function GoBack() {
    $(".lightbox-blanket").toggle();
}