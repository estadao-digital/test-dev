import {service} from './service.js';

let data = service.get2('/Carros');

data.then( (data) => {
    tablePopulate(data);
});


function tablePopulate(json)
{
    const table = document.getElementById('table');
    const tbody = table.getElementsByTagName('tbody')[0];
    tbody.innerText = '';
    for(let carro of json)
    {
        let row = tableRow(carro);
        tbody.appendChild(row);
    }
    
}


function tableRow(carro)
{
    const row = document.createElement('tr');
    const tdPlaca = document.createElement('td');
    tdPlaca.innerHTML = carro.placa;
    row.appendChild(tdPlaca);

    const tdModelo = document.createElement('td');
    tdModelo.innerHTML = carro.Modelo.nome;
    row.appendChild(tdModelo);


    const tdMarca = document.createElement('td');
    tdMarca.className = 'd-none d-sm-table-cell';
    tdMarca.innerHTML = carro.Marca.nome;
    row.appendChild(tdMarca);

    const tdAno = document.createElement('td');
    tdAno.className = 'd-none d-sm-table-cell';
    tdAno.innerHTML = carro.ano;
    row.appendChild(tdAno);

    const tdAction = document.createElement('td');
    tdAction.appendChild( createEditButton(carro) );
    tdAction.appendChild( createDeleteButton(carro) );
    row.appendChild(tdAction);

    return row;
}


function createEditButton(carro){
    const a = document.createElement('a');
    a.setAttribute('href', '#editModal');
    a.setAttribute('data-bs-toggle', 'modal');
    a.setAttribute('data-bs-id', carro.id);
    a.className = 'edit';
    const i = document.createElement('i');
    i.setAttribute('data-toggle', 'tooltip')
    i.setAttribute('title', 'Editar')
    i.className = 'material-icons';
    i.innerHTML = '&#xE254;';
    a.appendChild(i);
    whenOpenEditModel(a, carro);
    return a;
}


function createDeleteButton(carro){
    const a = document.createElement('a');
    a.setAttribute('href', '#deleteModal');
    a.setAttribute('data-bs-toggle', 'modal');
    a.setAttribute('data-bs-id', carro.id);
    a.className = 'delete';
    const i = document.createElement('i');
    i.setAttribute('data-toggle', 'tooltip')
    i.setAttribute('title', 'Deletar')
    i.className = 'material-icons';
    i.innerHTML = '&#xE872;';
    a.appendChild(i);
    whenOpenDeleteModel(a, carro);
    return a;
}

function whenOpenDeleteModel(a, carro){
    a.addEventListener('click', function(e){
        e.preventDefault();
        let modal = document.getElementById('deleteModal');
        modal.setAttribute('data-bs-id', carro.id);
        document.getElementById('span-placa').innerHTML = carro.placa;
    })
}
 
function whenOpenEditModel(a, carro){
    a.addEventListener('click', function(e){
        e.preventDefault();
        document.getElementById('input-placa').value = carro.placa;
        document.getElementById('input-ano').value = carro.ano;
    })
}


let deleteForm = document.getElementById('deleteForm');
deleteForm.addEventListener('submit', function(e){
    e.preventDefault();
    console.log('delete inpedido');
});

