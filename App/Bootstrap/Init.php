<?php
/**
 * Init Class
 *
 * PHP version 5.6
 *
 * @category Bootstrap
 * @package  FastApi
 * @author   Mario Miranda Fernandes Junior <mario.junior@aker.com.br>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace App\Bootstrap;

use FastApi\Routing\Routing;
/**
 * Init Class
 *
 * @category  Bootstrap
 * @package   FastApi
 * @author    Mario Miranda Fernandes Junior <mario.junior@aker.com.br>
 * @copyright 2018 Mario Miranda
 * @license   mmfjunior1@gmail.com Proprietary
 * @link      www.aker.com.br
 */
class Init
{
    /**
     * Constructor
     */
    public function __construct() 
    {
        try {
            $envFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'.environment';
            if (!file_exists($envFile)) {
                throw new \Exception('Environment file is missing ');
            }
            $iniParser = parse_ini_file($envFile);
            foreach ($iniParser as $field => $value) {
                define($field, $value);
            }
        } catch (\Exception $e) {
            echo 'Exception error: '.  $e->getMessage();
            exit;
        }
    }
    /**
     * Start the app
     * 
     * @return void
     */
    public function run() 
    {
        if(file_exists(__DIR__.'/routes.php') ) {
            include __DIR__.'/routes.php';
        }
        (new Routing)->run();
    }
}
