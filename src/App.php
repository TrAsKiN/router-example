<?php

namespace App;

use App\Controller\HomeController;
use App\Controller\ShowController;
use App\Router\Route;
use App\Router\Router;
use Exception;

class App
{
    private readonly Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run(): ?string
    {
        $homeRoute = new Route(
            '/',
            'homepage',
            HomeController::class,
            'home'
        );
        $this->router->addRoute($homeRoute);
        $showRoute = new Route(
            '/omg',
            'showMyContent',
            ShowController::class,
            'display'
        );
        $this->router->addRoute($showRoute);

        try {
            $route = $this->router->findRoute(); // On demande au routeur de trouver une route
            if ($route instanceof Route) {
                // Si $route est une instance de Route, il y a une correspondance
                $controller = new $route->controller; // On instancie le controller de la route
                $method = $route->method; // On enregistre la méthode pour pouvoir l'appeler sur le controller
                return $controller->$method(); // On exécute la méthode
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return null;
    }
}
