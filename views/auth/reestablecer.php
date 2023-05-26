<div class="global reestablecer-background">

    <div class="contenedor reestablecer">
        <div class="izquierda">
            <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
        </div>

        <div class="derecha">
            <p class="descripcion-pagina"><?php echo $titulo; ?></p>

            <!-- Template de las alertas -->
            <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

            <?php if ($mostrar) : ?>
                <form class="formulario" method="POST">
                    <div class="campo">
                        <label for="password">Nueva Contraseña</label>
                        <input type="password" id="password" placeholder="Nueva contraseña" name="password">
                    </div>
                    <div class="campo">
                        <label for="password2">Repite tu contraseña</label>
                        <input type="password" id="password2" placeholder="Repite tu contraseña" name="password2">
                    </div>
                    <input type="submit" class="boton" value="Reestablecer">
                </form>

                <div class="acciones">
                    <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
                    <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>