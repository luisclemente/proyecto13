<?php
/**
 * Created by PhpStorm.
 * User: daw17-15
 * Date: 22/11/18
 * Time: 17:07
 */
namespace Mini\Core;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = TemplatesFactory::templates();
        Session::init();
    }
}