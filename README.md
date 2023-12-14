# Projet Pokémon API

Ce projet a été réalisé dans le cadre d'un cours à l'ECV, dans le but de nous familiariser avec une API, en l'occurrence [PokeBuildAPI](https://pokebuildapi.fr/api/v1), en utilisant PHP et MySQL. De plus, TailwindCSS a été choisi pour le développement de l'interface.

![Screenshot du projet](https://i.imgur.com/Ok8MVjj.png)

## Exigences du Projet

### Utilisation de PokeBuildAPI pour sauvegarder des Pokémon dans une base de données MySQL en utilisant PHP.
1. Créez une page "liste" avec un formulaire dans le menu pour rechercher des Pokémon par leur nom et/ou leur ID :
   - Si le Pokémon n'est pas présent dans la base de données, enregistrez ses données depuis l'API dans la base de données.
   - Si le Pokémon est présent dans la base de données, récupérez ses données depuis la base de données.
   - Affichez la page du Pokémon après avoir soumis le formulaire.
   - Assurez-vous que le menu soit présent sur toutes les pages.

2. Ajoutez un menu avec les générations de Pokémon disponibles dans la base de données (Tout, Gen 1, Gen 2, Gen 3, ...):
   - Générez dynamiquement le menu en fonction des Pokémon présents dans la base de données (Ne pas afficher Gen 3 s'il n'y a pas de Pokémon Gen 3 dans la base de données).
   - Affichez tous les Pokémon de la génération sélectionnée sur la page de liste.

3. Sauvegardez toutes les images dans un dossier en utilisant la fonction PHP `file_put_contents` et affichez ces images à partir de ce dossier (par exemple, 25.png, 25_pikachu.png, feu.png, etc).

## Structure du Projet

### Page de Liste (par exemple, index.php)
- Formulaire de recherche et menu de navigation pour les générations.
- Liste des Pokémon avec ID, nom et image.

### Page de Pokémon Unique (par exemple, pokemon.php)
- Formulaire de recherche et menu de navigation pour les générations.
- Image du Pokémon, ID et nom.
- Types de Pokémon (par exemple, feu, eau) avec des icônes de type.
- Nom et image de ses évolutions (le cas échéant).
- Noms des évolutions cliquables pour afficher la page du Pokémon cliqué.
- Option pour supprimer le Pokémon.

## Directives de Codage

- Vous avez la flexibilité de coder de manière procédurale ou orientée objet.
- Partez de zéro, aucun framework n'est autorisé.
- JavaScript est autorisé mais non noté.
- Un minimum de styles est apprécié mais non noté (les bibliothèques CSS sont autorisées).

## Critères d'Évaluation

Les points suivants seront évalués (Total / 20) :

- Pourcentage d'achèvement et présence de tous les éléments énumérés.
- Organisation du code (un léger bonus en cas d'utilisation de la programmation orientée objet).
- Optimisation des requêtes SQL.
- Gestion des erreurs et des bugs (par exemple, la gestion des cas où un Pokémon n'existe pas).
