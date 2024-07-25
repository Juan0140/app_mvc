<h1 class="page-name">Olvide mi contraseña</h1>
<p class="description-page">Restablece tu contraseña escribiendo tu email</p>
<?php include_once __DIR__ . '/../templates/alerts.php' ?>
<form action="/forget" method="post" class="form">
    <div class="field">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Escribe tu email">
    </div>

    <input type="submit" class="button" value="Enviar Instrucciones">
</form>
<div class="actions">
    <a href="/">¿Ya tienes una cuenta?. Inicia sesion</a>
    <a href="/create-account">¿Aún no tienes una cuenta?. Crea una</a>
</div>