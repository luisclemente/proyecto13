<?php
namespace Mini\Controller;
use Mini\Model\Song;
use Mini\Core\View;
class CancionesController
{
    private $view = null;
    private $titulo;
    public function __construct()
    {
        $this->view = new View;
        $this->titulo = 'Canciones';
    }
    public function index()
    {
        $this->view->render('canciones/index', [
            'titulo' => $this->titulo
        ]);
    }
    public function listar()
    {
        $cancion = new Song();
        $canciones = $cancion->getAllSongs();
        $this->view->render('canciones/listar', [
            'titulo' => 'Listado de Canciones',
            'canciones' => $canciones
        ]);
    }
    public function ver($id = 0)
    {
        $id = (int) $id;
        if ( $id == 0 ) {
            header("location: /canciones/listar");
        } else {
            $cancion = new Song();
            $detalles = $cancion->getSong($id);
            $this->view->render('canciones/ver', [
                'titulo' => 'Detalles',
                'detalles' => $detalles
            ]);
        }
    }
}