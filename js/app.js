(function(){
	angular.module('cpm', ['ngSanitize', 'angularUtils.directives.dirPagination']).config(function(paginationTemplateProvider) {
	    paginationTemplateProvider.setPath('libs/angular/pagination/dirPagination.tpl.html');
	});

	angular.module('cpm').filter('capitalize', function() {
	    return function(input) {
	      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
	    };
	});

	angular.module('cpm').factory('dbMODEL', function($http, $httpParamSerializer, $q, $sce, $timeout){
		$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';

		var model = {
			types: [],
			records: [],
			primaries: [],
			selects: [],
			filters: [],
			msgs: [],
			sort: '',
			sfield: '',
			filteredO: {},
			search: {},
			formValues: {},
			formSelected: {},
			formCheck: 0,
			formOp: 0,
			formId: 0,
			checks: {},
			checksVal: {},
			exBtn: {},
			viewSelects: {},
			gridTitle: '',
			modalTitle: '',
			modalContent: '',
			aDate: '',
			filtered: '',
			limitVar: 70,
			pageSize: 10,
			currentPage: 1,
			order: '',
			direction: {},
			isArray: angular.isArray
		};

		angular.extend(model, {
			delegate: function($event){
				var element = angular.element($event.target).context.attributes;
				var elLength = element.length;
				var fAttr = element[elLength-1];
				var sAttr = element[elLength-2];
				if (sAttr !== undefined) {
					var data = (sAttr.value.indexOf('{')>=0) ? angular.fromJson(sAttr.value) : false;
					if (data) {
						if (sAttr.name.indexOf('edit')>=0) model.getRecord(data, fAttr.value);
					} else {
						if (fAttr.name.indexOf('details')>=0) model.getDetails(fAttr.value);
						if (sAttr.name.indexOf('data-tb')>=0) model.getResultsPage(sAttr.value, $event);
					}
				}
			},
			setRecord: function(){
				model.modalTitle = 'Cadastro';
				model.formValues = {};
				model.formSelected = {};
				model.formOp = 1;
				$timeout(function(){
					angular.element('#formModal .modal-body').scrollTop(0);
				}, 500);
			},
			getRecord: function(data, id){
				model.modalTitle = 'Alteração';
				model.formValues = data;
				model.formOp = 0;
				model.formId = id;
				$timeout(function(){
					angular.element('#formModal .modal-body').scrollTop(0);
				}, 500);
			},
			insertRecord: function(){
				var fields = [];
				var nValue = {};
				var nValue2 = {};
				angular.forEach(model.types, function(obj, index){
					fields.push([obj.name, obj.type]);
				});
				angular.forEach(fields, function(value, index){
					nValue[value[0]] = nValue2[value[0]] = (model.formValues[value[0]]===undefined) ? '' : model.formValues[value[0]];
				});

				var params = $httpParamSerializer(nValue2);
				$http.post('api/carros/', params).success(function(response, status){
			    if (response.error) {
			    	model.msgs[0] = response.error;
			    } else {
				  	model.msgs[0] = response.success;
			    	model.records.unshift(nValue);
			    	model.primaries.unshift(response.inserted);
						
			    	angular.forEach(model.types, function(obj){
			    		switch (obj.type){
			    			case 'select':
			    				model.getSelects();
			    				break;
			    		}
			    	});
			    }
				}).error(function(){
					alert('Não foi possível gravar os dados do banco!');
				});
			},
			updateRecord: function(id){
				var fields = [];
				var nValue = {};
				angular.forEach(model.types, function(obj, index){
					fields.push([obj.name, obj.type]);
				});
				angular.forEach(fields, function(value, index){
					nValue[value[0]] = (model.formValues[value[0]]===undefined) ? '' : model.formValues[value[0]];
				});

				var paramsS = $httpParamSerializer({ id: id });
				var paramsS2 = $httpParamSerializer(nValue);
				var params = paramsS+'&'+paramsS2;
				$http.put('api/carros/', params).success(function(response){
			    if (response.error) {
			    	model.msgs[0] = response.error;
			    } else {
			    	model.msgs[0] = response.success;

			    	model.getData().then(function(){
							angular.forEach(model.types, function(obj){
								switch(obj.type){
									case 'select':
										model.getSelects();
										break;
								}
							});
						}, function(error){
							alert(error);
						});
			    }
				}).error(function(){
					alert('Não foi possível gravar os dados do banco!');
				});
			},
			deleteRecord: function(data, id){
				if (confirm("Deseja realmente excluir este registro?")) {
					var params = $httpParamSerializer({ id: id });
					$http.delete('api/carros/', { data: params }).success(function(response){
				    if (response.error) {
				    	model.msgs[0] = response.error;
				    } else {
				    	model.msgs[0] = response.success;
				    	var pIndex = model.primaries.indexOf(id);
				    	if (pIndex>=0) model.primaries.splice(pIndex, 1);
			    	  model.records.every(function(obj, index){
			    			if (angular.toJson(obj)===angular.toJson(data)) {
			    				model.records.splice(index, 1);
			    				return false;
			    			}
			    			return true;
			    		});
				    }
					}).error(function(){
						alert('Não foi possível apagar os dados do banco!');
					});
				}
			},
			deleteRecords: function(){
				if (confirm("Deseja realmente excluir o(s) registro(s) selecionado(s)?")) {
					var pages = {};
					var splices = [];
					var data = [];
					var ids = [];
					data.push(model.records);
					angular.forEach(model.checks, function(obj, page){
						var start = ((page-1)*model.pageSize);
						var end = (page*model.pageSize);
						pages[page] = [];
						for (i=start; i<end; i+=1) {
							pages[page].push(i);
						}
						angular.forEach(obj, function(value, index){
							if (index!='check' && value===true) {
								if (model.checksVal[page][index]!==undefined) ids.push(model.checksVal[page][index]);
								splices.push(pages[page][index]);
								model.checks[page][index] = false;
							}
						});
					});
					var remove = data.concat(splices);
					
					var params = $httpParamSerializer({ 'id[]': ids });
					$http.delete('api/carros/', { data: params }).success(function(response){
				    if (response.error) {
				    	model.msgs[0] = response.error;
				    } else {
				    	model.msgs[0] = response.success;
			    	  model.multisplice.apply(this, remove);
				    }
					}).error(function(){
						alert('Não foi possível apagar os dados do banco!');
					});
				}
			},
			getData: function(){
				var deferred = $q.defer();
				$http.get('api/carros').success(function(response, status){
			    model.msgs[0] = 'Ainda não há dados para exibir!';
			    if (status!=204) {
			    	model.msgs[0] = '';
			    	model.primaries = response[0];
			    	model.records = response[1];
						deferred.resolve();
					} else {
						model.records = [];
					}
				}).error(function(){
					deferred.reject('Não foi possível carregar os dados do banco!');
				});
				var dt = new Date();
  			var d = dt.getDate() < 10 ? '0'+dt.getDate() : dt.getDate();
  			var m = (dt.getMonth()+1) < 10 ? '0'+(dt.getMonth()+1) : (dt.getMonth()+1);
				model.aDate = d+'/'+m+'/'+dt.getFullYear();
				return deferred.promise;
			},
			getTypes: function(){
				var deferred = $q.defer();
				model.filters = [];
				$http.get('mocks/types.json').success(function(response, status){
			    model.msgs[1] = '';
			    model.filters.push({value: '$', text: 'Todos'});
					angular.forEach(response, function(obj, index){
						var nFilter = ['select'];
						if (nFilter.indexOf(obj.type)==-1) model.filters.push({value: obj.name, text: obj.head});
					});
					model.types = response;
					model.sfield = model.filters[0];
					deferred.resolve(model.types);
				}).error(function(){
					deferred.reject('Não foi possível carregar os tipos de dados!');
				});
				return deferred.promise;
			},
			getSelects: function(){
				$http.get('api/marcas').success(function(response, status){
					model.msgs[2] = (status==204) ? 'Existem erros na configuração das combos!' : '';
				  model.selects = response;
				}).error(function(){
					alert('Não foi possível carregar as combos do banco!');
				});
			},
			getResultsPage: function(){
				model.gridTitle = 'Carros';
				model.cleanFilters();
				model.getTypes().then(function(response){
					model.getData().then(function(){
						angular.forEach(response, function(obj){
							switch(obj.type){
								case 'select':
									model.getSelects();
									break;
							}
						});
					}, function(error){
						alert(error);
					});
				}, function(error){
					alert(error);
				});
			},
			setCheckeds: function(){
				if (model.checks[model.currentPage]===undefined) model.checks[model.currentPage] = {};
				var ctt = 0;
				for (i=0; i<model.pageSize; i+=1) {
					model.checks[model.currentPage][i] = !model.checks[model.currentPage][i];
					model.checks[model.currentPage].check = model.checks[model.currentPage][i];
					if (model.checks[model.currentPage][i]) ctt++;
				}
				model.exBtn[model.currentPage] = (ctt>0) ? 1 : 0;
			},
			setChecked: function(){
				var ctt = 0;
				for (i=0; i<model.pageSize; i+=1) {
					if (model.checks[model.currentPage][i]) ctt++;
				}
				model.checks[model.currentPage].check = (ctt==model.pageSize) ? true : false;
				model.exBtn[model.currentPage] = (ctt>0) ? 1 : 0;
			},
			selectOpt: function(){
				angular.forEach(model.formValues, function(obj, index){
					if (index!='$$hashKey') {
						angular.forEach(model.types, function(obj2, index2){
							if (obj2.type=='select' && obj2.name==index) {
								var index3 = model.arrayObjectIndexOf(model.selects[index], obj, 'id');
								if (index3!=-1) model.formSelected[index] = model.selects[index][index3];
							}
						});
					}
				});
			},
			viewOpt: function(){
				angular.forEach(model.records, function(obj, index){
					angular.forEach(obj, function(obj2, index2){
						if (index2!='$$hashKey') {
							if (model.viewSelects[index2]===undefined) model.viewSelects[index2] = {};
							angular.forEach(model.types, function(obj3, index3){
								if (obj3.type=='select' && obj3.name==index2) {
									var index4 = model.arrayObjectIndexOf(model.selects[index2], obj2, 'id');
									if (index4!=-1) model.viewSelects[index2][obj2] = model.selects[index2][index4].value;
								}
							});
						}
					});
				});
			},
			setOrder: function(field){
				if (model.order==field) {
					model.order = (field.substr(0,1)=='-') ? field : '-'+field;
					model.direction[field] = true;
				} else {
					model.order = field;
					model.direction[field] = false;
				}
			},
			setFilters: function(ev){
				var keyBlocked = [16, 17, 18, 20, 46];
				if (keyBlocked.indexOf(ev.keyCode)==-1) {
					if (model.search!==undefined) {
						var m = 0;
						if (Object.keys(model.search).length!==undefined) {
							angular.forEach(model.search, function(obj, index){
								var field = (index=='$') ? 'Todos': index;
								if (typeof obj==='string' && obj!=='') {
									m = 1;
									if (obj.indexOf('button')==-1) {
										model.filteredO[field] = field+': '+obj+' <button class="btn btn-danger btn-xs" data-ng-click="model.cleanFilter(\''+index+'\');"><span class="glyphicon glyphicon-remove"></span></button>';
									}
								} else {
									delete model.filteredO[field];
								}
							});
							var arr = Object.keys(model.filteredO).map(function(k) { return $sce.trustAsHtml(model.filteredO[k]); });
							model.filtered = arr.join();
						}
						angular.element('[data-toggle="popover"]').popover({
			        trigger: 'manual',
			        placement: 'bottom',
			        html: true,
			        content: function(){
			            return model.filtered;
			        }
				    });
						if (m===0) {
							angular.element('[data-toggle="popover"]').popover("hide");
							angular.element('.panel-primary').css('margin-top', '');
						} else {
							angular.element('[data-toggle="popover"]').popover("show");
						}
					}
				}
			},
			cleanFilter: function(index){
				if (index=='$') {
					delete model.filteredO.Todos;
					delete model.search.Todos;
					delete model.filteredO[index];
					delete model.search[index];
				} else {
					delete model.filteredO[index];
					delete model.search[index];
				}
				model.setFilters(model.filteredO);
			},
			cleanFilters: function(){
				model.sfield = model.filters[0];
				model.filteredO = {};
				model.search = {};
				model.setFilters(model.filteredO);
			},
			arrayObjectIndexOf: function(arr, search, property){
		    var len = arr.length;
		    for (i=0; i<len; i+=1) {
		        if (arr[i][property]===search) return i;
		    }
		    return -1;
			},
			multisplice: function(array){
		    var args = Array.apply(null, arguments).slice(1);
		    args.sort(function(a, b){
		        return a - b;
		    });
		    var len = args.length;
		    for (i=0; i<len; i+=1) {
		        var index = args[i] - i;
		        array.splice(index, 1);
		    }        
			}
		});
		
		return model;
	});

	angular.module('cpm').controller('grid', function($scope, $compile, dbMODEL) {
    $scope.model = dbMODEL;
    $scope.model.getResultsPage();
    $scope.modalTemplate = 'templates/form.html';
    $scope.$watch('model.filtered', function(value){
    	var popoverContent = document.querySelector('.popover-content');
    	var popoverFadeBottomIn = document.querySelector('.popover.fade.bottom.in');
    	var panelPrimary = document.querySelector('.panel-primary');
			$compile(angular.element(popoverContent).contents())($scope);
			if (angular.element(popoverFadeBottomIn)[0]!==undefined) angular.element(panelPrimary).css('margin-top', angular.element(popoverFadeBottomIn)[0].clientHeight+'px');
		});
		$scope.$watch('model.formValues', function(){
			$scope.model.selectOpt();
		});
		$scope.$watch('model.selects', function(value){
			if (angular.isObject(value)) {
				$scope.model.viewOpt();
			}
		});
  });
})();
