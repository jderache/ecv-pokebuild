<?php

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id']) && isset($data['name'])) {
        $id = $data['id'];
        $name = $data['name'];

        $sql = 'UPDATE pokemons SET name = ? WHERE id = ?';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([$name, $id]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
