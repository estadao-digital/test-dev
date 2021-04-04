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

let deleteForm = document.getElementById('deleteForm');

deleteForm.addEventListener('submit', function(e){
    e.preventDefault();
    
    let id = deleteModal.getAttribute('data-bs-id');

    axios.delete( HOST + '/Carros/' + id)
        .then( (resposta) => {
            console.log(resposta.data);
            getCarros();
            bootstrapModalDelete.hide();
        });
});



editModal.addEventListener('shown.bs.modal', function (event) {
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


selecAddMarca.addEventListener('change', function(){
    getModelos(selecAddMarca.value)
        .then((response) => {
            buildSelect(selectAddModelo, response.data.data);
        });
});



getCarros()
    .then(response =>  buildTable.populate(response.data.data) );

getMarcas()
    .then( (response) =>{
        buildSelect(selecEditMarca, response.data.data);
        buildSelect(selecAddMarca, response.data.data)
    });



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