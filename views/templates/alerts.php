<?php
// debuguear($alerts);
foreach ($alerts as $key => $values) {
    foreach ($values as $value) { ?>
        <div class="alert <?php echo $key; ?>">
            <p> <?php echo $value; ?></p>
        </div>
<?php   }
}
