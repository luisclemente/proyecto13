<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 3/12/18
 * Time: 13:01
 */

namespace Mini\Model;

use Mini\Core\Database;
use Mini\Model\Conexion1;

class Producto extends Conexion1
{

    public $table = 'productos';

    public function search ( $opcion, $terminoBusqueda )
    {
        $sql = "SELECT * FROM productos WHERE $opcion LIKE :terminoBusqueda";

        $stmt = $this->dbh->prepare ( $sql );

        $stmt->bindValue ( ":terminoBusqueda", "%$terminoBusqueda%" );

        $stmt->execute ();

        return $stmt->fetchAll ();
    }

    /* LISTA TODAS LOS PRODUCTOS EN LA ZONA PÚBLICA */
    public function view_all ( $params )
    {
        foreach ( $params as $producto ) {

            $id = $producto->id_producto;

            echo
                '<div class="container">
                    <br>Nombre: ' . $producto->nombre . '<br>' .
                'Descripcion: ' . $producto->descripcion . '<br>' .
                'Marca: ' . $producto->marca . '<br>' .
                'Categoria: ' . $producto->categoria . '<br><br>' .

                '<form action="ver_producto.php" method="post" style= "padding-left: 450px">
                            <input type="hidden" name="id" value=" ' . $id . '">
                            <input type="submit" class="btn btn-primary" name="id_producto" id="id_producto" value="Ver producto">
                        </form></div>';

        }
    }

    public function view_search ( $params )
    {
        foreach ( $params as $producto ) {

            echo
                '<div class="caja_entradas cajas"><h3 style="color:cornflowerblue">' . $producto->nombre . '</h3>' .
                '<span>por </span><span style="color:orange">' . $producto->descripcion . '</span>' . ' >> ' . $producto->fecha .
                '<p>Categoria: ' . $producto->marca . '</p>' .
                'Contenido: ' . $producto->categoria . '<br>' .

                /*************     ZONA IMAGENES   *****************/

                '<div>
	                    <img src="/exa/imagenes/' . $producto->foto . '" alt="Imagen" width="25%">
                     </div>' . '</div>';

            /*************     END ZONA IMAGENES   *****************/
        }
    }

    public function deleteImage ( $image )
    {
        if ( is_array ( $image ) !== true ) {

            if ( file_exists ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/exa/imagenes/' . $image ) ) {

                unlink ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/exa/imagenes/' . $image );
            }

        } else {

            foreach ( $image as $imag ) {

                if ( file_exists ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/exa/imagenes/' . $imag->foto ) ) {

                    unlink ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/exa/imagenes/' . $imag->foto );
                }
            }
        }
    }
}