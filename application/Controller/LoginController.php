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
    public function index ()
    {
        if ( $_POST ) {

            $check = $_POST[ 'opción' ];

            $this->data = [
                'opción' => $_POST[ 'opción' ],
                $check => $_POST[ 'nickemail' ],
                'clave' => $_POST[ 'clave' ]
            ];

            $this->v->valida_data ( $this->data, $this->v->errors );

            if ( $this->v->errors )
                self::render ( 'users/login_form', [ 'errors' => $this->v->errors, 'data' => $this->data ] );

            else {

                $this->data[ 'clave' ] = $this->user->codificaClave ( $this->data[ 'clave' ] );
                array_shift ( $this->data );

                try {
                    // Comprobamos si existe el usuario en la bd
                    $user_bd = $this->user->get ( $this->data );

                    if ( ! $user_bd ) $this->v->errors [ 'db_empty' ] = 'Email o clave son incorrectos';

                } catch ( PDOException $e ) {

                    echo 'Error! ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();
                }

                if ( $this->v->errors )
                    self::render ( 'users/login_form', [ 'errors' => $this->v->errors, 'data' => $this->data ] );

                else {

                    echo 'hola has iniciado sesion';

                    Session::init ();
                    Session::set ( 'id_usuario', $user_bd->id_usuario );
                    Session::set ( 'nombre', $user_bd->nombre );
                    Session::set ( 'rol', $user_bd->rol );

                    echo ( Session::get ( 'nombre' ) );

                    $info = date ( 'Y-m-d H:i:s' );
                    setcookie ( 'cookielogin', $info, strtotime ( '+ 30 days' ), '/' );

                    header ( 'location: /productos/crud' );

                }
            }

        } else self::render ( 'users/login_form' );

    }
}