<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Evidencia produktov</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Evidencia produktov</h1>

    <form action="insert.php" method="post" class="form">
        <input type="text" name="nazov" placeholder="Názov produktu" required>
        <input type="number" step="0.01" name="cena" placeholder="Cena (€)" required>
        <textarea name="popis" placeholder="Popis produktu"></textarea>
        <button type="submit">Pridať produkt</button>
    </form>

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
            // Používame premennú $pdo, ktorú sme vytvorili v db.php
            $stmt = $pdo->query("SELECT * FROM produkty");

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . htmlspecialchars($row['nazov']) . "</td>
                        <td>" . number_format($row['cena'], 2, ',', ' ') . " €</td>
                        <td>" . htmlspecialchars($row['popis']) . "</td>
                        <td><a href='delete.php?id={$row['id']}' onclick=\"return confirm('Naozaj zmazať?')\">🗑️ Zmazať</a></td>
                      </tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='5'>Chyba pri načítaní dát: " . $e->getMessage() . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>