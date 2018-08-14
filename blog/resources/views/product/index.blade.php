
@extends('product.layouts.index')

@section('content')

<br><bR>
<div align="center">

    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/js/jQuery.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/js/Validacao.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/jQuery/jquery.alerts.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/jQuery/jquery.confirmation.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/js/Util.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/js/Util.Ajax.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="/js/ajax_categoria_subcategoria.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/js/ajax_item.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/js/headmask2.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/busca_dinamica_gera_relatorio.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/modulos/cadastro/item/cadastro_item.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/twbs/bootstrap/dist/js/bootstrap.min.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/jzaefferer/jquery-validation/dist/jquery.validate.min.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/jzaefferer/jquery-validation/dist/additional-methods.min.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/jzaefferer/jquery-validation/src/localization/messages_pt_BR.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/igorescobar/jquery-mask-plugin/dist/jquery.mask.min.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/select2/select2/dist/js/select2.min.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/select2/select2/dist/js/i18n/pt-BR.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/makeusabrew/bootbox/bootbox.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/js/sqgnet_forms/formulario/formularios.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/vendor/ehpc/bootstrap-waitingfor/build/bootstrap-waitingfor.min.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/ajax/cadastro/referencial_sped/ajax_referencial_sped.js?t1505911682"></script>
    <script type="text/javascript" language="Javascript" src="http://localhost/root/trunk/php/modulos/cadastro/item/cadastro_produto.js?t1505911682"></script>


    <html><head>
        <meta http-equiv="Content-Language" content="pt-br">
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>Cadastro de Produto</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk/vendor/twbs/bootstrap/dist/css/bootstrap.min.css?t1505910802">
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk//vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css?t1505910802">
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk/vendor/select2/select2/dist/css/select2.min.css?t1505910802">
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk/vendor/fortawesome/font-awesome/css/font-awesome.min.css?t1505910802">
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk/php/css/padrao.css?t1505910802">
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk/php/css/padrao_abas.css?t1505910802">
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk/php/css/cadastro.css?t1505910802">
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk/php/modulos/cadastro/item/cadastro_item_style.css?t1505910802">
        <link rel="stylesheet" type="text/css" href="http://localhost/root/trunk/php/jQuery/jquery.alerts.tributacao.css?t1505910802">
        <script type="text/javascript">
            //<![CDATA[

            var abaCadastro = null;
            var caminhoRoot = '../../../../';
            var caminhoRootUrl = '../../../../';
            var tipo_item = 'EI2';
            var NumeroCasasDecimaisSistema = 4;
            var NumeroCasasDecimaisPercentual = 3;
            var NumeroCasasDecimaisQtd = 4;
            var LiberaContrato = true;
            var ehEmpresaDescontoSimples = false;
            var ehEmpresaLucroRealPresumido = true;
            var decimais = 4;
            var validacoes =
                {
                    'aliquota_pdv': true,
                    'validaPromocao': true,
                    'validaTempoPreparacao': true
                };
            var configEmpresa =
                {
                    'barras_relacionadas': true,
                    'industria': 'S'
                };
            var ehCloneItem = false;
            var NumeroMaxCaractCodigoInterno = 13;
            var temPermissaoCadastroCelera = false;
            var temIntegracaoAtivaPDV = false;
            var codigoBarrasValido = true;
            var utilizaItensAdicionais = true;
            var temIntegracaoAtivaCadastroCelera = false;
            var temIntegracaoCeleraComRevisao = false;
            var temIntegracaoLPGPlus = false;
            var ehRegimeEspeciaIcmsl32 = 'N';
            var idAliquotaRegimeEspecialIcms32 = null;            //]]>
        </script>

    </head>
    <body cz-shortcut-listen="true" style="">
    <br>
    <div align="center">

        <table width="915" height="auto" cellspacing="0" cellpadding="0" border="0">
            <tbody><tr>
                <td height="15" valign="middle"><font size="2">
                    </font>
                </td>
                <td><font size="2">&nbsp;</font></td>
                <td height="15" valign="middle" align="right"><font size="1">
                        &nbsp; [ <a href="?ID_produto=" title="Atualizar Página"><img src="../../../../imagens/arrow_refresh.png" height="12"> Atualizar</a> ]
                        &nbsp; [ <a href="http://localhost/root/trunk/php/modulos/cadastro/item/lista_estoque2.php" title="Voltar a Lista de Produtos"><img src="../../../../imagens/arrow_turn_left.png" height="12"> Voltar</a> ]
                    </font></td>
            </tr>
            </tbody></table>
        <form name="form" id="form" action="salva_produto" method="POST" onsubmit="return validarFormularioProdMP();">

            <table class="tabelaAbas" width="910" height="auto" cellspacing="0" cellpadding="0" border="0" style="border-left: 1px solid #000000;" align="center">
                <tbody><tr>
                    <!--1º Aba Dados Principais-->
                    <td height="10" class="menu-sel" id="td_dados" onclick="AlternarAbasProdMP('td_dados','div_dados')"><center>Dados Principais</center></td>
                    <!--2º Aba Fornecimento-->
                    <td height="10" class="menu" id="td_fornecimento" onclick="AlternarAbasProdMP('td_fornecimento','div_fornecimento')"><center>Fornecimento (Entrada)</center></td>
                    <!--3º Aba Estoque-->
                    <td height="10" class="menu" id="td_estoque" onclick="AlternarAbasProdMP('td_estoque','div_estoque')"><center>Estoque</center></td>
                    <!--4º Aba Venda-->
                    <td height="10" class="menu" id="td_venda" onclick="AlternarAbasProdMP('td_venda','div_venda')"><center>Venda (Saida)</center></td>
                    <!--5º Aba Tributação-->
                    <td height="10" class="menu" id="td_tributacao" onclick="AlternarAbasProdMP('td_tributacao','div_tributacao')"><center>Tributacao</center></td>

                    <!--6º Aba Parâmetros-->
                    <td height="10" class="menu" id="td_concent" onclick="AlternarAbasProdMP('td_concent','div_concent')"><center>PDV</center></td>
                    <!--7º Aba Produção-->
                    <td height="10" class="menu" id="td_producao" onclick="AlternarAbasProdMP('td_producao','div_producao')"><center>Produção</center></td>
                </tr>
                <tr>

                    <td height="auto" class="tb-conteudo" colspan="10">
                        <div id="div_dados" class="conteudo" style="">
                            <fieldset>
                                <legend> Principal </legend>
                                <table class="formcadastro" border="0">
                                    <tbody><tr>
                                        <td align="right" width="150px">Status</td>
                                        <td>
                                            <select name="ativo">
                                                <option value="T" title="Liberado para Compra / Produção e Venda">Ativo</option>
                                                <option value="C" title="Liberado para Compra / Produção">Ativo para Compra / Produção</option>
                                                <option value="V" title="Liberado para Venda">Ativo para Venda</option>
                                                <option value="N" title="Bloqueado para Compra / Produção e Venda">Inativo</option>
                                            </select>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td align="right">Código Anterior</td>
                                        <td><input type="text" name="codigoAnterior" value="">
                                            Data Alteração: <input type="text" onkeypress="mascaraData(event, this);" onblur="validaData(this)" name="dataAlteracao" value="20/09/2017"></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">* Codigo Interno</td>

                                        <td><input type="text" id="codigo" name="codigo" size="30" maxlength="30" value="005811" style="background: #9cc7f1;text-align:right;" readonly=""> SEQUENCIAL                </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">* Descricao</td>
                                        <td><input type="text" name="descricao" size="50" maxlength="50" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Descricao 2</td>
                                        <td><input type="text" name="descricao2" size="70" maxlength="100" value=""></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">* Unidade de Medida</td>
                                        <td><select name="ID_unidade" id="ID_unidade">
                                                <option></option>
                                                <option value="15">BAR - BARRIL</option><option value="14">BD - </option><option value="17">BR - BARRA</option><option value="3">CX - CAIXA</option><option value="7">DZ - DUZIA</option><option value="11">FD - FARDO</option><option value="19">FRA - </option><option value="16">FRD - </option><option value="13">GL - GALAO</option><option value="2">KG - KILO</option><option value="4">L - LITRO</option><option value="18">LAT - </option><option value="6">LT - LATA</option><option value="12">MC - </option><option value="8">ML - MILHEIRO</option><option value="20">MT - </option><option value="9">PC - PECA</option><option value="5">PCT - PACOTE</option><option value="10">SC - SACO</option><option value="1">UN - UNIDADE</option>               </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td><td>&nbsp;</td>
                                    </tr>
                                    </tbody></table>

                            </fieldset>

                            <fieldset>
                                <legend> Classificação </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="150px">* Setor</td>
                                        <td><select name="ID_setor">
                                                <option></option>
                                                <option value="1">50 MATERIA PRIMA</option><option value="2">90 USO CONSUMO</option><option value="3">99 ATIVO</option><option value="6">IT ADICIONAL</option><option value="5">PROD PROPRIA</option><option value="4">REVENDA</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">* Categoria</td>
                                        <td><select name="ID_categoria" onchange="setDropDownSubcat(this.value,this.form,'ID_subcategoria',null,true);">
                                                <option></option><option value="23">BEBIDAS</option><option value="24">BOMBONIERE</option><option value="34">CIGARROS</option><option value="29">CONFEITARIA</option><option value="28">COPA</option><option value="18">EQUIPAMENTOS</option><option value="26">FRIOS</option><option value="31">HORTIFRUT</option><option value="35">IT ADICIONAL</option><option value="22">LATICINIOS</option><option value="21">MERCEARIA</option><option value="32">PADARIA</option><option value="25">PAES E BOLOS REVENDA</option><option value="33">PIZZA</option><option value="27">REFEICOES</option><option value="20">SORVETES</option><option value="37">TABACARIA</option>                </select></td>
                                    </tr>
                                    <tr>

                                        <td align="right" width="150px">* Subcategoria</td>
                                        <td><select name="ID_subcategoria">
                                                <option></option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="120px">Marca</td>
                                        <td>
                                            <select name="ID_marca">
                                                <option></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="120px">Modelo</td>
                                        <td>
                                            <input type="text" name="modelo" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Tipo Material</td>
                                        <td><select name="ID_tipo">
                                                <option></option>
                                                <option value="1">PROD REVENDA</option><option value="2">PRODUCAO PROPRIA</option>                    </select>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                            <fieldset>
                                <legend> Observações </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="150px">Descricao Extensa</td>
                                        <td><textarea name="descricao_extensa" rows="4" cols="80"></textarea>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                        </div>
                        <div id="div_fornecimento" class="conteudo" style="display: none;">
                            <input type="hidden" id="pedido_decimais" name="pedido_decimais" value="4">
                            <fieldset>
                                <legend> Consumo </legend>
                                <table class="formcadastro" width="100%">
                                    <tbody><tr>
                                        <td align="right" width="150px">Número de Dias</td>
                                        <td>
                                            <input type="text" name="int_consumo_compras" size="12" value="0" onkeypress="return Validacao.mascara.inteiro(event, this, 3);" onkeydown="return Validacao.mascara.keysBackspaceDelete(event,this);" style="text-align:right">
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                            <fieldset>
                                <legend> Fornecedores </legend>
                                <h3 style="padding:5px; margin:5px; color:#000; font-size:1.70em; font-weight:bold; margin-bottom: 150px;"> Insira o item para cadastrar Fornecedores </h3>     </fieldset>
                        </div>
                        <div id="div_estoque" class="conteudo" style="display: none;">
                            <fieldset>
                                <legend> Parâmetros de Estoque </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="150px">* Tipo de Controle</td>
                                        <td><select name="tipo_controle" onchange="valida_tipo_controle(this.form)">
                                                <option value=""></option>
                                                <option value="1">Estoque</option><option value="2">Aplicação Direta</option><option value="3">Terceiros</option><option value="4">Serviço</option>                          </select></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px"> * Utilização </td>
                                        <td><select name="tipo_utilizacao">
                                                <option value=""></option>
                                                <option value="1">Revenda</option><option value="2">Industrial/Insumo</option><option value="3">Uso e Consumo/Despesa</option><option value="4">Ativo</option><option value="5">Outros</option><option value="6">Formulação Direta</option>                          </select></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="100px"></td>
                                        <td>
                                            <input type="checkbox" name="controlar_estoque" value="S" checked="checked"> Controlar Estoque
                                            &nbsp;&nbsp;|&nbsp;&nbsp;Local Padrão: <select name="ID_local_estoque_padrao">
                                                <option value=""></option>

                                                <option value="1" selected="selected">PRINCIPAL</option>        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="30px"></td>
                                        <td>
                                            <input type="checkbox" name="bloqueia_fracionado" value="S" title="Bloqueia a utilização de quantidade fracionada na Retaguarda"> Bloquear Fracionado
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="100px"></td>
                                        <td><input type="checkbox" name="gera_curva_abc" value="S"> Visualizar Produto na Curva ABC</td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="100px"></td>
                                        <td><input type="checkbox" name="aceita_variacao" value="S"> Aceita Variação</td>
                                    </tr>

                                    <tr><td>&nbsp;</td></tr>
                                    <tr>
                                        <td align="right" width="150px">Controle Estoque </td>
                                        <td>
                                            <select name="tipo_controle_estoque" onchange="validaTipoControleEstoque()">
                                                <option value="N" selected="selected"> Normal</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Estoque Minimo</td>
                                        <td><input type="text" name="qtd_minima" onkeypress="return Validacao.mascara.realComPonto(event, this, 8, 4);" onkeydown="return Validacao.mascara.keysBackspaceDelete(event,this);" size="12" maxlength="11" value="0.0000" style="text-align:right">  </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Estoque Máximo</td>
                                        <td><input type="text" name="qtd_maxima" size="12" maxlength="11" onkeypress="return Validacao.mascara.realComPonto(event, this, 8, 4);" onkeydown="return Validacao.mascara.keysBackspaceDelete(event,this);" value="0.0000" style="text-align:right">  </td>
                                    </tr>                          <tr>
                                        <td align="right" width="150px">Perda</td>
                                        <td><input type="text" name="perda" onkeypress="return Validacao.mascara.real(event, this, null, 3);" onkeydown="return Validacao.mascara.keysBackspaceDelete(event,this);" size="6" maxlength="7" value="0,000" style="text-align:right"> % </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Localização </td>
                                        <td><input type="text" name="localizacao" size="30" maxlength="30" value=""></td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                        </div>
                        <div id="div_venda" class="conteudo" style="display: none;">
                            <fieldset>
                                <legend> Tipo de Custo </legend>
                                <table class="formcadastro">
                                    <tbody><tr height="40px">
                                        <td width="230px">
                                            <input onchange="tipo_custo_item_OnChange(this.form,
                        '0,0000');" type="radio" name="tipo_custo_item" id="tipo_custo_item_MPF" value="MPF" disabled="disabled">
                                            <label for="tipo_custo_item_MPF">Maior preço dos Fornecedores</label>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr>
                                    <tr height="40px">
                                        <td>
                                            <input type="radio" name="tipo_custo_item" id="tipo_custo_item_UE" value="UE" onchange="tipo_custo_item_OnChange(this.form,
                                    '0,0000');" disabled="disabled"> <label for="tipo_custo_item_UE">Última Entrada</label>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr>
                                    <tr height="40px">
                                        <td>
                                            <input type="radio" name="tipo_custo_item" id="tipo_custo_item_UOCA" value="UOCA" disabled="disabled" onchange="tipo_custo_item_OnChange(this.form,
                                    '0,0000');"> <label for="tipo_custo_item_UOCA">Última Ordem de Compra Aprovada</label>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr>
                                    <tr height="40px">
                                        <td>
                                            <input type="radio" name="tipo_custo_item" id="tipo_custo_item_ME" value="ME" onchange="tipo_custo_item_OnChange(this.form,
                                '0,0000');" disabled="disabled"> <label for="tipo_custo_item_ME">Média das Últimas </label>
                                            <span style="margin-left:0px;">
                        <select name="custo_numero_entradas" disabled="disabled">
                        <option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>                        </select>
                    </span><label for="tipo_custo_item_ME"> Entradas</label>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr>
                                    <tr height="40px">
                                        <td>
                                            <input type="radio" name="tipo_custo_item" id="tipo_custo_item_UESI" value="UESI" checked="checked" onchange="tipo_custo_item_OnChange(this.form,
                                '0,0000');"> <label for="tipo_custo_item_UESI">Ultima entrada sem impostos <br>
                                                <span style="margin-left:30px;">(ICMS - PIS - COFINS - IPI)</span>
                                            </label>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr>
                                    <tr height="40px">
                                        <td>
                                            <input type="radio" name="tipo_custo_item" id="tipo_custo_item_PF" value="PF" onchange="tipo_custo_item_OnChange(this.form,
                                '0,0000');" disabled="disabled"> <label for="tipo_custo_item_PF">Preço da Formulação</label><br>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr>
                                    <tr height="40px">
                                        <td>
                                            <input type="radio" name="tipo_custo_item" id="tipo_custo_item_PVD" value="PVD" disabled="disabled" onchange="tipo_custo_item_OnChange(this.form,
                            '0,0000');"> <label for="tipo_custo_item_PVD">Desfragmentação / Vinculação</label><br>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>                  <fieldset>
                                <legend> Formação de Preço de Venda </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="200px">Formação de Preço</td>
                                        <td>
                                            <select name="formacaoPreco" onchange="recalculaPrecoVenda(this.form)">
                                                <option value="1">Preço de Custo</option>
                                                <option value="2">Reposição</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="200px">Preço de Reposição</td>
                                        <td><input type="text" name="precoReposicao" onkeypress="return Validacao.mascara.real(event, this, null, 4);" onchange="atualizaUsuarioDataReposicao(form), recalculaPrecoVenda(this.form);" size="12" maxlength="12" value="0,0000" style="text-align:right">
                                            <input type="hidden" name="idUsuarioAlteracaoPrecoReposicaoAlterado" value="1" disabled="disabled">
                                            <input type="hidden" name="dataAlteracaoPrecoReposicaoAlterado" value="2017-09-20 09:33:23" disabled="disabled">
                                            <input type="hidden" name="idUsuarioAlteracaoPrecoReposicao" value="">
                                            <input type="hidden" name="dataAlteracaoPrecoReposicao" value="">
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                            <fieldset>
                                <legend> Venda </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="200px">Comissão sobre Venda</td>
                                        <td><input type="text" name="comissao" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="6" maxlength="3" value="" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="200px">Preço de Custo R$ </td>
                                        <td>
                                            <input type="text" name="preco_custo_atual" size="12" maxlength="12" value="" readonly="readonly" disabled="disabled" style="text-align:right">
                                            <input type="hidden" name="precoCustoCalculado" value="" disabled="disabled">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="200px">Tipo de Lucro</td>
                                        <td>
                                            <select name="str_tipoMargemLucro" onchange="str_tipoMargemLucro_OnChange(this.form);">
                                                <option value="L">Livre</option>
                                                <option value="F">Fixa</option>
                                                <option value="S">Sugerida</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="200px">Margem de Lucro</td>
                                        <td>
                                            <input type="text" name="lucro_item" onkeypress="return Validacao.mascara.real(event, this, null, 3);" onchange="recalculaPrecoVenda(this.form);" size="12" value="0,000" style="text-align:right">%
                                        </td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td align="right" width="200px">Margem Atual</td>
                                        <td>
                                            <input type="text" name="margem_atual" disabled="disabled" readonly="readonly" size="12" value="0,000" style="text-align:right">%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="200px">Preço de Venda Unitário R$ </td>
                                        <td><input type="text" name="preco" onkeypress="return Validacao.mascara.real(event, this, null, 4);" onchange="calculaMargemAtual(this.form);" size="12" maxlength="12" value="0,0000" style="text-align:right">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="right" width="200px">Preço Unitário PDV R$ </td>
                                        <td><input type="text" name="fgTrucarArredondarPrecoUnitPDV" size="12" maxlength="12" value="" readonly="readonly" disabled="disabled" style="text-align:right">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="200px">Preço Site
                                            <input type="checkbox" value="S" name="enviar_preco_site" onchange="sugerePrecoSite(this.form , 0)" title="Envia o preço para o site"></td>
                                        <td><input type="text" name="preco_site" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="12" maxlength="12" value="0,00" style="text-align:right">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><font size="1">&nbsp;</font></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><font size="1">* Para obter mais Preços de venda, utilize <i>Tabelas de Preços </i></font></td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                        </div>
                        <div id="div_tributacao" class="conteudo" style="display: none">
                            <input type="hidden" name="ehCadastroCelera" value="N">
                            <fieldset>
                                <legend> ICMS </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="200px"> * Tipo Item Fiscal</td>
                                        <td>
                                            <select name="tipo_item_fiscal">
                                                <option></option>
                                                <option value="00">00 - Mercadoria para Revenda</option><option value="01">01 - Matéria-Prima</option><option value="02">02 - Embalagem</option><option value="03">03 - Produto em Processo</option><option value="04">04 - Produto Acabado</option><option value="05">05 - Subproduto</option><option value="06">06 - Produto Intermediário</option><option value="07">07 - Material de Uso e Consumo</option><option value="08">08 - Ativo Imobilizado</option><option value="09">09 - Serviços</option><option value="10">10 - Outros insumos</option><option value="99">99 - Outras</option>                    </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="200px">IPPT</td>
                                        <td><select name="IPPT" title="Indicador de Produção Própria ou de Terceiro">
                                                <option value="" selected="selected"></option>
                                                <option value="P">Produção Própria</option>
                                                <option value="T">Produção de Terceiro</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="right" width="150px"> Referencial SPED</td>
                                        <td>
                                            <input name="produtoReferencialSPED" type="hidden" value="">
                                            <input name="produtoReferencialSPED_exibir" type="text" size="10" value="" disabled="disabled">
                                            <a id="botaoPesquisaReferencialSped" href="javascript:escolherNcmComreferencialSped()" title="Pesquisar Referencial SPED" style="display: none;"><img src="../../../../imagens/zoom.png"></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="right" width="150px">Natureza de Receita</td>
                                        <td>
                                            <input type="text" name="nat_rec" onkeypress="return Validacao.mascara.inteiro(event, this, 3);" size="5" maxlength="5" value="" style="text-align:right">        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px"> Gênero do Item</td>
                                        <td>
                                            <input type="text" name="cod_genero" id="cod_genero" size="5" value="" disabled="disabled">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">
                                            * Origem Mercadoria
                                        </td>
                                        <td>
                                            <select name="origemMercadoria">
                                                <option></option>
                                                <option value="0" title="0 - Nacional, exceto as indicadas nos códigos 3 a 5">0 - Nacional, exceto as indicadas nos códigos 3 a 5</option><option value="1" title="1 - Estrangeira - Importação direta, exceto a indicada no código 6">1 - Estrangeira - Importação direta, exceto a indicada no código 6</option><option value="2" title="2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7">2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option><option value="3" title="3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%">3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%</option><option value="4" title="4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam as legislações citadas nos Ajustes">4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos bás...</option><option value="5" title="5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%">5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%</option><option value="6" title="6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX">6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX</option><option value="7" title="7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista da CAMEX">7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista da CAMEX</option><option value="8" title="8 - Nacional - Mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento)">8 - Nacional - Mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento)</option>            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">CST ICMS ENTRADA</td>
                                        <td align="top">
                                            <select name="idTributacaoIcmsRealPresumidoEntrada">
                                                <option></option>
                                                <option value="1" cst="00" calculaimposto="S" data-idaliquotapdv="">00 - TRIBUTADA INTEGRALMENTE</option>
                                                <option value="2" cst="10" calculaimposto="S" data-idaliquotapdv="">10 - TRIBUTADA E COM COBRANCA DO ICMS POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="3" cst="20" calculaimposto="S" data-idaliquotapdv="">20 - COM REDUCAO DE BASE DE CALCULO</option>
                                                <option value="4" cst="30" calculaimposto="S" data-idaliquotapdv="">30 - ISENTA OU NAO TRIBUTADA E COM COBRANCA DO ICMS POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="5" cst="40" calculaimposto="N" data-idaliquotapdv="">40 - ISENTA</option>
                                                <option value="6" cst="41" calculaimposto="N" data-idaliquotapdv="">41 - NAO TRIBUTADA</option>
                                                <option value="7" cst="50" calculaimposto="N" data-idaliquotapdv="">50 - SUSPENSAO</option>
                                                <option value="8" cst="51" calculaimposto="N" data-idaliquotapdv="">51 - DIFERIMENTO</option>
                                                <option value="9" cst="60" calculaimposto="N" data-idaliquotapdv="">60 - ICMS COBRADO ANTERIORMENTE POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="10" cst="70" calculaimposto="S" data-idaliquotapdv="">70 - COM REDUCAO DE BASE DE CALCULO E COBRANCA DO ICMS POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="11" cst="90" calculaimposto="S" data-idaliquotapdv="">90 - OUTROS</option>
                                            </select>        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px"> * CST ICMS SAÍDA</td>
                                        <td align="top">
                                            <select onchange="changeIcmsSaida(this)" name="idTributacaoIcmsRealPresumidoSaida">
                                                <option></option>
                                                <option value="1" cst="00" calculaimposto="S" data-idaliquotapdv="">00 - TRIBUTADA INTEGRALMENTE</option>
                                                <option value="2" cst="10" calculaimposto="S" data-idaliquotapdv="">10 - TRIBUTADA E COM COBRANCA DO ICMS POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="3" cst="20" calculaimposto="S" data-idaliquotapdv="">20 - COM REDUCAO DE BASE DE CALCULO</option>
                                                <option value="4" cst="30" calculaimposto="S" data-idaliquotapdv="">30 - ISENTA OU NAO TRIBUTADA E COM COBRANCA DO ICMS POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="5" cst="40" calculaimposto="N" data-idaliquotapdv="">40 - ISENTA</option>
                                                <option value="6" cst="41" calculaimposto="N" data-idaliquotapdv="">41 - NAO TRIBUTADA</option>
                                                <option value="7" cst="50" calculaimposto="N" data-idaliquotapdv="">50 - SUSPENSAO</option>
                                                <option value="8" cst="51" calculaimposto="N" data-idaliquotapdv="">51 - DIFERIMENTO</option>
                                                <option value="9" cst="60" calculaimposto="N" data-idaliquotapdv="">60 - ICMS COBRADO ANTERIORMENTE POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="10" cst="70" calculaimposto="S" data-idaliquotapdv="">70 - COM REDUCAO DE BASE DE CALCULO E COBRANCA DO ICMS POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="11" cst="90" calculaimposto="S" data-idaliquotapdv="">90 - OUTROS</option>
                                            </select>        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Modalidade BC ICMS</td>
                                        <td>
                                            <select name="mod_bc_icms">
                                                <option></option>
                                                <option value="0">0 - Margem Valor Agregado</option>
                                                <option value="1">1 - Pauta (Valor)</option>
                                                <option value="2">2 - Preço Tabelado Max</option>
                                                <option value="3">3 - Valor da Operação</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Modalidade BC ICMS ST</td>
                                        <td>
                                            <select name="mod_bc_icms_st">
                                                <option></option>
                                                <option value="0">0 - Preco tabelado máximo sugerido</option>
                                                <option value="1">1 - Lista Negativa (Valor)</option>
                                                <option value="2">2 - Lista Positiva (Valor)</option>
                                                <option value="3">3 - Lista Neutra (Valor)</option>
                                                <option value="4">4 - Margem Valor Agregado (%)</option>
                                                <option value="5">5 - Pauta (Valor)</option>

                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">CEST</td>
                                        <td>
                                            <input type="text" name="cest" onkeypress="return Validacao.mascara.cest(event, this);" size="8" maxlength="9" value="" style="text-align:right">         </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">CFOP Estadual</td>
                                        <td><select name="cfop_estadual">
                                                <option></option>
                                                <option value="42">5.000 - VENDAS</option><option value="20">5.101 - VENDA DE PRODUCAO DO ESTABELECIMENTO</option><option value="21">5.102 - VENDA DE MERCADORIA ADQUIRIDA OU RECEBIDA DE TERCEIROS</option><option value="22">5.103 - VENDA DE PRODUCAO DO ESTABELECIMENTO, EFETUADA FORA DO ESTAB</option><option value="23">5.105 - VENDA DE PRODUCAO DO ESTABELECIMENTO QUE NAO DEVA POR ELE TR</option><option value="24">5.106 - VENDA DE MERCADORIA ADQUIRIDA OU RECEBIDA DE TERCEIROS, QUE</option><option value="25">5.202 - DEVOLUCAO DE COMPRA PARA COMERCIALIZACAO</option><option value="26">5.401 - VENDA DE PRODUCAO DO ESTABELECIMENTO EM OPERACAO COM PRODUTO</option><option value="27">5.402 - VENDA DE PRODUCAO DO ESTABELECIMENTO DE PRODUTO SUJEITO AO R</option><option value="28">5.403 - VENDA DE MERCADORIA, ADQUIRIDA OU RECEBIDA DE TERCEIROS, SUJ</option><option value="29">5.405 - VENDA DE MERCADORIA, ADQUIRIDA OU RECEBIDA DE TERCEIROS, SUJ</option><option value="30">5.411 - DEVOLUCAO DE COMPRA PARA COMERCIALIZACAO EM OPERACAO COM MER</option><option value="31">5.908 - REMESSA DE BEM POR CONTA DE CONTRATO DE COMODATO</option><option value="32">5.910 - REMESSA EM BONIFICACAO, DOACAO OU BRINDE</option><option value="33">5.911 - REMESSA DE AMOSTRA GRATIS</option><option value="84">5.915 - REMESSA PARA CONCERTO</option><option value="34">5.929 - LANCAMENTO EFETUADO EM DECORRENCIA DE EMISSAO DE DOCUMENTO F</option><option value="35">5.949 - OUTRA SAIDA DE MERCADORIA OU PRESTACAO DE SERVICO NAO ESPECI</option>                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">CFOP Interestadual</td>
                                        <td><select name="cfop_interestadual">
                                                <option></option>
                                                <option value="36">6.101 - VENDA DE PRODUCAO DO ESTABELECIMENTO</option><option value="37">6.102 - VENDA DE MERCADORIA ADQUIRIDA OU RECEBIDA DE TERCEIROS</option><option value="38">6.401 - VENDA DE PRODUCAO DO ESTABELECIMENTO EM OPERACAO COM PRODUTO</option><option value="39">6.403 - VENDA DE MERCADORIA ADQUIRIDA OU RECEBIDA DE TERCEIROS EM OP</option><option value="40">6.404 - VENDA DE MERCADORIA SUJEITA AO REGIME DE SUBSTITUICAO TRIBUT</option>                          </select></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Margem Valor Agregado ST</td>
                                        <td><input type="text" name="mva_icms_st" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="0,00" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Percentual redução BC ST</td>
                                        <td><input type="text" name="redu_icms_st" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="0,00" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Alíquota ICMS</td>
                                        <td><input type="text" name="icms_item" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="0,00" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Redução BC ICMS</td>
                                        <td><input type="text" name="reducao_icms_item" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="0,00" style="text-align:right">%</td>
                                    </tr><tr>
                                        <td align="right" width="150px">Alíquota de ICMS (PDV)</td>
                                        <td><select name="aliquota_pdv" onchange="changeAliquotaPdv()">
                                                <option disabled="disabled"></option>
                                                <option value="4" disabled="disabled" data-valor_aliquota="3.200">0320 - 3,20% - 3,20%</option><option value="5" disabled="disabled" data-valor_aliquota="7.000">0700 - 7,00% - 7,00%</option><option value="6" disabled="disabled" data-valor_aliquota="8.400">0840 - 8,40% - 8,40%</option><option value="7" disabled="disabled" data-valor_aliquota="12.000">1200 - 12,00% - 12,00%</option><option value="8" disabled="disabled" data-valor_aliquota="18.000">1800 - 18,00% - 18,00%</option><option value="9" disabled="disabled" data-valor_aliquota="25.000">2500 - 25,00% - 25,00%</option><option value="1" disabled="disabled" data-valor_aliquota="0.000">FF - SUBS TRIBUTARIA - 0,00%</option><option value="2" disabled="disabled" data-valor_aliquota="0.000">II - ISENTO - 0,00%</option><option value="3" disabled="disabled" data-valor_aliquota="0.000">N01 - NAO TRIBUTADO - 0,00%</option>                                  </select>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                            <fieldset>
                                <legend> IPI </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="150px">Redução BC IPI</td>
                                        <td><input type="text" name="reducao_ipi_item" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="0,00" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Aliquota de IPI</td>
                                        <td><input type="text" name="ipi" size="5" maxlength="5" value="0,00" asd="1" onkeypress="return Validacao.mascara.real(event, this, 3, 2);" style="text-align:right">% </td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Valor de IPI</td>
                                        <td><input type="text" name="dec_ipi_valor" onkeypress="return Validacao.mascara.real(event, this, null, 4);" size="5" maxlength="13" value="0,0000" style="text-align:right"></td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Qtde de IPI</td>
                                        <td><input type="text" name="dec_ipi_qtd" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" size="5" maxlength="7" value="0.0000" style="text-align:right"></td>
                                    </tr>
                                    <tr>
                                        <td width="150px" align="right">Código Enquadramento do IPI</td>
                                        <td><input type="text" name="cod_enq_ipi" onkeypress="return Validacao.mascara.inteiro(event, this, 3);" value="999" size="5" style="text-align:right"> </td>
                                    </tr>
                                    <tr>
                                        <td width="150px" align="right">CST IPI ENTRADA</td>
                                        <td><select name="idTributacaoIpiEntrada">
                                                <option></option>
                                                <option value="1" cst="00">00 - ENTRADA COM RECUPERACAO DE CREDITO</option>
                                                <option value="2" cst="01">01 - ENTRADA TRIBUTAVEL COM ALIQUOTA ZERO</option>
                                                <option value="3" cst="02">02 - ENTRADA ISENTA</option>
                                                <option value="4" cst="03">03 - ENTRADA NAO-TRIBUTADA</option>
                                                <option value="5" cst="04">04 - ENTRADA IMUNE</option>
                                                <option value="6" cst="05">05 - ENTRADA COM SUSPENSAO</option>
                                                <option value="7" cst="49">49 - OUTRAS ENTRADAS</option>
                                            </select>                          </td>
                                    </tr>
                                    <tr>
                                        <td width="150px" align="right">CST IPI SAÍDA</td>
                                        <td><select name="idTributacaoIpiSaida">
                                                <option></option>
                                                <option value="8" cst="50">50 - SAIDA TRIBUTADA</option>
                                                <option value="9" cst="51">51 - SAIDA TRIBUTAVEL COM ALIQUOTA ZERO</option>
                                                <option value="10" cst="52">52 - SAIDA ISENTA</option>
                                                <option value="11" cst="53">53 - SAIDA NAO-TRIBUTADA</option>
                                                <option value="12" cst="54">54 - SAIDA IMUNE</option>
                                                <option value="13" cst="55">55 - SAIDA COM SUSPENSAO</option>
                                                <option value="14" cst="99" selected="selected">99 - OUTRAS SAIDAS</option>
                                            </select>                          </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                            <fieldset>
                                <legend> PIS </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="150px">Redução BC PIS</td>
                                        <td><input type="text" name="reducao_pis_item" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="0,00" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Aliquota de PIS </td>
                                        <td><input type="text" name="pis" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="1,00" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Valor de PIS</td>
                                        <td><input type="text" name="dec_pis_valor" onkeypress="return Validacao.mascara.real(event, this, null, 4);" size="5" maxlength="13" value="0,0000" style="text-align:right"></td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Qtde de PIS</td>
                                        <td><input type="text" name="dec_pis_qtd" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" size="5" maxlength="7" value="0.0000" style="text-align:right"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">CST PIS ENTRADA:
                                            <br><select name="idTributacaoPisEntrada">
                                                <option></option>
                                                <option value="11" cst="50">50 - PIS - OPERACAO COM DIREITO A CREDITO - VINCULADA EXCLUSIVAMENTE A RECEITA TRIBUTADA NO MERCADO INTERNO</option>
                                                <option value="12" cst="51">51 - PIS - OPERACAO COM DIREITO A CREDITO - VINCULADA EXCLUSIVAMENTE A RECEITA NAO-TRIBUTADA NO MERCADO INTERNO</option>
                                                <option value="13" cst="52">52 - PIS - OPERACAO COM DIREITO A CREDITO - VINCULADA EXCLUSIVAMENTE A RECEITA DE EXPORTACAO</option>
                                                <option value="14" cst="53">53 - PIS - OPERACAO COM DIREITO A CREDITO - VINCULADA A RECEITAS TRIBUTADAS E NAO-TRIBUTADAS NO MERCADO INTERNO</option>
                                                <option value="15" cst="54">54 - PIS - OPERACAO COM DIREITO A CREDITO - VINCULADA A RECEITAS TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="16" cst="55">55 - PIS - OPERACAO COM DIREITO A CREDITO - VINCULADA A RECEITAS NAO TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="17" cst="56">56 - PIS - OPERACAO COM DIREITO A CREDITO - VINCULADA A RECEITAS TRIBUTADAS E NAO-TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="18" cst="60">60 - PIS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA EXCLUSIVAMENTE A RECEITA TRIBUTADA NO MERCADO INTERNO</option>
                                                <option value="19" cst="61">61 - PIS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA EXCLUSIVAMENTE A RECEITA NAO-TRIBUTADA NO MERCADO INTERNO</option>
                                                <option value="20" cst="62">62 - PIS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA EXCLUSIVAMENTE A RECEITA DE EXPORTACAO</option>
                                                <option value="21" cst="63">63 - PIS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA A RECEITAS TRIBUTADAS E NAO-TRIBUTADAS NO MERCADO INTERNO</option>
                                                <option value="22" cst="64">64 - PIS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA A RECEITAS TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="23" cst="65">65 - PIS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA A RECEITAS NAO-TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="24" cst="66">66 - PIS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA A RECEITAS TRIBUTADAS E NAO-TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="25" cst="67">67 - PIS - CREDITO PRESUMIDO - OUTRAS OPERACOES</option>
                                                <option value="26" cst="70">70 - PIS - OPERACAO DE AQUISICAO SEM DIREITO A CREDITO</option>
                                                <option value="27" cst="71">71 - PIS - OPERACAO DE AQUISICAO COM ISENCAO</option>
                                                <option value="28" cst="72">72 - PIS - OPERACAO DE AQUISICAO COM SUSPENSAO</option>
                                                <option value="29" cst="73">73 - PIS - OPERACAO DE AQUISICAO A ALIQUOTA ZERO</option>
                                                <option value="30" cst="74">74 - PIS - OPERACAO DE AQUISICAO SEM INCIDENCIA DA CONTRIBUICAO</option>
                                                <option value="31" cst="75">75 - PIS - OPERACAO DE AQUISICAO POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="32" cst="98">98 - PIS - OUTRAS OPERACOES DE ENTRADA</option>
                                            </select>                          </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">CST PIS SAÍDA:
                                            <br><select name="idTributacaoPisSaida">
                                                <option></option>
                                                <option value="1" cst="01" selected="selected">01 - PIS - OPERACAO TRIBUTAVEL COM ALIQUOTA BASICA</option>
                                                <option value="2" cst="02">02 - PIS - OPERACAO TRIBUTAVEL COM ALIQUOTA DIFERENCIADA</option>
                                                <option value="3" cst="03">03 - PIS - OPERACAO TRIBUTAVEL COM ALIQUOTA POR UNIDADE DE MEDIDA DE PRODUTO</option>
                                                <option value="4" cst="04">04 - PIS - OPERACAO TRIBUTAVEL MONOFASICA - REVENDA A ALIQUOTA ZERO</option>
                                                <option value="5" cst="05">05 - PIS - OPERACAO TRIBUTAVEL POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="6" cst="06">06 - PIS - OPERACAO TRIBUTAVEL A ALIQUOTA ZERO</option>
                                                <option value="7" cst="07">07 - PIS - OPERACAO ISENTA DA CONTRIBUICAO</option>
                                                <option value="8" cst="08">08 - PIS - OPERACAO SEM INCIDENCIA DA CONTRIBUICAO</option>
                                                <option value="9" cst="09">09 - PIS - OPERACAO COM SUSPENSAO DA CONTRIBUICAO</option>
                                                <option value="10" cst="49">49 - PIS - OUTRAS OPERACOES DE SAIDA</option>
                                                <option value="33" cst="99">99 - PIS - OUTRAS OPERACOES</option>
                                            </select>                          </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                            <fieldset>
                                <legend> COFINS </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="150px">Redução BC COFINS</td>
                                        <td><input type="text" name="reducao_cofins_item" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="0,00" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Aliquota de COFINS</td>
                                        <td><input type="text" name="cofins" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="7,00" style="text-align:right">%</td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Valor de COFINS</td>
                                        <td><input type="text" name="dec_cofins_valor" onkeypress="return Validacao.mascara.real(event, this, null, 4);" size="5" maxlength="13" value="0,0000" style="text-align:right"></td>
                                    </tr>
                                    <tr>
                                        <td width="200px" align="right">Qtde de COFINS</td>
                                        <td><input type="text" name="dec_cofins_qtd" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" size="5" maxlength="7" value="0.0000" style="text-align:right"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">CST COFINS ENTRADA:
                                            <br><select name="idTributacaoCofinsEntrada">
                                                <option></option>
                                                <option value="11" cst="50">50 - COFINS - OPERACAO COM DIREITO A CREDITO - VINCULADA EXCLUSIVAMENTE A RECEITA TRIBUTADA NO MERCADO INTERNO</option>
                                                <option value="12" cst="51">51 - COFINS - OPERACAO COM DIREITO A CREDITO - VINCULADA EXCLUSIVAMENTE A RECEITA NAO-TRIBUTADA NO MERCADO INTERNO</option>
                                                <option value="13" cst="52">52 - COFINS - OPERACAO COM DIREITO A CREDITO - VINCULADA EXCLUSIVAMENTE A RECEITA DE EXPORTACAO</option>
                                                <option value="14" cst="53">53 - COFINS - OPERACAO COM DIREITO A CREDITO - VINCULADA A RECEITAS TRIBUTADAS E NAO-TRIBUTADAS NO MERCADO INTERNO</option>
                                                <option value="15" cst="54">54 - COFINS - OPERACAO COM DIREITO A CREDITO - VINCULADA A RECEITAS TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="16" cst="55">55 - COFINS - OPERACAO COM DIREITO A CREDITO - VINCULADA A RECEITAS NAO TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="17" cst="56">56 - COFINS - OPERACAO COM DIREITO A CREDITO - VINCULADA A RECEITAS TRIBUTADAS E NAO-TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="18" cst="61">61 - COFINS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA EXCLUSIVAMENTE A RECEITA NAO-TRIBUTADA NO MERCADO INTERNO</option>
                                                <option value="19" cst="62">62 - COFINS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA EXCLUSIVAMENTE A RECEITA DE EXPORTACAO</option>
                                                <option value="20" cst="63">63 - COFINS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA A RECEITAS TRIBUTADAS E NAO-TRIBUTADAS NO MERCADO INTERNO</option>
                                                <option value="21" cst="64">64 - COFINS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA A RECEITAS TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="22" cst="65">65 - COFINS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA A RECEITAS NAO-TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="23" cst="66">66 - COFINS - CREDITO PRESUMIDO - OPERACAO DE AQUISICAO VINCULADA A RECEITAS TRIBUTADAS E NAO-TRIBUTADAS NO MERCADO INTERNO E DE EXPORTACAO</option>
                                                <option value="24" cst="67">67 - COFINS - CREDITO PRESUMIDO - OUTRAS OPERACOES</option>
                                                <option value="25" cst="70">70 - COFINS - OPERACAO DE AQUISICAO SEM DIREITO A CREDITO</option>
                                                <option value="26" cst="71">71 - COFINS - OPERACAO DE AQUISICAO COM ISENCAO</option>
                                                <option value="27" cst="72">72 - COFINS - OPERACAO DE AQUISICAO COM SUSPENSAO</option>
                                                <option value="28" cst="73">73 - COFINS - OPERACAO DE AQUISICAO A ALIQUOTA ZERO</option>
                                                <option value="29" cst="74">74 - COFINS - OPERACAO DE AQUISICAO SEM INCIDENCIA DA CONTRIBUICAO</option>
                                                <option value="30" cst="75">75 - COFINS - OPERACAO DE AQUISICAO POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="31" cst="98">98 - COFINS - OUTRAS OPERACOES DE ENTRADA</option>
                                            </select>                          </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">CST COFINS SAÍDA:
                                            <br><select name="idTributacaoCofinsSaida">
                                                <option></option>
                                                <option value="1" cst="01" selected="selected">01 - COFINS - OPERACAO TRIBUTAVEL COM ALIQUOTA BASICA</option>
                                                <option value="2" cst="02">02 - COFINS - OPERACAO TRIBUTAVEL COM ALIQUOTA DIFERENCIADA</option>
                                                <option value="3" cst="03">03 - COFINS - OPERACAO TRIBUTAVEL COM ALIQUOTA POR UNIDADE DE MEDIDA DE PRODUTO</option>
                                                <option value="4" cst="04">04 - COFINS - OPERACAO TRIBUTAVEL MONOFASICA - REVENDA A ALIQUOTA ZERO</option>
                                                <option value="5" cst="05">05 - COFINS - OPERACAO TRIBUTAVEL POR SUBSTITUICAO TRIBUTARIA</option>
                                                <option value="6" cst="06">06 - COFINS - OPERACAO TRIBUTAVEL A ALIQUOTA ZERO</option>
                                                <option value="7" cst="07">07 - COFINS - OPERACAO ISENTA DA CONTRIBUICAO</option>
                                                <option value="8" cst="08">08 - COFINS - OPERACAO SEM INCIDENCIA DA CONTRIBUICAO</option>
                                                <option value="9" cst="09">09 - COFINS - OPERACAO COM SUSPENSAO DA CONTRIBUICAO</option>
                                                <option value="10" cst="49">49 - COFINS - OUTRAS OPERACOES DE SAIDA</option>
                                                <option value="32" cst="99">99 - COFINS - OUTRAS OPERACOES</option>
                                            </select>                          </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                            <fieldset>
                                <legend> ISSQN </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="200px">Aliquota de ISSQN </td>
                                        <td><input type="text" name="issqn" onkeypress="return Validacao.mascara.real(event, this, null, 2);" size="5" maxlength="5" value="0,00" style="text-align:right" disabled="disabled">%</td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Situação tributária ISSQN </td>
                                        <td><select name="ISSQN_sit_tribu" disabled="disabled">
                                                <option></option>
                                                <option value="N">Normal</option>
                                                <option value="R">Retida</option>
                                                <option value="S">Substituta</option>
                                                <option value="I">Isenta</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">ISSQN LS-LC 116/03 </td>
                                        <td><input type="text" name="issqn_ls" size="5" maxlength="4" value="" style="text-align:right" disabled="disabled">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px" title="Nomenclatura Brasileira de Serviços">NBS</td>
                                        <td>
                                            <select name="idNbs" disabled="disabled">
                                                <option></option>
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                            <fieldset>
                                <legend> Outros </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="150px">Peso Bruto </td>
                                        <td><input type="text" name="peso_bru" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" size="9" maxlength="9" value="" style="text-align:right">kg</td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Peso Liquido </td>
                                        <td><input type="text" name="peso_liq" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" size="9" maxlength="9" value="" style="text-align:right">kg</td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                        </div>

                        <div id="div_concent" class="conteudo" style="display: none">
                            <fieldset>
                                <legend> Retaguarda </legend>
                                <table class="formcadastro">
                                </table>
                            </fieldset>
                        </div>
                        <div id="div_producao" class="conteudo" style="display: none;">

                            <fieldset>
                                <legend> Produção </legend>
                                <table class="formcadastro">
                                    <tbody><tr>
                                        <td align="right" width="150px">Comprado / Fabricado</td>
                                        <td><select name="comprado_fabricado" disabled="disabled">
                                                <option value="false" selected="selected">Comprado</option>
                                                <option value="true">Fabricado</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Setor Producao</td>
                                        <td><select name="ID_setor_producao" onchange="Util.Ajax.Industria.OnSetorProducaoChange(this, this.form.ID_subsetor_producao)">
                                                <option></option>
                                            </select></td>
                                    </tr>

                                    <tr>
                                        <td align="right" width="150px">Subsetor Producao</td>
                                        <td><select name="ID_subsetor_producao">
                                                <option></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Controla Producao</td>
                                        <td>
                                            <input type="radio" id="controla_producao" name="controla_producao" value="S" onchange="checa_producao(this.value)"> SIM

                                            <input type="radio" id="controla_producao" name="controla_producao" value="N" onchange="checa_producao(this.value)"> NAO
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Local de Producao</td>
                                        <td>
                                            <input type="radio" id="local_producao1" name="local_producao" value="INDUSTRIA"> INDUSTRIA
                                            <input type="radio" id="local_producao2" name="local_producao" value="COPA/COZINHA"> COPA/COZINHA
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="150px">Unidade de Producao</td>
                                        <td><select name="ID_unidade_producao">
                                                <option></option>
                                                <option value="15">BAR - BARRIL</option><option value="14">BD - </option><option value="17">BR - BARRA</option><option value="3">CX - CAIXA</option><option value="7">DZ - DUZIA</option><option value="11">FD - FARDO</option><option value="19">FRA - </option><option value="16">FRD - </option><option value="13">GL - GALAO</option><option value="2">KG - KILO</option><option value="4">L - LITRO</option><option value="18">LAT - </option><option value="6">LT - LATA</option><option value="12">MC - </option><option value="8">ML - MILHEIRO</option><option value="20">MT - </option><option value="9">PC - PECA</option><option value="5">PCT - PACOTE</option><option value="10">SC - SACO</option><option value="1">UN - UNIDADE</option>                </select>
                                            com <input type="text" name="unidade_producao_com" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" size="6" maxlength="9" value="0.0000" style="text-align: right;">         </td></tr>
                                    <tr>
                                        <td align="right" width="150px">Unidade de Formulação</td>
                                        <td><select name="unidade_formulacao">
                                                <option></option>
                                                <option value="15">BAR - BARRIL</option><option value="14">BD - </option><option value="17">BR - BARRA</option><option value="3">CX - CAIXA</option><option value="7">DZ - DUZIA</option><option value="11">FD - FARDO</option><option value="19">FRA - </option><option value="16">FRD - </option><option value="13">GL - GALAO</option><option value="2">KG - KILO</option><option value="4">L - LITRO</option><option value="18">LAT - </option><option value="6">LT - LATA</option><option value="12">MC - </option><option value="8">ML - MILHEIRO</option><option value="20">MT - </option><option value="9">PC - PECA</option><option value="5">PCT - PACOTE</option><option value="10">SC - SACO</option><option value="1">UN - UNIDADE</option>                </select>
                                            Qtde <input type="text" name="unidade_formulacao_com" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" onkeydown="return Validacao.mascara.keysBackspaceDelete(event,this);" onchange="formulacao_fator_conversao_OnChange(this);" size="6" maxlength="9" value="1.0000" style="text-align: right;">
                                            Para <input type="text" name="unidade_formulacao_para" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" onkeydown="return Validacao.mascara.keysBackspaceDelete(event,this);" onchange="formulacao_fator_conversao_OnChange(this);" size="6" maxlength="9" value="1.0000" style="text-align: right;">
                                            Fator Conversao :  <input type="text" name="fator_conversao" onkeypress="return Validacao.mascara.realComPonto(event, this, null, 4);" onkeydown="return Validacao.mascara.keysBackspaceDelete(event,this);" onchange="formulacao_fator_conversao_OnChange(this);" size="6" maxlength="9" value="1.0000" style="text-align: right;">
                                        </td></tr>
                                    <tr>
                                        <td align="right" width="150px">Tempo de Ressuprimento</td>
                                        <td name="tempo_ressuprimento">
                                            <input type="text" name="tempo_ressuprimento" onkeypress="return Validacao.mascara.inteiro(event, this, 3);" onkeydown="return Validacao.mascara.keysBackspaceDelete(event,this);" size="6" maxlength="3" value="" style="text-align: right;">
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </fieldset>
                        </div>
                    </td>
                </tr>

                <tr>
                    <!--// coloca as bordas ao redor da td para ficar no mesmo visual que as abas.-->
                    <td colspan="10" style="border-style:solid;border-color:#000000;border-width:0px 1px 1px 0px;">
                        <table cellspacing="0" cellpadding="4">
                            <tbody><tr>

                                <td>
                                    <p style="padding:15px 0px 15px 15px;">
                                        * Campos Obrigatórios
                                    </p>
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>

                </tbody></table>
            <p></p><center>
                <input type="submit" name="bbb1" value="Inserir e Editar">
                &nbsp;| <input type="submit" name="bbb1" value="Inserir e Cadastrar Novo">
                &nbsp;| <input type="submit" name="bbb1" value="Inserir e Clonar">
                &nbsp;| <input type="submit" name="bbb1" value="Inserir e Fechar">
                &nbsp;| <input type="button" onclick="confirmaRedirecionamento('O cadastro deste produto será perdido, deseja realmente cancelar a operação ?','lista_estoque2.php');" value="Cancelar">
            </center><p></p>
        </form></div>

    <br>
    <br>
    <br>
    <table class="tabelaRodape">
        <tbody><tr>
            <td>&nbsp;</td>
        </tr>
        <tr class="infoEmpresa">
            <td align="center">
                © 2004-2017 &nbsp;|&nbsp; Sistema SQGNET.Web 2.2 &nbsp;|&nbsp; Todos os Direitos Reservados &nbsp;|&nbsp; Desenvolvido por: <a href="http://www.sqginfo.com.br" target="_BLANK">SQG INFO</a>
            </td>
        </tr>
        <tr class="endereco">
            <td align="center"><br>
                Rua Dr. Zuquim, 550 - São Paulo - SP<br>
                Atendimento : (11) 3333-2338 - suporte@sqginfo.com.br
            </td>
        </tr>
        <tr>
        </tr>
        </tbody></table>


    </body></html>

@stop


