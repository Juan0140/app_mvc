<h1 class="page-name">Confirmar cuenta</h1>

<?php include_once __DIR__ . '/../templates/alerts.php' ?>

<div class="actions">
        <a href="/">Iniciar sesion</a>

        <?php echo isset($alerts['error']) ? "<a href='/create-account'>¿Aún no tienes una cuenta?. Crea una</a>" : '' ?>
    </div>