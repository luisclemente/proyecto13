<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 4/12/18
 * Time: 19:52
 */

namespace Mini\Model;

use Mini\Core\Database;

class Conexion1 extends Database
{

    public $dbh;

    public function __construct ()
    {
        $this->dbh = parent::getInstance ()->getDatabase ();

    }

    public function all ( $limit = 10 )
    {
        $stmt = $this->dbh->prepare ( 'SELECT * FROM ' . $this->table . ' LIMIT ' . $limit );

        $stmt->execute ();

      //  $this->setQuery ( $stmt );

        return $stmt->fetchAll ();
    }

    public function insert ( $params )
    {
        if ( ! empty( $params ) ) {  // empty() es true si el valor es null

            //var_dump ($params);

            $fields = '(' . implode ( ',', array_keys ( $params ) ) . ')';
            $values = "(:" . implode ( ",:", array_keys ( $params ) ) . ")";

            $sql = 'INSERT INTO ' . $this->table . ' ' . $fields . ' VALUES ' . $values;

            $stmt = $this->dbh->prepare ( $sql );

            $stmt->execute ( $this->normalizePrepareArray ( $params ) );

          //  $this->setQuery ( $stmt );

            return $this->dbh->lastInsertId ();

        } else {

            return false;
            //throw new Exception( 'Los parámetros están vacíos' );
        }
    }

  /*  public function setQuery ( $sql )
    {
        if ( $this->modeDEV ) $sql->debugDumpParams ();
    }

    public function lastQuery ()
    {
        return $this->lastQuery;
    }*/

    private function normalizePrepareArray ( $params )
    {
        foreach ( $params as $key => $value ) {

            $params[ ':' . $key ] = $value;
            unset( $params[ $key ] );
        }

        return $params;
    }

    public function update ( $params, $where )
    {
        if ( ! empty( $params ) ) {

            $fields = '';

            foreach ( $params as $key => $value ) {

                $fields .= $key . ' = :' . $key . ',';
            }

            $fields = rtrim ( $fields, ',' );

            $key = key ( $where );

            $value = $where[ $key ];

            $sql = 'UPDATE ' . $this->table . ' SET ' . $fields . ' WHERE ' . $key . '=' . $value;

            var_dump ( $sql );

            $stmt = $this->dbh->prepare ( $sql );

            $stmt->execute ( $this->normalizePrepareArray ( $params ) );

           // $this->setQuery ( $stmt );

        } else {

            throw new Exception( 'Los parámetros están vacíos' );
        }
    }

    public function delete ( $param = null )
    {
        if ( $param != null ) {

            if ( ! empty( $param ) ) {

                $key = key ( $param );

                $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . '= :' . $key;

                $stmt = $this->dbh->prepare ( $sql );

                $stmt->execute ( $this->normalizePrepareArray ( $param ) );

              //  $this->setQuery ( $stmt );

            } else {

                throw new Exception( 'Los parámetros están vacíos' );
            }

        } else {

            $sql = 'DELETE FROM ' . $this->table;

            $stmt = $this->dbh->prepare ( $sql );

            $stmt->execute ();

          //  $this->setQuery ( $stmt );

        }

    }

    public function get ( $params )
    {
        if ( ! empty( $params ) ) {

            if ( count ( $params ) === 1 ) {

                $key = key ( $params );

                $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . '= :' . $key;

                $stmt = $this->dbh->prepare ( $sql );

                $stmt->execute ( $this->normalizePrepareArray ( $params ) );

              //  $this->setQuery ( $stmt );

                return $stmt->fetch ();

            } elseif ( count ( $params ) === 2 ) {

                $key1 = array_keys ( $params )[ 0 ];
                $key2 = array_keys ( $params )[ 1 ];

                $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key1 . '= :' . $key1 . ' AND ' . $key2 . '= :' . $key2;

                $stmt = $this->dbh->prepare ( $sql );

                $stmt->execute ( $this->normalizePrepareArray ( $params ) );

             //   $this->setQuery ( $stmt );

                return $stmt->fetch ();
            }

        } else {

            throw new Exception( 'Los parámetros están vacíos' );
        }
    }

    public function get_all ( $params = null )
    {
        if ( $params !== null ) {

            if ( ! empty( $params ) ) {

                if ( count ( $params ) === 1 ) {

                    $key = key ( $params );

                    $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . '= :' . $key;

                    $stmt = $this->dbh->prepare ( $sql );

                    $stmt->execute ( $this->normalizePrepareArray ( $params ) );

                  //  $this->setQuery ( $stmt );

                    return $stmt->fetchAll ();

                } elseif ( count ( $params ) === 2 ) {

                    $key1 = array_keys ( $params )[ 0 ];
                    $key2 = array_keys ( $params )[ 1 ];

                    $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key1 . '= :' . $key1 . ' AND ' . $key2 . '= :' . $key2;

                    $stmt = $this->dbh->prepare ( $sql );

                    $stmt->execute ( $this->normalizePrepareArray ( $params ) );

                  //  $this->setQuery ( $stmt );

                    return $stmt->fetchAll ();
                }

            } else {

                throw new Exception( 'Los parámetros están vacíos' );
            }

        } else {

            $stmt = $this->dbh->prepare ( 'SELECT * FROM ' . $this->table );

            $stmt->execute ();

          //  $this->setQuery ( $stmt );

            return $stmt->fetchAll ();
        }
    }

    public function getId ( $id )
    {
        $stmt = $this->dbh->prepare ( "SELECT * FROM $this->table WHERE id = $id" );

        $stmt->execute ();
     //   $this->setQuery ( $stmt );
        return $stmt->fetchAll ();
    }

    public function setTransaction ()
    {
        return $this->dbh->beginTransaction ();
    }

    public function endTransaction ()
    {
        return $this->dbh->commit ();
    }

    public function cancelTransaction ()
    {
        return $this->dbh->rollBack ();
    }
}