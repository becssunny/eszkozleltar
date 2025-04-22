<?php
// Ellenõrizzük, hogy a felhasználó be van-e jelentkezve
if(!isset($_SESSION['felhasznalo'])) {
    header('Location: ./belepes');
    exit();
}

// Hibaüzenetek és sikerüzenetek tárolása
$uzenet = "";

// Kép feltöltés feldolgozása
if(isset($_POST['feltoltes']) && isset($_FILES['kep'])) {
    // Ellenõrizzük a feltöltött fájlt
    $fajl = $_FILES['kep'];
    
    // Hibaellenõrzés
    if($fajl['error'] == 4) {
        // Nincs fájl kiválasztva
        $uzenet = "Kérjük, válasszon egy képfájlt!";
    } elseif($fajl['error'] != 0) {
        // Egyéb feltöltési hiba
        $uzenet = "Hiba történt a feltöltés során (kód: " . $fajl['error'] . ")";
    } elseif(!in_array(strtolower(pathinfo($fajl['name'], PATHINFO_EXTENSION)), array('jpg', 'jpeg', 'png', 'gif'))) {
        // Nem megfelelõ fájltípus
        $uzenet = "Csak JPG, PNG és GIF formátumú képek tölthetõk fel!";
    } elseif($fajl['size'] > $MAXMERET) {
        // Túl nagy fájlméret
        $uzenet = "A feltöltött fájl túl nagy! (Maximum " . ($MAXMERET/1024) . " KB)";
    } else {
        // Minden rendben, menthetjük a fájlt
        $fajlnev = time() . '_' . $fajl['name']; // Egyedi fájlnév idõbélyeggel
        $cel = $MAPPA . $fajlnev;
        
        if(move_uploaded_file($fajl['tmp_name'], $cel)) {
            // Sikeres feltöltés, adatbázisba mentés
            try {
                // Adatbázis kapcsolódás
                $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], 
                               $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                               array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
                $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
                
                // Adatok mentése
                $sqlInsert = "INSERT INTO kepek(fajlnev, leiras, felhasznalo_id) VALUES (:fajlnev, :leiras, :felhasznalo_id)";
                $stmt = $dbh->prepare($sqlInsert);
                $stmt->execute(array(
                    ':fajlnev' => $fajlnev,
                    ':leiras' => isset($_POST['leiras']) ? $_POST['leiras'] : '',
                    ':felhasznalo_id' => $_SESSION['id']
                ));
                
                // Sikeres feltöltés üzenete SESSION-ben
                $_SESSION['uzenet_siker'] = "A képfájl sikeresen feltöltve!";
            } catch(PDOException $e) {
                // Adatbázis hiba esetén
                $_SESSION['uzenet_hiba'] = "Adatbázis hiba: " . $e->getMessage();
                // Töröljük a feltöltött fájlt, mert nem tudtuk az adatbázisba menteni
                @unlink($cel);
            }
        } else {
            // Sikertelen feltöltés
            $_SESSION['uzenet_hiba'] = "Hiba történt a fájl mentése során!";
        }
    }
}

// Átirányítás vissza a képek oldalra
header('Location: ./kepek');
exit();
?>