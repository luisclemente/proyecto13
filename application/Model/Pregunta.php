<?php


namespace Mini\Model;

Use Mini\Core\Database;

Class Pregunta
{
    public function getAll()
    {
        $conn = Database::getInstance()->getDatabase();

        $sql = 'select * from preguntas';

        $query = $conn->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public static function insert($datos)
    {
        $conn = Database::getInstance()->getDatabase();

        $errores_validacion = false;


        foreach ($datos as $index => $dato) {
            if(empty($datos[$index])){
                Session::add('feedback_negative', "No he recibido el campo $index");
                $errores_validaciones = true;
            }
        }

        /*if(empty($datos['asunto'])){
            $errores_validaciones['asunto'] = 'El campo asunto está vacio o no existe';
        }

        if(empty($datos['cuerpo'])){
            $errores_validacion['cuerpo'] = 'El campo cuerpo está vacio o no existe';
        }*/

        if($errores_validacion){
            return false;
        }

        $columnas = "";
        $valores = "";

        foreach ($datos as $key => $value) {
            $columnas .= "$key,";
        }


        foreach ($datos as $key => $value) {
            $valores .= ":$key,";
        }

        $columnas = trim($columnas, ',');
        $valores = trim($valores,',');

        $prepared = $conn->prepare("insert into preguntas($columnas)values($valores)");

        foreach ($datos as $key => $value) {
            $datos[':'.$key] = $value;
            unset($datos[$key]);
        }

        $prepared->execute($datos);

        //return $prepared;

        if ($prepared->rowCount() == 1){
            return $conn->lastInsertId();
        }

        return false;
    }

    public static function getId($id)
    {
        $conn = Database::getInstance()->getDatabase();

        $id = (int)$id;

        if($id == 0){
            return false;
        }

        $sql = "select * from preguntas where id = :id";

        $query = $conn->prepare($sql);

        $query->execute(array(':id'=>$id));

        return $query->fetch();
    }

    public static function edit($datos)
    {
        $conn = Database::getInstance()->getDatabase();

        $errores_validacion = false;


        foreach ($datos as $index => $dato) {
            if(empty($datos[$index])){
                Session::add('feedback_negative', "No he recibido el campo $index");
                $errores_validaciones = true;
            }
        }


        if($errores_validacion){
            return false;
        } else {

            $datos['id'] = (int) $datos['id'];
            $sql = "update preguntas set asunto = :asunto, cuerpo = :cuerpo where id = :id";
            $query = $conn->prepare($sql);

            $params = [':asunto'=>$datos['asunto'],':cuerpo'=>$datos['cuerpo'],':id'=>$datos['id']];

            $query->execute($params);

            //$count = $query->rowCount();

            if ($conn !== false){
                return true;
            } else {
                return false;
            }
        }
    }

}