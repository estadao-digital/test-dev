import { buildTable } from './build-table.js';
import { Api } from './api.js';



const deleteModal = document.getElementById('deleteModal');
const bootstrapModalDelete = new bootstrap.Modal(deleteModal, {keyboard: false});

const addModal = document.getElementById('addModal');
const bootstrapModalAdd = new bootstrap.Modal(addModal, {keyboard: false});

const editModal = document.getElementById('editModal');
const bootstrapModalEdit = new bootstrap.Modal(editModal, {keyboard: false});

const selecEditMarca = editModal.querySelector('#edit-marca');
const selectEditModelo = editModal.querySelector('#edit-modelo');

const selecAddMarca = addModal.querySelector('#add-marca');
const selectAddModelo = addModal.querySelector('#add-modelo');

const deleteForm = document.getElementById('deleteForm');

const addForm = addModal.querySelector('form');

const editForm = editModal.querySelector('form');




deleteForm.addEventListener('submit', function(e){
    e.preventDefault();
    
    let id = deleteModal.getAttribute('data-bs-id');

    Api.deleteCarro(id)
        .then( (resposta) => {
            refreshCarros();
            bootstrapModalDelete.hide();
        });
});



addForm.addEventListener('submit', function(e){
    e.preventDefault();
    let data = {
        placa: addForm.querySelector('#add-placa').value,
        modelo_id: selectAddModelo.value,
        ano: addForm.querySelector('#add-ano').value
    };
    Api.postCarro(data)
        .then( (response) => {
            refreshCarros();
            bootstrapModalAdd.hide();
        });

});



editForm.addEventListener('submit', function(e){
    e.preventDefault();
    let id = editModal.getAttribute('data-bs-id');
    let data = {
        placa: editForm.querySelector('#edit-placa').value,
        modelo_id: selectEditModelo.value,
        ano: editForm.querySelector('#edit-ano').value
    };  
    Api.putCarro(id, data)
        .then( (response) => {
            refreshCarros();
            bootstrapModalEdit.hide();
        });
})



editModal.addEventListener('shown.bs.modal', function () {
    Api.getModelos(selecEditMarca.value)
        .then((response) => {
            buildSelect(selectEditModelo, response.data.data);
            selectEditModelo.value = selectEditModelo.getAttribute('data-modelo-id');
        });
});

selecEditMarca.addEventListener('change', function(){
    Api.getModelos(selecEditMarca.value)
        .then((response) => {
            buildSelect(selectEditModelo, response.data.data);
        });
});

addModal.addEventListener('shown.bs.modal', function(){
    Api.getModelos(selecAddMarca.value)
        .then((response) => {
            buildSelect(selectAddModelo, response.data.data);
        });
});

selecAddMarca.addEventListener('change', function(){
    Api.getModelos(selecAddMarca.value)
        .then((response) => {
            buildSelect(selectAddModelo, response.data.data);
        });
});


refreshCarros();

Api.getMarcas()
    .then( (response) =>{
        buildSelect(selecEditMarca, response.data.data);
        buildSelect(selecAddMarca, response.data.data)
    });


function refreshCarros(){
    Api.getCarros()
        .then(response =>  buildTable.populate(response.data.data) );
}
function buildSelect(select, data)
{
    select.innerHTML = '';
    for(let item of data)
    {
        let opt = document.createElement('option');
        opt.setAttribute('value', item.id);
        opt.innerHTML = item.nome;
        select.appendChild(opt);
    }
}