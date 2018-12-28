<?php
/**
 * Created by PhpStorm.
 * User: daw17-15
 * Date: 22/11/18
 * Time: 17:07
 */
namespace Mini\Core;

use Mini\Model\Validacion;
use Mini\Model\Usuario;

class Controller
{
    protected $view;
    protected $user;
    protected $v;
    protected $data;

    public function __construct()
    {
        $this->view = TemplatesFactory::templates();
        Session::init();

        $this->user = new Usuario();
        $this->v = new Validacion();
        $this->data = [];
    }

    public function render ( $path, $params = null )
    {
        echo $params == null ? $this->view->render ( $path ) : $this->view->render ( $path, $params );
    }
}