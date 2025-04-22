<?php
// Csak bejelentkezett felhasználók láthatják
if(!isset($_SESSION['felhasznalo'])) {
    header('Location: ./belepes');
    exit();
}
?>

<h2>Beérkezett üzenetek</h2>

<!-- Üzenet táblázat (később adatbázisból) -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Dátum</th>
            <th>Feladó</th>
            <th>Email</th>
            <th>Üzenet</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>2023.10.15. 10:30</td>
            <td>Nagy János</td>
            <td>janos@gmail.com</td>
            <td>Érdeklődnék a leltárrendszer használatával kapcsolatban...</td>
        </tr>
        <tr>
            <td>2023.10.12. 14:45</td>
            <td>Kiss Éva</td>
            <td>eva@gmail.com</td>
            <td>Szeretnék hozzáférést kapni a rendszerhez...</td>
        </tr>
        <tr>
            <td>2023.10.10. 09:15</td>
            <td>Vendég</td>
            <td>vendeg@gmail.com</td>
            <td>Kérem, vegyék fel a következő eszközöket a leltárba...</td>
        </tr>
    </tbody>
</table>