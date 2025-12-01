<?php
namespace App\Core;

class Controller
{
    protected array $data = [];

    protected function view(string $template, array $data = [], string $layout = 'main'): void
    {
        $this->data = $data;
        $viewPath = __DIR__ . '/../views/' . $template . '.php';
        if (!file_exists($viewPath)) {
            http_response_code(404);
            echo "Vista no encontrada";
            return;
        }

        extract($data);
        $layoutPath = __DIR__ . '/../views/layouts/' . $layout . '.php';
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            include $viewPath;
        }
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
