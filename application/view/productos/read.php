<?php

use Mini\Core\Session;

Session::init ();

$this->layout ( 'layout' );

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>WEB</title>
</head>
<body>

<br><br>

<form class="buscador" action="<?= $_SERVER[ 'PHP_SELF' ] ?>" method="post">
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

<?php

foreach ( $registros as $registro ) {

    $id = $registro->id_producto;

    echo
        '<div class="container">
                        <br>Nombre: ' . $registro->nombre . '<br>' .
        'Descripcion: ' . $registro->descripcion . '<br>' .
        'Marca: ' . $registro->marca . '<br>' .
        'Categoria: ' . $registro->categoria . '<br><br>' .

        '<form action="ver_producto.php" method="post" style= "padding-left: 450px">
                                <input type="hidden" name="id" value=" ' . $id . '">
                                <input type="submit" class="btn btn-primary" name="id_producto" id="id_producto" value="Ver producto">
                            </form></div>';

}

?>

<div class="caja_enlaces">
    <p><a class="btn btn-outline-primary btn-sm" href="zona_privada.php">Ir a mi zona privada</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../index.php">Ir a la página principal</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../login/logout.php">Cierra sesión</a></p>
</div>

</body>
</html>

