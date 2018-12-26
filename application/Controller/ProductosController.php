<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 22/12/18
 * Time: 12:53
 */

namespace Mini\Controller;

use Mini\Core\View;
use Mini\Model\Validacion;
use Mini\Model\Usuario;
use Mini\Model\Producto;
use Mini\Model\Categoria;
use Mini\Core\Controller;
use Mini\Core\File;
use Mini\Core\Session;
use Mini\Core\TemplatesFactory;

class ProductosController extends Controller
{
    public $producto;
    public $v;

    public function __construct ()
    {
        parent::__construct ();

        $this->producto = new Producto ();
        $this->v = new Validacion ();
    }

    public function crud ()
    {
        $id_user = Session::get ( 'id_usuario' );

        try {
            Session::get ( 'rol' ) == 'jefe' ?
                $registros = $this->producto->get_all () :
                $registros = $this->producto->get_all ( [ 'id_usuario' => $id_user ] );

            echo $this->view->render ( 'productos/crud', [ 'registros' => $registros ] );

        } catch ( PDOException $e ) {

            echo 'Error! ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();
        }
    }

    public function read ( $id = null )
    {
        try {

            if ( $id == null ) {

                if ( isset( $_POST[ 'boton_busqueda' ] ) ) {

                    $terminoBusqueda = $this->v->validaIsset ( $_POST[ 'termino_busqueda' ] );

                    if ( ! $terminoBusqueda ) echo '<h5 style="color:red">Introduce un término de búsqueda</h5>';

                    elseif ( ! isset( $_POST[ 'opcion' ] ) ) echo '<h5 style="color:red">Introduce una opción</h5>';

                    else {

                        $opcion = $_POST[ 'opcion' ];

                        $registros = $this->producto->search ( $opcion, $terminoBusqueda );

                        if ( ! $registros ) echo '<h5 style="color:red">No se encontraron coincidencias en la búsqueda</h5>';

                        else echo $this->view->render ( 'productos/read_all', [ 'registros' => $registros ] );
                    }

                } else {

                    $registros = $this->producto->get_all ();

                    echo $this->view->render ( 'productos/read_all', [ 'registros' => $registros ] );

                }

            } else {

                $registro = $this->producto->get ( [ 'id_producto' => $id ] );

                echo $this->view->render ( 'productos/read_once', [ 'registro' => $registro ] );
            }


        } catch ( PDOException $e ) {

            echo 'Error! ' . $e->getMessage () . ' // Linea->' . $e->getLine ();
        }


    }


    public function create ()
    {
        if ( ! $_POST ) echo $this->view->render ( 'productos/create_form' );

        else {

            $data = [

                'nombre' => $_POST[ 'nombre' ],
                'descripcion' => $_POST[ 'descripcion' ],
                'marca' => $_POST[ 'marca' ],
                'categoria' => $_POST[ 'categoria' ]
            ];

            $this->v->valida_data ( $data, $this->v->errores );

            if ( $this->v->errores ) echo $this->view->render ( 'productos/create_form',
                [ 'errors' => $this->v->errores, 'data' => $data ] );

            else {

                $categoria = new Categoria();

                try {
                    // Capturamos el id de la categoria en la que se va a publicar
                    $id_categoria = $categoria->get ( [ 'nombre' => $data[ 'categoria' ] ] )->id_categoria;

                    $imag_name = $this->v->filtrar ( File::upFile ( 'imagen' ) );

                    $data_create = array_merge ( $data,
                        [ 'usuario' => Session::get ( 'nombre' ),
                            'id_usuario' => Session::get ( 'id_usuario' ),
                            'id_categoria' => $id_categoria,
                            'foto' => $imag_name ] );

                    $this->producto->insert ( $data_create );

                } catch ( PDOException $e ) {

                    echo 'Error! ' . $e->getMessage () . ' // Linea->' . $e->getLine ();
                }

                header ('Location: /productos/crud');
            }
        }
    }


    public function edit ( $id )
    {
        try {

            $registro = $this->producto->get ( [ 'id_producto' => $id ] );

            if ( ! $_POST ) { // Si viene del crud

                echo $registro ? $this->view->render ( 'productos/update_form', [ 'registro' => $registro ] ) :
                    'No se encontraron registros';

            } else {

                $data_update = [

                    'id_producto' => $_POST[ 'id_producto' ],
                    'nombre' => $_POST[ 'nombre' ],
                    'descripcion' => $_POST[ 'descripcion' ],
                    'marca' => $_POST[ 'marca' ],
                    'categoria' => $_POST[ 'categoria' ],
                ];

                $this->v->valida_data ( $data_update, $this->v->errores );

                if ( $this->v->errores ) echo $this->view->render ( 'productos/update_form',
                    [ 'errors' => $this->v->errores, 'data' => $data_update ] );

                else {

                    $id_producto = [ 'id_producto' => $data_update[ 'id_producto' ] ];
                    $id_usuario = [ 'id_usuario' => Session::get ( 'id_usuario' ) ];
                    $categoria = [ 'categoria' => $data_update[ 'categoria' ] ];
                    $nombre = ['nombre' => $data_update[ 'nombre' ]];

                    $foto = File::upFile ( 'imagen' );

                    if ( $foto ) { // Si ha editado la foto

                        $this->producto->deleteImage ( $id_producto );

                        $data_update[ 'foto' ] = $this->v->filtrar ( $foto );

                    }

                    if ( Session::get ( 'rol' ) !== 'jefe' ) {
                        // Comprobamos que la entrada a editar pertenece al usuario en sesión
                        $registro = $this->producto->get ( [ $id_producto, $id_usuario ] );

                        if ( ! $registro ) $this->v->errores [ 'nombre' ] = 'No puedes editar esta entrada';

                        else {
                            // Comprobamos si ya existe un registro con un nombre igual en la misma categoria
                            $registro = $this->producto->get ( [ $nombre, $categoria] );

                            // Si existe el nombre y es del usuario en sesion o no existe el nombre
                            $registro && $registro->id_usuario === Session::get ( 'id_usuario' ) || ! $registro ?
                            $this->producto->update ( $data_update, $id_producto ):
                            $this->v->errores [ 'nombre' ] = 'El nombre ya existe en esta categoría';
                        }

                    } else $this->producto->update ( $data_update, $id_producto );

                    if ( $this->v->errores ) echo $this->view->render ( 'productos/update_form',
                        [ 'errors' => $this->v->errores, 'data' => $data_update ] );

                    else header ( 'location: /productos/crud' );
                }
            }

        } catch ( PDOException $e ) {

            echo 'Error ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();
        }
    }

    public function delete ( $id = null )
    {
        $id_usuario = Session::get ( 'id_usuario' );
        $id_producto = [ 'id_producto' => $id ];

        try {

            if ( $id != null ) {

                $this->producto->deleteImage ( $id_producto );

                $this->producto->delete ( $id_producto );

            } else { // Eliminamos todas las entradas

                $this->producto->deleteImage ( [ 'id_usuario' => $id_usuario ] );

                $this->producto->delete ();

            }

        } catch ( PDOException $e ) {

            echo 'Error! ' . $e->getMessage () . ' // Lineas-> ' . $e->getLine ();
        }

        header ( 'location: /productos/crud' );
    }

}

