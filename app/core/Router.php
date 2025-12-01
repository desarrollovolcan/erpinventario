<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $handler = $this->routes[$method][$path] ?? null;
        if (!$handler) {
            http_response_code(404);
            echo "Ruta no encontrada";
            return;
        }

        [$controllerName, $action] = $handler;
        $controller = new $controllerName();
        if (!method_exists($controller, $action)) {
            http_response_code(500);
            echo "Acción inválida";
            return;
        }
        $controller->$action();
    }
}
