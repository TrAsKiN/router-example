# Exemple d'un routeur PHP basique en POO/MVC

## Lancer l'application facilement avec PHP

Il est très facile de lancer l'application avec le serveur interne de PHP. Il suffit de lancer la commande suivante dans un terminal depuis la racine du projet :

- `php -S localhost:8000 -t public/`

À partir de maintenant, l'application est accessible depuis votre navigateur à l'adresse : http://localhost:8000/ !

## Avant le routeur, l'application

Avant de commencer l'explication sur le routeur, il faut d'abord comprendre comment est architecturée son application.

Ici, le point d'entrée de toutes les requêtes est le fichier `public/index.php`. C'est lui qui va instancier `App`, exécuter la méthode `run()` et afficher le résultat.

On verra plus tard ce que fait la méthode `run()`, quand on aura vu le fonctionnement du routeur.

Il y a aussi 2 contrôleurs dans le dossier `Controller` qui ont chacun une seule méthode qui renvoi du texte.

## En route !

Il est temps de faire notre routeur ! Mais avant ça, il faut définir ce que sera celui-ci. En règle générale, un routeur ne fait que très peu de chose.

1. Enregistrer une route
2. Trouvé une route

Et c'est tout ! On peut bien sûr y ajouter quelques fonctions pratiques, par exemple : récupérer une route depuis son nom ou générer une url. Mais ces fonctions ne sont pas obligatoirement le rôle du routeur.

Maintenant que nous avons défini ce que fera le routeur, il est temps de commencer !

Hum... Pas si vite ! Il manque élément, la route ! Sans route, notre routeur ne sert pas à grand-chose. Et pour définir une route, il n'y a rien de plus simple qu'une classe. Elle ne fera rien de plus qu'avoir des propriétés qui définissent une route, soit :

1. Le schéma de son URL
2. Son nom
3. Le contrôleur
4. La méthode du contrôleur qui doit être appelée

C'est ce que j'ai défini dans le fichier `src/Router/Route.php`. Les propriétés sont en `readonly` car elles ne seront pas modifiées au cours de l'exécution de l'application.

Nous avons des routes, il ne nous reste plus que notre routeur ! Définissons d'abord les propriétés du routeur, ce qu'il doit avoir en mémoire :

1. La liste des routes
2. La route qui aurait été trouvée

Pour que le routeur fonctionne il a besoin des routes, il nous faut donc une possibilité de les enregistrer. C'est le rôle de la méthode `addRoute()` qui prend en paramètre une instance (ou objet) `Route` et l'ajoute dans la liste du routeur.

Parfait ! Attaquons-nous à la partie la plus complexe. La méthode `findRoute()`, qui s'occupera de trouver une route qui correspond à l'url de la requête. Elle devra donc retourner une `Route` s'il y a une correspondance ou `null` si rien n'est trouvé et émettre une exception si une erreur survient.

D'abord, nous avons besoin de l'url. Elle est accessible depuis la variable `$_SERVER['REQUEST_URI']` que nous enregistrons dans une variable `$request`.

Il est temps de tester toutes les routes qui ont été enregistrées grâce à une boucle `foreach`. Plutôt que de faire une simple condition, il est souvent préférable d'utiliser une expression régulière. Pour pouvoir utiliser notre schéma en tant qu'expression régulière, il faut l'encadrer avec des caractères spéciaux. Ici, j'ai choisi d'utiliser des `#`. Le symbole `^` précise que ça doit *commencer par* et le symbole `$` *finir par*.

Ensuite, la fonction `preg_match()` effectue une recherche de correspondance. Si le résultat est égal à `1` alors il y a une correspondance et la route que l'on est en train de tester est la bonne, nous pouvons l'enregistrer ! Si le résultat est égal à `0` alors il n'y a pas de correspondance et donc nous pouvons afficher une page 404. Enfin, si le résultat vaut `false` c'est qu'il y a une erreur avec notre test et il faut donc émettre une exception.

Il ne reste plus qu'à retourner ce qui a été trouvé ou non et nous avons terminé notre routeur !

## Utiliser le routeur

Il est temps d'utiliser le routeur, retournons dans notre application principale.

Le routeur est dorénavant un élément de notre application et peut être enregistré en tant que propriété de celle-ci. On souhaite aussi qu'au démarrage il soit initialisé grâce à la fonction `__construct()`.

Ok ! Maintenant, il faut préciser au routeur les routes à enregistrer. On peut le faire dans la méthode `__construct()` mais ce n'est généralement pas souhaitable. L'application étant simple, nous pouvons le faire dans notre fonction `run()`.

Commençons par créer les routes, une pour chaque contrôleur/méthode, que nous enregistrons dans la foulée grâce à la méthode `addRoute()` du routeur.

Les routes sont enregistrées, c'est partit ! Comme la méthode `findRoute()` peut émettre une exception, il faut encadrer ça dans un `try {} catch() {}`. Il nous suffit d'appeler la méthode `findRoute()` du routeur dans le `try` et de récupérer son retour. S'il s'agit d'une instance de `Route`, BINGO ! Récupérons le contrôleur et la méthode pour pouvoir les appelés et retourner le résultat ! Si rien n'a été trouvé, il ne se serait rien passé et la méthode `run()` aurait retourné `null`. Et s'il y avait eu une exception, elle aurait été attrapée et le message d'erreur retourné.

Bravo ! Vous avez un routeur !
