/*
 * Versão           :   3
 * Última alteração :   04/06/2013
 * Dependências     :   php/js/js_caminhoRoot.php
 */

//carrega o dropDown SubCategoria
function setDropDownSubcat(cat_value,objForm,selectSubCatName,value_selected,ehCadastro)
{
    var caminhoRootUrlPrivate = '../../';
    if(typeof window.caminhoRootUrl != "undefined" && window.caminhoRootUrl != null)
        caminhoRootUrlPrivate = window.caminhoRootUrl;
    if(typeof ehCadastro == "undefined" || ehCadastro == null )
    {
        ehCadastro = false;
    }

    if(typeof value_selected == "undefined")
    {
        value_selected = null;
    }
    //verifica se o browser tem suporte a ajax
    try {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e) {
        try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(ex) {
            try {
                ajax = new XMLHttpRequest();
            }
            catch(exc) {
                alert("Esse browser não tem recursos para uso do Ajax");
                ajax = null;
            }
        }
    }
    //se tiver suporte ajax
    if(ajax) {

        var objSelect  = objForm[selectSubCatName];
        //deixa apenas o elemento 1 no option, os outros são excluídos
        objSelect.innerHTML = '';
        ajax.open("GET", "http://localhost/root/trunk/php/subcategorias2.php?categoria="+cat_value, true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
            if(ajax.readyState == 2) {
                objSelect.innerHTML = "<option value=''>Carregando...!</option>";
            }
            //após ser processado - chama função processXML que vai varrer os dados
            if(ajax.readyState == 4 ) {
                if(ajax.responseXML) {
                    processXML(ajax.responseXML,objSelect,value_selected,ehCadastro);
                }
                else {
                    //caso não seja um arquivo XML emite a mensagem abaixo
                    objSelect.innerHTML = '';
                    var optionSub = document.createElement("option");
                    optionSub.value = "";
                    optionSub.text  = "--Nenhuma Subcategoria Cadastrada--";
                    objSelect.options.add(optionSub);
                }
            }
        }
        //passa o código do estado escolhido
        var params = "grupo="+cat_value;
        ajax.send(params);

    }
    return false;
}
function processXML(objResp,objSelect,value_selected,ehCadastro)
{
    //pega a tag cidade
    var dataArray   = objResp.getElementsByTagName("subcategoria");
    objSelect.innerHTML = "";
    var optionTodos = document.createElement("option");
    optionTodos.value = "";
    if(ehCadastro)
        optionTodos.text  = '';
    else
        optionTodos.text  = 'TODOS';
    objSelect.options.add(optionTodos);

    //total de elementos contidos na tag cidade
    if(dataArray.length > 0) {
        //percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
            //contéudo dos campos no arquivo XML
            var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
            var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
            //cria um novo option dinamicamente
            var novo = document.createElement("option");
            //atribui um valor
            novo.value = codigo;
            //atribui um texto
            novo.text  = descricao;
            //finalmente adiciona o novo elemento
            if(value_selected != null && value_selected == codigo)
                novo.setAttribute("selected","selected");

            objSelect.options.add(novo);
        }
    }
    else {
        //caso o XML volte vazio, printa a mensagem abaixo
        objSelect.innerHTML = "--Primeiro selecione a Categoria--";
    }
}