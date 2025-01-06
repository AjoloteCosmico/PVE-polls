<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresas;
use DB;

class EmpresasController extends Controller
{
    public function index(Request $request){
        $empresas = DB::table('empresas')
        ->select()
        ->get();
        
        //dd(compact('empresas'));
        return view('empresas.index', compact('empresas'));
    }

    public function show($id){
        $empresa = Empresas::findOrFail($id); // Busca la empresa por ID, si no existe lanza un error 404
        return view('empresas.show', compact('empresa')); // Pasa la empresa a la vista show
    }
    // Mostrar el formulario para crear una nueva empresa
    public function create(){
        return view('empresas.create');
    }

    // Almacenar una nueva empresa en la base de datos
    public function store(Request $request){
        // Validar la solicitud
        $request->validate([
            'usuario' => 'required|string|max:20',
            'nombre' => 'required|string|max:150',
            'clave_giro' => 'required|string|max:20',
            'giro_especifico' => 'required|string|max:150',
            'nota' => 'nullable|string|max:250',
        ]);

        // Crear una nueva empresa
        Empresas::create($request->all());

        // Redireccionar a la lista de empresas con un mensaje de éxito
        return redirect()->route('empresas.index')->with('success', 'Empresa creada exitosamente.');
    }

    // Mostrar el formulario para editar una empresa existente
    public function edit($id){
        $empresa = Empresas::findOrFail($id);
        return view('empresas.edit', compact('empresa'));
    }

    // Actualizar una empresa existente en la base de datos
    public function update(Request $request, $id){
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|string|max:150',
            'clave_giro' => 'required|string|max:20',
            'giro_especifico' => 'required|string|max:550',
            'nota' => 'nullable|string|max:250',
            'sector' => 'nullable|int|max:250',
        ]);

        // Encontrar la empresa y actualizarla
        $empresa = Empresas::findOrFail($id);
        $empresa->update($request->all());

        // Redireccionar a la lista de empresas con un mensaje de éxito
        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada exitosamente.');
    }

    // Eliminar una empresa de la base de datos
    public function destroy($id){
        $empresa = Empresas::findOrFail($id);
        $empresa->delete();

        // Redireccionar a la lista de empresas con un mensaje de éxito
        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada exitosamente.');
    }
}
