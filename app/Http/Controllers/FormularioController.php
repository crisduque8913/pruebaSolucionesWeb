<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormularioController extends Controller
{
    public function mostrarFormulario() 
    {
        return view("formulario");
    }
}
