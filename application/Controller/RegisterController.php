<?php

namespace Mini\Controller;

use Mini\Core\Controller;
use PDOException;

class RegisterController extends Controller
{
    public function index ()
    {
        if ( $_POST ) {

            var_dump ( $_POST );
            echo '<br>';

            $rol = isset ( $_POST[ 'rol' ] ) ? $this->v->filtrar ( $_POST[ 'rol' ] ) : '';

            $data = [

                'nombre' => $_POST[ 'nombre' ],
                'apellidos' => $_POST[ 'apellidos' ],
                'nickname' => $_POST[ 'nickname' ],
                'email' => $_POST[ 'email' ],
                'rol' => $rol,
                'clave' => $_POST[ 'clave' ],
                'confirmacion' => $_POST[ 'clave2' ]
            ];

            try {

                $this->v->validar_registro ( $data, $this->v->errors );

                if ( $this->v->errors )
                    self::render ( 'users/register_form', [ 'errors' => $this->v->errors, 'data' => $data ] );

                else {

                    array_pop ( $data );

                    $this->user->insert ( $data );
                }

            } catch ( PDOException $e ) {

                echo 'Error! ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();   
                self::render ( 'users/register_form' );
            }


        } else self::render ( 'users/register_form' );

    }
}