<?php
class Router
{
    protected $controllerName = "Home";
    protected $controller = null;
    protected $method = 'list';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (isset($url[0])) {               //Si existe algo despues del primer /, cambio el controller name
            $this->controllerName = ucfirst($url[0]) . 'Controller';
        }

        //instancio el controlador en base al controllerName, home o el seteado en el if anterior.
        require_once $this->controllerName . '.php';
        $this->controller = new $this->controllerName;


        if (isset($url[1])) {   //Si existe un segundo barra algo.
            $this->method = $url[1];
        }

        if (!method_exists($this->controller, $this->method)) {
            throw new Exception("No existe el método " . $this->method . " en el controlador " . $this->controllerName);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        if (!isset($_GET['url'])) { // Si no hay url retorno array vacío.
            return ["home"];
        }
        return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    }
}
