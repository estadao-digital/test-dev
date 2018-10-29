<?php
/**
* Classe do carro
 *
 * @author Tito Junior <titojunior1@gmail.com>
*/
class Carro{

    /*
     * Método construtor
     */
    public function __construct(){}

    /*
     * Método para criação de Carro
     * @param arrayObject $dadosCarro
     *
     * @throw InvalidArgumentException
     * @throw RuntimeException
     *
     * @return array $retorno
     */
    public function criaCarro($dadosCarro){

        if( !is_object($dadosCarro) ){
            throw new InvalidArgumentException("Dados invalidos - " . $id);
        }
        if( empty($dadosCarro->marca) ){
            throw new InvalidArgumentException("Marca de carro invalida - " . $id);
        }
        if( empty($dadosCarro->modelo) ){
            throw new InvalidArgumentException("Modelo de carro invalido - " . $id);
        }
        if( empty($dadosCarro->ano) ){
            throw new InvalidArgumentException("Ano de Carro Invalido - " . $id);
        }

        try {

            $carrosArquivo = json_encode($this->getCarrosArquivo());
            $carrosArquivo = json_decode($carrosArquivo, true);

            $qtd = count($carrosArquivo);
            $novoIdCarro = $qtd + 1;

            $carrosArquivo[$novoIdCarro]['MARCA'] = $dadosCarro->$novoIdCarro;
            $carrosArquivo[$novoIdCarro]['MARCA'] = $dadosCarro->marca;
            $carrosArquivo[$novoIdCarro]['MODELO'] = $dadosCarro->modelo;
            $carrosArquivo[$novoIdCarro]['ANO'] = $dadosCarro->ano;

            $this->setCarrosArquivo($carrosArquivo);
            return $retorno[] = "Registro Criado";

        }catch(Exception $e){
            throw new RuntimeException($e->getMessage());
        }


    }

    /*
     * Método para atualização de Carro
     * @param int $id
     * @param arrayObject $dadosCarro
     *
     * @throw InvalidArgumentException
     * @throw RuntimeException
     *
     * @return array $retorno
     */

    public function atualizaCarro($id, $dadosCarro){

        if (!ctype_digit($id)) {
            throw new InvalidArgumentException("ID de Carro Invalido - " . $id);
        }
        if( !is_object($dadosCarro) ){
            throw new InvalidArgumentException("Dados invalidos - " . $id);
        }
        if( empty($dadosCarro->marca) ){
            throw new InvalidArgumentException("Marca de carro invalida - " . $id);
        }
        if( empty($dadosCarro->modelo) ){
            throw new InvalidArgumentException("Modelo de carro invalido - " . $id);
        }
        if( empty($dadosCarro->ano) ){
            throw new InvalidArgumentException("Ano de Carro Invalido - " . $id);
        }

        try {

            $carrosArquivo = json_encode($this->getCarrosArquivo());
            $carrosArquivo = json_decode($carrosArquivo, true);

            if (array_key_exists($id, $carrosArquivo)) {
                $carrosArquivo[$id]['MARCA'] = $dadosCarro->marca;
                $carrosArquivo[$id]['MODELO'] = $dadosCarro->modelo;
                $carrosArquivo[$id]['ANO'] = $dadosCarro->ano;
            } else {
                throw new RuntimeException("ID informado nao existe - " . $id);
            }

            $this->setCarrosArquivo($carrosArquivo);
            return $retorno[] = "Registro Atualizado";

        }catch(Exception $e){
            throw new RuntimeException($e->getMessage());
        }


    }

    /*
     * Método para exclusão de Carro
     * @param int $id
     *
     * @throw InvalidArgumentException
     * @throw RuntimeException
     *
     * @return array $retorno
     */
    public function excluiCarro($id){

        if (!ctype_digit($id)) {
            throw new InvalidArgumentException("ID de Carro Invalido - " . $id);
        }
        try {

            $carrosArquivo = json_encode($this->getCarrosArquivo());
            $carrosArquivo = json_decode($carrosArquivo, true);

            if( array_key_exists($id, $carrosArquivo) ){
                //Excluir índice dp array
                unset($carrosArquivo[$id]);
            }else{
                throw new RuntimeException("ID informado nao existe - " . $id);
            }

            $this->setCarrosArquivo($carrosArquivo);
            return $retorno[] = "Registro Excluido";

        }catch (Exception $e){
            throw new RuntimeException($e->getMessage());
        }

    }

    /*
     * Método para listar Carro(s)
     * @param int $id
     *
     * @throw InvalidArgumentException
     * @throw RuntimeException
     *
     * @return array $retorno
     */
    public function listaCarro($id = null){

        if ( !empty($id) ) {
            if (!ctype_digit($id)) {
                throw new InvalidArgumentException("ID de Carro Invalido - {$id}.");
            }
            $carrosArquivo = $this->getCarrosArquivo();
            $carroRetorno = array();
            foreach ($carrosArquivo as $idCarro => $carro){
                if($idCarro == $id){
                    $carroRetorno['ID'] = $idCarro;
                    $carroRetorno['MARCA']= $carro->MARCA;
                    $carroRetorno['MODELO'] = $carro->MODELO;
                    $carroRetorno['ANO'] = $carro->ANO;
                    return $carroRetorno;
                }
            }
            if(count($carroRetorno == 0)){
                throw new RuntimeException("Nenhum carro encontrado");
            }
        }else{
           return $this->getCarrosArquivo();
        }
    }

    /*
     * Método para retornar carros salvos no arquivo carros.json
     * @return array $contents
     */
    public function getCarrosArquivo(){
        $handle = fopen("carros.json", "r");
        $contents = stream_get_contents($handle);
        fclose($handle);
        return json_decode($contents);
    }

    /*
     * Método para gravar registros no arquivo carros.json
     * @return true
     */
    public function setCarrosArquivo($carros){

        if( !is_array($carros) ){
            throw new InvalidArgumentException("Formato para gravação inválido.");
        }

        $dados_json = json_encode($carros);

        $fp = fopen("carros.json", "w+");

        fwrite($fp, $dados_json);
        fclose($fp);

        return true;

    }

}