<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
//    REALIZAR EL CRUD DE EQUIPO
    
// index
    public function index()
    {
        $equipo = Equipo::all();
        return response()->json($equipo,200);
    }
    
// create()
    public function create()
    {
        // codigo de create equipo

    }

     
    public function store(Request $request)
    {
        $equipo = Equipo::created($request->all()); 
        // return response()->json($equipo,200);
        // cambios 😀😀😀😀😀
        return response()->json(
            [
                'message' => 'Equipo creado correctamente',
                // 'equipo' => $equipo
            ],
            201
        );
    }

    public function show(Equipo $equipo)
    {
        // return 
         return response()->json($equipo,200);
    }

    public function edit(Equipo $equipo)
    {
        //return
        return response()->json($equipo,200);
    }

    public function update(Request $request, Equipo $equipo)
    {
        /* $equipo = Equipo::created($request->all(), 200);
        return response()->json($equipo, 200); */
        $equipo->update($request->all());
        return response()->json($equipo, 200);
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return response()->json(null, 204);
    }
}
