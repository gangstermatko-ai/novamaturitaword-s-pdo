<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazov = $_POST['nazov'];
    $cena = $_POST['cena'];
    $popis = $_POST['popis'];

    try {
        // Používame placeholdery (?) namiesto priameho vkladania premenných
        $sql = "INSERT INTO produkty (nazov, cena, popis) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nazov, $cena, $popis]);

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Chyba pri ukladaní: " . $e->getMessage());
    }
}
?>