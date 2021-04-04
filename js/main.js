import {buildTable} from './build-table.js';

const HOST = 'http://localhost:8080';

getCarros();

function getCarros(){
    axios( HOST + '/Carros')
        .then(resposta =>  buildTable.populate(resposta.data.data) ) ;
}


const deleteModal = document.getElementById('deleteModal');
const bootstrapModalDelete = new bootstrap.Modal(deleteModal, {keyboard: false});

const addModal = document.getElementById('addModal');
const bootstrapModalAdd = new bootstrap.Modal(addModal, {keyboard: false});

const editModal = document.getElementById('editModal');
const bootstrapModalEdit = new bootstrap.Modal(editModal, {keyboard: false});


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

editModal.addEventListener('show.bs.modal', function (event) {}