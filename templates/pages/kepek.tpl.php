<h2>Képgaléria</h2>

<p>Itt láthatja az eszközökről feltöltött képeket.</p>

<!-- Képgaléria -->
<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <img class="card-img-top" src="https://via.placeholder.com/350x200?text=Laptop" alt="Laptop">
            <div class="card-body">
                <h5 class="card-title">Laptop</h5>
                <p class="card-text">Dell XPS 13</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <img class="card-img-top" src="https://via.placeholder.com/350x200?text=Telefon" alt="Telefon">
            <div class="card-body">
                <h5 class="card-title">Telefon</h5>
                <p class="card-text">Samsung Galaxy S21</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <img class="card-img-top" src="https://via.placeholder.com/350x200?text=Nyomtató" alt="Nyomtató">
            <div class="card-body">
                <h5 class="card-title">Nyomtató</h5>
                <p class="card-text">HP LaserJet Pro</p>
            </div>
        </div>
    </div>
</div>

<?php if(isset($_SESSION['felhasznalo'])): ?>
<div class="mt-4">
    <h4>Új kép feltöltése</h4>
    <form action="./kepfeltoltes" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="kep">Válasszon képet:</label>
            <input type="file" class="form-control-file" id="kep" name="kep" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="leiras">Leírás:</label>
            <input type="text" class="form-control" id="leiras" name="leiras">
        </div>
        <button type="submit" class="btn btn-primary">Feltöltés</button>
    </form>
</div>
<?php else: ?>
<div class="alert alert-info mt-4">
    A képfeltöltéshez kérjük, jelentkezzen be!
</div>
<?php endif; ?>