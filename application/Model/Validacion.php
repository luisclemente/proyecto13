<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 4/12/18
 * Time: 19:13
 */

namespace Mini\Model;


use Mini\Model\Conexion1;

class Validacion extends Conexion1
{
    public $errores = [];

    public $table = 'usuarios';

    public function mostrar_campo ( $campo )
    {
        if ( isset( $_POST[ $campo ] ) ) {
            echo ' value="' . $_POST[ $campo ] . '"';
        }
    }

    public function mostrar_error_campo ( $campo, $errores )
    {
        if ( isset( $errores[ $campo ] ) ) {
            echo '<span class="errorf">' . $errores[ $campo ] . '</span>';
        }
    }

    public function nombreValido ( $nombre )
    {
        return preg_match ( '/^([A-ZÁÉÍÓÚ]{1}[A-Za-zñáéíóú]{2,}[\sdel]*[-]?)+$/', $nombre );
    }

    public function apellidoValido ( $apellido )
    {
        return preg_match ( '/^([A-ZÁÉÍÓÚ]{1}[\']?[a-zñáéíóú]{2,}[\sdelasy]*[-]?)+$/', $apellido );
        //return true;
    }

    public function nicknameValido ( $nick )
    {
        return preg_match ( '/([A-ZÁÉÍÓÚa-zñáéíóú@#&%,\.\-\*\d][\s]*){3,20}$/', $nick );
    }

    private function sanitizeEmail ( $data )
    {
        return filter_var ( $data, FILTER_SANITIZE_EMAIL );
    }

    private function validateEmail ( $data )
    {
        return filter_var ( $data, FILTER_VALIDATE_EMAIL );
    }

    private function checkEmail ( $data )
    {
        return checkdnsrr ( explode ( '@', $data )[ 1 ], 'MX' );
    }

    private function emailValido ( $email )
    {
        $email = $this->sanitizeEmail ( $email );
        $email = $this->validateEmail ( $email );

        return $this->checkEmail ( $email ) ? $email : false;
    }

    private function passwordValido ( $password )
    {
       // return preg_match ( '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]){6,}/', $password );
        return true;
    }

    private function rolValido ( $rol )
    {

        return true;
    }

    public function filtrar ( $datos )
    {
        $datos = trim ( $datos );
        $datos = addslashes ( $datos );
        $datos = htmlspecialchars ( $datos );
        return $datos;
    }

    public function validaIsset ( $data )
    {
        $data_filtrado = $this->filtrar ( $data );

        return ! isset( $data ) || empty( $data_filtrado ) || $data_filtrado == '-' ? false : $data_filtrado;
    }

    private function duplicateEmail ( $email )
    {
        $this->table = 'usuarios';

        $registro = $this->get ( [ 'email' => $email ] );

        return $registro ? true : false;

    }

    private function duplicateNick ( $nick )
    {
       // $this->table = 'usuarios';

        $registro = $this->get ( [ 'nickname' => $nick ] );

        return $registro ? true : false;

    }

    public function validar_registro ( &$data_register, &$params )
    {
        $claveuno = '';

        foreach ( $data_register as $key => $value ) {

            $data_register[ $key ] = $this->validaIsset ( $value );

            if ( ! $data_register[ $key ] ) $params [ $key ] = 'No hemos recibido ' . $key;

            else {

                switch ( $key ) {

                    case 'nombre':
                        if ( ! $this->nombreValido ( $value ) )
                            $params[ $key ] = 'El nombre debe tener al menos tres letras y empezar en mayúsculas';
                        break;

                    case 'apellido':
                        if ( ! $this->apellidoValido ( $value ) )
                            $params[ $key ] = 'El apellido debe tener al menos tres letras y empezar en mayúsculas';
                        break;

                    case 'nickname':
                        if ( ! $this->nicknameValido ( $value ) )
                            $params[ $key ] = 'Mínimo 3 caracteres, puede tener letras, números y caracteres no alfanuméricos';
                        elseif ( $this->duplicateNick ( $value ) )
                            $params[ $key ] = 'Nick ya existe';
                        break;

                    case 'email':
                        if ( ! $this->emailValido ( $value ) )
                            $params[ $key ] = 'El email no es válido';
                        elseif ( $this->duplicateEmail ( $value ) )
                            $params[ $key ] = 'Email ya existe, introduce otro email o dirígete al
                                                                    <a href="../login/login_form.php">login</a>';
                        else $data_register[ $key ] = $value;
                        break;

                    case 'clave':
                        $claveuno = $value;
                        if ( ! $this->passwordValido ( $value ) )
                            $params[ $key ] = 'La clave de seis caracteres mínimo, debe tener al menos una letra 
                                        mayúscula, una minúscula, un número y un carácter no alfanumérico';
                        break;

                    case 'confirmacion':
                        if ( $claveuno !== $value )
                            $params[ $key ] = 'Las claves tienen que ser iguales';
                        break;

                    case 'rol':
                        if ( ! $this->rolValido ( $value ) )
                            $params[ $key ] = 'Rol no es correcto';
                        break;

                }
            }
        }
    }

    public function valida_data ( &$data, &$params )
    {
        foreach ( $data as $key => $value ) {

            $data[ $key ] = $this->validaIsset ( $value );

            if ( ! $data[ $key ] ) $params [ $key ] = 'No hemos recibido ' . $key;
        }
    }

    public function dniValido ( $dni )
    {
        $formatoValido = preg_match ( '/^\d{8}-?[a-zA-Z]{1}/', $dni );

        if ( $formatoValido === 1 ) {

            $dni_ok = $this->dniCorrecto ( $dni );

            return $dni_ok ? true : false;

        } else {

            return false;
        }

    }

    public function dniCorrecto ( $dni )
    {
        $letras = [ 'T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N',
            'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E', 'T' ];

        if ( substr ( $dni, -2, 1 ) === '-' ) {

            $letra = explode ( '-', $dni )[ 1 ];
            $dni = explode ( '-', $dni )[ 0 ];

        } else {

            $letra = substr ( $dni, 8 );
            $dni = substr ( $dni, 0, -1 );
        }

        $letraDNI = $dni % 23;

        return $letras [ $letraDNI ] === $letra ? true : false;

    }

    public function edadValida ( $edad )
    {
        $opciones = array (

            'options' => array (

                'min_range' => 1,
                'max_range' => 150
            )
        );

        return filter_var ( $edad, FILTER_VALIDATE_INT, $opciones );

    }

    public function telefonoValido ( $telefono )
    {
        $phone = filter_var ( $telefono, FILTER_SANITIZE_NUMBER_INT );
        $phone = filter_var ( $phone, FILTER_VALIDATE_INT );

        return preg_match ( '/^[96][\d]{7,8}$/', $phone );
    }

    public function urlValida ( $URL )
    {
        $url = filter_var ( $URL, FILTER_SANITIZE_URL );
        return filter_var ( $url, FILTER_VALIDATE_URL );
    }

    public function direccionValida ( $direccion )
    {

        return preg_match ( '/^([A-ZÁÉÍÓÚ0-9]{1}[\']?[a-zñáéíóú\/º\.0-9]*[\s]*[-]?)+$/', $direccion );
    }

    public function codigoPostalValido ( $cp )
    {
        $cpostal = filter_var ( $cp, FILTER_VALIDATE_INT );

        return preg_match ( '/^[0-5]{1}[0-9]{4}/', $cpostal );
    }

    public function ciudadValida ( $ciudad )
    {
        $city = filter_var ( $ciudad, FILTER_SANITIZE_STRING ); // Elimina las comillas simples

        return preg_match_all ( '/^([A-ZÁÉÍÓÚ]{1}[A-Za-zñáéíóú]{2,}[\s]*[-]?)+$/', $city );
    }


}

/*(?=.*[@#&%,\.\-\*])[\w@#&%$=,\.\-\*]*/