@extends('layouts.master_spa')

@section('title', 'Carros')

@section('sidebar')
	@parent
	<div></div>
@stop

@section('content')

	<div class='panel panel-primary row justify-content-center m-5'>
	<div class="jumbotron col-md-6">
			<div class='form-group'>
			<h4>@{{app}}</h4>
			<span> Cadastre ou selecione os carros que deseja modificar.</span>
			</div>
			<br>
			<table class="table table-striped">
				<tr>
					<th></th>
					<th>ID</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Ano</th>
				</tr>
				<tr ng-repeat="Carro in Carros">
					<td>
						<input type="radio" name='radio' value='@{{Carro.id}}' ng-model="Carro.selecionado" ng-click="copiarForm(this.Carro)"/>
					</td>
					<td>@{{Carro.id}}</td>
					<td>@{{Carro.marca.nome}}</td>
					<td>@{{Carro.modelo}}</td>
					<td>@{{Carro.ano}}</td>
				</tr>
			</table>

			<hr/>

			<form name="CarroForm">
				<input class="form-control" type="text" ng-model="Carro.id" ng-value="name" id="id" name="id" ng-required="true" placeholder="ID">

				<select class="form-control" id='marca' ng-model="Carro.marca" ng-options="marca.nome for marca in marca">
					<option value="">Selecione uma marca</select>
				</select>

				<input class="form-control" id='modelo' type="text" ng-model="Carro.modelo" name="modelo" ng-required="true" placeholder="Modelo">

				<input class="form-control" id='ano' type="text" ng-model="Carro.ano" name="ano" ng-required="true" placeholder="Ano">
				
				
			</form>

			<div ng-show="CarroForm.ID.$invalid && CarroForm.ID.$dirty" class="alert alert-danger">Por favor, preencha o ID</div>
			<div ng-show="CarroForm.Modelo.$invalid" class="alert alert-danger" >Por favor, preencha o Modelo</div>

			<div ng-show="CarroForm.Ano.$invalid" class="alert alert-danger" >Por favor, preencha o Ano</div>

			<button class="btn btn-primary btn-block" ng-click="adicionarCarro(Carro)" ng-disabled="CarroForm.$invalid">
				Adicionar Carro
			</button>

			<button class="btn btn-danger btn-block" ng-click="apagarCarros(Carros)" ng-disabled="!hasCarroselecionado(Carros)">
				Apagar Carros
			</button>

			<button class="btn btn-warning btn-block" ng-click="editarCarros(Carros, Carro)" ng-disabled="!hasCarroselecionado(Carros)">
				Editar Carro
			</button>
	</div>
	</div>
	

	<script>
		angular.module("Carros", []);
		angular.module("Carros").controller("CarrosController", function($scope) {
			$scope.app = "Carros";
			$scope.marca = [
				{nome: "Chevrolet"},
				{nome: "Hyundai"},
				{nome: "Toyota"},
				{nome: "Honda"},
				{nome: "Fiat"},
				{nome: "Ford"}
			];
			$scope.Carros = [
				{id: "Pedro", marca: {nome: "Chevrolet"}, modelo: "HB20", ano: "2018"}
			];
			$scope.adicionarCarro = function (Carro) {
				$scope.Carros.push(angular.copy(Carro));
				delete $scope.Carro;
				$scope.CarroForm.$setPristine();
			}
			$scope.hasCarroselecionado = function (Carros) {
				return Carros.some(function(Carro) {
					return Carro.selecionado;
				})
			}
			$scope.apagarCarros = function (Carros) {
				$scope.Carros = Carros.filter(function(Carro) {
					if (!Carro.selecionado) return Carro;
				})
			}

			$scope.copiarForm = function (Carro) {
				document.getElementById('id').value = Carro.id;
				mark = document.getElementById('marca');
				for (var i = 0; i < mark.options.length; i++) {
				    if (mark.options[i].text == Carro.marca.nome) {
				        document.getElementById('marca').selectedIndex = i;
				        break;
				    }
				}
				document.getElementById('modelo').value = Carro.modelo;
				document.getElementById('ano').value = Carro.ano;
				return Carro;
			}


			$scope.editarCarros = function (Carros) {
				excCar = '';
				$scope.Carros = Carros.filter(function(Carro) {
					if (!Carro.selecionado){
						return Carro;
					} else{
						excCar = Carro;
					}
				}) 
				mark = document.getElementById('marca');
				marca = {
					nome: mark.options[mark.selectedIndex].innerHTML
				};
				Carro = 
						{
							id:document.getElementById('id').value,
							marca,
							modelo:document.getElementById('modelo').value,
							ano:document.getElementById('ano').value
						}
				$scope.Carros.push(angular.copy(Carro));
				delete $scope.editedCar;
				$scope.CarroForm.$setPristine();
			}


		})

		
	</script>

@stop



