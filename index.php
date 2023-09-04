<?php

require 'vendor/autoload.php';

Flight::register('db','PDO',array('mysql:host=localhost;dbname=api','root',''),
  function($db){
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
);

flight::route('/',function(){
   
      include_once 'vendor/views/index.php';


});



Flight::route('GET /alumnos', function(){
   $sentencia =  Flight::db()->prepare("SELECT * FROM ALUMNOS");
   $sentencia->execute();
   $datos = $sentencia->fetchALL(PDO::FETCH_ASSOC);
   if($datos){
    $arreglo = array("estado"=>"200","datos"=>$datos);
    flight::json($arreglo);
  }else{
    $arreglo = array("estado"=>"400","alumno"=>'No hay alumnos');
    flight::json($arreglo);
  }
});

Flight::route('POST /alumnos', function(){

    $nombres = Flight::request()->data->nombres;
    $apellidos = Flight::request()->data->apellidos;

    $sql = "INSERT INTO ALUMNOS (nombres,apellidos) VALUES(:nombres,:apellidos)";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->execute(["nombres"=>$nombres,"apellidos"=>$apellidos]);

    $arreglo = array("estado"=>"200","datos"=>"Alumno registrado");
      flight::json($arreglo);
});

Flight::route('PUT /alumnos', function(){

  try{
    $id = Flight::request()->data->id;
    $nombres = Flight::request()->data->nombres;
    $apellidos = Flight::request()->data->apellidos;
    $sql = "UPDATE ALUMNOS SET nombres = :nombres, apellidos = :apellidos WHERE id = :id";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->execute(["nombres"=>$nombres,"apellidos"=>$apellidos,"id"=>$id]);
    if($sentencia->rowCount() > 0){
    $arreglo = array("estado"=>"200","datos"=>"Alumno Actualizado Correctamente","id"=>$id);
    flight::json($arreglo);
    }else{
      $arreglo = array("estado"=>"400","datos"=>"Alumno no actualizado correctamente");
      flight::json($arreglo);
    }
  }catch(PDOException $e){
    $arreglo = array("estado"=>"400","datos"=>"Hubo un problema al actualizar datos");
    flight::json($arreglo);
  }
 
});

Flight::route('DELETE /alumnos', function(){

  try{
    $id = Flight::request()->data->id;
    $sql = "DELETE FROM ALUMNOS WHERE id = :id";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->execute(["id"=>$id]);
    if($sentencia->rowCount() > 0){
    $arreglo = array("estado"=>"200","datos"=>"Alumno Eliminado Correctamente","id"=>$id);
    flight::json($arreglo);
    }else{
      $arreglo = array("estado"=>"400","datos"=>"Alumno no eliminado");
      flight::json($arreglo);
    }
  }catch(PDOException $e){
    $arreglo = array("estado"=>"400","datos"=>"Hubo un problema");
    flight::json($arreglo);
  }
 
});


Flight::route('GET /alumnos/@id', function($id){
  try{
    $sentencia =  Flight::db()->prepare("SELECT * FROM ALUMNOS WHERE id = $id ");
    $sentencia->execute();
    $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
    if($datos){
      $arreglo = array("estado"=>"200","datos"=>$datos);
      flight::json($arreglo);
    }else{
      $arreglo = array("estado"=>"400","el alumno no existe con el id"=>$id);
      flight::json($arreglo);
    }

  }catch(PDOException $e){
    $arreglo = array("estado"=>"400","no funciona el parametro"=>$id);
    flight::json($arreglo);
  }
  
 });

Flight::start();