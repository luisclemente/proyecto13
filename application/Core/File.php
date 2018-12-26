<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 25/12/18
 * Time: 20:13
 */

namespace Mini\Core;


class File
{
    //public static $nom_img;

    /* public function __construct ()
     {

     }*/

    public static function setName ( $key )
    {
        //isset ($_FILES[''])
        $_FILES [ $key ][ 'name' ] = date ( 'Y-m-d H:i:s' ) . $_FILES [ $key ][ 'name' ];

    }

    public static function getName ( $key )
    {
        if ( isset( $_FILES[ $key ][ 'name' ] ) ) {
            return $_FILES[ $key ][ 'name' ];
        }

        return false;
    }

    public static function getType ( $key )
    {
        if ( isset( $_FILES[ $key ][ 'type' ] ) ) {
            return $_FILES[ $key ][ 'type' ];
        }

        return false;
    }


    public static function getErrors ( $key )
    {
        $error = $_FILES[ $key ][ 'error' ];

        if ( $error ) {

            switch ( $error ) {
                case 1:
                    return 'El tamaño del archivo excede lo permitido por el servidor';
                    break;
                case 2:
                    return 'El tamaño del archivo excede lo indicado en el formulario';
                    break;
                case 3:
                    return 'El envio de archivo se interrumpió: Archivo corrupto';
                    break;
                case 4:
                    return 'No se ha seleccionado ningún archivo';
                    break;
            }

        } else return true;

    }

    public static function upFile ( $key )
    {
        if ( $_FILES[ $key ][ 'name' ] != '' ) {

            self::setName ( $key );

            $errors = self::getErrors ( $key );
            $nom_img = self::getName ( $key );

            if ( $nom_img ) {

                if ( ! $errors == 1 ) echo 'Error -> ' . $errors;

                else {

                    if ( ! strcmp ( explode ( "/", self::getType ( $key ) )[ 0 ], "image" ) ) {

                        $carpeta_destino = $_SERVER[ 'DOCUMENT_ROOT' ] . '/imgs/';
                        $fichero_subido = $carpeta_destino . $nom_img;

                        return move_uploaded_file ( $_FILES[ $key ][ 'tmp_name' ], $fichero_subido ) ?
                            $nom_img : false;

                    } else {

                        echo ( 'Solo se pueden subir imagenes de tipo jpg, jpeg, png, gif ' );
                    }
                }
            }

        } else return null;


    }


}