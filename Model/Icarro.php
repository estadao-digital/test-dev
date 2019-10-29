<?php
namespace Models;

interface iCarro
{
    public function index();
    public function show($id);
    public function create($modelo,$marca,$ano);
    public function update($id,$modelo,$marca,$ano);
    public function destroy($id);
}
?>