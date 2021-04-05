import { Build } from './build.js';
import { Api } from './api.js';
import { Toasts } from './toasts.js';


/** Inicializando Dados */

const deleteModal   = document.getElementById('deleteModal');
const addModal      = document.getElementById('addModal');
const editModal     = document.getElementById('editModal');

const deleteForm    = deleteModal.querySelector('form');
const addForm       = addModal.querySelector('form');
const editForm      = editModal.querySelector('form');

const selecEditMarca    = editModal.querySelector('#edit-marca');
const selectEditModelo  = editModal.querySelector('#edit-modelo');

const selecAddMarca     = addModal.querySelector('#add-marca');
const selectAddModelo   = addModal.querySelector('#add-modelo');

const bootstrapModalDelete  = new bootstrap.Modal(deleteModal, { keyboard: false });
const bootstrapModalAdd     = new bootstrap.Modal(addModal, { keyboard: false });
const bootstrapModalEdit    = new bootstrap.Modal(editModal, { keyboard: false });



/** 
 * Popular tabela pela 1° vez
 */
 refreshCarros();


 getMarcas();

/**
 * Submit form para Deletar um veículo
 */
deleteForm.addEventListener('submit', function (e) {
    e.preventDefault();
    let id = deleteModal.getAttribute('data-bs-id');

    Api.deleteCarro(id)
        .then((response) => {
            if (response.data.code == 204) {
                Toasts.info('Sucesso', response.data.messages)
                refreshCarros();
                bootstrapModalDelete.hide();
            } else if (response.data.code == 404) {
                Toasts.warning('Ooops!', 'Não foi localizado Veículo para este ID')
            } else {
                Toasts.error('Erro', 'Não foi possível deletar o veículo');
            }
        });
});


/**
 * Submit form para Adicionar Novo veículo
 */
addForm.addEventListener('submit', function (e) {
    e.preventDefault();
    let data = {
        placa: addForm.querySelector('#add-placa').value,
        modelo_id: selectAddModelo.value,
        ano: addForm.querySelector('#add-ano').value
    };
    Api.postCarro(data)
        .then((response) => {
            if (response.data.code == 201) {
                refreshCarros();
                bootstrapModalAdd.hide();
                addForm.reset();
                Toasts.success('Sucesso', 'Adicionado novo carro!' );
            } else if (response.data.code == 422) {
                Toasts.warning('Ooops!', response.data.messages);
            } else {
                Toasts.error('Erro', 'Não foi possível Editar o veículo');
            }
        });

});


/**
 * Submit form para Editar veículo
 */
editForm.addEventListener('submit', function (e) {
    e.preventDefault();
    let id = editModal.getAttribute('data-bs-id');
    let data = {
        placa: editForm.querySelector('#edit-placa').value,
        modelo_id: selectEditModelo.value,
        ano: editForm.querySelector('#edit-ano').value
    };
    Api.putCarro(id, data)
        .then((response) => {
            console.log(response.data.code)
            if (response.data.code == 204) {
                refreshCarros();
                bootstrapModalEdit.hide();
                Toasts.success('Ok!', 'Veículo editado com sucesso!');
            } else if (response.data.code == 422) {
                Toasts.warning('Ooops!', response.data.messages);
            } else {
                Toasts.error('Erro', 'Não foi possível Editar o veículo');
            }
        });
})


/**
 * Quando modal de edição/adição abrirem
 * buscamos a lista de modelos da marca daquele carro
 * depois populamos no input select,
 * o mesmo acontece quando o usuário muda o valor do select marca
 */
editModal.addEventListener('shown.bs.modal', () => refreshModelos(selecEditMarca.value, selectEditModelo));

addModal.addEventListener('shown.bs.modal', () => refreshModelos(selecAddMarca.value, selectAddModelo));

selecEditMarca.addEventListener('change', () => refreshModelos(selecEditMarca.value, selectEditModelo) );

selecAddMarca.addEventListener('change', () => refreshModelos(selecAddMarca.value, selectAddModelo) );



function refreshModelos(idMarca, select){
    Api.getModelos(idMarca)
    .then((response) => {
        if (response.data.code == 200) {
            if (response.data.data.length == 0) {
                Toasts.warning(
                    'Ooops!',
                    'Não foram localizadas Modelos para essa marca!')
            } else {
                Build.inputSelect(select, response.data.data);
            }

        } else {
            Toasts.error(
                'Erro!',
                'Não foi possível retornar os Modelos')
        }
    });
}


function getMarcas(){
    Api.getMarcas()
        .then((response) => {
            Build.inputSelect(selecEditMarca, response.data.data);
            Build.inputSelect(selecAddMarca, response.data.data)
        });
}


function refreshCarros() {
    Api.getCarros()
        .then((response) => {
            if (response.data.code = 200) {
                if (response.data.data.length == 0) {
                    Toasts.warning(
                        'Nenhum veículo na base',
                        'Favor, adicione alguns carros!');
                }
                Build.tablePopulate(response.data.data)
            } else {
                Toasts.error(
                    'Erro',
                    'No momento não foi possível listar os Carros!');
            }
        });
}


