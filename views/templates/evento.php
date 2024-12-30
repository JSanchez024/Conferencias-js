<div class="evento swiper-slide">
    <p class="evento__hora"><?php echo $evento->hora->hora; ?>
    <div class="evento__informacion">
        <h4 class="evento__nombre"><?php echo $evento->nombre; ?></h4>
        <p class="evento__introducion"><?php echo $evento->descripcion; ?>
        <div class="evento__autor-info">
            <picture>
                <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.webp" type="image/webp"> 
                <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" type="image/png"> 
                <img class="evento__imagen-autor" src="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" alt="Speaker Image" loading="lazy" width="200" height="300">
            </picture>
            <p class="evento__autor-nombre">
                <?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?>
            </p>
        </div>
    </div>
</div>