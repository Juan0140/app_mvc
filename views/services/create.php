<h1 class="page-name">Crear Servcios</h1>
<p class="description-page">Administracion de servicios</p>
<?php 
include_once __DIR__ . '/../templates/barra.php'; 
include_once __DIR__ . '/../templates/alerts.php' 
?>

<form action="/services/create" method="POST" class="form">

<?php 
include_once __DIR__ . '/form.php' 

?>

<input type="submit" class="button" value="Guardar Servicio">
</form>