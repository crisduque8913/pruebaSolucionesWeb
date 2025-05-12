<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventos;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Testing\Concerns\AssertsStatusCodes;
use Ilumuninate\Support\Facades\Validator;


class EventosController extends Controller
{


    
public function mostrarEventos()
{
    $eventos = Eventos::all();
    return view('welcome', compact('eventos'));
}

public function mostrarformulario()
{
    return view('formulario');
}





    public function index()
    {
        $eventos=Eventos::all();
        if($eventos->isEmpty()){
            $data = [
                "message"=> "No se encontraron registros",
                "status"=> "200",
            ];
            return response()->json($data,200);
        }

        return response()->json($eventos,200);
        
    }


    public function store(Request $request)
    {
        //fecha','ubicacion','numboletos','precio'];
        $validator = FacadesValidator::make($request->all(), [
            'nombre'=>'required|max:40',
            'fecha'=>'required',
            'ubicacion'=>'required',
            'numboletos'=> 'required',
            'precio'=> 'required',
        ]);

        if($validator->fails()){

            $data = [  
                'message'=> 'Error en la validacion de datos',
                'errors'=> $validator->errors()->first(),
                'status'=> '400'
            ];
            return response()->json($data,400);
        }
        $evento = Eventos::create([
            'nombre'=> $request->nombre,
            'fecha'=>$request->fecha,
            'ubicacion'=>$request->ubicacion,
            'numboletos'=>$request->numboletos,
            'precio'=>$request->precio
        ]);
        
        if(!$evento){
            $data = [
                'message'=> 'Error al crear evento',
                'status'=> '500'
            ];
            return response()->json($data,500);
        }
            $data= [
                'evento'=>$evento,
                'status'=> 201,
            ];
            return response()->json($data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evento = Eventos::find($id);

        if(!$evento){
            $data = [
                'message'=> 'No se encontro el vento',
                'status'=> '404'
            ];
            return response()->json($data,404);
        }

        $data = [
            'evento'=>$evento,
            'status'=> 200,
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $evento = Eventos::find($id);
         if(!$evento){
            $data = [
                'message'=> 'Evento no encotrado',
                'status'=> 404
            ];
            return response()->json($data,404);
         }

         $validator = FacadesValidator::make($request->all(), [
            'nombre'=>'required|max:40',
            'fecha'=>'required',
            'ubicacion'=>'required',
            'numboletos'=> 'required',
            'precio'=> 'required',
        ]);

        if($validator->fails())
        {
            $data = [
                'message'=> 'Error en la validacion de datos',
                'status'=> 400
            ];
            return response()->json($data,404);
        }

        $evento->nombre = $request->nombre;
        $evento->fecha = $request->fecha;
        $evento->numboletos = $request->numboletos;
        $evento->ubicacion = $request->ubicacion;
        $evento->precio = $request->precio;

        $evento->save(); //metodeo save actualizar registro con request obtenido en parametro

        $data = [
            'message'=> 'Evento actualizado correctamente',
            'evento'=>$evento,
            'status'=> 200
        ];
        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $evento = Eventos::find($id);
        if(!$evento){
            $data = [
                'message'=> 'No se encontro el evento',
                'status'=> 404
            ];
            return response()->json($data,404);
        }
        $evento->delete();
        $data = [
            'message'=> 'Evento eliminado Correctamente',
            'status'=> 200,
        ];
        return response()->json($data,200);
    }
}
