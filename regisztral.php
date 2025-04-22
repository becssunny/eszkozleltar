<?php
// Ellenõrizzük, hogy beérkezett-e minden adat
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['keresztnev']) && isset($_POST['email'])) {
    try {
        // Adatbázis kapcsolat létrehozása
        $dbh = new PDO(
            'mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'].';charset=utf8',
            $adatbazis['felhasznalonev'],
            $adatbazis['jelszo'],
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            )
        );
        
        // Ellenõrizzük, hogy a felhasználónév foglalt-e
        $sqlSelect = "SELECT id FROM felhasznalok WHERE felhasznalonev = :felhasznalo";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':felhasznalo' => $_POST['felhasznalo']));
        
        if($row = $sth->fetch()) {
            // A felhasználónév már foglalt
            $uzenet = "A felhasználónév már foglalt!";
            $ujra = true;
        }
        else {
            // Beszúrás az adatbázisba
            $sqlInsert = "INSERT INTO felhasznalok(felhasznalonev, jelszo, vezeteknev, keresztnev, email)
                          VALUES (:felhasznalo, :jelszo, :vezeteknev, :keresztnev, :email)";
            
            // Jelszó hash
            $jelszoHash = sha1($_POST['jelszo']);
            
            $sth = $dbh->prepare($sqlInsert);
            $insertParams = array(
                ':felhasznalo' => $_POST['felhasznalo'],
                ':jelszo' => $jelszoHash,
                ':vezeteknev' => $_POST['vezeteknev'],
                ':keresztnev' => $_POST['keresztnev'],
                ':email' => $_POST['email']
            );
            
            $sth->execute($insertParams);
            
            // Sikeres regisztráció
            $uzenet = "A regisztráció sikeres! Most már bejelentkezhet.";
            $ujra = false;
        }
    }
    catch (PDOException $e) {
        // Adatbázis hiba esetén
        $uzenet = "Adatbázis hiba: " . $e->getMessage();
        $ujra = true;
    }
}
else {
    // Ha nem minden mezõ van kitöltve
    $uzenet = "Minden mezõ kitöltése kötelezõ!";
    $ujra = true;
}
?>

<h2>Regisztráció</h2>

<?php if(isset($uzenet)): ?>
<div class="alert alert-<?= $ujra ? 'danger' : 'success' ?>">
    <?= $uzenet ?>
</div>
<?php endif; ?>

<?php if($ujra): ?>
<p><a href="./belepes" class="btn btn-primary">Újra</a></p>
<?php else: ?>
<p>Most már bejelentkezhet a <a href="./belepes">bejelentkezés oldalon</a>.</p>
<?php endif; ?>