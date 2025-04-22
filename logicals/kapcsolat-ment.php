<?php
// Ha nem POST met�dussal h�vt�k meg, �tir�ny�t�s
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ./kapcsolat');
    exit();
}

// Form adatok kinyer�se �s tiszt�t�sa
$nev = isset($_POST['nev']) ? trim($_POST['nev']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$uzenet = isset($_POST['uzenet']) ? trim($_POST['uzenet']) : '';

// Valid�l�s szerver oldalon
$hibak = array();

// N�v ellen�rz�se (min. 5 karakter)
if (strlen($nev) < 5) {
    $hibak[] = "A n�v legal�bb 5 karakter hossz� legyen!";
}

// Email ellen�rz�se
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $hibak[] = "K�rj�k, adjon meg egy �rv�nyes email c�met!";
}

// �zenet ellen�rz�se (nem lehet �res)
if (empty($uzenet)) {
    $hibak[] = "Az �zenet mez� nem lehet �res!";
}

// Ha vannak hib�k, visszat�r�s a kapcsolat oldalra
if (!empty($hibak)) {
    $_SESSION['uzenet_hiba'] = implode('<br>', $hibak);
    header('Location: ./kapcsolat');
    exit();
}

// Ment�s az adatb�zisba
try {
    // Adatb�zis kapcsol�d�s
    $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], 
                  $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                  array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
    
    // Adatok ment�se
    $sqlInsert = "INSERT INTO uzenetek(nev, email, uzenet, felhasznalo_id) VALUES (:nev, :email, :uzenet, :felhasznalo_id)";
    $stmt = $dbh->prepare($sqlInsert);
    $stmt->execute(array(
        ':nev' => $nev,
        ':email' => $email,
        ':uzenet' => $uzenet,
        ':felhasznalo_id' => isset($_SESSION['id']) ? $_SESSION['id'] : NULL
    ));
    
    // Sikeres ment�s - �zenet t�rol�sa a session-ben
    $_SESSION['uzenet_siker'] = "K�sz�nj�k az �zenetet! Hamarosan v�laszolunk.";
    header('Location: ./kapcsolat');
    exit();
} catch(PDOException $e) {
    // Adatb�zis hiba eset�n
    $_SESSION['uzenet_hiba'] = "Adatb�zis hiba: " . $e->getMessage();
    header('Location: ./kapcsolat');
    exit();
}
?>