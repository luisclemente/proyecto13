<?php
/**
 * Created by PhpStorm.
 * User: daw17-15
 * Date: 9/11/18
 * Time: 19:08
 */
namespace Mini\Controller;

class EjemploController
{

    public function index()
    {
        echo 'Estoy en el controlador de ejemplo';
    }

    public function acercade()
    {
        echo 'Somos el curso de 2º DAW del Ingeniero';
        d($this);
    }

}