<!-- Header Dashboard -->
<?php include_once __DIR__ . "/../dashboard/header-dashboard.php"; ?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button type="button" class="agregar-tarea" id="agregar-tarea">
            <span>+</span> Nueva Tarea
        </button>
    </div>

    <div class="filtros" id="filtros">
        <h2>Filtros:</h2>
        <div class="filtros-inputs">
            <div class="campo">
                <label for="todas">Todas</label>
                <input type="radio" id="todas" name="filtro" value="" checked>
            </div>
            <div class="campo">
                <label for="completadas">Completadas</label>
                <input type="radio" id="completadas" name="filtro" value="1">
            </div>
            <div class="campo">
                <label for="pendientes">Pendientes</label>
                <input type="radio" id="pendientes" name="filtro" value="0">
            </div>
        </div>
    </div>
    <ul id="listado-tareas" class="listado-tareas"></ul>
</div>


<!-- Footer Dashboard -->
<?php include_once __DIR__ . "/../dashboard/footer-dashboard.php"; ?>

<?php

$script .= "
    <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/tareas.js'></script>";
?>