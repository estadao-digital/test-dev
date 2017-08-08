<?php

namespace TestDev\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
      /**
     * A variavel a seguir define a tabela utilizada no banco de dados
     *
     * @var string
     */
    protected $table = 'modelos';


    /**
     * A variável a seguir define como falso o controle de registros por datas
     * @var array
     */
    public $timestamps = false;

    /**
     * Os atributos a seguir são 'pesquisáveis'
     *
     * @var array
     */
    protected $fillable = [
        'id', 'marca', 'modelo'
    ];
}
