<?php
// Session indítása
session_start();

// Konfigurációs fájl betöltése
include('./includes/config.inc.php');

// Paraméter beolvasása az URL-ből
// A $_SERVER['QUERY_STRING'] változóban kapjuk meg az URL ? után következő részét
$oldal = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "";

// Ha nincs paraméter, akkor a főoldalt töltjük be
if ($oldal == "") $oldal = '/';

// Ellenőrizzük, hogy létezik-e ilyen oldal a konfigurációban és a fájl is létezik-e
if (isset($oldalak[$oldal]) && file_exists("./templates/pages/{$oldalak[$oldal]['fajl']}.tpl.php")) {
    $keres = $oldalak[$oldal];
} else {
    // Ha nem létezik az oldal, 404-es oldalt adunk vissza
    $keres = array('fajl' => '404', 'szoveg' => 'Oldal nem található', 'menun' => array(0,0));
}

// Főoldal sablon betöltése
include('./templates/index.tpl.php');
?>