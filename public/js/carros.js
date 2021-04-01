// Verifies if the user typed a number.
function isNumberKey(event)
{
    let key = "";
    if (window.event) {
        key = event.keyCode;
    } else {
        key = event.which;
    }

    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if (key < 48 || key > 57) {
        return false;
    } else {
        return true;
    }
};

// Retrieves and lists all records.
function listAll()
{
    document.getElementById("carros_msg").innerHTML = 'Processando... Por favor, aguarde.';

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        // If the records request was successful.
        if ((this.readyState == 4) && (this.status == 200)) {
            const response = JSON.parse(this.responseText);

            // If no record was found, tells the user and stops processing.
            if (response[0] === "Nenhum resultado encontrado.") {
                document.getElementById("carros_msg").innerHTML = response;
                document.getElementById("carros_op").innerHTML = '';

                return true;
            }

            // If at least one record was found, proceeds with the processing.
            let tabela_carros = '<table id="tabela_carros">' +
                '<thead>' +
                '   <tr>' +
                '       <th>MARCA</th>' +
                '       <th>MODELO</th>' +
                '       <th>ANO</th>' +
                '       <th>OPERA&Ccedil;&Otilde;ES</th>' +
                '   </tr>' +
                '<thead>' +
                '<tbody>';

            // Counts how many records were found.
            var counter = 0;
            for (var i = 0; i < response.length; i++) {
                counter += 1;

                // Object with information about the current record.
                let carro = response[i];
                tabela_carros += '   <tr>' +
                '       <td>' + carro.marca + '</td>' +
                '       <td>' + carro.modelo + '</td>' +
                '       <td>' + carro.ano + '</td>' +
                '       <td>' +
                '           <button class="button edit" onclick="editOne(' + carro.id + ')">Editar</button>' +
                '           <button class="button exclude" onclick="excludeOne(' + carro.id + ')">Excluir</button>' +
                '       </td>' +
                '   </tr>';
            }

            tabela_carros += '</tbody>' +
                '</table>';

            // Shows the results table to the user.
            document.getElementById("carros_op").innerHTML = tabela_carros;

            document.getElementById("carros_msg").innerHTML = (counter == 1) ? '1 resultado encontrado.' : counter + ' resultados encontrados.';

        // If the records request was NOT successful.
        } else if ((this.readyState == 4) && (this.status != 200)) {
            document.getElementById("carros_msg").innerHTML = 'Houve um erro ao tentar recuperar a lista de carros cadastrados.';
        }
    };

    // Retrieves records.
    xmlhttp.open("GET", "http://localhost:8080/api/carros/", true);
    xmlhttp.send();
}

// Retrieves partial records, and prepares to include a new record.
function includeOne()
{
    document.getElementById("carros_msg").innerHTML = "Preencha o formul&aacute;rio abaixo.";

    let tabela_carros = '<table id="tabela_carros">' +
        '<thead>' +
        '   <tr>' +
        '       <th>MARCA</th>' +
        '       <th>MODELO</th>' +
        '       <th>ANO</th>' +
        '   </tr>' +
        '<thead>' +
        '<tbody>' +
        '   <tr>' +
        '       <td><div id="select_marca"><select name="marcas" id="marcas"></select></div></td>' +
        '       <td><input type="text" id="modelo" name="modelo" value=""></td>' +
        '       <td><input type="text" id="ano" name="ano" value="" style="width: 50px;" maxlength="4" onkeypress="return isNumberKey(event);"></td>' +
        '   </tr>' +
        '</tbody>' +
        '</table>' +
        '<div style="max-width: 800px; width: 100%; margin: auto;">' +
        '   <button type="button" class="button edit" id="include_one" onclick="inclusionConfirm()">Cadastrar</button>' +
        '   <button type="button" class="button" id="cancel" onclick="listAll()">Cancelar</button>' +
        '</div>';

    document.getElementById("carros_op").innerHTML = tabela_carros;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        // If the records request was successful.
        if ((this.readyState == 4) && (this.status == 200)) {
            const response = JSON.parse(this.responseText);

            let select_marcas = '<select name="marcas" id="marcas">';
            // If the response is wrong.
            if ((select_marcas === undefined) || (select_marcas === null)) {
                select_marcas += '<option value="-1">[Erro]</option>';
            // If the response is ok.
            } else {
                for (var i = 0; i < response.length; i++) {
                    let carro = response[i];
                    select_marcas += '<option value="' + carro.id + '">' + carro.marca + '</option>';
                }
            }
            select_marcas += '</select><br/>';

            document.getElementById("select_marca").outerHTML = select_marcas;

        // If the records request was NOT successful.
        } else if ((this.readyState == 4) && (this.status != 200)) {
            document.getElementById("carros_msg").innerHTML = 'Houve um erro ao tentar recuperar as informa&ccedil;&otilde;s do carro cadastrado.';
        }
    };

    // Retrieves the record.
    xmlhttp.open("GET", "http://localhost:8080/api/marcas/", true);
    xmlhttp.send();
}

// Includes a new record.
function inclusionConfirm()
{
    const marca_index = document.getElementById("marcas");
    const marca = marca_index.options[marca_index.selectedIndex].text;
    const modelo = document.getElementById("modelo").value;
    const ano = document.getElementById("ano").value;

    // Validates the form fields.
    if ((modelo === undefined) || (modelo === null) || (modelo == "")) {
        document.getElementById("carros_msg").innerHTML = 'O campo "modelo" deve ser preenchido.';

        return true;
    }

    if ((ano === undefined) || (ano === null) || (ano == "")) {
        document.getElementById("carros_msg").innerHTML = 'O campo "ano" deve ser preenchido.';

        return true;
    } else {
        if (ano < 1900) {
            document.getElementById("carros_msg").innerHTML = 'O valor m&iacute;nimo para o campo "ano" &eacute; "1900".';

            return true;
        }

        if (ano > 2022) {
            document.getElementById("carros_msg").innerHTML = 'O valor m&aacute;ximo para o campo "ano" &eacute; "2022".';

            return true;
        }
    }

    document.getElementById("include_one").style.visibility = 'collapse';
    document.getElementById("cancel").style.visibility = 'collapse';

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        // If the records request was successful.
        if ((this.readyState == 4) && (this.status == 200)) {
            const carro = JSON.parse(this.responseText);
            document.getElementById("carros_msg").innerHTML = carro;

        // If the records request was NOT successful.
        } else if ((this.readyState == 4) && (this.status != 200)) {
            document.getElementById("carros_msg").innerHTML = 'Houve um erro ao enviar as informa&ccedil;&otilde;s do carro.';
        }
    };

    // Sends the new record's information.
    xmlhttp.open("POST", "http://localhost:8080/api/carros/");
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    const post_json = JSON.stringify({ "marca" : marca, "modelo" : modelo, "ano": ano });
    xmlhttp.send(post_json);
}

// Retrieves only one record, and prepares to edit the record.
function editOne(id)
{
    if ((id === undefined) || (id === null)) {
        document.getElementById("carros_msg").innerHTML = 'Houve um erro ao tentar recuperar as informa&ccedil;&otilde;es do carro.';
        return true;
    }

    document.getElementById("carros_msg").innerHTML = 'Informe as novas informa&ccedil;&otilde;es do carro.';

    var carro = "";
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        // If the records request was successful.
        if ((this.readyState == 4) && (this.status == 200)) {
            carro = JSON.parse(this.responseText);

            document.getElementById("modelo").value = carro.modelo;
            document.getElementById("ano").value = carro.ano;

        // If the records request was NOT successful.
        } else if ((this.readyState == 4) && (this.status != 200)) {
            document.getElementById("carros_msg").innerHTML = 'Houve um erro ao tentar recuperar as informa&ccedil;&otilde;s do carro.';
        }
    };

    // Retrieves the record.
    xmlhttp.open("GET", "http://localhost:8080/api/carros/" + id, true);
    xmlhttp.send();

    xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        // If the records request was successful.
        if ((this.readyState == 4) && (this.status == 200)) {
            const response = JSON.parse(this.responseText);

            let select_marcas = '<select name="marcas" id="marcas">';

            // If the response is wrong.
            if ((select_marcas === undefined) || (select_marcas === null)) {
                select_marcas += '<option value="-1">[Erro]</option>';

            // If the response is ok.
            } else {
                for (var i = 0; i < response.length; i++) {
                    let marca = response[i];
                    if (carro.marca == marca.marca) {
                        select_marcas += '<option value="' + marca.id + '" selected>' + marca.marca + '</option>';
                    } else {
                        select_marcas += '<option value="' + marca.id + '">' + marca.marca + '</option>';
                    }
                }
            }

            select_marcas += '</select><br/>';

            document.getElementById("select_marca").outerHTML = select_marcas;
        } else if ((this.readyState == 4) && (this.status != 200)) {
            document.getElementById("carros_msg").innerHTML = 'Houve um erro ao enviar as informa&ccedil;&otilde;s do carro.';
        }
    };

    xmlhttp.open("GET", "http://localhost:8080/api/marcas/", true);
    xmlhttp.send();

    let tabela_carros = '<table id="tabela_carros">' +
        '<thead>' +
        '   <tr>' +
        '       <th>MARCA</th>' +
        '       <th>MODELO</th>' +
        '       <th>ANO</th>' +
        '   </tr>' +
        '<thead>' +
        '<tbody>' +
        '   <tr>' +
        '       <td><div id="select_marca"><select name="marcas" id="marcas"></select></div></td>' +
        '       <td><input type="text" id="modelo" name="modelo" value=""></td>' +
        '       <td><input type="text" id="ano" name="ano" value="" style="width: 50px;" maxlength="4" onkeypress="return isNumberKey(event);"></td>' +
        '   </tr>' +
        '</tbody>' +
        '</table>' +
        '<div style="max-width: 800px; width: 100%; margin: auto;">' +
        '   <button type="button" class="button edit" id="edit_one" onclick="editionConfirm(' + id + ')">Salvar</button>' +
        '   <button type="button" class="button" id="cancel" onclick="listAll()">Cancelar</button>' +
        '</div>';

    document.getElementById("carros_op").innerHTML = tabela_carros;
}

// Edits a record.
function editionConfirm(id)
{
    if ((id === undefined) || (id === null)) {
        document.getElementById("carros_msg").innerHTML = 'Houve um erro ao tentar recuperar as informa&ccedil;&otilde;es do carro.';
        return true;
    }

    const marca_index = document.getElementById("marcas");
    const marca = marca_index.options[marca_index.selectedIndex].text;
    const modelo = document.getElementById("modelo").value;
    const ano = document.getElementById("ano").value;

    // Validates the form fields.
    if ((modelo === undefined) || (modelo === null) || (modelo == "")) {
        document.getElementById("carros_msg").innerHTML = 'O campo "modelo" deve ser preenchido.';

        return true;
    }

    if ((ano === undefined) || (ano === null) || (ano == "")) {
        document.getElementById("carros_msg").innerHTML = 'O campo "ano" deve ser preenchido.';

        return true;
    } else {
        if (ano < 1900) {
            document.getElementById("carros_msg").innerHTML = 'O valor m&iacute;nimo para o campo "ano" &eacute; "1900".';

            return true;
        }

        if (ano > 2022) {
            document.getElementById("carros_msg").innerHTML = 'O valor m&aacute;ximo para o campo "ano" &eacute; "2022".';

            return true;
        }
    }

    document.getElementById("edit_one").style.visibility = 'collapse';
    document.getElementById("cancel").style.visibility = 'collapse';

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        // If the records request was successful.
        if ((this.readyState == 4) && (this.status == 200)) {
            const carro = JSON.parse(this.responseText);
            document.getElementById("carros_msg").innerHTML = carro;

        // If the records request was NOT successful.
        } else if ((this.readyState == 4) && (this.status != 200)) {
            document.getElementById("carros_msg").innerHTML = 'Houve um erro ao enviar as informa&ccedil;&otilde;s do carro.';
        }
    };

    xmlhttp.open("PUT", "http://localhost:8080/api/carros/" + id);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    const post_json = JSON.stringify({ "marca" : marca, "modelo" : modelo, "ano": ano });
    xmlhttp.send(post_json);
}

// Retrieves only one record, and prepares to exclude the record.
function excludeOne(id)
{
    document.getElementById("carros_msg").innerHTML = 'Confirme a exclus&atilde;o das informa&ccedil;&otilde;es.';

    let tabela_carros = '<table id="tabela_carros">' +
        '<thead>' +
        '   <tr>' +
        '       <th>MARCA</th>' +
        '       <th>MODELO</th>' +
        '       <th>ANO</th>' +
        '   </tr>' +
        '<thead>' +
        '<tbody>' +
        '   <tr>' +
        '       <td><div id="marca"></div></td>' +
        '       <td><div id="modelo"></div></td>' +
        '       <td><div id="ano"></div></td>' +
        '   </tr>' +
        '</tbody>' +
        '</table>' +
        '<div style="max-width: 800px; width: 100%; margin: auto;">' +
        '   <button type="button" class="button exclude" id="exclude_one" onclick="exclusionConfirm(' + id + ')">Excluir</button>' +
        '   <button type="button" class="button" id="cancel" onclick="listAll()">Cancelar</button>' +
        '</div>';

    document.getElementById("carros_op").innerHTML = tabela_carros;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        // If the records request was successful.
        if ((this.readyState == 4) && (this.status == 200)) {
            const carro = JSON.parse(this.responseText);

            document.getElementById("marca").innerText = carro.marca;
            document.getElementById("modelo").innerText = carro.modelo;
            document.getElementById("ano").innerText = carro.ano;

        // If the records request was NOT successful.
        } else if ((this.readyState == 4) && (this.status != 200)) {
            document.getElementById("carros_msg").innerHTML = 'Houve um erro ao enviar as informa&ccedil;&otilde;s do carro.';
        }
    };

    xmlhttp.open("GET", "http://localhost:8080/api/carros/" + id, true);
    xmlhttp.send();
}

function exclusionConfirm(id)
{
    if ((id === undefined) || (id === null)) {
        document.getElementById("carros_msg").innerHTML = 'Houve um erro ao tentar recuperar as informa&ccedil;&otilde;es do carro.';
        return true;
    }

    document.getElementById("exclude_one").style.visibility = 'collapse';
    document.getElementById("cancel").style.visibility = 'collapse';

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        // If the records request was successful.
        if ((this.readyState == 4) && (this.status == 200)) {
            const carro = JSON.parse(this.responseText);
            document.getElementById("carros_msg").innerHTML = carro;

        // If the records request was NOT successful.
        } else if ((this.readyState == 4) && (this.status != 200)) {
            document.getElementById("carros_msg").innerHTML = 'Houve um erro ao tentar excluir as informa&ccedil;&otilde;s do carro.';
        }
    };

    xmlhttp.open("DELETE", "http://localhost:8080/api/carros/" + id);
    xmlhttp.send();
}
