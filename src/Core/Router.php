<?php

namespace App\Core;

use Exception;

class Router
{
    protected $routes = [];
    protected $protectedRoutes = [];
    protected $lastRoute = null;
    protected $lastMethod = null;

    public function get($url, $controllerAction)
    {
        return $this->addRoute('GET', $url, $controllerAction);
    }
    public function post($url, $controllerAction)
    {
        return $this->addRoute('POST', $url, $controllerAction);
    }
    public function put($url, $controllerAction)
    {
        return $this->addRoute('PUT', $url, $controllerAction);
    }
    public function patch($url, $controllerAction)
    {
        return $this->addRoute('PATCH', $url, $controllerAction);
    }
    public function delete($url, $controllerAction)
    {
        return $this->addRoute('DELETE', $url, $controllerAction);
    }
    public function options($url, $controllerAction)
    {
        return $this->addRoute('OPTIONS', $url, $controllerAction);
    }
    public function head($url, $controllerAction)
    {
        return $this->addRoute('HEAD', $url, $controllerAction);
    }

    // DRY: Simplifica la asignación de rutas repetitivas
    protected function addRoute($method, $url, $controllerAction)
    {
        // Normalizamos quitando barras extras al final (menos si es solo "/")
        $url = ($url !== '/') ? rtrim($url, '/') : $url;

        $this->routes[$method][$url] = $controllerAction;
        $this->lastRoute = $url;
        $this->lastMethod = $method;

        return $this;
    }

    public function protect()
    {
        if ($this->lastRoute && $this->lastMethod) {
            $this->protectedRoutes[$this->lastMethod][$this->lastRoute] = true;
        }

        return $this;
    }

    public function direct()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = ($uri !== '/') ? rtrim($uri, '/') : $uri; 
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$method])) {
            $this->notFound();
        }

        foreach ($this->routes[$method] as $route => $controllerAction) {

            // Reemplaza {param} por expresiones regulares de captura
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^\/]+)', $route);
            $pattern = "#^{$pattern}$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Quita la coincidencia completa de la aguja

                // Verificación de protección de ruta
                if (isset($this->protectedRoutes[$method][$route])) {

                    if (!Auth::check()) {

                        // MEJORA: Detección inteligente de peticiones AJAX/Fetch o JSON
                        $isJsonRequest = (
                            (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
                            (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) ||
                            (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
                        );

                        if ($isJsonRequest) {
                            http_response_code(401);
                            header('Content-Type: application/json; charset=UTF-8');
                            echo json_encode([
                                'success' => false,
                                'message' => 'No autorizado. Su sesión expiró.'
                            ], JSON_UNESCAPED_UNICODE);
                        } else {
                            header('Location: /inicio');
                        }
                        exit;
                    }
                }
                list($controller, $action) = explode('@', $controllerAction);

                return $this->callAction($controller, $action, $matches);
            }
        }

        $this->notFound();
    }

    protected function callAction(string $controller, string $action, array $params = [])
    {
        $controllerClass = "App\\Controllers\\{$controller}";

        if (!class_exists($controllerClass)) {
            throw new Exception("El controlador {$controller} no existe.");
        }

        $controllerInstance = new $controllerClass();

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("La acción {$action} no existe en {$controller}.");
        }

        return call_user_func_array([$controllerInstance, $action], $params);
    }

    protected function notFound(): void
    {
        http_response_code(404);
        $viewPath = __DIR__ . '/../views/error/error_404.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode([
                'success' => false,
                'message' => 'Error 404 - Recurso no encontrado.'
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}
