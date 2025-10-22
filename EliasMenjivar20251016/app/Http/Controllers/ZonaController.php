<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zonas;

class ZonaController extends Controller
{
    //
    public function obtenerZonas(){
        $Zona = new Zona();


        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        $valores = $Zona::all();

        //VERIFICACION DE EXISTENCIA DE DATOS//
        if(!empty($valores)){
            //Si se encuentran Datos
            $satisfactorio = true;
            $estado = 200;
            $mensaje = "Valores Encontrados";
            $errores = [
                "code" => 200,
                "msg" => ""
            ];
        }
        else{
            //No se encuentran Datos
            $satisfactorio = false;
            $estado = 404;
            $mensaje = "No se Encontraron Valores";
            $errores = [
                "code" => 404,
                "msg" => "Datos No Encontrados"
            ];
        }

        //VARIABLE DE SALIDA
        $respuesta = [
            "success"=> $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $valores,
            "errors"=> $errores,
            "total" => sizeof($valores)
        ];
        //SE RETORNA EL MENSAJE AL USUARIO
        return response()->json($respuesta,$estado);
    }

    public function obtenerZona(int $idzona = 0){
        
        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        if($idzona > 0){
            $Zona = new Zona();
            $valores = $Zona->where('id_zona',$id_zona)->get();

                //VERIFICACION DE EXISTENCIA DE DATOS//
            if(!empty($valores)){
                //Si se encuentran Datos
                $satisfactorio = true;
                $estado = 200;
                $mensaje = "Valores Encontrados";
                $errores = [
                    "code" => 200,
                    "msg" => ""
                ];
            }
            else{
                //No se encuentran Datos
                $satisfactorio = false;
                $estado = 404;
                $mensaje = "No se Encontraron Valores";
                $errores = [
                    "code" => 404,
                    "msg" => "Datos No Encontrados"
                ];
            }
        }else{
            //No se ha enviado un valor para el parametro $idzona
            $satisfactorio = false;
            $estado = 400;
            $mensaje = "No se ha enviado el Parametro Obligatorio";
            $errores = [
                "code" => 400,
                "msg" => "El identificador de la Zona esta vacio"
            ];
        }

        //Variable de Salida
        $respuesta = [
            "success"=> $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $valores,
            "errors"=> $errores,
            "total" => sizeof($valores)
        ];

        return response()->json($respuesta,$estado);
    }
}