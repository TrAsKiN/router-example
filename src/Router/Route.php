<?php

namespace App\Router;

/**
 * Représente une route
 */
class Route
{
    /**
     * @param string $schema Le format de l'url
     * @param string $name Le nom de la route
     * @param string $controller Le controller à appeler
     * @param string $method La méthode à appeler dans le controller
     */
    public function __construct(
        public readonly string $schema,
        public readonly string $name,
        public readonly string $controller,
        public readonly string $method
    ) {
    }
}
