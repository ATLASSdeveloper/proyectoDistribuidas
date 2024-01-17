<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
            
use Exception;

class AsientoController extends Controller
{
    public function ObtenerInformacionAsientos($idVuelo){

        if(!$this->verificarLogin()){
            return redirect('/');
        }

        $serviceUrl = env('API_ASIENTO_URL');
    
        //session_start();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['vuelo'] = $idVuelo;
    
        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];
    
        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);
    
            $result = $client->ObtenerInformacionVueloAsientos(['id_vuelo' => $idVuelo]);
    
            return view('asientos', compact('result'));
        } catch (\SoapFault $e) {
            return view('home');
        }
    
    }

    public function GenerarReserva(Request $respuesta){
        $serviceUrl = env('API_ASIENTO_URL');
    
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        $usuario = $_SESSION['usuario'];
        $asiento = $respuesta->input("asiento");
        $asiento = intval($asiento);
        $valor = 0;
        $reserva = [
            'id_detalle_vuelo' => $asiento,
            'id_reserva' => $valor, 'persona_reserva' => $usuario,
            'persona_reserva' => $usuario,
        ];
        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];

        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);
    
            $result = $client->ActualizarReserva(['reserva' => $reserva]);
    
            return $result;
        
        } catch (\SoapFault $e) {
            throw new Exception("Error en la solicitud SOAP: " . $e->getMessage());
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    

    public function ObtenerInformacionReservas(){
        if(!$this->verificarLogin()){
            return redirect('/');
        }
        $serviceUrl = env('API_ASIENTO_URL');
    
        //session_start();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $usuario = $_SESSION['usuario'];

        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];
    
        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);
    
            $result = $client->ObtenerDetallesVueloPorPersonaReserva(['persona_documento' => $usuario]);
            return view('reservas', compact('result'));
        } catch (\SoapFault $e) {
            return view('home');
        }
    

        return view('reservas');
    
    }

    public function EliminarReserva(Request $respuesta){
        $serviceUrl = env('API_ASIENTO_URL');
    
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        $reserva = $respuesta->input("reserva");
        $reserva = intval($reserva);

        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];

        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);
    
            $result = $client->EliminarReserva(['id_reserva' => $reserva]);
    
            return $result;
        
        } catch (\SoapFault $e) {
            throw new Exception("Error en la solicitud SOAP: " . $e->getMessage());
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function EstablecerParametros(Request $respuesta){
        //session_start();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['asiento_old']= $respuesta->input("asiento_old");
        $_SESSION['reserva'] = $respuesta->input("reserva");
    }

    public function ObtenerInformacionMiAsiento($idVuelo){
        if(!$this->verificarLogin()){
            return redirect('/');
        }
        $serviceUrl = env('API_ASIENTO_URL');
    
        //session_start();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['vuelo'] = $idVuelo;
    
        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];
    
        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);
    
            $result = $client->ObtenerInformacionVueloAsientos(['id_vuelo' => $idVuelo]);
    
            return view('modificarAsiento', compact('result'));
        } catch (\SoapFault $e) {
            return view('home');
        }
    }

    public function CambiarReserva(Request $respuesta){
        $serviceUrl = env('API_ASIENTO_URL');
    
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        $usuario = $_SESSION['usuario'];
        $asiento_new = $respuesta->input("asiento_new");
        $asiento_old = $_SESSION['asiento_old'];
        $reserva = $_SESSION['reserva'];;
        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];

        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);
    
            $result = $client->CambiarReserva(['reserva' => $reserva,'persona' => $usuario,'asiento_new' => $asiento_new,'asiento_old' => $asiento_old]);
    
            if ($result->CambiarReservaResult) {
                throw new Exception("Hubo un error al cambiar la reserva. CambiarReservaResult es false.");
            }
    
            return $result;
        
        } catch (\SoapFault $e) {
            throw new Exception("Error en la solicitud SOAP: " . $e->getMessage());
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function verificarLogin(){
        //session_start();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['usuario'])){
            return true;
        }else{
            return false;
        }
    }
}
