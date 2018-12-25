<?php $this->layout ( 'layout' ) ?>
<?php //$this->insert('partials/menu') ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Página principal</title>
</head>
<body>

<div class="container">
    <h1>Introduce tus datos</h1>


    <form action="<?= URL; ?>login" method="post">

        <div class="col-5 col-offset-10">

            <!-- EMAIL -->

            <div class="form-group">
                <label for="select">Login</label>
                <select class="form-control" id="select" name="select">

                    <?php if ( isset( $_POST[ 'select' ] ) && $_POST[ 'select' ] === 'Nick' ) { ?>
                        <option value="Nick">Nick</option>
                        <option value="Email">Email</option>

                    <?php } elseif ( isset( $_POST[ 'select' ] ) && $_POST[ 'select' ] === 'Email' ) { ?>
                        <option value="Email">Email</option>
                        <option value="Nick">Nick</option>
                    <?php } else { ?>
                        <option value="0" disabled selected>Elige una opción</option>
                        <option value="Nick">Nick</option>
                        <option value="Email">Email</option>
                    <?php } ?>

                </select>
                <input type="text" name="nickemail" class="form-control"
                    <?php if ( isset( $data_login[ 'nickname' ] ) )
                        echo ' value="' . $data_login[ 'nickname' ] . '"';
                    elseif ( isset( $data_login[ 'email' ] ) )
                       echo ' value="' . $data_login[ 'email' ] . '"'; ?>
                >

                <?php
                if ( isset ( $errores [ 'select' ] ) )
                    echo '<span class="errorf">' . $errores[ 'select' ] . '</span>';
                elseif ( isset ( $errores [ 'nickname' ] ) )
                    echo '<span class="errorf">' . $errores[ 'nickname' ] . '</span>';
                elseif ( isset ( $errores [ 'email' ] ) )
                    echo '<span class="errorf">' . $errores[ 'email' ] . '</span>';
                elseif ( isset ( $errores [ 'db_empty' ] ) )
                    echo '<span class="errorf">' . $errores[ 'db_empty' ] . '</span>';

                ?>

            </div>

            <!-- PASSWORD -->

            <div class="form-group">
                <label for="clave">Clave</label>
                <input type="password" name="clave" id="clave" class="form-control">
                <?php if ( isset ( $errores [ 'clave' ] ) )
                    echo '<span class="errorf">' . $errores[ 'clave' ] . '</span>'; ?>
            </div>

            <!-- SUBMIT -->

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg" name="submit_login">Login</button>
            </div>
        </div>
    </form>

</div>

<!--<div class="caja_enlaces">
    <p><a class="btn btn-outline-primary btn-sm" href="../index.php">Ir a la página principal</a></p>
    <p><a class="btn btn-outline-primary btn-sm" href="../web/zona_publica.php">Ir a la web</a></p>
</div>
-->
<script src="../../../public/js/bootstrap.js"></script>
</body>
</html>