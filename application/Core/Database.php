<?php

namespace Mini\Core;

use PDO;
use PDOException;

class Database
{
    private static $instancia = null;
    protected $dbh = null;

    private function __construct ()
    {
        $options = [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ];

        try {

            $this->dbh = new PDO( DB_TYPE . ':host=' . DB_HOST . ';dbname=' .
                DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options );

        } catch ( PDOException $e ) {
            exit( 'La base de datos no está accesible' );
        }
    }

    public static function getInstance ()
    {
        if ( is_null ( self::$instancia ) ) {
            self::$instancia = new Database();
        }

        return self::$instancia;
    }

    public function getDatabase ()
    {
        return $this->dbh;
    }
}