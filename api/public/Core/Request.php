<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

/**
 * Class Request
 * 
 * @package App\Core
 */
class Request
{
    public function __construct()
    {
        $this->createObjectsServer();        
    }

    /**
     * Creation of an object for each item of $ _SERVER
     * 
     * @return void
     */
    private function createObjectsServer(): void
    {
        foreach($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    /**
     * Trasnform string to Camel Case
     * 
     * @param string $string
     * 
     * @return string
     */
    private function toCamelCase($string): string
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * Get Body
     * 
     * @return array
     */
    public function getBody(): array
    {
       $typesAllowBody = ['POST', 'PUT'];

       if (in_array($this->requestMethod, $typesAllowBody)) {            
            if ($_POST) {
                $body = [];

                foreach($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            
                return $body;
            }

            $inputContent = json_decode(file_get_contents('php://input'), true);

            if ($inputContent) return $inputContent;
       }

        return [];
    }
}