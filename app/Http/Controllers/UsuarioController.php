<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use Illuminate\Support\Facades\Log;



class UsuarioController extends Controller
{
    public function comprobarCredenciales(Request $request)
    {

        $email = $request->input('email');
        $contrasena = $request->input('contrasena');

        $serviceUrl = env('API_USUARIO_URL');

        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];

        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);
    
            $result = $client->ObtenerUsuarioAutenticacion(['email' => $email, 'contrasena' => $contrasena]);
    
            if (isset($result->ObtenerUsuarioAutenticacionResult->numeroDocumento)) {
                $numeroDocumento = $result->ObtenerUsuarioAutenticacionResult->numeroDocumento;
                //session_start();
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['usuario'] = $numeroDocumento;
                return $numeroDocumento;
            } else {
                throw new Exception("No se pudo obtener el número de documento");
            }
        } catch (\SoapFault $e) {
            throw new Exception("Error en la solicitud SOAP: " . $e->getMessage());
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function crearUsuario(Request $request)
    {
        $nuevoUsuario = [
            'numeroDocumento' => $request->input('numeroDocumento'),
            'tipoDocumento' => $request->input('tipoDocumento'),
            'primerNombre' => $request->input('primerNombre'),
            'segundoNombre' => $request->input('segundoNombre'),
            'apellidoPaterno' => $request->input('apellidoPaterno'),
            'apellidoMaterno' => $request->input('apellidoMaterno'),
            'fechaNacimiento' => $request->input('fechaNacimiento'),
            'genero' => $request->input('genero'),
            'email' => $request->input('correoElectronico'),
            'contrasena' => $request->input('contrasena'),
        ];
        
        $serviceUrl = env('API_USUARIO_URL');

        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];

        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);

            $result = $client->AgregarUsuario(['usuario' => $nuevoUsuario]);

            return $result;
        } catch (\SoapFault $e) {
            return $result;
        }
    }


}
