<!-- Header Dashboard -->
<?php include_once __DIR__ . "/../dashboard/header-dashboard.php"; ?>

<?php if (count($proyectos) === 0) { ?>
    <p class="no-proyectos">Aún no has creado un proyecto <a href="/crear-proyecto">Comienza creando uno</a></p>
<?php } else { ?>
    <nav class="listado-proyectos">
        <?php foreach ($proyectos as $proyecto) : ?>
            <div class="proyecto">
                <a class="proyecto-titulo" href="/proyecto?id=<?php echo $proyecto->url; ?>">
                    <?php echo $proyecto->nombre; ?>
                </a>
                <div class="acciones">
                    <a class="actualizar" href="/actualizar-proyecto?id=<?php echo $proyecto->id; ?>"><i class="fa-solid fa-pencil"></i></a>
                    <a class="eliminar" href="/eliminar-proyecto?id=<?php echo $proyecto->id; ?>"><i class="fa-solid fa-trash"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </nav>
<?php } ?>

<!-- Footer Dashboard -->
<?php include_once __DIR__ . "/../dashboard/footer-dashboard.php"; ?>