<?php 

class Router {
    public function route() {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

        if ($uri === '/') {
            include_once __DIR__ . '/../views/home.php';
        } else if ($uri === '/products') {
            include_once __DIR__ . '/../views/products.php';
        } else {
            include_once __DIR__ . '/../views/404.php';
        }
    }
}