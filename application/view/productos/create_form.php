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
    <title>CREATE</title>
</head>
<body>

<?php //if (isset($data)) var_dump ($data) ?>

<div class="container">

    <h1>Crea un nuevo registro</h1>

    <form action="<?= URL; ?>productos/create" method="POST" enctype="multipart/form-data">

        <div class="col-10 col-offset-10">

            <!-- NOMBRE -->

            <input type="hidden" name="MAX_FILE_SIZE" value="100000000">

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre"
                    <?php if ( isset( $data[ 'nombre' ] ) ) echo ' value="' . $data[ 'nombre' ] . '"'; ?>
                >
                <?php if ( isset ( $errors [ 'nombre' ] ) )
                    echo '<span class="errorf">' . $errors[ 'nombre' ] . '</span>'; ?>
            </div>


            <!-- DESCRIPCION -->

            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4">
                    <?php if ( isset( $data[ 'descripcion' ] ) ) echo $data[ 'descripcion' ]; ?></textarea>
                    <?php if ( isset ( $errors [ 'descripcion' ] ) )
                        echo '<span class="errorf">' . $errors[ 'descripcion' ] . '</span>'; ?>
            </div>

            <!-- MARCA -->

            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" placeholder="marca"
                    <?php if ( isset( $data[ 'marca' ] ) ) echo ' value="' . $data[ 'marca' ] . '"'; ?>
                >
                <?php if ( isset ( $errors [ 'marca' ] ) )
                    echo '<span class="errorf">' . $errors[ 'marca' ] . '</span>'; ?>
            </div>

            <!-- CATEGORIA -->
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select class="form-control" id="categoria" name="categoria">
                     <?php if ( isset ( $_POST[ 'categoria' ] ) ) { ?>
                         <option value="<?= $_POST[ 'categoria' ] ?>"><?= $_POST[ 'categoria' ] ?></option>
                    <?php }else { ?>
                         <option value="-" selected>-</option>

                   <?php }?>

                    <option value="deportes">deportes</option>
                    <option value="alimentacion">alimentacion</option>
                    <option value="tiempo_libre">tiempo_libre</option>
                    <option value="informatica">informatica</option>
                </select>
                <?php if ( isset ( $errors [ 'categoria' ] ) )
                    echo '<span class="errorf">' . $errors[ 'categoria' ] . '</span>'; ?>

            </div>

            <!-- FOTO -->

            <div class="form-group">
                <label for="imagen">Sube una imagen</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen">
            </div>

            <!-- SUBMIT -->

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit_registro_post">Enviar</button>
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