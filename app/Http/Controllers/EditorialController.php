<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;

class EditorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $editoriales = Editorial::where('estatus', 1)->get();
        return view('editorial.index', ['editoriales' => $this->cargarDT($editoriales)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('editorial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|min:5|max:100',
            'domicilio' => 'required|min:5|max:100',
            'correo' => 'required|email',
        ]);

        $editorial = new Editorial();
        $editorial->nombre = $request->nombre;
        $editorial->domicilio = $request->domicilio;
        $editorial->correo = $request->correo;
        $editorial->save();

        return redirect()->route('editoriales.index')->with('message', 'Editorial creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('editorial.edit', ['editorial' => Editorial::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombre' => 'required|min:5|max:100',
            'domicilio' => 'required|min:5|max:100',
            'correo' => 'required|email',
        ]);

        $editorial = Editorial::findOrFail($id);
        $editorial->nombre = $request->nombre;
        $editorial->domicilio = $request->domicilio;
        $editorial->correo = $request->correo;
        $editorial->save();

        return redirect()->route('editoriales.index')->with('message', 'Editorial actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Eliminar una editorial.
     */
    public function deleteEditorial($editorial_id)
    {
        $editorial = Editorial::find($editorial_id);
        if ($editorial) {
            $editorial->estatus = 0;
            $editorial->update();
            return redirect()->route('editoriales.index')->with("message", "La editorial se ha eliminado correctamente");
        } else {
            return redirect()->route('editoriales.index')->with("message", "La editorial que trata de eliminar no existe");
        }
    }

    /**
     * Cargar datos en formato DataTables.
     */
    private function cargarDT($consulta)
    {
        $editoriales = [];
        foreach ($consulta as $key => $value) {
            $actualizar = route('editoriales.edit', $value['id']);
            $acciones = '
           <div class="btn-acciones">
               <div class="btn-circle">
                   <a href="' . $actualizar . '" role="button" class="btn btn-success" title="Actualizar">
                       <i class="far fa-edit"></i>
                   </a>
                    <a role="button" class="btn btn-danger" onclick="modal(' . $value['id'] . ')" data-bs-toggle="modal" data-bs-target="#exampleModal"">
                       <i class="far fa-trash-alt"></i>
                   </a>
               </div>
           </div>';

            $editoriales[$key] = array(
                $acciones,
                $value['id'],
                $value['correo'],
                $value['nombre'],
                $value['domicilio'],
            );
        }
        return $editoriales;
    }
}
