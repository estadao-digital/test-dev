import {buildTable} from './build-table.js';

const HOST = 'http://localhost:8080';



function getCarros(){
    return axios( HOST + '/Carros')
}

function getMarcas(){
    return axios( HOST + '/Marcas');
}

function getModelos(id){
    return axios( HOST + '/Modelos/' + id);
}

function postCarro(data){
    return axios.post(HOST + '/Carros', data);
}

function deleteCarro(id){
    return axios.delete( HOST + '/Carros/' + id);
}

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

deleteForm.addEventListener('submit', function(e){
    e.preventDefault();
    
    let id = deleteModal.getAttribute('data-bs-id');

    deleteCarro(id)
        .then( (resposta) => {
            refreshCarros();
            bootstrapModalDelete.hide();
        });
});


const addForm = addModal.querySelector('form');

addForm.addEventListener('submit', function(e){
    e.preventDefault();
    let data = {
        placa: addForm.querySelector('#add-placa').value,
        modelo_id: selectAddModelo.value,
        ano: addForm.querySelector('#add-ano').value
    };
    postCarro(data)
        .then( (response) => {
            refreshCarros();
            bootstrapModalAdd.hide();
        });

});



editModal.addEventListener('shown.bs.modal', function () {
    getModelos(selecEditMarca.value)
        .then((response) => {
            buildSelect(selectEditModelo, response.data.data);
            selectEditModelo.value = selectEditModelo.getAttribute('data-modelo-id');
        });
});

selecEditMarca.addEventListener('change', function(){
    getModelos(selecEditMarca.value)
        .then((response) => {
            buildSelect(selectEditModelo, response.data.data);
        });
});

addModal.addEventListener('shown.bs.modal', function(){
    getModelos(selecAddMarca.value)
        .then((response) => {
            buildSelect(selectAddModelo, response.data.data);
        });
});

selecAddMarca.addEventListener('change', function(){
    getModelos(selecAddMarca.value)
        .then((response) => {
            buildSelect(selectAddModelo, response.data.data);
        });
});


refreshCarros();

getMarcas()
    .then( (response) =>{
        buildSelect(selecEditMarca, response.data.data);
        buildSelect(selecAddMarca, response.data.data)
    });


function refreshCarros(){
    getCarros()
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