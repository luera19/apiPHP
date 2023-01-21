<?php

//Framework
require 'flight/Flight.php';

//Conexión a BD

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api','root',''));

//Inicio
Flight::route('/', function(){
    Flight::jsonp(["API DE ALUMNOS"]);
});


//Lee los datos por medio de GET
Flight::route('GET /alumnos', function () {
    $sentencia =Flight::db()->prepare("SELECT * FROM `alumnos`");
    $sentencia ->execute();
    $datos = $sentencia ->fetchAll();
    Flight::json($datos);
});


//Recepciona datos por método POST
Flight::route('POST /alumnos', function () {
    $nombres =(Flight::request()->data->nombres);
    $apellidos =(Flight::request()->data->apellidos);

    //Consulta SQL
    $sql="INSERT INTO alumnos(nombres, apellidos) VALUES (?,?)";
    $sentencia =Flight::db()->prepare($sql);
    $sentencia -> bindParam(1,$nombres);
    $sentencia -> bindParam(2,$apellidos);
    $sentencia ->execute();

    Flight::jsonp(["Alumno Agregado"]);
});

//Borrar registro (DELETE)
Flight::route('DELETE /alumnos', function () {
    $id=(Flight::request()->data->id);

    //Consulta SQL
    $sql="DELETE FROM alumnos WHERE id=?";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$id);
    $sentencia->execute();

    Flight::jsonp(["Alumno Borrado"]);
});

//Actualizar registro (PUT)
Flight::route('PUT /alumnos', function () {

    $id=(Flight::request()->data->id);
    $nombres=(Flight::request()->data->nombres);
    $apellidos=(Flight::request()->data->apellidos);

    //Consulta SQL
    $sql="UPDATE alumnos SET nombres=? ,apellidos=? WHERE id=?";
    $sentencia= Flight::db()->prepare($sql);
    
    //Actualizo los datos
    $sentencia->bindParam(1,$nombres);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->bindParam(3,$id);

    $sentencia->execute();
    Flight::jsonp(["Alumno modificado"]);

});

//Consultar un registro determinado
Flight::route('GET /alumnos/@id', function ($id) {
    
    //Sentencia SQL    
    $sentencia= Flight::db()->prepare("SELECT * FROM `alumnos` WHERE id=?");
    
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    Flight::json($datos);
});

Flight::start();


