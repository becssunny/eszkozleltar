<h2>Bejelentkezés és regisztráció</h2>

<div class="row">
    <div class="col-md-6">
        <h3>Bejelentkezés</h3>
        <form action="<?= $BASE_URL ?>/belep" method="post">
            <div class="form-group">
                <label for="felhasznalo">Felhasználónév:</label>
                <input type="text" class="form-control" id="felhasznalo" name="felhasznalo" required>
            </div>
            <div class="form-group">
                <label for="jelszo">Jelszó:</label>
                <input type="password" class="form-control" id="jelszo" name="jelszo" required>
            </div>
            <button type="submit" class="btn btn-primary">Bejelentkezés</button>
        </form>
    </div>
    <div class="col-md-6">
        <h3>Regisztráció</h3>
        <form action="<?= $BASE_URL ?>/regisztral" method="post">
            <div class="form-group">
                <label for="reg_vezeteknev">Vezetéknév:</label>
                <input type="text" class="form-control" id="reg_vezeteknev" name="vezeteknev" required>
            </div>
            <div class="form-group">
                <label for="reg_keresztnev">Keresztnév:</label>
                <input type="text" class="form-control" id="reg_keresztnev" name="keresztnev" required>
            </div>
            <div class="form-group">
                <label for="reg_email">Email:</label>
                <input type="email" class="form-control" id="reg_email" name="email" required>
            </div>
            <div class="form-group">
                <label for="reg_felhasznalo">Felhasználónév:</label>
                <input type="text" class="form-control" id="reg_felhasznalo" name="felhasznalo" required>
            </div>
            <div class="form-group">
                <label for="reg_jelszo">Jelszó:</label>
                <input type="password" class="form-control" id="reg_jelszo" name="jelszo" required minlength="6">
            </div>
            <button type="submit" class="btn btn-success">Regisztráció</button>
        </form>
    </div>
</div>