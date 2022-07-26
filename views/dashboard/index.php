<?php include_once __DIR__  . '/header-dashboard.php'; ?>

    <?php if(count($crias) === 0 ) { ?>
        <p class="no-proyectos">No Hay Crias Aún <a href="/crear-proyecto">¿Añadir una?</a></p>
    <?php } else { ?>
        <ul class="listado-proyectos">
            <?php foreach($crias as $cria) { ?>
                <li class="proyecto">
                    <div class="org">
                    <a href="/crias?id=<?php echo $cria->url; ?>"><span>Nombre:</span>
                        <?php 
                        echo $cria->nombre;                                                
                        ?>
                    </a>
                    <a href="/crias?id=<?php echo $cria->url; ?>"><span>Peso:</span>
                        <?php 
                        echo $cria->peso;                                                
                        ?>
                    </a>
                    <a href="/crias?id=<?php echo $cria->url; ?>"><span>costo:</span>
                        <?php 
                        echo $cria->costo;                                                
                        ?>
                    </a>
                    <a href="/crias?id=<?php echo $cria->url; ?>"><span>identificador:</span>
                        <?php 
                        echo $cria->identificador;                                                
                        ?>
                    </a>
                    <a href="/crias?id=<?php echo $cria->url; ?>"><span>proveedor:</span>
                        <?php 
                        echo $cria->proveedor;                                                
                        ?>
                    </a>
                    <a href="/crias?id=<?php echo $cria->url; ?>"><span>descripcion:</span>
                        <?php 
                        echo $cria->descripcion;                                                
                        ?>
                    </a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>