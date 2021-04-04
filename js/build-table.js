
export const buildTable = {
    populate: (json) => {
        const table = document.getElementById('table');
        const tbody = table.getElementsByTagName('tbody')[0];
        tbody.innerText = '';
        for(let carro of json)
        {
            let row = buildTable.buildRow(carro);
            tbody.appendChild(row);
        }
    },

    buildRow : (carro) =>{
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
        tdAction.appendChild( buildTable.createEditButton(carro) );
        tdAction.appendChild( buildTable.createDeleteButton(carro) );
        row.appendChild(tdAction);
    
        return row;
    }, 

    createEditButton: (carro) =>{
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
        buildTable.whenOpenEditModel(a, carro);
        return a;
    },

    createDeleteButton: (carro) =>{
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
        buildTable.whenOpenDeleteModel(a, carro);
        return a;
    },

    whenOpenDeleteModel: (a, carro) => {
        a.addEventListener('click', function(e){
            e.preventDefault();
            let modal = document.getElementById('deleteModal');
            modal.setAttribute('data-bs-id', carro.id);
            document.getElementById('span-placa').innerHTML = carro.placa;
        });
    },

    whenOpenEditModel: (a, carro) => {
        a.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById('input-placa').value = carro.placa;
            document.getElementById('input-ano').value = carro.ano;
        })
    }
}