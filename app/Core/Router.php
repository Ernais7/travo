<?php

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, callable|array $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    private function addRoute(string $method, string $path, callable|array $action): void
    {
        $path = $this->normalize($path);

        $this->routes[$method][] = [
            'path' => $path,
            'action' => $action
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $currentPath = $this->normalize($uri);

        if (!isset($this->routes[$method])) {
            $this->send404();
            return;
        }

        foreach ($this->routes[$method] as $route) {
            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $currentPath, $matches)) {
                array_shift($matches);

                $this->runAction($route['action'], $matches);
                return;
            }
        }

        $this->send404();
    }

    private function runAction(callable|array $action, array $params = []): void
    {
        if (is_array($action) && isset($action[0], $action[1]) && is_string($action[0])) {
            $controllerName = $action[0];
            $method = $action[1];

            if (!class_exists($controllerName)) {
                die("Le contrôleur {$controllerName} est introuvable.");
            }

            $controller = new $controllerName();

            if (!method_exists($controller, $method)) {
                die("La méthode {$method} est introuvable dans {$controllerName}.");
            }

            call_user_func_array([$controller, $method], $params);
            return;
        }

        call_user_func_array($action, $params);
    }

    private function normalize(string $path): string
    {
        $path = parse_url($path, PHP_URL_PATH) ?? '/';

        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

        if ($scriptDir !== '/' && $scriptDir !== '.' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }

        $path = '/' . trim($path, '/');

        return $path === '//' ? '/' : $path;
    }

    private function send404(): void
    {
        $errorController = new ErrorController();
        $errorController->notFound();
    }
}