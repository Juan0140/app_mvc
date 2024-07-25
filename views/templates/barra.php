<div class="barra">
    <p>Hola: <?php echo $name ?? '' ?></p>
    <a class="button" href="/logout">Cerrar sesion</a>
</div>

<?php 
    if (isset($_SESSION['admin'])) { ?>
        <div class="barra-service">
            <a href="/admin" class="button">Ver citas</a>
            <a href="/services" class="button">Ver servicios</a>
            <a href="/services/create" class="button">Nuevo Servicio</a>
        </div>
  <?php  }
?>