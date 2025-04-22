<?php
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['keresztnev']) && isset($_POST['email'])) {
    try {
        // Adatbázis kapcsolat
        $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                      array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Ellenőrizzük, hogy a felhasználónév foglalt-e
        $sqlSelect = "select id from felhasznalok where felhasznalonev = :felhasznalo";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':felhasznalo' => $_POST['felhasznalo']));
        
        if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            // A felhasználónév már foglalt
            $uzenet = "A felhasználónév már foglalt!";
            $ujra = true;
        }
        else {
            // Beszúrás az adatbázisba
            $sqlInsert = "INSERT INTO felhasznalok(felhasznalonev, jelszo, vezeteknev, keresztnev, email)
                          VALUES (:felhasznalo, :jelszo, :vezeteknev, :keresztnev, :email)";
            $sth = $dbh->prepare($sqlInsert);
            $sth->execute(array(
                ':felhasznalo' => $_POST['felhasznalo'],
                ':jelszo' => sha1($_POST['jelszo']), // SHA-1 titkosítás a jelszóra
                ':vezeteknev' => $_POST['vezeteknev'],
                ':keresztnev' => $_POST['keresztnev'],
                ':email' => $_POST['email']
            ));
            
            // Sikeres regisztráció
            $uzenet = "A regisztráció sikeres! Most már bejelentkezhet.";
            $ujra = false;
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