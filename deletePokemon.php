<?php 

require_once('db.php');

function deletePokemon($conn, $id) {
    try {
        $conn->beginTransaction();
    
        $sql1 = "DELETE FROM pokemons_types WHERE pokemonId = ?";
        $query1 = $conn->prepare($sql1);
        $query1->execute([$id]);
    
        $sql2 = "DELETE FROM pokemons_evolutions WHERE pokemonId = ?";
        $query2 = $conn->prepare($sql2);
        $query2->execute([$id]);
    
        $sql3 = "DELETE FROM pokemons_pre_evolutions WHERE pokemonId = ?";
        $query3 = $conn->prepare($sql3);
        $query3->execute([$id]);
    
        $sql4 = "DELETE FROM pokemons WHERE id = ?";
        $query4 = $conn->prepare($sql4);
        $query4->execute([$id]);
    
        $conn->commit();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Une erreur s'est produite : " . $e->getMessage();
    }
    
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    deletePokemon($db, $id);
}

?>
