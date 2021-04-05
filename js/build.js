export const Build = {

    tablePopulate: (json) => {
        const table = document.getElementById('table');
        const tbody = table.querySelector('tbody');
        tbody.innerText = '';
        for (let carro of json) {
            let row = Build.tableRow(carro);
            tbody.appendChild(row);
        }
    },

    tableRow: (carro) => {
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
        tdAction.appendChild(Build.createEditButton(carro));
        tdAction.appendChild(Build.createDeleteButton(carro));
        row.appendChild(tdAction);

        return row;
    },

    createEditButton: (carro) => {

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

        Build.whenOpenEditModel(a, carro);
        return a;
    },

    createDeleteButton: (carro) => {

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

        Build.whenOpenDeleteModel(a, carro);
        return a;
    },

    whenOpenDeleteModel: (a, carro) => {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            let modal = document.getElementById('deleteModal');
            modal.setAttribute('data-bs-id', carro.id);
            document.getElementById('span-placa').innerHTML = carro.placa;
        });
    },

    whenOpenEditModel: (a, carro) => {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            let modal = document.getElementById('editModal');
            modal.setAttribute('data-bs-id', carro.id);
            document.getElementById('edit-placa').value = carro.placa;
            document.getElementById('edit-ano').value = carro.ano;
            document.getElementById('edit-marca').value = carro.Marca.id;
            document.getElementById('edit-modelo').setAttribute('data-modelo-id', carro.Modelo.id);
        })
    },

    inputSelect: (select, data) => {
        select.innerHTML = '';
        for (let item of data) {
            let opt = document.createElement('option');
            opt.setAttribute('value', item.id);
            opt.innerHTML = item.nome;
            select.appendChild(opt);
        }
    }
}