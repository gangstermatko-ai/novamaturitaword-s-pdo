<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM produkty WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        die("Chyba pri mazaní: " . $e->getMessage());
    }
}

header("Location: index.php");
exit();
?>