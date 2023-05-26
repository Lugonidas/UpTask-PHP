<!-- Header Dashboard -->
<?php

 include_once __DIR__ . "/header-dashboard.php"; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . "/../templates/alertas.php "; ?>

    <a href="/perfil" class="enlace">Perfil</a>

    <form action="/cambiar-password" class="formulario" method="POST">
        <div class="campo">
            <label for="passwordActual">Contraseña Actual</label>
            <input type="password" id="passwordActual" placeholder="Tu contraseña actual" name="passwordActual">
        </div>
        <div class="campo">
            <label for="passwordNuevo">Contraseña Nueva</label>
            <input type="password" id="passwordNuevo" placeholder="Tu contraseña nueva" name="passwordNuevo">
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<!-- Footer Dashboard -->
<?php include_once __DIR__ . "/footer-dashboard.php"; ?>