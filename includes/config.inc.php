<?php
$adatbazis = array(
    'host' => 'localhost',
    'felhasznalonev' => 'root',
    'jelszo' => '',
    'adatbazis' => 'eszkozeltar'
);

$oldalak = array(
    '/' => array('fajl' => 'cimlap', 'szoveg' => 'Főoldal', 'menun' => array(1,1)),
    'kepek' => array('fajl' => 'kepek', 'szoveg' => 'Képek', 'menun' => array(1,1)),
    'kapcsolat' => array('fajl' => 'kapcsolat', 'szoveg' => 'Kapcsolat', 'menun' => array(1,1)),
    'uzenetek' => array('fajl' => 'uzenetek', 'szoveg' => 'Üzenetek', 'menun' => array(1,0)),
    'belepes' => array('fajl' => 'belepes', 'szoveg' => 'Belépés', 'menun' => array(0,1)),
    'kilepes' => array('fajl' => 'kilepes', 'szoveg' => 'Kilépés', 'menun' => array(1,0)),
    'belep' => array('fajl' => 'belep', 'szoveg' => '', 'menun' => array(0,0)),
    'regisztral' => array('fajl' => 'regisztral', 'szoveg' => '', 'menun' => array(0,0))
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