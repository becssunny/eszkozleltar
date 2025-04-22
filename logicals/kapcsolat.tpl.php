<h2>Kapcsolat</h2>

<div class="row">
    <div class="col-md-6">
        <h4>Kapcsolati adatok</h4>
        <address>
            <strong>Eszközleltár Kft.</strong><br>
            1234 Budapest, Példa utca 1.<br>
            Telefon: +36 1 234 5678<br>
            Email: info@eszközleltár.hu
        </address>
        
        <!-- Google térkép beágyazása -->
        <div class="embed-responsive embed-responsive-16by9 mt-4">
            <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2726.3375296155727!2d19.66695091525771!3d46.89607994478184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4743da7a6c479e1d%3A0xc8292b3f6dc69e7f!2sPallasz+Ath%C3%A9n%C3%A9+Egyetem+GAMF+Kar!5e0!3m2!1shu!2shu!4v1475753185783" allowfullscreen></iframe>
        </div>
    </div>
    <div class="col-md-6">
        <h4>Küldjön üzenetet</h4>
        <form action="./kapcsolat-ment" method="post">
            <div class="form-group">
                <label for="nev">Név:</label>
                <input type="text" class="form-control" id="nev" name="nev" required minlength="5">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="uzenet">Üzenet:</label>
                <textarea class="form-control" id="uzenet" name="uzenet" rows="6" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Küldés</button>
        </form>
    </div>
</div>