<?php
class Router
{
    protected $controllerName = '';
    protected $controller = null;
    protected $method = 'list';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (isset($url[0])) {
            $this->controllerName = ucfirst($url[0]) . 'Controller';
        }

        require_once $this->controllerName . '.php';
        $this->controller = new $this->controllerName;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->params = $url ? array_values($url) : [];

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
