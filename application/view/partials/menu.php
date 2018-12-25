<div class="navigation">
    <a href="<?php echo URL; ?>">home</a>
    <a href="<?php echo URL; ?>canciones">Canciones</a>
    <a href="<?php echo URL; ?>preguntas/todas">Todas las preguntas</a>
    <a href="<?php echo URL; ?>preguntas/crear">Crear pregunta</a>
    <a href="<?php echo URL; ?>songs">songs</a>
    <a href="<?php echo URL; ?>login">Login</a>
    <a href="<?php echo URL; ?>register">Registro</a>

    <?php if ( $_SESSION ) { ?>
        <a href="<?php echo URL; ?>productos/crud">Mi Web</a>
        <a href="<?php echo URL; ?>productos/read">Web</a>
    <?php } ?>

    <!-- <?php if ( $_SESSION[ 'rol' ] == 'jefe' ) { ?> -->
    <!-- <a href="<?php echo URL; ?>songs">songs</a> -->
    <!-- <?php } ?> -->
</div>