<?php
// 1. NAPOJENIE: Načítame súbor db.php, kde je vytvorené pripojenie k databáze ($pdo).
include 'db.php';

// 2. KONTROLA ADRESY: Zisťujeme, či je v URL adrese napísané "?id=číslo".
if (isset($_GET['id'])) {
    
    /* 
       PREVOD NA ČÍSLO: (int) zabezpečí, že aj keby niekto do adresy napísal text, 
       premení sa to na celé číslo. Je to dôležitý bezpečnostný prvok.
    */
    $id = (int)$_GET['id'];

    try {
        /* 
           3. SQL PRÍKAZ S OTÁZNIKOM: 
           Používame tzv. "positional placeholder" (otáznik). 
           Hovoríme: "Vymaž z tabuľky 'produkty' ten riadok, kde sa id rovná niečomu..."
        */
        $stmt = $pdo->prepare("DELETE FROM produkty WHERE id = ?");
        
        /* 
           4. VYKONANIE: Otáznik v príkaze sa nahradí číslom z premennej $id.
           Dáta posielame v poli [ ].
        */
        $stmt->execute([$id]);

    } catch (PDOException $e) {
        // Ak sa niečo pokazí (napr. produkt s tým ID neexistuje alebo je zamknutý), vypíše chybu.
        die("Chyba pri mazaní: " . $e->getMessage());
    }
}

/* 
   5. PRESMEROVANIE A KONIEC: 
   Po vymazaní (alebo aj keby žiadne ID neprišlo) hodíme používateľa späť na index.php.
   exit() zabezpečí, že sa už po tomto príkaze nič ďalšie nevykoná.
*/
header("Location: index.php");
exit();
?>
