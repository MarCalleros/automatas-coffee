<?php 

namespace App;

class Router {
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn){
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn){
        $this->postRoutes[$url] = $fn;
    }

    public function testRoutes() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
    
        $routes = $method === 'GET' ? $this->getRoutes : $this->postRoutes;
    
        foreach ($routes as $route => $fn) {
            // Ruta con parámetros tipo /informacion/:seccion
            $routeRegex = preg_replace('#:([\w]+)#', '([^/]+)', $route);
            $routeRegex = "#^" . $routeRegex . "$#";
    
            if (preg_match($routeRegex, $url, $matches)) {
                array_shift($matches); // quitamos la coincidencia completa
                return call_user_func_array($fn, array_merge([$this], $matches));
            }
        }
    
        echo "404 Not Found";
        exit;
    }
    

    public function render($view, $data = []) {
        foreach ($data as $key => $value) {
            $$key = $value; 
        }
        
        //ob_start(); 
        include_once __DIR__ . "/views/$view.php";
        //$content = ob_get_clean();

        //echo $content;
    }
}