<div class="field">
    <label for="name">Nombre</label>
    <input type="text"
    id="name"
    name="name"
    placeholder="Nombre servicio"
    value="<?php echo $service->name ?>">
</div>

<div class="field">
    <label for="price">Precio</label>
    <input type="number"
    id="price"
    name="price"
    placeholder="Nombre servicio"
    value="<?php echo number_format($service->price, 0) ?>">
</div>