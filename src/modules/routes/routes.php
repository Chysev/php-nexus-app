<?php

// require_once __DIR__ . '/../services/services.php';
require_once __DIR__ . '/../controllers/users.controller.php';
require_once __DIR__ . '/../controllers/auth.controller.php';

class routes
{
    public static function handleRoutes()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $routes = [

            ['GET', '/', __DIR__ . '/../pages/index.php'],

            // User API Endpoints
            ['GET', '/api/users', [UserController::class, 'getAllUsers']],
            ['GET', '/api/user/{id}', [UserController::class, 'getUserById']],
            ['PATCH', '/api/user/{id}', [UserController::class, 'updateUser']],
            ['DELETE', '/api/user/{id}', [UserController::class, 'deleteUser']],

            // Auth API Endpoints
            ['POST', '/api/login', [AuthController::class, 'login']],
            ['POST', '/api/register', [AuthController::class, 'register']],
            ['GET', '/api/session', [AuthController::class, 'session']],

            // Role API Endpoints
            ['GET', '/api/roles', [UserController::class, 'getAllRoles']],
            ['GET', '/api/role/{id}', [UserController::class, 'getRoleById']],
            ['POST', '/api/roles', [UserController::class, 'createRole']],
            ['PATCH', '/api/roles/{id}', [UserController::class, 'updateRole']],
            ['DELETE', '/api/roles/{id}', [UserController::class, 'deleteRole']],
        ];


        // Automatic routings for pages
        $viewDir = __DIR__ . '/../pages';
        $viewFiles = glob($viewDir . '/*.php');
        foreach ($viewFiles as $viewFile) {
            $fileName = basename($viewFile, '.php');
            $routePath = '/' . ($fileName === 'index' ? '' : strtolower($fileName));
            $routes[] = ['GET', $routePath, $viewFile];
        }

        foreach ($routes as $route) {
            [$method, $path, $handler] = $route;

            $regexPath = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $path);
            $regexPath = '#^' . $regexPath . '$#';

            if ($method === $requestMethod && preg_match($regexPath, $requestUri, $matches)) {
                if (is_string($handler)) {
                    if (file_exists($handler)) {
                        include $handler;
                        return;
                    } else {
                        http_response_code(404);
                        echo "404 View Not Found";
                        return;
                    }
                }

                if (is_callable($handler)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    call_user_func_array($handler, $params);
                    return;
                }
            }
        }

        self::notFound();
    }

    private static function notFound()
    {
        http_response_code(404);
        echo "404 Not Found";
        exit;
    }
}
