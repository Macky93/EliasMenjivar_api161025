<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zona;

class ZonaController extends Controller
{
    
      //Metodo Obtener zonas Plural//
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
            $valores = $Zona->where('id_zona',$idzona)->get();

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

      //Metodo Obtener zonaPais//

    public function obtenerZonaPais(int $idpais = 0){
        
        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        if($idpais > 0){
            //El prametro de $idpis es mayor que cero
            $Zona = new Zona();
            $valores = $Zona->where('id_pais',$idpais)->get();

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
            //No se ha enviado un valor para el parametro $idpais
            $satisfactorio = false;
            $estado = 400;
            $mensaje = "No se ha enviado el Parametro Obligatorio";
            $errores = [
                "code" => 400,
                "msg" => "El identificador del pais esta vacio"
            ];
        }//if($idpais > 0)

        //Se crea variable de salida
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

    public function crearZona(Request $request){

        $satisfactorio = false;
                $estado = 0;
                $mensaje = "";
                $errores = [];
                $valores = [];
                //Validacion de datos de entrada de los parametros
                $validacion = $request->validate([
                    "idpais" =>"required|integer|gt:0",
                    "nombrezona"=>"required|max:50"
                ]);

                $Zona = new Zona();

                $Zona->id_pais = $request->idpais;
                //-----^(BD) ----------------^(Campo de form)
                $Zona->nombre_zona = $request->nombrezona;
                //-----^(BD) -------------------- ^(Campo de form)
                $insertado = $Zona->save();// Se hace insert a la base de datos

                if($insertado){
                    $ultimoinsertado = $Zona->id_zona;
                    $datosinsertados = $this->obtenerZona($ultimoinsertado);

                    $satisfactorio = true;
            $estado = 200;
            $mensaje = "Se guardaron los datos corectamente";
            $errores = [
                "code" => 200,
                "msg" => ""
            ];

        }else{
            $satisfactorio = false;
            $estado = 500;
            $mensaje = "Hubo un problema al guardar los datos";
            $errores = [
                "code" => 500,
                "msg" => "No se pudo hacer insert a la tabla Zona"
            ];

        }

        //Se crea la variable de salida
        $respuesta = [
            "success"=> $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $datosinsertados->original["data"][0],
            "errors"=> $errores,
            "total" => $datosinsertados->original["total"]
            //""total"=>sizeof($valores)
        ];

        //Se muestra el mensaje al usuario

        return response()->json($respuesta,$estado);

    }

        public function nuevoUsuario(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        $token = $usuario->createToken('token_personal')->plainTextToken;

        return response()->json([
            "success" => true,
            "status" => 201,
            "msg" => "Usuario creado exitosamente",
            "data" => [
                "user" => $usuario,
                "token" => $token
            ]
        ], 201);
    }

    /**
     * POST /login
     * Autentica un usuario y devuelve su token Sanctum.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = User::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                "success" => false,
                "status" => 401,
                "msg" => "Credenciales incorrectas",
                "errors" => ["code" => 401, "msg" => "Email o contraseña inválidos"]
            ], 401);
        }

        $token = $usuario->createToken('token_personal')->plainTextToken;

        return response()->json([
            "success" => true,
            "status" => 200,
            "msg" => "Inicio de sesión exitoso",
            "data" => [
                "user" => $usuario,
                "token" => $token
            ]
        ], 200);
    }

    /**
     * GET /usuario
     * Devuelve los datos del usuario autenticado (requiere token Sanctum).
     */
    public function usuario(Request $request)
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "msg" => "Usuario autenticado",
            "data" => $request->user()
        ]);
    }
}
