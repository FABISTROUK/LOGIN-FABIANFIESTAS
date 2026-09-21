<?php

use App\Http\Controllers\api\LoginController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('login/registrar', 'registrar');
    Route::post('login/recuperar', 'recuperar');
    Route::post('login/validar', 'validar');
    Route::post('login/passwordd', 'actualizarPassword');
});