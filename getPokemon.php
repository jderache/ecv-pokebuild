<?php

require_once 'db.php';

// Fonction pour créer un Pokémon
function createPokemon($conn, $id, $name, $image, $sprite, $generation, $types)
{
    // Télécharger et stocker l'image localement
    $localImagePath = './public/images/'.$id.'.png';
    $spriteImagePath = './public/images/sprites/'.$id.'.png';
    file_put_contents($localImagePath, file_get_contents($image));
    file_put_contents($spriteImagePath, file_get_contents($sprite));

    // Insérer le Pokémon dans la table pokemons
    $sql = 'INSERT INTO pokemons (id, name, image, sprite, generation) VALUES (?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id, $name, $localImagePath, $spriteImagePath, $generation]);

    // Insérer les types du Pokémon dans la table pokemons_types
    foreach ($types as $type) {
        // Vérifier si le type existe déjà en BDD
        $sql = 'SELECT id FROM types WHERE name = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$type['name']]);
        $typeId = $stmt->fetchColumn();

        // Si le type n'existe pas, l'insérer dans la table types avec son image
        if (!$typeId) {
            $typeImage = $type['image'];
            $localTypeImagePath = './public/images/types/'.$type['name'].'.png';
            file_put_contents($localTypeImagePath, file_get_contents($typeImage));

            // Insérer le type dans la table types
            $sql = 'INSERT INTO types (name, image) VALUES (?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->execute([$type['name'], $localTypeImagePath]);
            $typeId = $conn->lastInsertId();
        }

        // Insérer le type du Pokémon dans la table pokemons_types
        $sql = 'INSERT INTO pokemons_types (pokemonId, typeId) VALUES (?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id, $typeId]);
    }
}

function searchPokemon($conn, $searchTerm)
{
    // Requête SQL pour rechercher le Pokémon en base de données
    $sql = 'SELECT * FROM pokemons WHERE name LIKE ? OR id = ? LIMIT 1';
    $stmt = $conn->prepare($sql);
    $likeTerm = "%{$searchTerm}%";
    $stmt->execute([$likeTerm, $searchTerm]);
    $result = $stmt->fetch();

    if ($result) {
        // Rediriger vers la page du Pokémon trouvé
        header("Location: pokemon.php?id={$result->id}");
        exit;
    }

    // Requête à l'API pour vérifier si le Pokémon existe
    $apiUrl = "https://pokebuildapi.fr/api/v1/pokemon/{$searchTerm}";
    $headers = get_headers($apiUrl);

    if (strpos($headers[0], '200') !== false) {
        $data = file_get_contents($apiUrl);
        if ($data !== false) {
            $data = json_decode($data, true);

            // Vérifier si les données de l'API sont valides
            if (isset($data['id'], $data['name'], $data['image'], $data['sprite'], $data['apiGeneration'], $data['apiTypes'], $data['apiEvolutions'], $data['apiPreEvolution'])) {
                $id = $data['id'];
                $name = $data['name'];
                $image = $data['image']; // URL de l'image
                $sprite = $data['sprite'];
                $generation = $data['apiGeneration'];
                $types = $data['apiTypes'];

                // Appeler la fonction createPokemon pour créer le Pokémon
                createPokemon($conn, $id, $name, $image, $sprite, $generation, $types);

                // Si le Pokémon a une évolution, l'insérer dans la table pokemons_evolutions
                if ($data['apiEvolutions'] !== []) {
                    foreach ($data['apiEvolutions'] as $evolution) {
                        $evolutionName = $evolution['name'];
                        $evolutionId = $evolution['pokedexId'];
                    }
                    $sql = 'INSERT INTO pokemons_evolutions (name, pokemonId, evolutionPokemonId) VALUES (?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$evolutionName, $id, $evolutionId]);
                }

                if ($data['apiPreEvolution'] !== 'none') {
                    $preEvolutionName = $data['apiPreEvolution']['name'];
                    $preEvolutionId = $data['apiPreEvolution']['pokedexIdd'];
                    $sql = 'INSERT INTO pokemons_pre_evolutions (name, pokemonId, evolutionPokemonId) VALUES (?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$preEvolutionName, $id, $preEvolutionId]);
                }

                // Rediriger vers la page du Pokémon
                header("Location: pokemon.php?id={$id}");
                exit;
            } else {
                // Les données de l'API sont incorrectes
                header('Location: error.php');
                exit;
            }
        } else {
            // Erreur lors de la récupération des données de l'API
            header('Location: error.php');
            exit;
        }
    } else {
        // Pokémon non trouvé dans l'API
        header('Location: error.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recherche de Pokémon
    $searchTerm = $_POST['searchTerm'];
    searchPokemon($db, $searchTerm);
}
