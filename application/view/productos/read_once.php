<?php use Mini\Core\Session; Session::init (); $this->layout ( 'layout' ); ?>

<div class="container">

    <article class="pregunta">
        <span style="color:cornflowerblue">Nombre: </span><?= $registro->nombre ?><br>
        <span style="color:cornflowerblue">Descripcion: </span><?= $registro->descripcion ?><br>
        <span style="color:cornflowerblue">Marca: </span><?= $registro->marca ?><br>
        <span style="color:cornflowerblue">Categoria: </span><?= $registro->categoria ?><br>
        <span style="color:cornflowerblue">Fecha: </span><?= $registro->fecha ?><br>
        <span style="color:cornflowerblue">Usuario: </span><?= $registro->usuario ?><br>
        <footer>
            <div>
                <img src="<?= '/imgs/' . $registro->foto ?>" alt="imagen" width="25%">
            </div>
        </footer>
    </article>
    <hr>
    <hr>
</div>

