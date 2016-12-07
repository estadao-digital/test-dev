function removeCar(id) {


    if (id == undefined)
        alert('nenhum carro para ser removido');

    var c = confirm('Deseja realmente apagar registro: ' + id + '? ');

    if (c) {
        jQuery.ajax({
            type: 'DELETE',
            url: BASE_URL + '/carros/' + id,
            success: function (result) {
                if (result.success == true) {
                    alert('carro removido com sucesso.');
                } else {
                    alert(result.message);
                }

                jQuery('tr[data-id=' + id + ']').remove();

                reloadList();
            }
        });
    }

}


function saveOrUpdate() {
    var form = jQuery('form-cars');
    if (form.find('[name=ano]').val() == '') {
        alert('Selcionar ano do veículo');
        return false;
    }
    if (form.find('[name=marca]').val() == '') {
        alert('Informar marca');
        return false;
    }
    if (form.find('[name=modelo]').val() == '') {
        alert('Informar modelo');
        return false;
    }

    var ano = jQuery('[name=ano]').val();
    var marca = jQuery('[name=marca]').val();
    var modelo = jQuery('[name=modelo]').val();
    var id = jQuery('#id_car').val();
    console.log(id);

    var method = (id == '' || id == undefined) ? 'POST' : 'PUT';

    jQuery.ajax({
        type: method,
        url: BASE_URL + '/carros/' + id,
        data: {ano: ano, marca: marca, modelo: modelo, id: id},
        success: function (result) {
            console.log(result);
            if (result.success == true) {
                alert('carro criado/atualizado com sucesso.');
            } else {
                //    alert(result.message);

            }
            
            reloadList();

        }
    });

}

function reloadList() {

}


function showEditForm(el){
    var id = jQuery(el).data('id');
    var marca = jQuery(el).data('marca');
    var modelo = jQuery(el).data('modelo');
    var ano = jQuery(el).data('ano');
    
    var form = jQuery('#form-cars');
    form.attr('method','PUT');
    jQuery('#marca').val(marca);
    jQuery('#modelo').val(modelo);
    jQuery('#ano').val(ano);
    jQuery('#id_car').val(id);
    
}

function reloadList(){
    jQuery.ajax({
        type: 'GET',
        url: BASE_URL + '/carros/listCars',
        success: function (result) {
            jQuery('#tbody-cars').html(result);
        }
    });
    
}