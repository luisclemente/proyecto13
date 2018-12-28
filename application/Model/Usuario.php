<?php

namespace Mini\Model;

use Mini\Model\Conexion1;


class Usuario extends Conexion1
{
    //public $table = 'usuarios';
    public $table = 'categorias';

    public function insert ( $params )
    {
        return parent::insert ( $this->validateParams ( $params ) );
    }

    private function validateParams ( $params )
    {
        if ( ! $params ) return null;

        else {

            $params [ 'clave' ] = $this->codificaClave ( $params[ 'clave' ] );

            return $params;
        }
    }

    public function codificaClave ( $clave )
    {
        return md5 ( $clave );
    }

    public function getRol ($id_usuario) {

        $sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario AND rol = 'jefe'";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function logIn ($data_login)
    {
        $sql = "SELECT * FROM usuarios WHERE email= :email AND clave= :clave";

        $stmt = $this->dbh->prepare($sql);

        $stmt->execute (array(":email" => $data_login['email'],
            ":clave" => $data_login['clave']));

        echo $stmt->rowCount() ? 'Usuario existe' : 'Usuario no existe';

    }
}