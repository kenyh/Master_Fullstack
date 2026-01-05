<?php

class Router
{
    static public $controllerName = "Home";                                             //Si no hay nada despues de la primer / es el Home
    static $method = 'list';                                                            //Por defecto llamamos al método list del controlador

    static public function route()
    {
        $urlArray = empty($_GET["url"]) ? [] : explode('/', rtrim($_GET["url"], '/'));  //Convierto la url en un array separando por /, sin la barra final (rtrim)

        if (isset($urlArray[0])) Router::$controllerName = ucfirst($urlArray[0]);       //Si hay elementos en urlArray. O sea, si la ruta no es / a secas.
        if (isset($urlArray[1])) Router::$method = $urlArray[1];                        //Si existe un segundo elemento en urlArray.

        $controllerFullName = Router::$controllerName . 'Controller';                   //instancio el controlador en base al controllerName, home o el seteado en el if anterior.

        require_once $controllerFullName . ".php";                                      //Requiero el archivo del controlador.
        $controller = new $controllerFullName;

        if (!method_exists($controller, Router::$method)) {                             //Si no existe el método en el controlador
            throw new Exception("No existe el método "
                . Router::$method
                . " en el controlador " . Router::$controllerName);
        }

        call_user_func_array([$controller, Router::$method], []);                       //Invocamos el método del controlador de esta forma rara. 
    }
}
