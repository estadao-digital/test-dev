<?php

class DataBase
{
    private $file = __DIR__ . '/db/carros.json';

    public function getSource()
    {
        return file_get_contents($this->file);
    }

    public function getSourceArray()
    {
        $source = $this->getSource();
        return json_decode($source, true);
    }

    public function getFile()
    {
        return $this->file;
    }
}
