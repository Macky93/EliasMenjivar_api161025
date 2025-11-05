<?php
require("classes/estudiante.class.php");
$Estudiante = new Estudiante();

if($_SERVER["REQUEST_METHOD"]=="GET"){
    $tipo_peticion = ( isset($_Get["t"]) ? ($_GET["t"]) : null );

    if($tipo_peticion=="selectAll"){
        $resultado = $Estudiante->obtenerEstudiante();
    }else{
        $resultado = [];
    }
}elseif($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["fnac"]) and isset($_POST["idg"])){
        $resultado = $Estudiante->nuevoEstudiante($_POST["fnac"],$_POST["idg"]);

    }else{
        header('HTTP/1.1 400 Bad Request');
        $resultado = array("Mensaje"=>"Parametros no enviados");
    }
}


//$resultado = $Estudiante->obtenerEstudiantes();

header("Content-Type: Application/json");
echo(json_encode($resultado));

?>