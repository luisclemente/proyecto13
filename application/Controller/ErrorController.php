<?php

/**
 * Class Error
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Core\View;

class ErrorController extends Controller
{
    private $msg;

    public function __construct($msg = "")
    {
        parent::__construct();
        $this->msg = $msg;
    }

    public function index()
    {
        echo $this->view->render('error/index');
    }
}
