<h1 class="page-name">Servicios</h1>
<p class="description-page">Administracion de servicios</p>
 <?php include_once __DIR__ . '/../templates/barra.php' ?>

<ul class="services">
<?php
foreach($services as $service){ ?>
    <li>
        <p>Nombre: <span><?php echo $service->name ?></span></p>
        <p>Precio: <span>$<?php echo $service->price ?></span></p>

        <div class="actions">
            <a href="/services/update?id=<?php echo $service->id ?>" class="button">Actualizar</a>

            <form action="services/delete" method="POST">
                <input type="hidden" name="id" value="<?php echo $service->id ?>">
                <input type="submit" value="Eliminar" class="button-delete">
            </form>
        </div>
    </li>
<?php }
?>
</ul>