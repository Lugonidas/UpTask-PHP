<div class="global olvide-background">

    <div class="contenedor olvide">
        <div class="izquierda">
            <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
        </div>

        <div class="derecha">
            <p class="descripcion-pagina"><?php echo $titulo; ?></p>

            <!-- Template de alertas -->
            <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

            <form class="formulario" action="/olvide" method="POST" novalidate>
                <div class="campo">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Tu email" name="email">
                </div>
                <input type="submit" class="boton" value="Enviar instrucciones">
            </form>

            <div class="acciones">
                <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
                <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
            </div>
        </div>
    </div>
</div>