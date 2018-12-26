<?php

namespace Mini\Controller;

use Mini\Core\View;
use Mini\Model\Validacion;
use Mini\Model\Usuario;
use Mini\Core\Controller;
use Mini\Core\Session;
use Mini\Core\TemplatesFactory;


class LoginController extends Controller
{
    public function __construct ()
    {
        parent::__construct ();
    }

    public function index ()
    {

        $v = new Validacion();
        $user = new Usuario();
        $data_login = [];

        if ( isset( $_POST[ 'submit_login' ] ) ) {

            if ( ! isset ( $_POST[ 'select' ] ) ) {

                $v->errores [ 'select' ] = 'Debes elegir una opción';

            } else {

                if ( $_POST[ 'select' ] === 'Nick' ) {

                    $data_login = [

                        'nickname' => $_POST[ 'nickemail' ],
                        'clave' => $_POST[ 'clave' ]
                    ];

                } elseif ( $_POST[ 'select' ] === 'Email' ) {

                    $data_login = [

                        'email' => $_POST[ 'nickemail' ],
                        'clave' => $_POST[ 'clave' ]
                    ];
                }

                $v->valida_data ( $data_login, $v->errores );
            }

            echo '<br><br>';

            if ( $v->errores ) echo $this->view->render ( 'users/login_form',
                [ 'errores' => $v->errores, 'data_login' => $data_login ] );

            else {

                $data_login[ 'clave' ] = $user->codificaClave ( $data_login[ 'clave' ] );

                try {
                    // Comprobamos si existe el usuario en la bd
                    $user_bd = $user->get ( $data_login );

                    if ( ! $user_bd ) $v->errores [ 'db_empty' ] = 'Email o clave son incorrectos';

                } catch ( PDOException $e ) {

                    echo 'Error! ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();
                }

                if ( $v->errores ) echo $this->view->render ( 'users/login_form',
                    ['errores' => $v->errores, 'data_login' => $data_login ] );

                else {

                    echo 'hola has iniciado sesion';

                    Session::init ();
                    Session::set ( 'id_usuario', $user_bd->id_usuario );
                    Session::set ( 'nombre', $user_bd->nombre );
                    Session::set ( 'rol', $user_bd->rol );

                    echo (Session::get('nombre'));

                    $info = date ( 'Y-m-d H:i:s' );
                    setcookie ( 'cookielogin', $info, strtotime ( '+ 30 days' ), '/' );

                    header ( 'location: /productos/crud' );

                }
            }

        } else echo $this->view->render ( 'users/login_form' );

    }
}