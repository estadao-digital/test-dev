<?php

interface Crud
{
    public function listar();

    public function incluir(array $data);

    public function editar($id, array $data);

    public function excluir($id);
}
