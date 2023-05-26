<div class="global crear-background">

    <div class="contenedor crear">
        <div class="izquierda">
            <!-- Template del nombre del sitio -->
            <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
        </div>

        <div class="derecha">
            <p class="descripcion-pagina"><?php echo $titulo; ?></p>

            <!-- Template de alertas -->
            <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
            
            <form class="formulario" action="/crear" method="POST">
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="nombre" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo $usuario->nombre; ?>">
                </div>
                <div class="campo">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Tu email" name="email" value="<?php echo $usuario->email; ?>">
                </div>
                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" placeholder="Tu contraseña" name="password">
                </div>
                <div class="campo">
                    <label for="password2">Repetir Contraseña</label>
                    <input type="password" id="password2" placeholder="Repite tu contraseña" name="password2">
                </div>

                <input type="submit" class="boton" value="Crear Cuenta">
            </form>

            <div class="acciones">
                <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
                <a href="/olvide">¿Olvidaste tu contraseña?</a>
            </div>
        </div>
    </div>
</div>