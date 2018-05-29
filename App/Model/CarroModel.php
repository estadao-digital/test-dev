<?php
namespace App\Model;

use FastApi\Db\Db;

/**
 * Model CarroModel. 
 *
 * PHP version >= 5.6
 *
 * @category Model
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class CarroModel extends Db
{
    protected $table = 'carro';
    protected $primaryKey = 'id';
    public $fields = array('id' => '', 'id_marca' => '', 'modelo' => '',);
}
