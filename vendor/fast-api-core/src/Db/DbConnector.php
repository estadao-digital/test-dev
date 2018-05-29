<?php
/**
 * DbConnector Class.
 *
 * PHP version 5.6
 *
 * @category Db
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\Db;
/**
 * DbConnector Class.
 *
 * PHP version 5.6
 *
 * @category Db
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class DbConnector
{
    
    protected $connection;
    /**
     * Constructor
     */
    public function __construct()
    {
        $dbPath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database/'.DB_FILE;
        $exitsDb = file_exists($dbPath);
        try{
            if ($this->connection==null) {
                switch(DB_DRIVER) {
                    case 'sqlite':
                        $this->connection =new \PDO(
                                "sqlite:$dbPath", "", "", array(
                                \PDO::ATTR_PERSISTENT => true,
                            )
                        );
                    break;
                    case 'mysql':
                        $this->connection = new \PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST.";port=".DB_PORT, DB_USER, DB_PASSWORD,array(\PDO::ATTR_PERSISTENT => true));
                    break;
                    case 'pgsql':
                        $this->connection = new \PDO("pgsql:dbname=".DB_NAME.";host=".DB_HOST.";port=".DB_PORT, DB_USER, DB_PASSWORD,array(\PDO::ATTR_PERSISTENT => true));
                    break;
                }
                
            }
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
        }catch(PDOException $e){
            print "Error in openhrsedb ".$e->getMessage();
        }
    }
}
