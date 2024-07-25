<h1 class="page-name">Login</h1>
<p class="description-page">Inicia sesion con tus datos</p>
<?php include_once __DIR__ . '/../templates/alerts.php' ?>
<form action="/" method="post" class="form">
    <div class="field">
        <label for="email">Email</label>
        <input 
        type="email"
        id="email"
        placeholder="Escribe tu email"
        name="email">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input 
        type="password"
        id="password"
        placeholder="Escribe tu password"
        name="password">
    </div>

    <input type="submit" class="button" value="Iniciar Sesion">

    <div class="actions">
        <a href="/create-account">¿Aún no tienes una cuenta?. Crea una</a>
        <a href="/forget">Olvidé mi password</a>
    </div>
</form>