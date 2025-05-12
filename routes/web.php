<?php

use App\Http\Controllers\EventosController;
use App\Http\Controllers\FormularioController;
use Illuminate\Support\Facades\Route;


Route::get('/', [EventosController::class, 'mostrarEventos'])->name('mostrarEventos');

Route::get('/mostrarformulario', [FormularioController::class, 'mostrarFormulario'])->name('mostrarformulario');
