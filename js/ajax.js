function create() {
    var marca = document.querySelector(".form__input--marca-create");
    var modelo = document.querySelector(".form__input--modelo-create");
    var ano = document.querySelector(".form__input--ano-create");

    var error = document.querySelector(".form__error--create");
    var errorLog = "";

    if (marca.value != "" && modelo.value != "" && ano.value != "") {
        if (parseInt(ano.value) < 1950 || parseInt(ano.value) > 2999) {
            errorLog += "Ano inválido<br>";
        }

        else {
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    readAll();

                    marca.value = "";
                    modelo.value = "";
                    ano.value = "";

                    errorLog = "";
                    error.innerHTML = "";
                    error.style.visibility = "hidden";
                    error.style.WebkitTransform = "scale(0,0)";
                    error.style.msTransform = "scale(0,0)";
                    error.style.transform = "scale(0,0)";

                    closeModal();
                }
            };

            var url = "api.php?";
            url += "method=create&";
            url += "marca=" + marca.value + "&";
            url += "modelo=" + modelo.value + "&";
            url += "ano=" + ano.value;

            xmlhttp.open("POST",url, true);
            xmlhttp.send();
        }
    }

    else {
        errorLog += "Você precisa preencher todos os campos!<br>";
    }

    if (errorLog != "") {
        error.innerHTML = errorLog;
        error.style.visibility = "visible";
        error.style.WebkitTransform = "scale(1,1)";
        error.style.msTransform = "scale(1,1)";
        error.style.transform = "scale(1,1)";
    }
}

function readAll() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var carros = JSON.parse(this.responseText).carros,
                lista = document.querySelector(".carros-lista"),
                title = document.createElement("H1"),
                titleText;

            lista.innerHTML = "";

            if (carros.length == 0) {
                titleText = document.createTextNode("Nenhum carro registrado até o momento");
                title.setAttribute("class","carros-lista__element carros-lista__title carros-lista__title--blank col");
            }

            else {
                titleText = document.createTextNode("Carros");
                title.setAttribute("class","carros-lista__element carros-lista__title col");
            }

            title.appendChild(titleText);
            lista.appendChild(title);

            for (i = 0; i < carros.length; i++) {
                var li = document.createElement("LI");

                var id = document.createElement("INPUT");
                var marca = document.createElement("P");
                var modelo = document.createElement("P");
                var ano = document.createElement("P");
                var buttons = document.createElement("DIV");
                var editButton = document.createElement("BUTTON");
                var deleteButton = document.createElement("BUTTON");

                var marcaText = document.createTextNode("Marca: " + carros[i].marca);
                var modeloText = document.createTextNode("Modelo: " + carros[i].modelo);
                var anoText = document.createTextNode("Ano: " + carros[i].ano);
                var editButtonText = document.createTextNode("Editar");
                var deleteButtonText = document.createTextNode("Deletar");

                marca.appendChild(marcaText);
                modelo.appendChild(modeloText);
                ano.appendChild(anoText);
                editButton.appendChild(editButtonText);
                deleteButton.appendChild(deleteButtonText);

                id.type = "hidden";
                id.value = carros[i].id;

                editButton.setAttribute("onclick","edit('" + carros[i].id + "', '" + carros[i].marca + "', '" + carros[i].modelo + "', '" + carros[i].ano + "')");
                deleteButton.setAttribute("onclick","del(" + carros[i].id + ")");

                li.appendChild(id);
                li.appendChild(marca);
                li.appendChild(modelo);
                li.appendChild(ano);
                li.appendChild(buttons);
                buttons.appendChild(editButton);
                buttons.appendChild(deleteButton);

                if (i == carros.length - 1) {
                    li.setAttribute("class","carros-lista__element carros-lista__element--last col");
                }

                else {
                    li.setAttribute("class","carros-lista__element col");
                }

                id.setAttribute("class","form__input");
                marca.setAttribute("class","carros-lista__element__text col");
                modelo.setAttribute("class","carros-lista__element__text col");
                ano.setAttribute("class","carros-lista__element__text col");
                buttons.setAttribute("class","col carros-lista__element__buttons");
                editButton.setAttribute("class","form__button carros-lista__element__button carros-lista__element__button--first");
                deleteButton.setAttribute("class","form__button-red carros-lista__element__button");

                lista.appendChild(li);
            }
        }
    };

    var url = "api.php?";
    url += "method=read-all";

    xmlhttp.open("GET",url, true);
    xmlhttp.send();
}

function edit(id, marca, modelo, ano) {
    var idEdit = document.querySelector(".form__input--id-edit");
    var marcaEdit = document.querySelector(".form__input--marca-edit");
    var modeloEdit = document.querySelector(".form__input--modelo-edit");
    var anoEdit = document.querySelector(".form__input--ano-edit");

    idEdit.value = id;
    marcaEdit.value = marca;
    modeloEdit.value = modelo;
    anoEdit.value = ano;

    showModal('edit');
}

function update() {
    var id = document.querySelector(".form__input--id-edit");
    var marca = document.querySelector(".form__input--marca-edit");
    var modelo = document.querySelector(".form__input--modelo-edit");
    var ano = document.querySelector(".form__input--ano-edit");

    var error = document.querySelector(".form__error--edit");
    var errorLog = "";

    if (id.value != "" && marca.value != "" && modelo.value != "" && ano.value != "") {
        if (parseInt(ano.value) < 1950 || parseInt(ano.value) > 2999) {
            errorLog += "Ano inválido<br>";
        }

        else {
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    readAll();

                    marca.value = "";
                    modelo.value = "";
                    ano.value = "";

                    errorLog = "";
                    error.innerHTML = "";
                    error.style.visibility = "hidden";
                    error.style.WebkitTransform = "scale(0,0)";
                    error.style.msTransform = "scale(0,0)";
                    error.style.transform = "scale(0,0)";

                    closeModal();
                }
            };

            var url = "api.php?";
            url += "method=update&";
            url += "id=" + id.value + "&";
            url += "marca=" + marca.value + "&";
            url += "modelo=" + modelo.value + "&";
            url += "ano=" + ano.value;

            xmlhttp.open("POST",url, true);
            xmlhttp.send();
        }
    }

    else {
        errorLog += "Você precisa preencher todos os campos!<br>";
    }

    if (errorLog != "") {
        error.innerHTML = errorLog;
        error.style.visibility = "visible";
        error.style.WebkitTransform = "scale(1,1)";
        error.style.msTransform = "scale(1,1)";
        error.style.transform = "scale(1,1)";
    }
}

function del(id) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            readAll();
        }
    };

    var url = "api.php?";
    url += "method=delete&";
    url += "id=" + id;

    xmlhttp.open("POST",url, true);
    xmlhttp.send();
}

readAll();
