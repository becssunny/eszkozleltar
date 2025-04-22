<div class="row">
    <div class="col-12">
        <div class="alert alert-success">
            <strong>A regisztráció sikeres!</strong> Most már bejelentkezhet.
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Bejelentkezés</h4>
            </div>
            <div class="card-body">
                <p>Most már bejelentkezhet fiókjába az alábbi hivatkozáson:</p>
                <a href="./belepes" class="btn btn-primary">Bejelentkezés</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Felhasználói adatok</h4>
            </div>
            <div class="card-body">
                <p><strong>Felhasználónév:</strong> <?= $_SESSION['reg_felhasznalonev'] ?></p>
                <p><strong>Név:</strong> <?= $_SESSION['reg_nev'] ?></p>
                <p><strong>Email:</strong> <?= $_SESSION['reg_email'] ?></p>
            </div>
        </div>
    </div>
</div>