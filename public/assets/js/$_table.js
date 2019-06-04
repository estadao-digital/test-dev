function setTable() {

  $("#carrosTableContainer").bootstrapTable({
    locale: 'pt-BR',
    url: 'carros', // ROUTE 'carros' METHOD 'GET'
    pagination: true,
    showRefresh: true,
    autoRefresh: true,
    toolbar: '#buttons-toolbar',
    columns: [
      {
        field: 'id',
        title: '#',
        width: 70,
        sortable: true
      },
      {
        field: 'modelo',
        title: 'Modelo',
        sortable: true
      },
      {
        field: 'marca_nome',
        title: 'Marca',
        sortable: true
      },
      {
        field: 'ano',
        title: 'Ano',
        sortable: true
      },
      {
        title: 'Ações',
        formatter: tableActions
      }
    ]
  })

}

function tableActions (value, row, index) {

    return [
        '<a class="btn btn-info" href="javascript:void(0)" onClick="carroEdit('+row.id+')" data-toggle="modal" data-tooltip="tooltip" data-placement="top" title="Editar">',
          '<i class="fas fa-pencil-alt fa-fw"></i>',
        '</a>',

        '<a class="btn btn-danger" href="javascript:void(0)" onClick="carroDeleteGet('+row.id+')" data-toggle="modal" data-tooltip="tooltip" data-placement="top" title="Remover">',
          '<i class="fas fa-trash-alt fa-fw"></i>',
        '</a>',
    ].join('');

}
