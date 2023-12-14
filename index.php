<?php
require_once 'db.php';

// Gestion de la pagination

// On détermine sur quelle page on se trouve
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}

// On détermine le nombre de pokémons à afficher par page
$limit = 25;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Pokémons</title>
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body class="p-5 bg-white dark:bg-gray-900 antialiased">
    <header class="mt-5">
        <?php require_once 'components/search.php'; ?>
    </header>
    <h1 class="text-xl font-bold py-2.5">Liste des Pokémons</h1>

    <div class="py-2.5">
        <?php
        echo "<button class='me-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'><a class='flex py-2.5 px-5' href='index.php'>Toutes les générations</a></button>";
// Afficher un menu en fonction de la génération du Pokémon permettant de filtrer la liste
$sql = 'SELECT DISTINCT generation FROM pokemons';
$res = $db->query($sql);
$res = $res->fetchAll();
foreach ($res as $generation) {
    // Afficher des boutons permettant d'afficher ou non les Pokémon de la génération
    echo "<button type='button' class='me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700'><a class='flex py-2.5 px-5' href='index.php?generation=".$generation->generation."'>Génération ".$generation->generation.'</a></button>';
}

// Afficher un menu permettant de trier la liste par type
$sql = 'SELECT * FROM types';
$res = $db->query($sql);
$res = $res->fetchAll();
echo "<div class='inline-block me-2 mb-2 flex'>";
foreach ($res as $type) {
    echo "<a href='index.php?type=".$type->name."'><img class='h-10' src='".$type->image."' alt='".$type->name."' title='".$type->name."'></a>";
}
echo '</div>';
?>
    </div>
    <div>
        <?php
    // Affiche la liste de tous les Pokémon présents en BDD
    if (isset($_GET['generation'])) {
        // On détermine le nombre total de pokémons de la génération en question
        $generation = $_GET['generation'];
        $sql = 'SELECT COUNT(*) AS total FROM pokemons WHERE generation = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$generation]);
        $result = $stmt->fetch();
        $total = $result->total;

        $premier = ($currentPage - 1) * $limit;

        // On calcule le nombre de pages total
        $pages = ceil($total / $limit);

        $sql = 'SELECT * FROM pokemons WHERE generation = :generation LIMIT :premier, :limit;';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':premier', $premier, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':generation', $generation, PDO::PARAM_INT);
        $stmt->execute();
        $pokemon_generation = $stmt->fetchAll();

        if (empty($pokemon_generation)) {
            echo "<p class='text-xl font-bold py-2.5'>Aucun Pokémon de la génération ".$generation.' dans notre base de données.</p>';
        }
        echo "<div class='grid grid-cols-2 md:grid-cols-5 gap-4'>";
        foreach ($pokemon_generation as $pokemon) {
            ?>
            <div class="h-auto max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="pokemon.php?id=<?php echo $pokemon->id; ?>" class="flex flex-col items-center">
                    <p class="font-bold"><?php echo $pokemon->name; ?></p><img src="<?php echo $pokemon->sprite; ?>"/><p>ID: <?php echo $pokemon->id; ?></p>
                </a>
            </div>
            <?php
        }
        echo '</div>';
        ?>
                <nav class="my-2 py-2 flex justify-center">
                    <ul class="inline-flex -space-x-px text-base h-10">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?php echo ($currentPage == 1) ? 'pointer-events-none text-gray-400 no-underline cursor-not-allowed' : ''; ?>">
                        <a href="./?generation=<?php echo $_GET['generation']; ?>&page=<?php echo $currentPage - 1; ?>" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><span class="sr-only">Previous</span>
                        <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/></svg></a>
                    </li>
                    <?php for ($page = 1; $page <= $pages; ++$page) { ?>
                        <li class="page-item">
                            <a href="./?generation=<?php echo $_GET['generation']; ?>&page=<?php echo $page; ?>" class="<?php echo ($currentPage == $page) ? 'z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'; ?>"><?php echo $page; ?></a>
                        </li>
                    <?php } ?>
                        <li class="page-item <?php echo ($currentPage == $pages) ? 'pointer-events-none text-gray-400 no-underline cursor-not-allowed' : ''; ?>">
                        <a href="./?generation=<?php echo $_GET['generation']; ?>&page=<?php echo $currentPage + 1; ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><span class="sr-only">Next</span><svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                        </a>
                    </li>
                    </ul>
                </nav>
            <?php
    } elseif (isset($_GET['type'])) {
        $type = $_GET['type'];

        // On détermine le nombre total de pokémons du type en question
        $sql = 'SELECT COUNT(*) AS total FROM pokemons
                INNER JOIN pokemons_types ON pokemons.id = pokemons_types.pokemonId
                INNER JOIN types ON pokemons_types.typeId = types.id
                WHERE types.name = :type';

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();
        $total = $result->total;

        $premier = ($currentPage - 1) * $limit;

        // On calcule le nombre de pages total
        $pages = ceil($total / $limit);

        // Requêtes en BDD pour récupérer les pokémons du type en question

        $sql = 'SELECT pokemons.*, types.name AS type_name
        FROM pokemons
        INNER JOIN pokemons_types ON pokemons.id = pokemons_types.pokemonId
        INNER JOIN types ON pokemons_types.typeId = types.id
        WHERE types.name = :type
        LIMIT :premier, :limit;';

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':premier', $premier, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        $pokemons = $stmt->fetchAll();

        if (empty($pokemons)) {
            echo "<p class='text-xl font-bold py-2.5'>Aucun Pokémon de type ".$type.' dans notre base de données.</p>';
        }

        echo "<div class='grid grid-cols-2 md:grid-cols-5 gap-4'>";
        foreach ($pokemons as $pokemon) {
            ?>
                    <div class="h-auto max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="pokemon.php?id=<?php echo $pokemon->id; ?>" class="flex flex-col items-center">
                            <p class="font-bold"><?php echo $pokemon->name; ?></p><img src="<?php echo $pokemon->sprite; ?>"/><p>ID: <?php echo $pokemon->id; ?></p>
                        </a>
                    </div>
                    <?php
        }
        echo '</div>';
        ?>
        <nav class="my-2 py-2 flex justify-center">
            <ul class="inline-flex -space-x-px text-base h-10">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?php echo ($currentPage == 1) ? 'pointer-events-none text-gray-400 no-underline cursor-not-allowed' : ''; ?>">
                <a href="./?page=<?php echo $currentPage - 1; ?>" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><span class="sr-only">Previous</span>
                <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/></svg></a>
            </li>
            <?php for ($page = 1; $page <= $pages; ++$page) { ?>
                <li class="page-item">
                    <a href="./?page=<?php echo $page; ?>" class="<?php echo ($currentPage == $page) ? 'z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'; ?>"><?php echo $page; ?></a>
                </li>
            <?php } ?>
                <li class="page-item <?php echo ($currentPage == $pages) ? 'pointer-events-none text-gray-400 no-underline cursor-not-allowed' : ''; ?>">
                <a href="./?page=<?php echo $currentPage + 1; ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><span class="sr-only">Next</span><svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                </a>
            </li>
            </ul>
        </nav>
        <?php
    } else {
        // On détermine le nombre total de pokémons en BDD
        $sql = 'SELECT COUNT(*) AS total FROM pokemons';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        $total = $result->total;

        $premier = ($currentPage - 1) * $limit;

        // On calcule le nombre de pages total
        $pages = ceil($total / $limit);

        $sql = 'SELECT * FROM pokemons LIMIT :premier, :limit;';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':premier', $premier, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $pokemons = $stmt->fetchAll();
        echo "<div class='grid grid-cols-2 md:grid-cols-5 gap-4'>";
        foreach ($pokemons as $pokemon) {
            ?>
                    <div class="h-auto max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="pokemon.php?id=<?php echo $pokemon->id; ?>" class="flex flex-col items-center">
                            <p class="font-bold"><?php echo $pokemon->name; ?></p><img src="<?php echo $pokemon->sprite; ?>"/><p>ID: <?php echo $pokemon->id; ?></p>
                        </a>
                    </div>
                    <?php
        }
        echo '</div>';
        ?>
                <nav class="my-2 py-2 flex justify-center">
                    <ul class="inline-flex -space-x-px text-base h-10">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?php echo ($currentPage == 1) ? 'pointer-events-none text-gray-400 no-underline cursor-not-allowed' : ''; ?>">
                        <a href="./?page=<?php echo $currentPage - 1; ?>" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><span class="sr-only">Previous</span>
                        <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/></svg></a>
                    </li>
                    <?php for ($page = 1; $page <= $pages; ++$page) { ?>
                        <li class="page-item">
                            <a href="./?page=<?php echo $page; ?>" class="<?php echo ($currentPage == $page) ? 'z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'; ?>"><?php echo $page; ?></a>
                        </li>
                    <?php } ?>
                        <li class="page-item <?php echo ($currentPage == $pages) ? 'pointer-events-none text-gray-400 no-underline cursor-not-allowed' : ''; ?>">
                        <a href="./?page=<?php echo $currentPage + 1; ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><span class="sr-only">Next</span><svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                        </a>
                    </li>
                    </ul>
                </nav>
            <?php
    }
?>
        </div>
    </div>
</body>
</html>