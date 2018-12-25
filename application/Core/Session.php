<?php
/**
 * Created by PhpStorm.
 * User: daw17-15
 * Date: 20/11/18
 * Time: 16:46
 */

namespace Mini\Core;

class Session
{
    public static function init ()
    {
        if ( session_id () == "" ) {
            session_start ();
        }
    }

    public static function set ( $key, $value )
    {
        $_SESSION[ $key ] = $value;
    }

    public static function get ( $key )
    {
        if ( isset( $_SESSION[ $key ] ) ) {
            return $_SESSION[ $key ];
        }
    }

    public static function add ( $key, $value )
    {
        $_SESSION[ $key ][] = $value;
    }

    public static function destroy ()
    {
        session_destroy ();
    }

    public static function userIsLoggedIn ()
    {
        return ( Session::get ( 'user_logged_in' ) );
    }
}