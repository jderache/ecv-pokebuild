<?php

require_once 'db.php';

// Affiche le pokemon selectionné de par l'id présent dans l'url
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'SELECT * FROM pokemons WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $result = $stmt->fetch();
    $idPokemonName = $result->id;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./public/css/style.css">
  <?php
  if ($result) {
      echo "<meta name='description' content='Pokemon - ".$result->name."'>";
      echo "<meta name='keywords' content='Pokemon, ".$result->name."'>";
      echo '<title>Pokémon - '.$result->name.'</title>';
      echo "<link rel='favicon' type='image/png' href='".$result->sprite."'>";
  }
?>
</head>
<body class="p-5 bg-white dark:bg-gray-900 antialiased">

<header class="mt-5">
  <?php require_once 'components/search.php'; ?>
  <button class="my-5 mx-5 fixed top-0 left-0 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><a href="index.php" class="flex p-2.5">Retour</a></button>
</header>


<?php
if ($result) {
    ?>
    <div class="mt-2.5 flex gap-2 justify-center">
        <h1 id="pokemonName" class="font-bold text-xl"><?php echo $result->name; ?></h1>
        <button id="editButton">
        <svg class="h-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000" version="1.1" id="Layer_1" viewBox="0 0 512 512" xml:space="preserve"><g><g><path d="M37.839,407.747L1.646,484.275c0,0-5.687,12.222,4.084,21.996c9.771,9.771,21.996,4.081,21.996,4.081l76.526-36.193L37.839,407.747z"/></g></g><g><g><rect x="97.087" y="163.264" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -85.681 264.4366)" width="358.552" height="144.761"/></g></g><g><g><rect x="419.682" y="-4.161" transform="matrix(0.7071 -0.7071 0.7071 0.7071 81.7408 333.7798)" width="48.194" height="144.761"/></g></g><g><g><rect x="88.167" y="329.3" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -251.7197 195.655)" width="44.3" height="144.761"/></g></g></svg>
        </button>
        <div id="editNameDiv" class="gap-2" style="display: none;">
            <input type="text" id="newName" class="my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo $result->name; ?>">
            <button id="saveButton" class="p-2.5 my-2 text-sm font-medium text-white bg-green-700 rounded-lg border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Enregistrer</button>
        </div>
    </div>
    <form action='deletePokemon.php' method='POST'>
        <input type='hidden' name='id' value='<?php echo $result->id; ?>'>
        <button type='submit' class='flex gap-2 center mx-5 my-5 p-2.5 fixed top-0 right-0 text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800'>Supprimer
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M2 8h20M6 8V4a2 2 0 012-2h8a2 2 0 012 2v4M6 8v12a2 2 0 002 2h8a2 2 0 002-2V8M12 14v4"></path>
        </svg>
        </button>
    </form>
    <div class="flex justify-center flex-col items-center">
    <img class="flex justify-center mt-4" width="250" height="250" src='<?php echo $result->image; ?>'><br/>
    <p><strong>ID :</strong> <?php echo $result->id; ?></p>
    <p><strong>Génération :</strong> <?php echo $result->generation; ?></p>
    <br/>
    </div>
    <?php
        $sql = 'SELECT types.name FROM types
        INNER JOIN pokemons_types ON types.id = pokemons_types.typeId
        INNER JOIN pokemons ON pokemons_types.pokemonId = pokemons.id
        WHERE pokemons.id = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $types = $stmt->fetchAll();
    ?>
    <h2 class="text-center text-lg font-bold"><?php echo count($types) > 1 ? 'Types' : 'Type'; ?></h2>
    <div class="flex justify-center items-center gap-4">
        <?php
    foreach ($types as $type) {
        ?>  
        <div class="flex justify-center flex-col items-center">
            <img src='./public/images/types/<?php echo $type->name; ?>.png' width='50px'>
            <span><?php echo $type->name; ?></span>
        </div>
        <?php } ?>
        <?php } else { ?>
            Aucun résultat
        <?php } ?>
    </div>

<div class="evolutions flex gap-5 justify-center mt-6">

<?php
// Vérifie si le pokemon comporte une pré-évolution en BDD
$sql = 'SELECT * FROM pokemons_pre_evolutions WHERE pokemonId = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$_GET['id']]);
$result_pre_evol = $stmt->fetch();

if ($result_pre_evol) {
    $pre_evolutionId = $result_pre_evol->evolutionPokemonId;
    $sql = 'SELECT * FROM pokemons WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$pre_evolutionId]);
    $result = $stmt->fetch();
    ?>
<?php if ($result) { ?>
<div class="flex flex-col align-center h-auto max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-48">
    <a href="pokemon.php?id=<?php echo $result->id; ?>" class="flex flex-col items-center">
        <h2><< Pré-évolution</h2>
        <p class="font-bold"><?php echo $result->name; ?></p><img src="<?php echo $result->sprite; ?>"/><p>ID: <?php echo $result->id; ?></p>
    </a>
</div>
<?php } else { ?>
        <div class="flex flex-col align-center h-auto max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-48">
        <form  method="post" action="getPokemon.php" class="flex flex-col items-center">
            <h2><< Pré-évolution</h2>
            <input type="hidden" name="searchTerm" value="<?php echo $pre_evolutionId; ?>">
            <p class="font-bold"><?php echo $result_pre_evol->name; ?></p><p>ID: <?php echo $pre_evolutionId; ?></p>
            <button type="submit" class="my-2 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Voir</button>
        </form>
        </div>
        <?php
}
} ?>
<?php
// Vérifie si le pokemon comporte une évolution en BDD
$sql = 'SELECT * FROM pokemons_evolutions WHERE pokemonId = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$_GET['id']]);
$result_evol = $stmt->fetch();

if ($result_evol) {
    $evolutionId = $result_evol->evolutionPokemonId;
    $sql = 'SELECT * FROM pokemons WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$evolutionId]);
    $result = $stmt->fetch();
    ?>
<?php if ($result) { ?>
<div class="flex flex-col align-center h-auto max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-48">
    <a href="pokemon.php?id=<?php echo $result->id; ?>" class="flex flex-col items-center">
        <h2>Evolution >></h2>
        <p class="font-bold"><?php echo $result->name; ?></p><img src="<?php echo $result->sprite; ?>"/><p>ID: <?php echo $result->id; ?></p>
    </a>
</div>
<?php } else { ?>
        <div class="flex flex-col align-center h-auto max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-48">
            <form method="post" action="getPokemon.php" class="flex flex-col items-center">
                    <h2>Evolution >></h2>
                    <input type="hidden" name="searchTerm" value="<?php echo $evolutionId; ?>">
                    <p class="font-bold"><?php echo $result_evol->name; ?></p><p>ID: <?php echo $evolutionId; ?></p>
                    <button type="submit" class="my-2 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Voir</button>
                </form>
            </div>
        <?php
}
} ?>
</div>

<script>
    const pokemonName = document.getElementById('pokemonName');
    const editButton = document.getElementById('editButton');
    const editNameDiv = document.getElementById('editNameDiv');
    const newNameInput = document.getElementById('newName');
    const saveButton = document.getElementById('saveButton');

    editButton.addEventListener('click', () => {
        pokemonName.style.display = 'none';
        editNameDiv.style.display = 'flex';
    });

    saveButton.addEventListener('click', () => {
        const newPokemonName = newNameInput.value;
        const pokemonId = <?php echo $idPokemonName; ?>;

        // Envoie du nouveau nom via une requête AJAX
        fetch('updatePokemonName.php', {
            method: 'POST',
            body: JSON.stringify({ id: pokemonId, name: newPokemonName }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                pokemonName.textContent = newPokemonName;
                document.title = 'Pokémon - ' + newPokemonName;
                pokemonName.style.display = 'flex';
                editNameDiv.style.display = 'none';
            } else {
                alert('Erreur lors de la mise à jour du nom du Pokémon.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur s\'est produite lors de la mise à jour du nom du Pokémon.');
        });
    });
</script>

</body>
</html>