<?php
//Itera sobre el array de alertas
foreach ($alertas as $key => $alerta) :
    //Itera sobre los mensajes 
    foreach ($alerta as $mensaje) :
?>

<div class="alerta <?php echo $key;?>">
        <?php echo $mensaje; ?>
</div>


<?php
    endforeach;
endforeach;
