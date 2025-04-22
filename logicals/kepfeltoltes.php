<?php
// Ellen�rizz�k, hogy a felhaszn�l� be van-e jelentkezve
if(!isset($_SESSION['felhasznalo'])) {
    header('Location: ./belepes');
    exit();
}

// Hiba�zenetek �s siker�zenetek t�rol�sa
$uzenet = "";

// K�p felt�lt�s feldolgoz�sa
if(isset($_POST['feltoltes']) && isset($_FILES['kep'])) {
    // Ellen�rizz�k a felt�lt�tt f�jlt
    $fajl = $_FILES['kep'];
    
    // Hibaellen�rz�s
    if($fajl['error'] == 4) {
        // Nincs f�jl kiv�lasztva
        $uzenet = "K�rj�k, v�lasszon egy k�pf�jlt!";
    } elseif($fajl['error'] != 0) {
        // Egy�b felt�lt�si hiba
        $uzenet = "Hiba t�rt�nt a felt�lt�s sor�n (k�d: " . $fajl['error'] . ")";
    } elseif(!in_array(strtolower(pathinfo($fajl['name'], PATHINFO_EXTENSION)), array('jpg', 'jpeg', 'png', 'gif'))) {
        // Nem megfelel� f�jlt�pus
        $uzenet = "Csak JPG, PNG �s GIF form�tum� k�pek t�lthet�k fel!";
    } elseif($fajl['size'] > $MAXMERET) {
        // T�l nagy f�jlm�ret
        $uzenet = "A felt�lt�tt f�jl t�l nagy! (Maximum " . ($MAXMERET/1024) . " KB)";
    } else {
        // Minden rendben, menthetj�k a f�jlt
        $fajlnev = time() . '_' . $fajl['name']; // Egyedi f�jln�v id�b�lyeggel
        $cel = $MAPPA . $fajlnev;
        
        if(move_uploaded_file($fajl['tmp_name'], $cel)) {
            // Sikeres felt�lt�s, adatb�zisba ment�s
            try {
                // Adatb�zis kapcsol�d�s
                $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], 
                               $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                               array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
                $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
                
                // Adatok ment�se
                $sqlInsert = "INSERT INTO kepek(fajlnev, leiras, felhasznalo_id) VALUES (:fajlnev, :leiras, :felhasznalo_id)";
                $stmt = $dbh->prepare($sqlInsert);
                $stmt->execute(array(
                    ':fajlnev' => $fajlnev,
                    ':leiras' => isset($_POST['leiras']) ? $_POST['leiras'] : '',
                    ':felhasznalo_id' => $_SESSION['id']
                ));
                
                // Sikeres felt�lt�s �zenete SESSION-ben
                $_SESSION['uzenet_siker'] = "A k�pf�jl sikeresen felt�ltve!";
            } catch(PDOException $e) {
                // Adatb�zis hiba eset�n
                $_SESSION['uzenet_hiba'] = "Adatb�zis hiba: " . $e->getMessage();
                // T�r�lj�k a felt�lt�tt f�jlt, mert nem tudtuk az adatb�zisba menteni
                @unlink($cel);
            }
        } else {
            // Sikertelen felt�lt�s
            $_SESSION['uzenet_hiba'] = "Hiba t�rt�nt a f�jl ment�se sor�n!";
        }
    }
}

// �tir�ny�t�s vissza a k�pek oldalra
header('Location: ./kepek');
exit();
?>