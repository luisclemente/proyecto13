<?php

Use Mini\Core\Session;

$this->layout ( 'layout' );

Session::init ();

// Session::start ();

//  if ( Session::validateSession () === false ) header ( 'location:../productos/warning_zona_restringida.php' );

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Zona privada</title>

</head>
<body>

<div class="container">

    <h1>Bienvenid@ <?= Session::get ( 'nombre' ) ?> </h1><br>
    <h6>Sesión iniciada <?= $_COOKIE[ 'cookielogin' ] ?> </h6><br>

    <?php

    /*  $id_user = Session::get ( 'id_usuario' );

      try {

          $producto = new Producto();

          $_SESSION [ 'rol' ] == 'jefe' ?
              $registros = $producto->get_all () :
              $registros = $producto->get_all ( [ 'id_usuario' => $id_user ] );

      } catch ( PDOException $e ) {

          echo 'Error! ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();

      }*/

    ?>


    <table class="table">
        <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Marca</th>
            <th scope="col">Descripción</th>
        </tr>
        </thead>
        <tbody>

        <?php

        // Mostramos las entradas del usuario en una tabla CRUD
        foreach ( $registros as $registro ) : ?>

            <tr>
                <td><?= $registro->nombre ?></td>
                <td><?= $registro->marca ?></td>
                <td><?= $registro->descripcion ?></td>
                <td>
                    <?php

                    if ( $_SESSION [ 'rol' ] == 'jefe' ) : ?>

                    <form action="<?= URL; ?>productos/delete/<?= $registro->id_producto ?>" method="post">
                        <input type="submit" class="btn btn-danger" name="del" id="del" value="Borrar">
                    </form>
                </td>

                <?php endif; ?>

                <td><a href="<?= URL; ?>productos/edit/<?= $registro->id_producto ?>">
                        <input type='button' class="btn btn-warning" name='up' id='up' value='Editar'></a>
                </td>

            </tr>

        <?php
        endforeach;
        ?>

        </tbody>
    </table>

    <a href="<?= URL; ?>productos/create">
        &nbsp;<input type='button' class="btn btn-primary" name='crear' id='crear' value='Crear'></a>

    <?php

    if ( $_SESSION [ 'rol' ] == 'jefe' ) : ?>

        <a href="<?= URL; ?>productos/delete">
            &nbsp;<input type='button' class="btn btn-danger" name='del_all' id='del_all' value='Borrar todo'></a>
        <br><br>

    <?php endif; ?>

</div>

<div class="caja_enlaces" style="margin-left: 230px">

    <?php

    if ( $_SESSION [ 'rol' ] == 'jefe' ) : ?>

        <p><a class="btn btn-outline-primary btn-sm" href="../registro/register_form.php">Ir al registro</a></p>

    <?php endif; ?>

</div>
</body>
</html>

