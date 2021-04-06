<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core\Database;

/**
 * Class DatabaseMysql
 * 
 * @package App\Core\Database
 */
class DatabaseMysql implements DatabaseInterface
{
    /**
     * DatabaseMysql construct
     * 
     * @param Database $config
     * @param string $entity
     */
    public function __construct(Database $config, $entity = '')
    {
        // TODO
    }

    /**
     * Find all records
     * 
     * @return array
     */
    public function findAll(): array
    {
        // TODO
        return [];
    }

    /**
     * Find a record by id
     */
    public function findById($id = null): array
    {
        // TODO
        return [];
    }
}