<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\EncuestaEmpresa;
use DB;

use Illuminate\Support\Facades\Auth;
class EmpresasController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->query('q'); // Obtener el término de búsqueda

        $resultados = Empresas::where(DB::raw('lower(nombre)'), 'like', '%' . strtolower($term) . '%')
            // where('nombre', 'LIKE', "%$term%")
            ->take(10)
            ->get();

        return response()->json($resultados);
    }

/** 
    public function index(Request $request){
        $empresas = DB::table('empresas')
        ->select()
        ->orderBy('nombre', 'asc')
        ->get();
        
        //dd(compact('empresas'));
        return view('empresas.index', compact('empresas'));
    }
*/
    public function index(Request $request) 
    {
        $empresas = DB::table('empresas')
            ->leftJoin('users', 'empresas.usuario', '=', 'users.clave')
            ->select(
                'empresas.*',
                'users.name as nombre_usuario'
            )
            ->orderBy('empresas.nombre', 'asc')
            ->get();
        
        //Arreglos de girtos y sectores
        $giros = [
            1 => 'Agricultura, ganadería, aprovechamiento forestal, caza y pesca',
            19 => 'Asociaciones y agrupaciones',
            20 => 'Actividades de gobierno, organismos internacionales y extraterritoriales',
            4 => 'Construcción',
            6 => 'Comercio al por mayor',
            7 => 'Comercio al por menor',
            13 => 'Dirección de corporativos y empresass',
            23 => 'Editorial',
            3 => 'Electricidad, agua y suministro de gas',
            5 => 'Industrias manufactureras o de la transformación',
            9 => 'Información en medios masivos',
            2 => 'Minería',
            10 => 'Servicios financieros y de seguros',
            11 => 'Servicios inmobiliarios y de alquiler de bienes muebles e intangibles',
            12 => 'Servicios profesionales, científicos y técnicos',
            14 => 'Servicios de apoyo a los negocios, manejo de desecho y servicios de remediación',
            15 => 'Servicios de salud',
            16 => 'Servicios educativos',
            17 => 'Servicios de esparcimiento, cultural, deportivos y otros centros recreativos',
            18 => 'Servicios de alojamiento temporal, de preparación de alimentos y bebidas (hotel, restaurant, bar)',
            8 => 'Transporte, correos y almacenamiento',
            22 => 'Telecomunicaciones',
            24 => 'Servicios Personales',
            25 => 'Servicios  de reparacion y mantenimiento',
            21 => 'Otro (Especifíque)'
        ];

        $sectores = [
            1 => 'Público',
            2 => 'Privado',
            3 => 'Social'
        ];
        return view('empresas.index', compact('empresas','giros','sectores'));

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
            'giro_especifico' => 'required|string|max:200',
            'nota' => 'nullable|string|max:280',
        ]);
        // Crear una nueva empresa
        Empresas::create($request->all());

        // Redireccionar a la lista de empresas con un mensaje de éxito
        return redirect()->route('empresas.index')->with('success', 'Empresa creada exitosamente.');
        }

    public function modal_store(Request $request){
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|string|max:150',
            'sector' => 'required|string|max:150',
            'rama' => 'required|string|max:20',
            'giro_especifico' => 'required|string|max:300',
            'nota' => 'nullable|string|max:250',
        ]);
        // EncuestaEmpresa::where('encuesta_id',$request->id_encuesta)->where('table',$request->table)->delete();
        // // //guardar la relacion de empresa/encuestas
        $Empresa=new Empresas();
        $Empresa->usuario=Auth::user()->clave;
        $Empresa->nombre=$request->nombre;
        $Empresa->sector=$request->sector;
        $Empresa->clave_giro=$request->rama;
        $Empresa->giro_especifico=$request->giro_especifico;
        $Empresa->nota=$request->nota;
        $Empresa->save();

        $EncuestaEmpresa=new EncuestaEmpresa();
        $EncuestaEmpresa->encuesta_id=$request->encuesta_id;
        $EncuestaEmpresa->empresa_id=$Empresa->id;
        $EncuestaEmpresa->suvery_type=$request->table;
        $EncuestaEmpresa->save();
        // Crear una nueva empresa
        return response()->json(['message' => 'Empresa creada', 'data' => $Empresa,'notas'=>$request->nota,'giro_esp'=>$request->giro_especifico], 201);
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
            'giro_especifico' => 'required|string|max:540',
            'nota' => 'nullable|string|max:250',
            'sector' => 'nullable|int|max:250',
        ]);

        // Encontrar la empresa y actualizarla
        $empresa = Empresas::find($id);
        $empresa->nombre = $request->nombre;
        $empresa->clave_giro = $request->clave_giro;
        $empresa->giro_especifico = $request->giro_especifico;
        $empresa->nota = $request->nota;
        $empresa->sector = $request->sector;
        $empresa->usuario=Auth::user()->clave;
        $empresa->save();
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
