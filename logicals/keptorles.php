<?php
// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if(!isset($_SESSION['felhasznalo'])) {
    header('Location: ./belepes');
    exit();
}

// Ellenőrizzük, hogy POST kérés-e és hogy van-e kép azonosító
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kep_id']) && isset($_POST['fajlnev'])) {
    $kep_id = $_POST['kep_id'];
    $fajlnev = $_POST['fajlnev'];
    
    try {
        // Adatbázis kapcsolódás
        $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], 
                       $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                       array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Ellenőrizzük, hogy a kép a bejelentkezett felhasználóé-e
        $sql = "SELECT felhasznalo_id FROM kepek WHERE id = :kep_id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':kep_id' => $kep_id]);
        $kep = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($kep && $kep['felhasznalo_id'] == $_SESSION['id']) {
            // A kép a bejelentkezett felhasználóé, törölhetjük
            
            // 1. Töröljük a fájlt
            $teljes_fajlnev = $MAPPA . $fajlnev;
            if(file_exists($teljes_fajlnev)) {
                unlink($teljes_fajlnev);
            }
            
            // 2. Töröljük az adatbázis bejegyzést
            $sql = "DELETE FROM kepek WHERE id = :kep_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([':kep_id' => $kep_id]);
            
            $_SESSION['torles_siker'] = true;
        } else {
            $_SESSION['uzenet_hiba'] = "A kép törlése nem sikerült - nincs jogosultsága hozzá.";
        }
    } catch(PDOException $e) {
        $_SESSION['uzenet_hiba'] = "Adatbázis hiba: " . $e->getMessage();
    }
}

// Visszairányítás a képek oldalra
header('Location: ./kepek');
exit();
?>