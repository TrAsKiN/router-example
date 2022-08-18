<?php

namespace App\Router;

use Exception;

class Router
{
    /**
     * @var array Liste des routes enregistrées dans le routeur
     */
    private array $routes = [];

    /**
     * @var Route|null La route trouvée ou null
     */
    private ?Route $foundRoute = null;

    /**
     * Ajoute une route dans la liste du routeur
     *
     * @param Route $route
     * @return void
     */
    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    /**
     * Essai de trouver et de retourner la route correspondant à la requête ou null si rien n'est trouvé
     * Lève une exception si une erreur se produit
     *
     * @return Route|null
     * @throws Exception
     */
    public function findRoute(): ?Route
    {
        $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        foreach ($this->routes as $route) {
            $pattern = sprintf('#^%s$#', $route->schema); // Met le schéma entre des # pour former l'expression régulière
            $check = preg_match($pattern, $request); // Effectue la recherche entre le schéma et l'url
            if ($check === 1) {
                // Le schéma d'une route correspond à l'url
                $this->foundRoute = $route;
            } elseif ($check === 0) {
                // Aucun schéma ne correspond
            } else {
                // Une erreur est survenue dans le test
                throw new Exception();
            }
        }
        return $this->foundRoute;
    }
}
