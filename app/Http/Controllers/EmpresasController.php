<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresas;

class EmpresasController extends Controller
{
    public function index(Request $request){
        $query = Empresas::query();

        // Si hay una búsqueda, filtrar las empresas
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('usuario', 'like', "%$search%")
                ->orWhere('nombre', 'like', "%$search%")
                ->orWhere('giro', 'like', "%$search%")
                ->orWhere('clave_giro', 'like', "%$search%")
                ->orWhere('giro_especifico', 'like', "%$search%")
                ->orWhere('nota', 'like', "%$search%");
            });
        }

        // Paginación de empresas
        $empresas = $query->paginate(10);
        //dd($empresas);
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
            'giro' => 'required|string|max:75',
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
            'usuario' => 'required|string|max:20',
            'nombre' => 'required|string|max:150',
            'giro' => 'required|string|max:75',
            'clave_giro' => 'required|string|max:20',
            'giro_especifico' => 'required|string|max:150',
            'nota' => 'nullable|string|max:250',
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
