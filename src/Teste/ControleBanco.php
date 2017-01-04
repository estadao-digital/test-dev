<?php namespace Teste;


class ControleBanco
{

    /**
     * Função para retornar Carro
     *
     * @param integer|null $id
     * @return string
     */
    public function leDados($tabela, $formato = 'raw') {
        $dados = file_get_contents(__BASE__.'resources'.DIRECTORY_SEPARATOR.$tabela.'.json');

        //echo 'convertePara'. ucfirst($formato);
        return call_user_func_array([$this, 'convertePara'. ucfirst($formato)], [$tabela, $dados]);

        if($formato === 'raw') {

        } elseif($formato === 'classe') {
            return $arquivo;
        }
    }

    public function salvaDados($tabela, $dados) {
        file_put_contents(__BASE__.'resources'.DIRECTORY_SEPARATOR.$tabela.'.json', $dados);
    }

    public function insereDado($tabela, $dao) {

        $dados = $this->leDados($tabela, 'classe');
        $id = ++$dados->last_id;
        $dao->id = $id;
        $dados->linhas->$id = $dao;
        $this->salvaDados($tabela, json_encode($dados));
        return $dao;
    }

    public function atualizaDado($tabela, $dao) {
        $id = $dao->id;

        $dados = $this->leDados($tabela, 'classe');
        $dados->linhas->$id = $dao;
        $this->salvaDados($tabela, json_encode($dados));
        return $dao;
    }

    public function deletaDados($tabela, $id) {
        $dados = $this->leDados($tabela, 'classe');
        unset($dados->linhas->$id);
        $this->salvaDados($tabela, json_encode($dados));
        return true;
    }

    private function converteParaRaw($tabela, $dados) {
        $resultado = json_decode($dados);
        return json_encode($resultado->linhas);
    }

    private function converteParaClasse($tabela, $dados) {
        return json_decode($dados);
    }
}