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
        $url = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url] ?? null;
        } else {
            $fn = $this->postRoutes[$url] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            //header('Location: /404');
            echo "404 Not Found";
            exit;
        }
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