<?php
namespace App\Model;

use FastApi\Db\Db;

/**
 * Model UserModel - An example of model. 
 *
 * PHP version >= 5.6
 *
 * @category Model
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class UserModel extends Db
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $fields = array('id' => '', 'name' => '', 'email' => '', 'password' => '');
}
