<?php
// Ha nem POST metódussal hívták meg, átirányítás
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ./kapcsolat');
    exit();
}

// Form adatok kinyerése és tisztítása
$nev = isset($_POST['nev']) ? trim($_POST['nev']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$uzenet = isset($_POST['uzenet']) ? trim($_POST['uzenet']) : '';

// Validálás szerver oldalon
$hibak = array();

// Név ellenõrzése (min. 5 karakter)
if (strlen($nev) < 5) {
    $hibak[] = "A név legalább 5 karakter hosszú legyen!";
}

// Email ellenõrzése
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $hibak[] = "Kérjük, adjon meg egy érvényes email címet!";
}

// Üzenet ellenõrzése (nem lehet üres)
if (empty($uzenet)) {
    $hibak[] = "Az üzenet mezõ nem lehet üres!";
}

// Ha vannak hibák, visszatérés a kapcsolat oldalra
if (!empty($hibak)) {
    $_SESSION['uzenet_hiba'] = implode('<br>', $hibak);
    header('Location: ./kapcsolat');
    exit();
}

// Mentés az adatbázisba
try {
    // Adatbázis kapcsolódás
    $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], 
                  $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                  array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
    
    // Adatok mentése
    $sqlInsert = "INSERT INTO uzenetek(nev, email, uzenet, felhasznalo_id) VALUES (:nev, :email, :uzenet, :felhasznalo_id)";
    $stmt = $dbh->prepare($sqlInsert);
    $stmt->execute(array(
        ':nev' => $nev,
        ':email' => $email,
        ':uzenet' => $uzenet,
        ':felhasznalo_id' => isset($_SESSION['id']) ? $_SESSION['id'] : NULL
    ));
    
    // Sikeres mentés - üzenet tárolása a session-ben
    $_SESSION['uzenet_siker'] = "Köszönjük az üzenetet! Hamarosan válaszolunk.";
    header('Location: ./kapcsolat');
    exit();
} catch(PDOException $e) {
    // Adatbázis hiba esetén
    $_SESSION['uzenet_hiba'] = "Adatbázis hiba: " . $e->getMessage();
    header('Location: ./kapcsolat');
    exit();
}
?>