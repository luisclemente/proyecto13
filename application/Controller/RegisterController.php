<?php

namespace Mini\Controller;


use Mini\Core\View;
use Mini\Model\Validacion;
use Mini\Model\Usuario;
use Mini\Core\Controller;
use Mini\Core\TemplatesFactory;

class RegisterController extends Controller
{
    public function index ()
    {
        $v = new Validacion();
        $user = new Usuario();

        if ( isset( $_POST[ 'submit_registro' ] ) ) {

            $rol = '';

            if ( isset ( $_POST[ 'rol' ] ) ) $rol = $_POST[ 'rol' ];

            $datos_registro = [

                'nombre' => $_POST[ 'nombre' ],
                'apellidos' => $_POST[ 'apellidos' ],
                'nickname' => $_POST[ 'nickname' ],
                'email' => $_POST[ 'email' ],
                'rol' => $rol,
                'clave' => $_POST[ 'clave' ],
                'confirmacion' => $_POST[ 'clave2' ],

            ];

            try {

                $v->validar_registro ( $datos_registro, $v->errores );

                if ( $v->errores ) echo $this->view->render ( 'users/register_form',
                    [ 'errores' => $v->errores, 'data' => $datos_registro ] );

                else {

                    array_pop ( $datos_registro );

                    $registro_ok = $user->insert ( $datos_registro );

                    if ( ! $registro_ok ) echo $this->view->render ( 'users/register_form' );

                    else { ?>


                        <div class="caja_enlaces">
                            <h1>Todo correcto, usuario registrado</h1><br>
                            <!--<p><a class="btn btn-outline-primary btn-sm" href="../login/login_form.php?logueo">Ir al
                                    login</a></p>
                            <p><a class="btn btn-outline-primary btn-sm" href="../web/zona_publica.php">Ir a la web</a>
                            </p>
                            <p><a class="btn btn-outline-primary btn-sm" href="../index.php">Ir la página principal</a>
                            </p>-->
                        </div>

                    <?php }

                }

            } catch ( PDOException $e ) {

                echo 'Error! ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();
            }


        } else {

            echo $this->view->render ( 'users/register_form' );
        }
    }
}