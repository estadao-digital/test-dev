<?php
	$this->assign('title','CADASTRO DE CARROS | Dados');
	$this->assign('nav','dados');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/dados.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> Dados
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		
		
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="dadoCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Marca">Marca<% if (page.orderBy == 'Marca') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Modelo">Modelo<% if (page.orderBy == 'Modelo') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Ano">Ano<% if (page.orderBy == 'Ano') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('marca') || '') %></td>
				<td><%= _.escape(item.get('modelo') || '') %></td>
				<td><%if (item.get('ano')) { %><%= _date(app.parseDate(item.get('ano'))).format('MMM D, YYYY') %><% } else { %>NULL<% } %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="dadoModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="id" placeholder="Id" value="<%= _.escape(item.get('id') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="marcaInputContainer" class="control-group">
					<label class="control-label" for="marca">Marca</label>
					<div class="controls inline-inputs">
						<textarea class="input-xlarge" id="marca" rows="3"><%= _.escape(item.get('marca') || '') %></textarea>
						<span class="help-inline"></span>
					</div>
				</div>

				<div id="modeloInputContainer" class="control-group">
					<label class="control-label" for="modelo">Modelo</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="modelo" placeholder="Modelo" value="<%= _.escape(item.get('modelo') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="anoInputContainer" class="control-group">
					<label class="control-label" for="ano">Ano</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="ano" type="text" value="<%= _date(app.parseDate(item.get('ano'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteDadoButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteDadoButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Dado</button>
						<span id="confirmDeleteDadoContainer" class="hide">
							<button id="cancelDeleteDadoButton" class="btn btn-mini">Cancelar</button>
							<button id="confirmDeleteDadoButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="dadoDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Editar Dados
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="dadoModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancelar</button>
			<button id="saveDadoButton" class="btn btn-primary">Salvar Alterações</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="dadoCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newDadoButton" class="btn btn-primary">Adicionar Carro</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
