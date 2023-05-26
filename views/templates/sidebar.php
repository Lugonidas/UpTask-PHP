<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2>UpTask</h2>
        <i id="cerrar-menu" class="fa-solid fa-xmark"></i>
    </div>
    <nav class="sidebar-nav">
        <div class="link <?php echo ($titulo === "Proyectos") ? "activo" : ''; ?>">
            <i class="icon fa-solid fa-folder-tree"></i>
            <a href="/proyectos"></i>Proyectos</a>
        </div>
        <div class="link <?php echo ($titulo === "Crear Proyecto") ? "activo" : ""; ?>">
            <i class="icon fa-solid fa-folder-plus"></i>
            <a href="/crear-proyecto">Crear Proyecto</a>
        </div>
        <div class="link <?php echo ($titulo === "Perfil") ? "activo" : ""; ?>">
            <i class="icon fa-solid fa-user-astronaut"></i>
            <a href="/perfil">Perfil</a>
        </div>
    </nav>
</aside>