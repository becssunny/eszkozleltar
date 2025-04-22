<h2>Képgaléria</h2>

<?php if(isset($_SESSION['uzenet_siker'])): ?>
<div class="alert alert-success">
    A képfájl sikeresen feltöltve!
</div>
<?php unset($_SESSION['uzenet_siker']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['uzenet_hiba'])): ?>
<div class="alert alert-danger">
    Hiba történt a feltöltés során!
</div>
<?php unset($_SESSION['uzenet_hiba']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['torles_siker'])): ?>
<div class="alert alert-success">
    A képfájl sikeresen törölve!
</div>
<?php unset($_SESSION['torles_siker']); ?>
<?php endif; ?>

<p>Itt láthatja az eszközökről feltöltött képeket.</p>

<!-- Képgaléria stílus - fix magasság a képekhez -->
<style>
    .gallery-img-container {
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .gallery-img {
        width: 100%;
        height: 200px;
        object-fit: cover; /* A kép kitölti a rendelkezésre álló teret, levágva a szükséges részeket */
    }
    
    .delete-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(220, 53, 69, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        font-weight: bold;
        cursor: pointer;
        z-index: 10;
    }
    
    .delete-button:hover {
        background-color: rgba(220, 53, 69, 1);
    }
    
    .card {
        position: relative;
    }
</style>

<?php
// Képek lekérdezése az adatbázisból
try {
    $dbh = new PDO('mysql:host='.$adatbazis['host'].';dbname='.$adatbazis['adatbazis'], 
                   $adatbazis['felhasznalonev'], $adatbazis['jelszo'],
                   array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
    
    // Képek lekérdezése csökkenő sorrendben (legújabbak elől)
    $sql = "SELECT k.*, f.vezeteknev, f.keresztnev 
            FROM kepek k 
            LEFT JOIN felhasznalok f ON k.felhasznalo_id = f.id 
            ORDER BY k.feltoltes_datum DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $kepek = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo '<div class="alert alert-danger">Adatbázis hiba: ' . $e->getMessage() . '</div>';
    $kepek = array();
}
?>

<!-- Képgaléria -->
<div class="row">
    <?php if(count($kepek) > 0): ?>
        <?php foreach($kepek as $kep): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <?php if(isset($_SESSION['felhasznalo']) && ($kep['felhasznalo_id'] == $_SESSION['id'])): ?>
                    <!-- Törlés gomb - csak a kép feltöltője látja -->
                    <form action="./keptorles" method="post" onsubmit="return confirm('Biztosan törölni szeretné ezt a képet?');">
                        <input type="hidden" name="kep_id" value="<?= $kep['id'] ?>">
                        <input type="hidden" name="fajlnev" value="<?= $kep['fajlnev'] ?>">
                        <button type="submit" class="delete-button" title="Kép törlése">×</button>
                    </form>
                    <?php endif; ?>
                    
                    <div class="gallery-img-container">
                        <a href="<?= $MAPPA . $kep['fajlnev'] ?>" target="_blank">
                            <img class="gallery-img" src="<?= $MAPPA . $kep['fajlnev'] ?>" alt="<?= htmlspecialchars($kep['leiras']) ?>">
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($kep['leiras'] ?: 'Nincs leírás') ?></h5>
                        <p class="card-text">
                            Feltöltve: <?= date('Y.m.d. H:i', strtotime($kep['feltoltes_datum'])) ?><br>
                            Feltöltő: <?= isset($kep['vezeteknev']) ? htmlspecialchars($kep['vezeteknev'] . ' ' . $kep['keresztnev']) : 'Ismeretlen' ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info">Még nincsenek feltöltött képek.</div>
        </div>
    <?php endif; ?>
</div>

<?php if(isset($_SESSION['felhasznalo'])): ?>
<div class="mt-4">
    <h4>Új kép feltöltése</h4>
    <form action="./kepfeltoltes" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="kep">Válasszon képet:</label>
            <input type="file" class="form-control-file" id="kep" name="kep" accept="image/*" required>
            <small class="form-text text-muted">Megengedett formátumok: JPG, PNG, GIF. Maximum méret: <?= $MAXMERET/1024 ?> KB</small>
        </div>
        <div class="form-group">
            <label for="leiras">Leírás:</label>
            <input type="text" class="form-control" id="leiras" name="leiras" maxlength="255">
        </div>
        <button type="submit" name="feltoltes" class="btn btn-primary">Feltöltés</button>
    </form>
</div>
<?php else: ?>
<div class="alert alert-info mt-4">
    A képfeltöltéshez kérjük, <a href="./belepes">jelentkezzen be</a>!
</div>
<?php endif; ?>