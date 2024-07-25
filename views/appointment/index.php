<h1 class="page-name">Crear nueva cita</h1>
<p class="description-page">Elige tus servicios y coloca tus datos</p>
<?php include_once __DIR__ . '/../templates/barra.php' ?>
<div class="app">
    <nav class="tabs">
        <button class="actual" type="button" data-step="1">Servicios</button>
        <button type="button" data-step="2">Informacion Cita</button>
        <button type="button" data-step="3">Resumen</button>
    </nav>
    <div id="step-1" class="section">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <div class="list-services" id="services"></div>
    </div>
    <div id="step-2" class="section">
        <h2>Datos</h2>
        <p class="text-center">Coloca datos y fecha de cita</p>
        <form class="form">
            <div class="field">
                <label for="name">Nombre</label>
                <input type="text" id="name" placeholder="Tu nombre" value="<?php echo $name ?>" disabled>
            </div>
            <div class="field">
                <label for="date">Fecha</label>
                <input type="date" id="date" placeholder="Fecha" min="<?php echo date('Y-m-d') ?>">
            </div>
            <div class="field">
                <label for="hour">Hora</label>
                <input type="time" id="hour" placeholder="Hora">
            </div>
            <input type="hidden" id="id" value="<?php echo $id
             ?>">
        </form>
    </div>
    <div id="step-3" class="section content-resume">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>

    <div class="pagination">
        <button id="back" class="button">&laquo Anterior</button>
        <button id="next" class="button" >Siguiente &raquo</button>
    </div>
</div>

<?php 
$script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/app.js'></script>
";
?>