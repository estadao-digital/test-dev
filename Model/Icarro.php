<?php
interface iCarro
{
    public function index();
    public function show($id);
    public function create();
    public function update($id);
    public function getHtml($template);
}
?>