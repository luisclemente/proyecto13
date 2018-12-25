<?php

use Mini\Core\Session;

$this->layout ( 'layout' );

Session::init ();

// if ( ! Session::validateSession () ) header ( 'location:../login/warning_zona_restringida.php' );

?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>UPDATE</title>

</head>
<body>

<?php

if ( isset( $data ) ) var_dump ( $data );
if ( isset( $errors ) ) var_dump ( $errors );

?>

<!-- OJO!! los values van entrecomillados -->
<div class="container">
    <h1>Editar</h1>
    <form method="post" action="<?php URL; ?>productos/edit" enctype="multipart/form-data">

        <div class="col-10 col-offset-10">

            <div class="form-group">
                <label for="id_producto"></label>
                <input type="hidden" class="form-control" id="id_producto" name="id_producto"
                       value="<?php echo ! isset( $data[ 'id_producto' ] ) ?
                           $registro->id_producto : $data[ 'id_producto' ]; ?>">
            </div>

            <div class="form-group">
                <label for="categoria"></label>
                <input type="hidden" class="form-control" id="categoria" name="categoria"
                       value="<?php echo ! isset( $data[ 'categoria' ] ) ?
                           $registro->categoria : $data[ 'categoria' ]; ?>">
            </div>

            <div class="form-group">
                <label for="id_categoria"></label>
                <input type="hidden" class="form-control" id="id_categoria" name="id_categoria"
                       value="<?php echo ! isset( $data[ 'id_categoria' ] ) ?
                           $registro->id_categoria : $data[ 'id_categoria' ]; ?>">
            </div>

            <!-- NOMBRE -->

            <input type="hidden" name="MAX_FILE_SIZE" value="100000000">

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                       value="<?php echo ! isset( $data[ 'nombre' ] ) ?
                           $registro->nombre : $data[ 'nombre' ]; ?>">

                <?php if ( isset ( $errors [ 'nombre' ] ) )
                    echo '<span class="errorf">' . $errors[ 'nombre' ] . '</span>'; ?>
            </div>

            <!-- DESCRIPCION -->

            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="10"
                ><?php echo ! isset( $data[ 'descripcion' ] ) ?
                        $registro->descripcion : $data[ 'descripcion' ];?></textarea>

                <?php if ( isset ( $errors [ 'descripcion' ] ) )
                    echo '<span class="errorf">' . $errors[ 'descripcion' ] . '</span>'; ?>
            </div>

            <!-- MARCA -->

            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca"
                       value="<?php echo ! isset( $data[ 'marca' ] ) ?
                           $registro->marca : $data[ 'marca' ]; ?>">
                <?php if ( isset ( $errors [ 'marca' ] ) )
                    echo '<span class="errorf">' . $errors[ 'marca' ] . '</span>'; ?>
            </div>


            <!-- FOTO -->

            <div class="form-group">
                <label for="imagen">Sube una imagen</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen">
            </div>

            <!-- SUBMIT -->

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="editar">Editar</button>
            </div>
        </div>

    </form>
</div>
<div class="caja_enlaces">
    <p><a class="btn btn-outline-primary btn-sm" href="../web/zona_privada.php">Regresar a mi zona privada</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../web/zona_publica.php">Ir a la web</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../index.php">Ir a la página principal</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../login/logout.php">Cierra sesión</a></p>
</div>

</body>
</html>

