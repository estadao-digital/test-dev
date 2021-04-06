<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core\Database;

use App\Config\Database;

/**
 * Interface DatabaseInterface
 * 
 * @package App\Core\Database
 */
interface DatabaseInterface
{
    /**
     * DatabaseJson construct
     * 
     * @param Database $config
     * @param string $entity
     */
    public function __construct(Database $config, $entity = '');

    /**
     * Find all records
     * 
     * @return array
     */
    public function findAll(): array;

    /**
     * Find a record by id
     * 
     * @param int $id
     * 
     * @return array
     */
    public function findById($id): array;

    /**
     * Create record
     * 
     * @param array $data
     * 
     * @return array
     */
    public function create($data): array;
}