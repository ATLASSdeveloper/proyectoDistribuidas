<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VueloController;
use App\Http\Controllers\AsientoController;

Route::get('/', function () {
    session_start();

    $_SESSION = array();

    session_destroy();
    
    return view('login');
})->name('login');

Route::get('/registro', function () {
    return view('registro');
})->name('registro');

Route::get('/home',[VueloController::class,'ObtenerInformacionVuelos'])->name('ObtenerInformacionVuelos');
Route::get('/home/asientos/{idVuelo}',[AsientoController::class,'ObtenerInformacionAsientos'])->name('ObtenerInformacionAsientos');
Route::get('/home/reservas/{idVuelo}',[AsientoController::class,'ObtenerInformacionMiAsiento'])->name('ObtenerInformacionMiAsiento');
Route::get('/home/reservas/',[AsientoController::class,'ObtenerInformacionReservas'])->name('ObtenerInformacionReservas');
Route::get('/parametros',[AsientoController::class,'EstablecerParametros'])->name('EstablecerParametros');

Route::post('/login',[UsuarioController::class,'comprobarCredenciales'])->name('comprobarCredenciales');
Route::post('/registro',[UsuarioController::class,'crearUsuario'])->name('crearUsuario');
Route::post('/home',[VueloController::class,'ObtenerInformacionVuelosEspecificos'])->name('ObtenerInformacionVuelosEspecificos');
Route::post('/home/asientos/',[AsientoController::class,'GenerarReserva'])->name('GenerarReserva');

Route::delete('/home/reservas/',[AsientoController::class,'EliminarReserva'])->name('EliminarReserva');

Route::put('/home/reservas/',[AsientoController::class,'CambiarReserva'])->name('CambiarReserva');