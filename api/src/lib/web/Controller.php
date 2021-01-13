<?php

namespace app\lib\web;

use app\lib\Identity;
use app\lib\Response;
use Exception;

class Controller {


    /** @var string filename the filename that contains the application default layout */
    protected String $layout = 'index';


    /**
     * Render the page with default application layout
     * @param String
     * @param Array
     * @return void
     */
    public function render(String $view = '', Array $params = []) : void
    {
        $layoutPath = realpath(__DIR__.'/../../layout/'. $this->layout .'.php');
        ob_start();
        ob_implicit_flush(false);

        try {
            $content = $this->renderPhpFile($view, $params);
            require $layoutPath;
            echo ob_get_clean();
        } catch (Exception $e) {
            ob_clean();
        }
    }

    /**
     * Render a PHP file 
     * @param String
     * @param Array
     * @return string|null
     */
    public function renderPhpFile (string $view, array $params = []) : ?string
    {
        $contentPath = realpath(__DIR__ . '/../../view/' . $view . '.php');
        ob_start();
        ob_implicit_flush(false);
        extract($params);

        try {
            require $contentPath;
            return ob_get_clean();
        } catch (Exception $e) {
            ob_clean();
        }
    }

    public function isAuthenticated()
    {
        $user = Identity::getIdentity();
        if (!$user) {
            Response::sendResponse(Response::UNAUTHORIZED, Response::UNAUTHORIZED);
        }
    }
}