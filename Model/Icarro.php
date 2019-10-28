<?php
namespace Models;

interface iCarro
{
    public function index();
    public function show($id);
    public function create();
    public function update($id);
}
?>