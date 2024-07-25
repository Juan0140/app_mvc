<h1 class="page-name">Recuperar Password</h1>
<p class="description-page">Coloca tu Nuevo password</p>
<?php include_once __DIR__ . '/../templates/alerts.php';

if($error) return; ?>
<form method="POST" class="form">
    <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu nuevo Password">
    </div>
    <input type="submit" class="button" value="Guardar Nuevo Password">
</form>

<div class="actions">
    <a href="/">¿Ya tienes una cuenta?. Inicia sesion</a>
    <a href="/create-account">¿Aún no tienes una cuenta?. Crea una</a>
</div>