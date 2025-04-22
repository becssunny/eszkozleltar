<?php
// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if(!isset($_SESSION['felhasznalo'])) {
    header('Location: ./belepes');
    exit();
}

// Ellenőrizzük, hogy POST kérés-e és hogy van-e üzenet azonosító
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['uzenet_id'])) {
    $uzenet_id = $_POST['uzenet_id'];
    
    try {
        // Adatbázis kapcsolódás
        $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], 
                       $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                       array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Törölhetjük az üzenetet (minden bejelentkezett felhasználó bármely üzenetet törölhet)
        $sql = "DELETE FROM uzenetek WHERE id = :uzenet_id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':uzenet_id' => $uzenet_id]);
        
        if($stmt->rowCount() > 0) {
            $_SESSION['torles_siker'] = true;
        } else {
            $_SESSION['uzenet_hiba'] = "Az üzenet törlése nem sikerült.";
        }
    } catch(PDOException $e) {
        $_SESSION['uzenet_hiba'] = "Adatbázis hiba: " . $e->getMessage();
    }
}

// Visszairányítás az üzenetek oldalra
header('Location: ./uzenetek');
exit();
?>