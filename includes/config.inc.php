<?php
// Bázis URL beállítása - módosítsd a projektednek megfelelően
$BASE_URL = '/eszkozeltar';

// Adatbázis beállítások
$adatbazis = array(
    'host' => 'localhost',
    'felhasznalonev' => 'eszkozeltar',
    'jelszo' => 'JElszo1234',
    'adatbazis' => 'eszkozeltar'
);

// Feltöltésekhez szükséges beállítások
$MAPPA = 'uploads/kepek/';
$TIPUSOK = array('.jpg', '.jpeg', '.png', '.gif');
$MAXMERET = 500*1024; // 500KB

// Oldalak definíciói
$oldalak = array(
    '/' => array('fajl' => 'cimlap', 'szoveg' => 'Főoldal', 'menun' => array(1,1)),
    'kepek' => array('fajl' => 'kepek', 'szoveg' => 'Képek', 'menun' => array(1,1)),
    'kapcsolat' => array('fajl' => 'kapcsolat', 'szoveg' => 'Kapcsolat', 'menun' => array(1,1)),
    'uzenetek' => array('fajl' => 'uzenetek', 'szoveg' => 'Üzenetek', 'menun' => array(1,0)),
    'belepes' => array('fajl' => 'belepes', 'szoveg' => 'Belépés', 'menun' => array(0,1)),
    'kilepes' => array('fajl' => 'kilepes', 'szoveg' => 'Kilépés', 'menun' => array(1,0)),
    'belep' => array('fajl' => 'belep', 'szoveg' => '', 'menun' => array(0,0)),
    'regisztral' => array('fajl' => 'regisztral', 'szoveg' => '', 'menun' => array(0,0)),
    'kapcsolat-ment' => array('fajl' => 'kapcsolat-ment', 'szoveg' => '', 'menun' => array(0,0)),
    'kepfeltoltes' => array('fajl' => 'kepfeltoltes', 'szoveg' => '', 'menun' => array(0,0)),
    'keptorles' => array('fajl' => 'keptorles', 'szoveg' => '', 'menun' => array(0,0)),
    'uzenettorles' => array('fajl' => 'uzenettorles', 'szoveg' => '', 'menun' => array(0,0)),
    'sikeres-regisztracio' => array('fajl' => 'sikeres-regisztracio', 'szoveg' => 'Sikeres regisztráció', 'menun' => array(0,0))
);

$fejlec = array(
    'cim' => 'Eszközleltár',
    'motto' => 'Minden eszköz egy helyen!'
);

$lablec = array(
    'copyright' => 'Copyright &copy; ' . date("Y") . ' Eszközleltár',
    'ceg' => 'Minden jog fenntartva.'
);
?>
