<?php
$url = "http://localhost:3000/carros";
$dados_json = json_decode(file_get_contents('carros.json'));
?>

<h2>Lista de todos os carros</h2>
<br>
<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Marca</th>
      <th scope="col">Modelo</th>
      <th scope="col">Ano</th>
      <th scope="col" style="text-align:center;">Editar/Excluir</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($dados_json->carros as $mostra){ ?>
    <tr>
      <th scope="row"><?php echo $mostra->id ?> </th>
      <td><?php echo $mostra->Marca ?></td>
      <td><?php echo $mostra->Modelo ?></td>
      <td><?php echo $mostra->Ano ?></td>
      <td style="text-align:center;">
      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#Editar" onclick="obterDados(<?php echo $mostra->id ?>)"  ata-toggle="tooltip" data-placement="left"title="Editar"><i class="far fa-edit"></i></button>
      <button type="button" class="btn btn-danger btn-sm"  onclick="apagar(<?php echo $mostra->id ?>)" ata-toggle="tooltip" data-placement="left"title="Excluir"><i class="fas fa-trash"></i></button>
        
      </td>
    </tr>
      <?php }?>
  </tbody>
</table>
<br>
<a class="btn btn-default" href="">Fechar</a>
