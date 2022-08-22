<?php

namespace App\Router;

/**
 * Représente une route
 */
class Route
{
    public string $schema;
    public string $name;
    public string $controller;
    public string $method;

    /**
     * @param string $schema Le format de l'url
     * @param string $name Le nom de la route
     * @param string $controller Le controller à appeler
     * @param string $method La méthode à appeler dans le controller
     */
    public function __construct(
        string $schema,
        string $name,
        string $controller,
        string $method
    ) {
        $this->schema = $schema;
        $this->name = $name;
        $this->controller = $controller;
        $this->method = $method;
    }
}
