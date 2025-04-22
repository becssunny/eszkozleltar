<?php
// Ellen�rizz�k, hogy be�rkezett-e minden adat
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['keresztnev']) && isset($_POST['email'])) {
    try {
        // Adatb�zis kapcsolat l�trehoz�sa
        $dbh = new PDO(
            'mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'].';charset=utf8',
            $adatbazis['felhasznalonev'],
            $adatbazis['jelszo'],
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            )
        );
        
        // Ellen�rizz�k, hogy a felhaszn�l�n�v foglalt-e
        $sqlSelect = "SELECT id FROM felhasznalok WHERE felhasznalonev = :felhasznalo";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':felhasznalo' => $_POST['felhasznalo']));
        
        if($row = $sth->fetch()) {
            // A felhaszn�l�n�v m�r foglalt
            $uzenet = "A felhaszn�l�n�v m�r foglalt!";
            $ujra = true;
        }
        else {
            // Besz�r�s az adatb�zisba
            $sqlInsert = "INSERT INTO felhasznalok(felhasznalonev, jelszo, vezeteknev, keresztnev, email)
                          VALUES (:felhasznalo, :jelszo, :vezeteknev, :keresztnev, :email)";
            
            // Jelsz� hash
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
            
            // Sikeres regisztr�ci�
            $uzenet = "A regisztr�ci� sikeres! Most m�r bejelentkezhet.";
            $ujra = false;
        }
    }
    catch (PDOException $e) {
        // Adatb�zis hiba eset�n
        $uzenet = "Adatb�zis hiba: " . $e->getMessage();
        $ujra = true;
    }
}
else {
    // Ha nem minden mez� van kit�ltve
    $uzenet = "Minden mez� kit�lt�se k�telez�!";
    $ujra = true;
}
?>

<h2>Regisztr�ci�</h2>

<?php if(isset($uzenet)): ?>
<div class="alert alert-<?= $ujra ? 'danger' : 'success' ?>">
    <?= $uzenet ?>
</div>
<?php endif; ?>

<?php if($ujra): ?>
<p><a href="./belepes" class="btn btn-primary">�jra</a></p>
<?php else: ?>
<p>Most m�r bejelentkezhet a <a href="./belepes">bejelentkez�s oldalon</a>.</p>
<?php endif; ?>