function SinglePage() {

    this.appendCarrosOnTable = appendCarrosOnTable;
    this.excluirCarroConfirm = excluirCarroConfirm;
    this.carregarAlteracaoCarro = carregarAlteracaoCarro;
    this.carregarCadastroCarro = carregarCadastroCarro;
    this.cadastrarCarro = cadastrarCarro;

    function excluirCarroConfirm(id) {
        if (confirm("Deseja realmente excluir o carro?")) {
            var AR = new AjaxRequest();
            var response = AR.getJSON('/carros/'+id, 'delete');
            response.then(
                function (val) {
                    document.getElementById("tbody-lista").innerHTML = '';
                    appendCarrosOnTable();
                }
            );

        }
    };
    function carregarAlteracaoCarro(id) {
        var AR = new AjaxRequest();
        var carros = AR.getJSON('/carros/'+id);

        carros.then(
            function (val) {
                var btnCadastrar = document.getElementById("button-cadastrar");
                if (btnCadastrar) {
                    btnCadastrar.innerHTML = 'Alterar';
                    btnCadastrar.id = 'button-alterar';
                }
                document.getElementById("p-label-form-carro").innerHTML = 'Alterar carro';
                document.getElementById("select-marca").options.namedItem(val.carro.marca).selected = true;
                document.getElementById("text-modelo").value = val.carro.modelo;
                document.getElementById("text-cor").value = val.carro.cor;
                document.getElementById("button-alterar").onclick = function() {
                    var AR = new AjaxRequest();
                    var e = document.getElementById("select-marca");
                    var marca = e.options[e.selectedIndex].value;
                    var modelo = document.getElementById("text-modelo").value;
                    var cor = document.getElementById("text-cor").value;
                    AR.getJSON('/carros/'+id+'?marca='+marca+'&modelo='+modelo+'&cor='+cor, 'put');
                    document.getElementById("tbody-lista").innerHTML = '';
                    alert('Carro alterado com sucesso!');
                    appendCarrosOnTable();
                }
            }
        );
    };
    function carregarCadastroCarro() {
        document.getElementById("p-label-form-carro").innerHTML = 'Cadastrar novo carro';
        document.getElementById("select-marca").options.namedItem('Honda').selected = true;
        document.getElementById("text-modelo").value = '';
        document.getElementById("text-cor").value = '';
        var btnAlterar = document.getElementById("button-alterar");
        if (btnAlterar) {
            btnAlterar.id = "button-cadastrar";
            btnAlterar.innerHTML = 'Cadastrar';
        }
    };
    function cadastrarCarro() {
        document.getElementById("button-limpar").onclick = function() {
            carregarCadastroCarro();
        };
        document.getElementById("button-cadastrar").onclick = function() {
            var AR = new AjaxRequest();
            var e = document.getElementById("select-marca");
            var marca = e.options[e.selectedIndex].value;
            var modelo = document.getElementById("text-modelo").value;
            var cor = document.getElementById("text-cor").value;
            AR.getJSON('/carros?marca='+marca+'&modelo='+modelo+'&cor='+cor, 'post');
            document.getElementById("tbody-lista").innerHTML = '';
            alert('Carro cadastrado com sucesso!');
            appendCarrosOnTable();
        };
    };
    function appendCarrosOnTable() {
        var AR = new AjaxRequest();
        var carros = AR.getJSON('/carros');
        var tbodyLista = document.getElementById("tbody-lista");

        carros.then(
            function (val) {
                val.carros.forEach(
                    function (currentVal) {
                        tbodyLista.innerHTML = tbodyLista.innerHTML +
                            "<tr> <th scope=\"row\">"+currentVal.id+"</th> <td>"+currentVal.marca+"</td> <td>"+currentVal.modelo+"</td> <td>"+currentVal.cor+"</td> <td><button type=\"button\" onclick=\"SinglePage.carregarAlteracaoCarro("+currentVal.id+")\" class=\"btn btn-info btn-sm\">Alterar</button></td> <td><button type=\"button\" onclick=\"SinglePage.excluirCarroConfirm("+currentVal.id+")\" class=\"btn btn-danger btn-sm\">Excluir</button></td> </tr>"
                        ;
                    }
                );
            }
        );
    };
}
