<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueloController extends Controller
{
    public function ObtenerInformacionVuelos(){
        if(!$this->verificarLogin()){
            return redirect('/');
        }
        $serviceUrl = env('API_VUELO_URL');

        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];

        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);

            $result = $client->ObtenerInformacionVuelos();

            $sedes = $client->ObtenerSedes();
            return view('home',compact('result','sedes'));
        } catch (\SoapFault $e) {
            return view('home');
        }

    }

    public function ObtenerInformacionVuelosEspecificos(Request $request){
        $serviceUrl = env('API_VUELO_URL');

        $options = [
            'trace' => 1,
            'exceptions' => true,
        ];


        $filtroVuelo = [
            'origen' => $request->input('origen'),
            'destino' => $request->input('destino'),
            'fecha_salida' => $request->input('fecha'),
        ];

        try {
            $client = new \SoapClient($serviceUrl . '?singleWsdl', $options);

            $result = $client->ObtenerInformacionVuelosEspecificos($filtroVuelo);

            return $result;

        } catch (\SoapFault $e) {
            return null;
        }

    }

    public function verificarLogin(){
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
