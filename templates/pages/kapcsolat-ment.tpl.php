<h2>Üzenet elküldve</h2>

<div class="alert alert-success">
    <h4>Köszönjük az üzenetet!</h4>
    <p>Az üzenetét sikeresen rögzítettük. Hamarosan válaszolunk.</p>
</div>

<div class="card">
    <div class="card-header">
        Az elküldött üzenet adatai
    </div>
    <div class="card-body">
        <p><strong>Név:</strong> <?= isset($_POST['nev']) ? htmlspecialchars($_POST['nev']) : 'Nincs megadva' ?></p>
        <p><strong>Email:</strong> <?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'Nincs megadva' ?></p>
        <p><strong>Üzenet:</strong> <?= isset($_POST['uzenet']) ? nl2br(htmlspecialchars($_POST['uzenet'])) : 'Nincs megadva' ?></p>
    </div>
</div>

<p class="mt-3">
    <a href="./" class="btn btn-primary">Vissza a főoldalra</a>
</p>