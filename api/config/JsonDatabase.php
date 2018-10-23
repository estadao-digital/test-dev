<?php
class JsonDatabase{

    // specify your own database credentials
    public $carroEntity;
    public $tabela;
    public $arquivo;
    public $dados;

    // get the database connection

    public function __construct() {
        $this->arquivo = "./config/db.json";
    }

    private function readAll() {
        $fp = fopen($this->arquivo, 'r');
        $prevData = fread($fp, filesize($this->arquivo));
        $prevData = json_decode($prevData,true);
        fclose($fp);

        return $prevData;
    }

    private function record($novo) {
        if(!file_exists("../config/db.json")) {
            file_put_contents('./config/db.json', '');
        }

        $fp = fopen("./config/db.json", 'w');
        $resultado = fwrite($fp, json_encode($novo));
        fclose($fp);
    }

    public function getData($tabela = '') {
        $tabela = ($tabela)?$tabela:$this->tabela;
        $tabela_dados = $this->readAll();
        $tabela_dados = $tabela_dados[$tabela]["dados"];

        return $tabela_dados;
    }

    public function getDataById($id,$tabela = '') {
        $tabela = ($tabela)?$tabela:$this->tabela;
        $tabela_dados = $this->readAll();
        if(!isset($tabela_dados[$tabela]["dados"][$id])) {
            return false;
        } else {
            $tabela_dados = $tabela_dados[$tabela]["dados"][$id];
        }
        return $tabela_dados;
    }

    // get the database connection
    public function create($array) {
        $anteriores = $this->readAll();
        $new_id = max(array_keys($anteriores[$this->tabela]["dados"])) + 1;
        $array['id'] = $new_id;
        $anteriores[$this->tabela]["dados"][$new_id] = $array;

        return ($this->record($anteriores))?array('success'=>true,'id' => $new_id):array('success'=>false);
    }

    // get the database connection
    public function updateData($id,$data) {
            $anteriores = $this->readAll();
            $anteriores[$this->tabela]['dados'][$id] = $data;

            $this->record($anteriores);
    }

    // get the database connection
    public function deleteData($id) {
        $anteriores = $this->readAll();
        unset($anteriores[$this->tabela]["dados"][$id]);
        $this->record($anteriores);
    }

}
?>