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
                <label for="opción"></label>
                <select class="form-control" id="opción" name="opción">

                    <?php if ( isset( $_POST[ 'opción' ] ) && $_POST[ 'opción' ] === 'nickname' ) { ?>
                        <option value="nickname">Nickname</option>
                        <option value="Email">Email</option>

                    <?php } elseif ( isset( $_POST[ 'opción' ] ) && $_POST[ 'opción' ] === 'email' ) { ?>
                        <option value="email">Email</option>
                        <option value="nickname">Nickname</option>
                    <?php } else { ?>
                        <option value="0" selected>Elige una opción</option>
                        <option value="nickname">Nickname</option>
                        <option value="email">Email</option>
                    <?php } ?>

                </select>
                <input type="text" class="form-control" name="nickemail"
                    <?php if ( isset( $data[ 'nickname' ] ) )
                        echo ' value="' . $data[ 'nickname' ] . '"';
                    elseif ( isset( $data[ 'email' ] ) )
                        echo ' value="' . $data[ 'email' ] . '"';
                    elseif ( isset( $data[ 'nickemail' ] ) )
                        echo ' value="' . $data[ 'nickemail' ] . '"'; ?>
                >

                <?php
                if ( isset ( $errors [ 'opción' ] ) )
                    echo '<span class="errorf">' . $errors[ 'opción' ] . '</span>';
                if ( isset ( $errors [ 'nickname' ] ) )
                    echo '<span class="errorf">' . $errors[ 'nickname' ] . '</span>';
                if ( isset ( $errors [ 'email' ] ) )
                    echo '<span class="errorf">' . $errors[ 'email' ] . '</span>';
                if ( isset ( $errors [ 'db_empty' ] ) )
                    echo '<span class="errorf">' . $errors[ 'db_empty' ] . '</span>';

                ?>

            </div>

            <!-- PASSWORD -->

            <div class="form-group">
                <label for="clave">Clave</label>
                <input type="password" name="clave" id="clave" class="form-control">
                <?php if ( isset ( $errors [ 'clave' ] ) )
                    echo '<span class="errorf">' . $errors[ 'clave' ] . '</span>'; ?>
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