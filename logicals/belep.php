<?php
// Ellenőrizzük, hogy érkeztek-e adatok
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo'])) {
    try {
        // Adatbázis kapcsolat
        $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                      array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Felhasználó ellenőrzése
        // Preparált utasítást használunk a biztonság miatt
        $sqlSelect = "SELECT id, felhasznalonev, vezeteknev, keresztnev FROM felhasznalok 
                      WHERE felhasznalonev = :felhasznalo AND jelszo = :jelszo";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':felhasznalo' => $_POST['felhasznalo'], ':jelszo' => sha1($_POST['jelszo'])));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            // Sikeres bejelentkezés - session adatok beállítása
            $_SESSION['felhasznalo'] = $row['felhasznalonev'];
            $_SESSION['vezeteknev'] = $row['vezeteknev'];
            $_SESSION['keresztnev'] = $row['keresztnev'];
            $_SESSION['id'] = $row['id'];
            
            $uzenet = "Sikeres bejelentkezés!";
            $ujra = false;
            header("Location: ./");
            exit();
        }
        else {
            // Sikertelen bejelentkezés
            $uzenet = "Hibás felhasználónév vagy jelszó!";
            $ujra = true;
        }
    }
    catch (PDOException $e) {
        // Adatbázis hiba
        $uzenet = "Hiba: ".$e->getMessage();
        $ujra = true;
    }
}
else {
    header("Location: ./belepes");
    exit();
}
?>

<h2>Bejelentkezés</h2>

<?php if(isset($uzenet)): ?>
<div class="alert alert-<?= $ujra ? 'danger' : 'success' ?>">
    <?= $uzenet ?>
</div>
<?php endif; ?>

<?php if($ujra): ?>
<p><a href="./belepes" class="btn btn-primary">Új próbálkozás</a></p>
<?php endif; ?>