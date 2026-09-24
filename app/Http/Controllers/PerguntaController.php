<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\PerguntaController;

Route::post('/eventos/{evento}/perguntas', [PerguntaController::class, 'store'])
    ->middleware('auth')
    ->name('perguntas.store');