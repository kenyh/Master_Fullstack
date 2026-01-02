<?php
class Router
{
    static public $controllerName = "HomeController"; //Si no hay nada despues de la primer / es el Home
    protected $controller = null;
    protected $method = 'list'; //Por defecto llamamos al método list del controlador
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (isset($url[0])) {               //Si existe algo despues del primer /, cambio el controller name
            Router::$controllerName = ucfirst($url[0]) . 'Controller';
        }

        //instancio el controlador en base al controllerName, home o el seteado en el if anterior.
        require_once Router::$controllerName . '.php';
        $this->controller = new Router::$controllerName;


        if (isset($url[1])) {   //Si existe un segundo barra algo.
            $this->method = $url[1];
        }

        if (!method_exists($this->controller, $this->method)) { //Si no existe el método en el controlador
            throw new Exception("No existe el método " . $this->method . " en el controlador " . Router::$controllerName);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);    //Invocamos el método del controlador de esta forma rara. 
    }

    private function parseUrl()
    {
        //ej de $_GET['url'] : platforms/create
        if (!isset($_GET['url'])) { // Si no hay url retorno array vacío.
            return ["home"];
        }
        $url = rtrim($_GET['url'], '/');    //Sin espacios y sin la barra final.
        return explode('/', $url);          //Convierto los valores separados por / de la url en un array.
    }
}
