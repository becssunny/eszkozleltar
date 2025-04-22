<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $fejlec['cim'] ?></title>
    
    <!-- Bootstrap CSS a reszponzív tervezéshez -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Saját stíluslap -->
    <link rel="stylesheet" href="./styles/main.css">
</head>
<body>
    <!-- Fejléc -->
    <header class="container">
        <div class="row">
            <div class="col-12">
                <h1><?= $fejlec['cim'] ?></h1>
                <p class="motto"><?= $fejlec['motto'] ?></p>
                
                <!-- Bejelentkezett felhasználó adatai -->
                <?php if(isset($_SESSION['felhasznalo'])): ?>
                <div class="user-info">
                    <p>Bejelentkezett: <?= $_SESSION['vezeteknev'] ?> <?= $_SESSION['keresztnev'] ?> (<?= $_SESSION['felhasznalo'] ?>)</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <!-- Menü -->
    <nav class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav">
                    <?php foreach($oldalak as $url => $oldal): ?>
                        <?php if($oldal['menun'][0] || $oldal['menun'][1]): ?>
                            <?php if(
                                ($oldal['menun'][0] && isset($_SESSION['felhasznalo'])) || 
                                ($oldal['menun'][1] && !isset($_SESSION['felhasznalo']))
                            ): ?>
                                <li class="nav-item<?= ($oldal == $keres) ? ' active' : '' ?>">
                                    <a href="<?= ($url == '/') ? '.' : $url ?>" class="nav-link"><?= $oldal['szoveg'] ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Tartalom -->
    <main class="container">
        <div class="row">
            <div class="col-12">
                <!-- Az aktuális oldal tartalmának betöltése -->
                <?php include("./templates/pages/{$keres['fajl']}.tpl.php"); ?>
            </div>
        </div>
    </main>
    
    <!-- Lábléc -->
    <footer class="container">
        <div class="row">
            <div class="col-12">
                <p><?= $lablec['copyright'] ?> - <?= $lablec['ceg'] ?></p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>