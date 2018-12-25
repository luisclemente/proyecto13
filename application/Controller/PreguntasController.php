<?php
namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Model\Pregunta;
use Mini\Core\View;
use Mini\Core\Session;

class PreguntasController extends Controller
{
    private $titulo;

    public function __construct()
    {
        parent::__construct();
        $this->titulo = 'Preguntas';
    }

    public function todas()
    {
        $pregunta = new Pregunta();

        $preguntas = $pregunta->getAll();

        echo $this->view->render('/preguntas/todas',['preguntas'=>$preguntas,'titulo'=>$this->titulo]);
    }

    public function crear()
    {
        if (!$_POST){
            echo $this->view->render('preguntas/formulariopregunta');
        } else {
            $errores = [];
            if (!isset($_POST['asunto'])){
                $errores['asunto'] = 'El campo asunto no puede estar vacio';
                $_POST['asunto'] = "";
            }

            if(!isset($_POST['cuerpo'])){
                $errores['cuerpo'] = 'El campo cuerpo no puede estar vacio';
                $_POST['cuerpo'] = "";
            }

            $datos = ['asunto'=>$_POST['asunto'],'cuerpo'=>$_POST['cuerpo']];

            if(Pregunta::insert($datos)){
                echo $this->view->render('preguntas/preguntainsertada');
            } else {
                echo $this->view->render('preguntas/formulariopregunta', ['errores'=> $errores, 'datos'=> $_POST]);
            }
        }
    }

    public function editar($id = 0)
    {
        if(!$_POST){
            $pregunta = Pregunta::getId($id);
            if($pregunta){
                echo $this->view->render('preguntas/formulariopregunta', ['accion'=> 'editar', 'datos'=> get_object_vars($pregunta)]);
            } else {
                header('Location: /preguntas/todas');
            }
        } else {
            $datos = ['id' =>  (isset($_POST['id'])) ? $_POST['id'] : 0, 'asunto' => (isset($_POST['asunto'])) ? $_POST['asunto'] : '','cuerpo' => (isset($_POST['cuerpo'])) ? $_POST['cuerpo'] : ''];

            if(Pregunta::edit($datos)){
                header('Location: /preguntas/todas');
            } else {
                echo $this->view->render('preguntas/formulariopregunta', ['errores' => ['El error al editar'], 'accion'=> 'editar', 'datos'=> $_POST]);
            }
        }
    }
}