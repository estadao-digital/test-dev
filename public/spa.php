<html ng-app="listaTelefonica">
<head>
<meta charset="UTF-8">
<title>Lista Telefonica</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

<style>
	.jumbotron {
		width: 400px;
		text-align: center;
		margin-top: 20px;
		margin-left: auto;
		margin-right: auto;
	}
	.table {
		margin-top: 20px;
	}
	.form-control {
		margin-bottom: 5px;
	}
</style>
</head>

<body ng-controller="listaTelefonicaCtrl">
	<div class="jumbotron">
			<h4>{{app}}</h4>
			<table class="table table-striped">
				<tr>
					<th></th>
					<th>Nome</th>
					<th>Telefone</th>
					<th>Operadora</th>
				</tr>
				<tr ng-repeat="contato in contatos">
					<td>
						<input type="checkbox" ng-model="contato.selecionado"/>
					</td>
					<td>{{contato.nome}}</td>
					<td>{{contato.telefone}}</td>
					<td>{{contato.operadora.nome}}</td>
				</tr>
			</table>

			<hr/>

			<form name="contatoForm">
				<input class="form-control" type="text" ng-model="contato.nome" name="nome" ng-required="true" placeholder="Nome">
				
				<input class="form-control" type="text" ng-model="contato.telefone" name="telefone" ng-required="true" placeholder="Telefone">
				
				<select class="form-control" ng-model="contato.operadora" ng-options="operadora.nome group by operadora.categoria for operadora in operadoras">
					<option value="">Selecione uma operadora</select>
				</select>
			</form>

			<div ng-show="contatoForm.nome.$invalid && contatoForm.nome.$dirty" class="alert alert-danger">Por favor, preencha o nome</div>
			<div ng-show="contatoForm.telefone.$invalid && contatoForm.nome.$dirty" class="alert alert-danger" >Por favor, preencha o telefone</div>

			<button class="btn btn-primary btn-block" ng-click="adicionarContato(contato)" ng-disabled="contatoForm.$invalid">
				Adicionar Contato
			</button>
			<button class="btn btn-danger btn-block" ng-click="apagarContatos(contatos)" ng-disabled="!hasContatoSelecionado(contatos)">
				Apagar Contatos
			</button>
	</div>
	
	<!--div ng-include="'footer.html'"></div-->
	

	<script src="js/angular.js"></script>
	<script>
		angular.module("listaTelefonica", []);
		angular.module("listaTelefonica").controller("listaTelefonicaCtrl", function($scope) {
			$scope.app = "Lista Telefônica";
			$scope.contatos = [
				{nome: "Pedro", telefone: "99998888"},
				{nome: "Ana", telefone: "787787888"},
				{nome: "Maria", telefone: "132342343"}
			];
			$scope.operadoras = [
				{nome: "Oi", codigo: 14, categoria: "Celular"},
				{nome: "Vivo", codigo: 15, categoria: "Celular"},
				{nome: "Tim", codigo: 41, categoria: "Celular"},
				{nome: "Claro", codigo: 51, categoria: "Celular"},
				{nome: "GVT", codigo: 25, categoria: "Fixo"},
				{nome: "Embratel", codigo: 21, categoria: "Fixo"}
			];
			$scope.adicionarContato = function (contato) {
				$scope.contatos.push(angular.copy(contato));
				delete $scope.contato;
				$scope.contatoForm.$setPristine();
			}
			$scope.hasContatoSelecionado = function (contatos) {
				return contatos.some(function(contato) {
					return contato.selecionado;
				})
			}
			$scope.apagarContatos = function (contatos) {
				$scope.contatos = contatos.filter(function(contato) {
					if (!contato.selecionado) return contato;
				})
			}
		})
	</script>
</body>
</html>