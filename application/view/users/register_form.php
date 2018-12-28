<?php $this->layout ( 'layout' ) ?>
<?php //$this->insert('partials/menu')?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>CRUD</title>

    <!--    <link rel="stylesheet" href="../../../public/css/bootstrap.css">-->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
           integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href=../../../public/css/hojaestilos.css>
 -->
</head>
<body>

<div class="container">
    <h1>Formulario de registro</h1>

    <form action="<?= URL; ?>register" method="POST">   <!-- Redirige a RegisterController@index -->

        <div class="col-5 col-offset-5">

            <!-- NOMBRE -->

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    <?php if ( isset( $data[ 'nombre' ] ) ) echo ' value="' . $data[ 'nombre' ] . '"'; ?>>
                <?php if ( isset ( $errors [ 'nombre' ] ) )
                    echo '<span class="errorf">' . $errors[ 'nombre' ] . '</span>'; ?>


            </div>


            <!-- APELLIDO -->

            <div class="form-group">
                <label for="apellidos">Apellido</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control"
                    <?php if ( isset( $data[ 'apellidos' ] ) ) echo ' value="' . $data[ 'apellidos' ] . '"'; ?>>
                <?php if ( isset ( $errors [ 'apellidos' ] ) )
                    echo '<span class="errorf">' . $errors[ 'apellidos' ] . '</span>'; ?>

            </div>

            <!-- EMAIL -->

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    <?php if ( isset( $data[ 'email' ] ) ) echo ' value="' . $data[ 'email' ] . '"'; ?>>
                <?php if ( isset ( $errors [ 'email' ] ) )
                    echo '<span class="errorf">' . $errors[ 'email' ] . '</span>'; ?>
            </div>

            <!-- NICK -->

            <div class="form-group">
                <label for="nickname">Nick</label>
                <input type="text" name="nickname" id="nickname" class="form-control"
                    <?php if ( isset( $data[ 'nickname' ] ) ) echo ' value="' . $data[ 'nickname' ] . '"'; ?>>
                <?php if ( isset ( $errors [ 'nickname' ] ) )
                    echo '<span class="errorf">' . $errors[ 'nickname' ] . '</span>'; ?>
            </div>

            <!-- ROL -->

            <div class="form-group">
                <label for="rol">Rol</label><br>
                <input type="radio" name="rol" value="empleado" id="rol"
                    <?php if ( isset($data[ 'rol' ]) && $data[ 'rol' ] === 'empleado') echo ' checked '; ?>> Empleado<br>
                <input type="radio" name="rol" value="jefe"
                    <?php if ( isset($data[ 'rol' ]) && $data[ 'rol' ] === 'jefe') echo ' checked '; ?>> Jefe<br>

                <?php if ( isset ( $errors [ 'rol' ] ) )
                    echo '<span class="errorf">' . $errors[ 'rol' ] . '</span>'; ?>
            </div>


            <!-- PASSWORD -->

            <div class="form-group">
                <label for="clave">Clave</label>
                <input type="password" name="clave" id="clave" class="form-control">
                <?php if ( isset ( $errors [ 'clave' ] ) )
                    echo '<span class="errorf">' . $errors[ 'clave' ] . '</span>'; ?>
            </div>

            <!-- PASSWORD CONFIRM -->

            <div class="form-group">
                <label for="clave2">Repetir Clave</label>
                <input type="password" name="clave2" id="clave2" class="form-control">
                <?php if ( isset ( $errors [ 'confirmacion' ] ) )
                    echo '<span class="errorf">' . $errors[ 'confirmacion' ] . '</span>'; ?>
            </div>


            <!-- SUBMIT -->

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit_registro">Registrar</button>
            </div>
        </div>
    </form>
</div>


<div class="caja_enlaces">
    <p><a class="btn btn-outline-primary btn-sm" href="login_form.php">Ir al login</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../productos/crud.php">Ir a mi zona de usuario</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../index.php">Ir la página principal</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../productos/read_all.php">Ir a la web</a></p>
</div>


</body>
</html>