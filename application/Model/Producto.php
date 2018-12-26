<?php

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

    /*  public function deleteImage ( $image, $params )
      {
          if ($this->getFile ($params)) {

              $imgs = $_SERVER[ 'DOCUMENT_ROOT' ] . '/imgs/';

              if ( is_array ( $image ) !== true ) {

                  if ( file_exists ( $imgs . $image ) ) {

                      unlink ( $imgs . $image );
                  }

              } else {

                  foreach ( $image as $imag ) {

                      if ( file_exists ( $imgs . $imag->foto ) ) {

                          unlink ( $imgs . $imag->foto );
                      }
                  }
              }

          } else {


          }



      }*/

    public function deleteImage ( $params )
    {
        $foto_antigua = $this->getFile ( $params );

        if ( $foto_antigua ) {

            $imgs = $_SERVER[ 'DOCUMENT_ROOT' ] . '/imgs/';

            if ( is_array ( $foto_antigua ) !== true ) {

                if ( file_exists ( $imgs . $foto_antigua ) ) {

                    unlink ( $imgs . $foto_antigua );
                }

            } else {

                foreach ( $foto_antigua as $imag ) {

                    if ( file_exists ( $imgs . $imag->foto ) ) {

                        unlink ( $imgs . $imag->foto );
                    }
                }
            }

        }


    }

    public function getFile ( $params )
    {
        if ( isset ( $params[ 'id_usuario' ] ) ) { // Si se van a borrar todas las imagenes

            $fotos_antiguas = $this->get_all ( $params );

            return $fotos_antiguas ? $fotos_antiguas : false;

        } else {

            $foto_antigua = $this->get ( $params )->foto;

            return $foto_antigua ? $foto_antigua : false;

        }

    }


}