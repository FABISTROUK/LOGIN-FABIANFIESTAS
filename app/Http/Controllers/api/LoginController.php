<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class LoginController extends Controller
{
    public function registrar(Request $request)
    {
        try {
            $nombres = $request->input('nombres');
            $correo = $request->input('correo');
            $passwordd = $request->input('passwordd');

            DB::select('call sp_Usuario_Guardar(?, ?, ?)', [$nombres, $correo, $passwordd]);

            return response()->json([
                'success' => true, 
                'message' => 'Usuario registrado correctamente'
            ], 200);

        } catch (Exception $e) {
            // Esto atrapará el error real de MySQL y te lo mostrará en pantalla
            return response()->json([
                'success' => false,
                'error_sql' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $usuario = DB::selectOne('call sp_Usuario_Login(?, ?)', [$request->input('correo'), $request->input('passwordd')]);
        return $usuario ? response()->json(['success' => true, 'data' => $usuario]) : response()->json(['success' => false], 401);
    }

    public function recuperar(Request $request)
    {
        $codigo = (string) rand(100000, 999999);
        DB::select('call sp_Usuario_Codigo(?, ?)', [$request->input('correo'), $codigo]);
        return response()->json(['success' => true, 'codigo_generado' => $codigo]);
    }

    public function validar(Request $request)
    {
        $validacion = DB::selectOne('call sp_Usuario_Validar(?, ?)', [$request->input('correo'), $request->input('codigo')]);
        return $validacion ? response()->json(['success' => true]) : response()->json(['success' => false], 401);
    }

    public function actualizarPassword(Request $request)
    {
        DB::select('call sp_Usuario_UpdatePasswordd(?, ?)', [$request->input('correo'), $request->input('passwordd')]);
        return response()->json(['success' => true]);
    }
}