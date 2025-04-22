<?php
// Csak bejelentkezett felhasználók láthatják
if(!isset($_SESSION['felhasznalo'])) {
    header('Location: ./belepes');
    exit();
}

// Üzenetek lekérdezése az adatbázisból
try {
    $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], 
                   $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                   array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
    
    // Üzenetek lekérdezése csökkenő időrend szerint
    $sql = "SELECT u.*, f.vezeteknev, f.keresztnev 
            FROM uzenetek u 
            LEFT JOIN felhasznalok f ON u.felhasznalo_id = f.id 
            ORDER BY u.kuldes_datum DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $uzenetek = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo '<div class="alert alert-danger">Adatbázis hiba: ' . $e->getMessage() . '</div>';
    $uzenetek = array();
}
?>

<h2>Beérkezett üzenetek</h2>

<?php if(isset($_SESSION['torles_siker'])): ?>
<div class="alert alert-success">
    Az üzenet sikeresen törölve!
</div>
<?php unset($_SESSION['torles_siker']); ?>
<?php endif; ?>

<!-- Üzenet táblázat -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Dátum</th>
                <th>Feladó</th>
                <th>Email</th>
                <th>Üzenet</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($uzenetek) > 0): ?>
                <?php foreach($uzenetek as $uzenet): ?>
                    <tr>
                        <td><?= date('Y.m.d. H:i', strtotime($uzenet['kuldes_datum'])) ?></td>
                        <td>
                            <?php if($uzenet['felhasznalo_id']): ?>
                                <?= htmlspecialchars($uzenet['vezeteknev'] . ' ' . $uzenet['keresztnev']) ?>
                            <?php else: ?>
                                <?= htmlspecialchars($uzenet['nev']) ?> (Vendég)
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($uzenet['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($uzenet['uzenet'])) ?></td>
                        <td>
                            <form action="./uzenettorles" method="post" onsubmit="return confirm('Biztosan törölni szeretné ezt az üzenetet?');">
                                <input type="hidden" name="uzenet_id" value="<?= $uzenet['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Törlés</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Még nincsenek beérkezett üzenetek.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>