
const api = function() {

	let me = this;

	this.url = 'http://localhost/test-dev/api/public';

	this.list = function(){

		$.ajax({
			url : me.url+"/carros",
			type : 'GET',
			dataType : 'JSON',
			success : function( response ){

				let $datagrid = new datagrid( response.data );

			}
		});

	}	

	this.delete = function( ID ){
		$.ajax({
			url : me.url+"/carros/"+ID,
			type : 'DELETE',
			dataType : 'JSON',
			success : function( response ){

				if( response.success ) me.list()

			}
		});
	}

	this.send = function( data , id = null){
		$.ajax({
			url : me.url+"/carros"+(id ? '/'+id : '' ),
			type : ( id ? 'PUT' : 'POST') ,
			dataType : 'JSON',
			data : data,
			success : function( response ){

				if( response.success ){
					me.list();
					$('#mymodal').modal('hide')	
				} 

			}
		});
	}

	this.get = function( ID, form ){
		$.ajax({
			url : me.url+"/carros/"+ID,
			type : 'GET',
			dataType : 'JSON',
			success : function( response ){

				if( response.success ){
					for( var i in response.data  ){
						form.find('#'+i).val(response.data[i])
					}
				} 

			}
		});
	}

}

const datagrid = function( data ){ 

	let me = this;
	this.local = $('#datagrid');

	this.do = function( data ){

		me.local.find('tbody').html(''); 
		if( data.length ){

			for( let row in data ){

				let tr = $('<TR>');

				for( let col in data[row] ){
					tr.attr( "data-"+col, data[row][col])
					tr.append("<td> "+ data[row][col] +" </td>");
				}

				tr.append("<td scope='row' width='20%'> <button type='button' class='btn blue btn-sm edit'>Editar</button> <button type='button' class='btn red btn-sm delete'>Excluir</button> </td>");

				me.local.append(tr)
			}

		} else {
			me.local.find('tbody').html("<tr><td colspan='10'>Nenhum registro encontrado</td></tr>"); 
		}

		me.local.find('button').unbind('click').click(function(){
			let tr = $(this).parents('tr:eq(0)')
			let id = tr.attr('data-id') 
			if ( $(this).hasClass('delete') ){

				if( confirm('Deseja realmente prosseguir ?') )$api.delete( id )
			}

			if( $(this).hasClass('edit') ){
				$api.get(id, $('#form-carro'))
				$('#mymodal').off('show.bs.modal').on('show.bs.modal', function () {
			        InitForm()
			    }).modal()
			}

			return false;

		})


	}

	me.do( data )
}

const $api = new api();

function InitForm(){
	$('form').unbind('submit').submit(function(){

		$api.send( $(this).serialize(), $(this).find('#ID').val() )

		return false;
	})
}
