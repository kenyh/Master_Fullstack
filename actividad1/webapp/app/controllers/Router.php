<?php
class Router
{
    //controllerName lo hacemos static para que sea facil detectar cual es el controlador usado en la vista y pintar la opción correcta en el menú.
    static public $controllerName = "HomeController"; //Si no hay nada despues de la primer / es el Home
    protected $controller = null;
    protected $method = 'list'; //Por defecto llamamos al método list del controlador
    protected $params = [];

    public function __construct()
    {
        $urlArray = $this->urlToArray();

        if (isset($urlArray[0])) {          //Si hay elementos en urlArray. O sea, si la ruta no es / a secas.
            Router::$controllerName = ucfirst($urlArray[0]) . 'Controller';
        }
        if (isset($urlArray[1])) {          //Si existe un segundo elemento en urlArray.
            $this->method = $urlArray[1];
        }

        //instancio el controlador en base al controllerName, home o el seteado en el if anterior.
        require_once Router::$controllerName . '.php';
        $this->controller = new Router::$controllerName;

        if (!method_exists($this->controller, $this->method)) {                     //Si no existe el método en el controlador
            throw new Exception("No existe el método " . $this->method . " en el controlador " . Router::$controllerName);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);    //Invocamos el método del controlador de esta forma rara. 
    }

    private function urlToArray()
    {                                       //ej de $_GET['url'] : platforms/create
        if (!isset($_GET['url'])) {
            return [];                      // Si no hay url retorno array vacío.
        }
        $url = rtrim($_GET['url'], '/');    //Sin espacios y sin la barra final.
        return explode('/', $url);          //Convierto los valores separados por / de la url en un array.
    }
}
