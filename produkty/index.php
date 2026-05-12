<?php 
// Načítame prepojenie s databázou, aby sme mohli vyťahovať dáta
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Evidencia produktov</title>
    // Tu napájame tvoj vizuálny štýl (CSS)
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Evidencia produktov</h1>

    // FORMULÁR: Po odoslaní pošle dáta do súboru insert.php metódou POST
    <form action="insert.php" method="post" class="form">
        <input type="text" name="nazov" placeholder="Názov produktu" required>
        // step="0.01" umožňuje zadávať desatinné čísla (centy)
        <input type="number" step="0.01" name="cena" placeholder="Cena (€)" required>
        <textarea name="popis" placeholder="Popis produktu"></textarea>
        <button type="submit">Pridať produkt</button>
    </form>

    // TABUĽKA: Tu sa zobrazia všetky produkty z databázy
    <table>
        <tr>
            <th>ID</th>
            <th>Názov</th>
            <th>Cena (€)</th>
            <th>Popis</th>
            <th>Akcia</th>
        </tr>
        <?php
        try {
            // Povieme databáze: "Daj mi všetky riadky z tabuľky produkty"
            $stmt = $pdo->query("SELECT * FROM produkty");

            // CYKLUS: Opakuj tento kód pre každý jeden nájdený riadok v databáze
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        // Zobrazíme ID produktu
                        <td>{$row['id']}</td>
                        
                        // htmlspecialchars: Ochrana, aby niekto nevložil škodlivý kód cez názov
                        <td>" . htmlspecialchars($row['nazov']) . "</td>
                        
                        // number_format: Upravíme číslo na pekný formát (napr. 10,50 €)
                        <td>" . number_format($row['cena'], 2, ',', ' ') . " €</td>
                        
                        // Zobrazíme popis produktu
                        <td>" . htmlspecialchars($row['popis']) . "</td>
                        
                        // ODKAZ NA MAZANIE: Posiela ID cez adresu (GET) a pýta sa na potvrdenie
                        <td>
                            <a href='delete.php?id={$row['id']}' onclick=\"return confirm('Naozaj zmazať?')\">🗑️ Zmazať</a>
                        </td>
                      </tr>";
            }
        } catch (PDOException $e) {
            // Ak nastane chyba pripojenia, vypíšeme ju do tabuľky
            echo "<tr><td colspan='5'>Chyba pri načítaní dát: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
