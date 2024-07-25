<h1 class="page-name">Panel de Administracion</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<div class="search">
    <h2>Buscar Citas</h2>
    <form action="" class="form">
        <div class="field">
            <label for="date">Fecha</label>
            <input type="date" name="date" id="date" value="<?php echo $date ?>">
        </div>
    </form>
</div>
<?php
if (count($appointments) === 0) {
    echo '<h2>No hay citas registradas</h2>';
}
?>

<div class="appointment-admin">
    <ul class="appointment">
        <?php
        $idAppointment = 0;
        foreach ($appointments as $key => $appointment) {
            if ($idAppointment !== $appointment->id) {
                $total = 0; ?>

                <li>
                    <p>ID: <span><?php echo $appointment->id ?></span></p>
                    <p>Hora: <span><?php echo $appointment->hour ?></span></p>
                    <p>Cliente: <span><?php echo $appointment->client ?></span></p>
                    <p>E-mail: <span><?php echo $appointment->email ?></span></p>
                    <p>Telefono: <span><?php echo $appointment->phone ?></span></p>
                    <h3>Servicios</h3>
                    <?php
                    $idAppointment = $appointment->id;
            }
            $total += intval($appointment->price);
            ?>
                <p class="service"><?php echo $appointment->service . ": \$" . $appointment->price ?></p>
                <?php
                $actual = $appointment->id;
                $next = $appointments[$key + 1]->id ?? 0;
                if (isLast($actual, $next)) { ?>
                    <p class="service"><?php echo "Total: $" . $total ?></p>
                    <form action="api/delete" method="POST">
                    <input type="hidden" name="id" value="<?php echo $appointment->id ?>">
                    <input type="submit" class="button-delete" value="Eliminar">
                    </form>
                <?php }
        }
        ?>
    </ul>
</div>

<?php $script = "<script src='build/js/search.js'></script>" ?>