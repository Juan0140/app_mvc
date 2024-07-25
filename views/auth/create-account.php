<h1 class="page-name">Crear Cuenta</h1>
<p class="description-page">Llena el siguiente formulario para crear una cuenta</p>

<?php 
include_once __DIR__ . '/../templates/alerts.php';
?>

<form action="/create-account" method="POST" class="form">
    <div class="field">
        <label for="name">Nombre</label>
        <input type="text"
        id="name"
        name="name"
        placeholder="Tu nombre"
        value="<?php echo s($user->name) ?>">
    </div>
    <div class="field">
        <label for="lastName">Apellido</label>
        <input type="text"
        id="lastName"
        name="lastName"
        placeholder="Tu Apellido"
        value="<?php echo s($user->lastName) ?>">
    </div>
    <div class="field">
        <label for="phone">Tu Telefono</label>
        <input type="tel"
        id="phone"
        name="phone"
        placeholder="Tu Telefono"
        value="<?php echo s($user->phone) ?>">
    </div>
    <div class="field">
        <label for="email">E-mail</label>
        <input type="text"
        id="email"
        name="email"
        placeholder="Tu E-mail"
        value="<?php echo s($user->email) ?>">
    </div>
    <div class="field">
        <label for="password">Contraseña</label>
        <input type="password"
        id="password"
        name="password"
        placeholder="Tu Contraseña">
    </div>

    <input type="submit" value="Crear Cuenta" class="button">

    <div class="actions">
        <a href="/">¿Ya tienes una cuenta?. Inicia sesion</a>
        <a href="/forget">Olvidé mi password</a>
    </div>
</form>