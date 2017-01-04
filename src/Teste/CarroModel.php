<?php namespace Teste;

use Symfony\Component\HttpFoundation\Request;


class CarroModel
{
    /** @var  ControleBanco */
    private $db;

    public function __construct(ControleBanco $db)
    {
        $this->db = $db;
    }


    /**
     * Função para retornar Carro
     *
     * @param integer|null $id
     * @return string
     */
    public function buscaCarros($id = null) {
        if($id === null) {
            return $this->db->leDados('carros', 'raw');
        }

        $arquivo = $this->db->leDados('carros', 'classe');
        return json_encode($arquivo->linhas->$id);
    }

    public function insereCarro(Request $values) {
        $dao = new \stdClass();
        try {
            $dao->marca = $values->get('marca');
            $dao->ano = $values->get('ano');
            $dao->modelo = $values->get('modelo');
            $resultado = $this->db->insereDado('carros', $dao);

            return json_encode([
                'resultado' => true,
                'carro' => $resultado
            ]);

        } catch(\Exception $e) {
            return json_encode([
                'resultado' => false,
                'mensagem' => $e->getMessage()
            ]);
        }
    }

    /**
     * `/carros/{id}`[PUT] deve atualizar os dados do carro com ID especificado.
     *
     * @param $id
     * @return string
     */
    public function atualizaCarro($id, Request $values) {
        $dao = json_decode($this->buscaCarros($id));
        try {
            $dao->marca = $values->get('marca');
            $dao->ano = $values->get('ano');
            $dao->modelo = $values->get('modelo');
            $resultado = $this->db->atualizaDado('carros', $dao);

            return json_encode([
                'resultado' => true,
                'carro' => $resultado
            ]);

        } catch(\Exception $e) {
            return json_encode([
                'resultado' => false,
                'mensagem' => $e->getMessage()
            ]);
        }


    }

    /**
     * `/carros/{id}`[DELETE] deve apagar o carro com ID especificado.
     *
     * @param $id
     * @return string
     */
    public function deletaCarro($id) {
        try {
            $this->db->deletaDados('carros', $id);
            return json_encode([
                'resultado' => true
            ]);

        } catch(\Exception $e) {
            return json_encode([
                'resultado' => false,
                'mensagem' => $e->getMessage()
            ]);
        }
    }

}