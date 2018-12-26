<?php use Mini\Core\Session; Session::init (); $this->layout ( 'layout' ); ?>

<br><br><br>
<form class="buscador" action="<?= URL; ?>productos/read" method="post">
    <div>
        <label for="post">Introduce un término de búsqueda</label>
        <input type="text" id="post" name="termino_busqueda" required>
        <label for="seleccion"></label>
        <select id="seleccion" name="opcion">
            <option value="1" disabled selected>Elige una opción</option>
            <option value="nombre">nombre</option>
            <option value="marca">marca</option>
            <option value="categoria">categoria</option>
        </select>
        &nbsp;<input type="submit" name="boton_busqueda" id="boton_busqueda" value="Busca">
    </div>
</form>

<div class="container">
    <h2>Todos los registros</h2>
    <?php if ( count ( $registros ) == 0 ) : ?>
        <p>No tenemos registros en la Base de Datos</p>
    <?php else : ?>
        <p>Tenemos <?= count ( $registros ) ?> registros en la base de datos</p>
        <?php foreach ( $registros as $registro ) : ?>
            <article class="pregunta">
                <span>Nombre: <?= $registro->nombre ?></span><br>
                <span>Marca: <?= $registro->marca ?></span><br>
                <span>Categoria: <?= $registro->categoria ?></span><br>
                <span>Autor: <?= $registro->usuario ?></span><br><br><br>
                <footer>
                    <a class="btn btn-outline-primary btn-sm" href="/productos/read/<?= $registro->id_producto ?>">Ver producto</a>
                </footer>
            </article>
            <hr><hr>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

