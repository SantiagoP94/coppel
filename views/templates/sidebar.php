<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2>Corrales Terneros</h2>

        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
    </div>
    

    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Proyectos') ? 'activo' : ''; ?>" href="/dashboard">Crias</a>
        <a class="<?php echo ($titulo === 'Crear cria') ? 'activo' : ''; ?>" href="/crear-crias">Crear Cria</a>
        <a class="<?php echo ($titulo === 'Perfil') ? 'activo' : ''; ?>" href="/perfil">Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>