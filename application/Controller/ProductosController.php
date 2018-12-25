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

    public function read ()
    {
       // echo $this->view->render ( 'productos/read' );

      //  $v = new Validacion();
      //  $producto = new Producto ();

        try {

            if ( isset( $_POST[ 'boton_busqueda' ] ) ) {

                $terminoBusqueda = $this->v->validaIsset ( $_POST[ 'termino_busqueda' ] );

                if ( ! $terminoBusqueda ) echo '<h5 style="color:red">Introduce un término de búsqueda</h5>';

                elseif ( ! isset( $_POST[ 'opcion' ] ) ) echo '<h5 style="color:red">Introduce una opción</h5>';

                else {

                    $opcion = $_POST[ 'opcion' ];

                    $registros = $this->producto->search ( $opcion, $terminoBusqueda );

                    if ( ! $registros ) echo '<h5 style="color:red">No se encontraron coincidencias en la búsqueda</h5>';

                    else $this->producto->view_search ( $registros );
                }

            } else {

                $registros = $this->producto->get_all ();

                //$this->producto->view_all ( $registros );
                echo $this->view->render ( 'productos/read', ['registros' => $registros] );

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

                    $data_create = [

                        'nombre' => $data[ 'nombre' ],
                        'descripcion' => $data[ 'descripcion' ],
                        'marca' => $data[ 'marca' ],
                        'usuario' => Session::get ( 'nombre' ),
                        'categoria' => $data[ 'categoria' ],
                        'id_usuario' => Session::get ( 'id_usuario' ),
                        'id_categoria' => $id_categoria,
                        // 'foto' => $nom_imagen
                    ];

                    $this->producto->insert ( $data_create );

                    header ('Location: /productos/crud');

                } catch ( PDOException $e ) {

                    echo 'Error! ' . $e->getMessage () . ' // Linea->' . $e->getLine ();
                }
            }
        }
    }


    public function edit ( $id )
    {
        try {

            if ( ! $_POST ) {

                $registro = $this->producto->get ( [ 'id_producto' => $id ] );

                echo $this->view->render ( 'productos/update_form', [ 'registro' => $registro ] );

            } else {

                $data_update = [

                    'id_producto' => $_POST[ 'id_producto' ],
                    'nombre' => $_POST[ 'nombre' ],
                    'descripcion' => $_POST[ 'descripcion' ],
                    'marca' => $_POST[ 'marca' ],
                    'usuario' => Session::get ( 'nombre' ),
                    'categoria' => $_POST[ 'categoria' ],
                    'id_usuario' => Session::get ( 'id_usuario' ),
                    'id_categoria' => $_POST[ 'id_categoria' ]
                ];

                $this->v->valida_data ( $data_update, $this->v->errores );

                if ( $this->v->errores ) echo $this->view->render ( 'productos/update_form',
                    [ 'errors' => $this->v->errores, 'data' => $data_update ] );

                else {

                    $id_producto = $data_update[ 'id_producto' ];
                    $categoria = $data_update[ 'categoria' ];
                    $nombre = $data_update[ 'nombre' ];

                    /***********   START IMAGENES   ************/

                    /*  $foto = $nom_imagen;

                      if ( $foto ) { // Si ha editado la foto

                          $foto_antigua = $producto->get ( [ 'id_producto' => $id ] )->foto;

                          // $producto->deleteImage ( [ 'foto' => $foto_antigua ] );
                          $producto->deleteImage (  $foto_antigua  );

                          $data_update[ 'foto' ] = $foto;

                      }*/

                    /***********     END IMAGENES   **************/

                    if ( Session::get ( 'rol' ) !== 'jefe' ) {
                        // Comprobamos que la entrada a editar pertenece al usuario en sesión
                        $registro = $this->producto->get ( [
                            'id_producto' => $id_producto,
                            'id_usuario' => Session::get ( 'id_usuario' )
                        ] );

                        if ( ! $registro ) $this->v->errores [ 'nombre' ] = 'No puedes editar esta entrada';

                        else {

                            // Comprobamos si ya existe un registro con un nombre igual en la misma categoria
                            $registro = $this->producto->get ( [ 'nombre' => $nombre, 'categoria' => $categoria ] );

                            // Si existe el nombre y es del usuario en sesion o no existe el nombre
                            if ( $registro && $registro->id_usuario === Session::get ( 'id_usuario' ) || ! $registro ) {

                                $target_editar = [ 'id_producto' => $id_producto ];

                                $this->producto->update ( $data_update, $target_editar );

                            } else $this->v->errores [ 'nombre' ] = 'El nombre ya existe en esta categoría';

                        }

                    } else {

                        $target_editar = [ 'id_producto' => $id_producto ];

                        $this->producto->update ( $data_update, $target_editar );
                    }

                    if ( $this->v->errores ) echo $this->view->render ( 'productos/update_form',
                        [ 'errors' => $this->v->errores, 'data' => $data_update ] );

                    else header ( 'location: /productos/crud' );

                }
            }

        } catch ( PDOException $e ) {

            echo 'Error ' . $e->getMessage () . ' // Linea-> ' . $e->getLine ();
        }


    }

    public function delete ($id = null)
    {
        $id_usuario = Session::get ( 'id_usuario' );

        try {

            // if ( isset( $_POST[ 'del' ] ) && isset ( $_POST[ 'id_producto' ] ) ) {
             if ( $id != null) {

             /*   $foto = $this->producto->get ( [ 'id_producto' => $id])->foto;
                // Si el registro tiene foto la borramos del servidor
                if ( $foto ) $this->producto->deleteImage (  $foto );*/

                $this->producto->delete ( [ 'id_producto' => $id] );

            } else { // Eliminamos todas las entradas

               /*   $fotos = $this->producto->get_all ( ['id_usuario' => $id_usuario ]);

                  // Eliminamos todas las fotos del usuario en el servidor
                  if ( $fotos ) $this->producto->deleteImage ( $fotos );*/

                 $this->producto->delete ();

             }

            header ( 'location: /productos/crud' );

        } catch ( PDOException $e ) {

            echo 'Error! ' . $e->getMessage () . ' // Lineas-> ' . $e->getLine ();
        }
    }

}

