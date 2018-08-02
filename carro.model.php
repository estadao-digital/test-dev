<?php 

 /*  
 * Classe para operações CRUD na tabela ARTIGO   
 */
class crudCarro{  
 
    /*  
     * Atributo para conexão com o banco de dados   
     */  
    private $pdo = null;  
   
    /*  
     * Atributo estático para instância da própria classe    
     */  
    private static $crudCarro = null; 
   
    /*  
     * Construtor da classe como private  
     * @param $conexao - Conexão com o banco de dados  
     */  
    private function __construct($conexao){  
      $this->pdo = $conexao;  
    }  
    
    /*
    * Método estático para retornar um objeto crudBlog    
    * Verifica se já existe uma instância desse objeto, caso não, instância um novo    
    * @param $conexao - Conexão com o banco de dados   
    * @return $crudBlog - Instancia do objeto crudBlog    
    */   
    public static function getInstance($conexao){   
     if (!isset(self::$crudCarro)):    
      self::$crudCarro = new crudCarro($conexao);   
     endif;   
     return self::$crudCarro;    
    } 
   
    /*   
    * Metodo para inclusão de novos registros   
    * @param $categoria - Valor para o campo categoria   
    * @param $titulo - Valor para o campo titulo   
    * @param autor  - Valor para o campo autor   
    */   
    public function insert($modelo, $marca, $ano){   
     if (!empty($modelo) && !empty($marca) && !empty($ano)):   
      try{   
       $sql = "INSERT INTO carros (modelo, marca, ano) VALUES (?, ?, ?)";   
       $stm = $this->pdo->prepare($sql);   
       $stm->bindValue(1, $modelo);   
       $stm->bindValue(2, $marca);   
       $stm->bindValue(3, $ano);   
       $stm->execute();   
       echo "<script>alert('Registro inserido com sucesso');location.href='index.php';</script>";   
      }catch(PDOException $erro){   
       echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
      }   
     endif;   
    } 
   
    /*   
    * Metodo para edição de registros   
    * @param $categoria - Valor para o campo categoria   
    * @param $titulo - Valor para o campo titulo   
    * @param autor  - Valor para o campo autor   
    * @param id   - Valor para o campo id   
    */   
    public function update($modelo, $marca, $ano, $id){   
     if (!empty($modelo) && !empty($marca) && !empty($ano) && !empty($id)):   
      try{   
       $sql = "UPDATE carros SET modelo=?, marca=?, ano=? WHERE id=?";   
       $stm = $this->pdo->prepare($sql);   
       $stm->bindValue(1, $modelo);   
       $stm->bindValue(2, $marca);   
       $stm->bindValue(3, $ano);   
       $stm->bindValue(4, $id);   
       $stm->execute();   
       echo "<script>alert('Registro atualizado com sucesso')</script>";   
      }catch(PDOException $erro){   
       echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";   
      }   
     endif;   
    }  
   
    /*   
    * Metodo para exclusão de registros   
    * @param id - Valor para o campo id   
    */   
    public function delete($id){   
     if (!empty($id)):   
      try{   
       $sql = "DELETE FROM carros WHERE id=?";   
       $stm = $this->pdo->prepare($sql);   
       $stm->bindValue(1, $id);   
       $stm->execute();   
       echo "<script>alert('Registro excluido com sucesso')</script>";   
      }catch(PDOException $erro){   
       echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";    
      }   
     endif;   
    } 
   
    /*   
    * Metodo para consulta de artigos   
    * @return $dados - Array com os registros retornados pela consulta   
    */   
    public function getAllCarros(){   
     try{   
      $sql = "SELECT * FROM carros";   
      $stm = $this->pdo->prepare($sql);   
      $stm->execute();   
      $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
      return $dados;   
     }catch(PDOException $erro){   
      echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
     }   
    } 
    
    
    public function selectCarros($id){   
        try{   
         $sql = "SELECT * FROM carros WHERE id=?";   
         $stm = $this->pdo->prepare($sql);
         $stm->bindValue(1, $id);   
         $stm->execute();   
         $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
         return $dados;   
        }catch(PDOException $erro){   
         echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
        }   
       }

   }  