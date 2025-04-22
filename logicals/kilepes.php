<?php
// Session törlése
session_unset();
session_destroy();

// Átirányítás a főoldalra
header("Location: ./");
exit();
?>
