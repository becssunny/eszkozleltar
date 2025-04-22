<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Konfigurációs fájl betöltése
include('./includes/config.inc.php');

// Adatbázis kapcsolat tesztelése
if(test_db_connection()) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed!";
    
    // További információk megjelenítése a hibáról
    try {
        $pdo = new PDO(
            'mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'].';charset=utf8',
            $adatbazis['felhasznalonev'],
            $adatbazis['jelszo']
        );
    } catch (PDOException $e) {
        echo "<br>Hiba részletei: " . $e->getMessage();
    }
}

// Adatbázis információk kiírása (csak fejlesztési célra)
echo "<hr>";
echo "<h3>Adatbázis beállítások:</h3>";
echo "Host: " . $adatbazis['host'] . "<br>";
echo "Adatbázis: " . $adatbazis['adatbazis'] . "<br>";
echo "Felhasználónév: " . $adatbazis['felhasznalonev'] . "<br>";
echo "Jelszó: " . (empty($adatbazis['jelszo']) ? "(üres)" : "(beállítva)") . "<br>";
?>