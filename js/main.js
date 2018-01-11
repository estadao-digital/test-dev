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
    }).fail(function () {
        alert("erro ao carregar atualize a pagina");
    })
});

/* A funcao abaixo eu pego todos os carros ja cadastrados e exibo eles na pagina de compra*/
function loadCars() {
    /* Aqui busco na api de carros todos os carros */
    $.getJSON("/api/carros", function (data) {
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
            //thisitem = thisitem.replace('{id}', value.carros.id)
        });

    });
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

function GetYearCode(marcaCode, model) {
    /*Funcao para obter todos os anos apartir do que for enviado*/
    var result = null;
    var scriptUrl = "/api/extra.php?marca=" + marcaCode + '&model=' + model + "&year";
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
    var scriptUrl = "/api/extra.php?marca=" + marcaCode + '&model=' + model + "&year=" + year;
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
    var marca = $('.product-marca-model').data('marca');
    var marcaCode = GetMarcaCode(marca)
    var model = $('.product-marca-model').data('model');
    var year = $('.product-year').data('year');
    var id = i;
    var img = $('.product-image').data('img');
    fillmodal(marca, marcaCode, model, year, id, img)
}

/*Preencho o modal com os dados do carro*/
function fillmodal(marca, marcaCode, model, year, id, img) {
    $.get("modalcompra.html", function (data) {
        data = data.replace(new RegExp('{marca}', 'g'), marca);
        data = data.replace(new RegExp('{marcacode}', 'g'), marcaCode);
        data = data.replace(new RegExp('{model}', 'g'), model);
        data = data.replace(new RegExp('{year}', 'g'), year);
        data = data.replace(new RegExp('{id}', 'g'), id);
        data = data.replace(new RegExp('{img}', 'g'), img);
        $('#modal-compra').html(data);

    }).fail(function () {
        alert("erro ao carregar atualize a pagina");
    })
}

function GoBack() {
    $(".lightbox-blanket").toggle();
}