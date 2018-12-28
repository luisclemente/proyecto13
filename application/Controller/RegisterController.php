<?php

namespace Mini\Controller;

use Mini\Core\Controller;

class RegisterController extends Controller
{
    public function index ()
    {
        if ( $_POST ) {

            var_dump ( $_POST );

            $rol = '';

            if ( isset ( $_POST[ 'rol' ] ) ) $rol = $this->v->filtrar ( $_POST[ 'rol' ] );

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

                    $registro_ok = $this->user->insert ( $data );

                    if ( ! $registro_ok ){} //self::render ( 'users/register_form' );

                    else { ?>


                        <div class="caja_enlaces">
                            <h1>Todo correcto, usuario registrado</h1><br>
                        </div>

                    <?php }

                }

            } catch ( PDOException $e ) {

                echo 'Error! ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();
            }


        } else self::render ( 'users/register_form' );

    }
}