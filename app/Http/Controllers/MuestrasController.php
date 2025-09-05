<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estudio;
use App\Models\Muestra;

use App\Models\Carrera;
use DB;
use App\Models\Egresado;
use App\Models\EgresadoPosgrado;
use App\Models\respuestas2;

use App\Models\respuestas20;
use App\Models\respuestas16;
use App\Models\respuestas14;
use App\Models\respuestasPosgrado;

use Illuminate\Support\Facades\Auth;
class MuestrasController extends Controller
{
  public function index(){
    //  $Muestras2019=Muestra::where('enc_id','=',Auth::user()->id)
    $Muestras2019=DB::table('muestras')
     ->leftJoin('carreras', function($join)
                         {
                             $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
                             $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
                         })
    ->select('muestras.*','carreras.carrera','carreras.plantel')
                         ->get();
    //dd($Muestras2019);
    return view('muestras.index',compact('Muestras2019'));
  }
  
  public function show($id){
    $Muestra=Muestra::find($id);
    $Egresados=Egresado::where('carrera','=',$Muestra->carrera_id)->where('plantel','=',$Muestra->plantel_id)->get();
    return view('muestras.show',compact('Egresados','Muestra'));
}

public function plantel_index_16(){

  $Planteles=Egresado::where('act_suvery','1')
      ->join('carreras','egresados.plantel','carreras.clave_plantel')
      ->select('carreras.plantel','carreras.clave_plantel',)
      ->distinct()->get();
  // dd($planteles);
  return view('muestras.act16.plantel_index',compact('Planteles'));
}

//public function plantel_index(){
  //$Planteles=Carrera::distinct()->get(['plantel','clave_plantel']);
  //return view('muestras.seg20.plantel_index',compact('Planteles'));
//}

public function index_general($gen,$id){

  //CHECA GENERACION 2016
  if ($gen==16){
    $carreras=Egresado::where('act_suvery','1')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'egresados.carrera');
      $join->on('carreras.clave_plantel', '=', 'egresados.plantel');                             
  })
  ->where('carreras.clave_plantel',$id)
  ->select('carreras.carrera','carreras.plantel','egresados.plantel as p','egresados.carrera as c')
  ->distinct()
  ->get();
  if($id==0){
    $carreras=Egresado::where('act_suvery','1')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'egresados.carrera');
      $join->on('carreras.clave_plantel', '=', 'egresados.plantel');                             
  })
  ->select('carreras.carrera','carreras.plantel')
  ->distinct()
  ->get();
  }

  foreach($carreras as $c){
    // Partes comunes de la consulta base
    $queryBase = Egresado::where('act_suvery', 1)
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->get();

    // Encuestas por teléfono
    $c->nencuestas_tel = $queryBase
    ->where('status', 1)
    ->count();

    // Encuestas por internet
    $c->nencuestas_int = $queryBase
    ->where('status', 2)
    ->count();

    // Encuestas requeridas
    $c->requeridas = $queryBase
    ->count();
  }
  return view('muestras.act16.index',compact('carreras','gen'));
  
  //CHECA GENERACION 2020
  } else if ($gen==20){
    $carreras=Muestra::where('estudio_id','=','3')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
      $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
  })
  ->where('carreras.clave_plantel',$id)
  ->select('carreras.carrera','carreras.plantel','muestras.carrera_id as c','muestras.plantel_id as p','carreras.clave_carrera','carreras.clave_plantel','muestras.requeridas_5')->get();
  
  if($id==0){
    $carreras=Muestra::where('estudio_id','=','3')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
      $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
  })
    ->select('carreras.carrera','carreras.plantel','muestras.carrera_id as c','muestras.plantel_id as p','carreras.clave_carrera','carreras.clave_plantel','muestras.requeridas_5')->get();
  }
  foreach($carreras as $c){
    // Partes comunes de la consulta base
    $queryBase = Egresado::where('muestra', 3)
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->get();

    // Encuestas por teléfono
    $c->nencuestas_tel = $queryBase
    ->where('status', 1)
    ->count();

    // Encuestas por internet
    $c->nencuestas_int = $queryBase
    ->where('status', 2)
    ->count();
     if($id==0){
      $c->pob=Egresado::where('anio_egreso', '2020')
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->count();
     }
      
  }
  return view('muestras.seg20.index',compact('carreras','id','gen'));
    

  //CHECA GENERACION 2022
  }else if ($gen==22){
    $carreras=Muestra::where('estudio_id','=','5')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
      $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
  })
  ->where('carreras.clave_plantel',$id)
  ->select('carreras.carrera','carreras.plantel','muestras.carrera_id as c','muestras.plantel_id as p','carreras.clave_carrera','carreras.clave_plantel','muestras.requeridas_5')->get();
  
  if($id==0){
    $carreras=Muestra::where('estudio_id','=','5')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
      $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
  })
    ->select('carreras.carrera','carreras.plantel','muestras.carrera_id as c','muestras.plantel_id as p','carreras.clave_carrera','carreras.clave_plantel','muestras.requeridas_5')->get();
  }
  foreach($carreras as $c){
    // Partes comunes de la consulta base
    $queryBase = Egresado::where('muestra', 5)
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->get();

    // Encuestas por teléfono
    $c->nencuestas_tel = $queryBase
    ->where('status', 1)
    ->count();

    // Encuestas por internet
    $c->nencuestas_int = $queryBase
    ->where('status', 2)
    ->count();
     if($id==0){
      $c->pob=Egresado::where('anio_egreso', '2022')
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->count();
     }
      
  }
  return view('muestras.seg20.index22',compact('carreras','id','gen'));
  }

}

  
public function index_16($id){
  $carreras=Egresado::where('act_suvery','1')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'egresados.carrera');
      $join->on('carreras.clave_plantel', '=', 'egresados.plantel');                             
  })
  ->where('carreras.clave_plantel',$id)
  ->select('carreras.carrera','carreras.plantel','egresados.plantel as p','egresados.carrera as c')
  ->distinct()
  ->get();
  if($id==0){
    $carreras=Egresado::where('act_suvery','1')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'egresados.carrera');
      $join->on('carreras.clave_plantel', '=', 'egresados.plantel');                             
  })
  ->select('carreras.carrera','carreras.plantel')
  ->distinct()
  ->get();
  }

  foreach($carreras as $c){
    // Partes comunes de la consulta base
    $queryBase = Egresado::where('act_suvery', 1)
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->get();

    // Encuestas por teléfono
    $c->nencuestas_tel = $queryBase
    ->where('status', 1)
    ->count();

    // Encuestas por internet
    $c->nencuestas_int = $queryBase
    ->where('status', 2)
    ->count();

    // Encuestas requeridas
    $c->requeridas = $queryBase
    ->count();
  }
  // dd($carreras);
  // $carreras=collect($carreras);
  return view('muestras.act16.index',compact('carreras'));
}

public function index_20($id){
  $carreras=Muestra::where('estudio_id','=','3')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
      $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
  })
  ->where('carreras.clave_plantel',$id)
  ->select('carreras.carrera','carreras.plantel','muestras.carrera_id as c','muestras.plantel_id as p','carreras.clave_carrera','carreras.clave_plantel','muestras.requeridas_5')->get();
  
  if($id==0){
    $carreras=Muestra::where('estudio_id','=','3')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
      $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
  })
    ->select('carreras.carrera','carreras.plantel','muestras.carrera_id as c','muestras.plantel_id as p','carreras.clave_carrera','carreras.clave_plantel','muestras.requeridas_5')->get();
  }
  foreach($carreras as $c){
    // Partes comunes de la consulta base
    $queryBase = Egresado::where('muestra', 3)
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->get();

    // Encuestas por teléfono
    $c->nencuestas_tel = $queryBase
    ->where('status', 1)
    ->count();

    // Encuestas por internet
    $c->nencuestas_int = $queryBase
    ->where('status', 2)
    ->count();
     if($id==0){
      $c->pob=Egresado::where('anio_egreso', '2020')
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->count();
     }
      
  }
  // $carreras=collect($carreras);
  return view('muestras.seg20.index',compact('carreras','id'));
}


//Metodo momentaneo para index de 2022
public function index_22($id){
  $carreras=Muestra::where('estudio_id','=','5')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
      $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
  })
  ->where('carreras.clave_plantel',$id)
  ->select('carreras.carrera','carreras.plantel','muestras.carrera_id as c','muestras.plantel_id as p','carreras.clave_carrera','carreras.clave_plantel','muestras.requeridas_5')->get();
  
  if($id==0){
    $carreras=Muestra::where('estudio_id','=','5')->leftJoin('carreras', function($join){
      $join->on('carreras.clave_carrera', '=', 'muestras.carrera_id');
      $join->on('carreras.clave_plantel', '=', 'muestras.plantel_id');                             
  })
    ->select('carreras.carrera','carreras.plantel','muestras.carrera_id as c','muestras.plantel_id as p','carreras.clave_carrera','carreras.clave_plantel','muestras.requeridas_5')->get();
  }
  foreach($carreras as $c){
    // Partes comunes de la consulta base
    $queryBase = Egresado::where('muestra', 5)
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->get();

    // Encuestas por teléfono
    $c->nencuestas_tel = $queryBase
    ->where('status', 1)
    ->count();

    // Encuestas por internet
    $c->nencuestas_int = $queryBase
    ->where('status', 2)
    ->count();
     if($id==0){
      $c->pob=Egresado::where('anio_egreso', '2022')
    ->where('carrera', $c->c)
    ->where('plantel', $c->p)
    ->count();
     }
      
  }
  return view('muestras.seg20.index22',compact('carreras','id'));
}

public function plantel_index($gen){
  $Planteles=Carrera::distinct()->get(['plantel','clave_plantel']);
   if ($gen==20){
    return view('muestras.plantel_index',compact('Planteles', 'gen'));
   } else if ($gen==16){
    $Planteles=Egresado::where('act_suvery','1')
      ->join('carreras','egresados.plantel','carreras.clave_plantel')
      ->select('carreras.plantel','carreras.clave_plantel',)
      ->distinct()->get();
    return view('muestras.plantel_index',compact('Planteles', 'gen'));
  } else if ($gen==22){
    return view('muestras.plantel_index',compact('Planteles', 'gen'));
   }
  
}


public function show_20($carrera,$plantel){
  $Carrera= Carrera::where('clave_carrera',$carrera)->where('clave_plantel',$plantel)->first();
  $muestra=DB::table('egresados')->where('muestra','=','3')->where('egresados.carrera','=',$carrera)->where('plantel','=',$plantel)
    ->leftJoin('codigos','codigos.code','=','egresados.status')
    ->select('egresados.*','codigos.color_rgb','codigos.description','codigos.orden')
    ->get();

  $Codigos=DB::table('codigos')->where('internet','=',0)
  ->orderBy('color')->get();
  
  return view('muestras.seg20.show',compact('muestra','Carrera','Codigos','carrera','plantel'));
}


public function show_16($carrera,$plantel){
  $Carrera= Carrera::where('clave_carrera',$carrera)->where('clave_plantel',$plantel)->first();
  $muestra=DB::table('egresados')->where('act_suvery','=','1')->where('egresados.carrera','=',$carrera)->where('plantel','=',$plantel)
    ->leftJoin('codigos','codigos.code','=','egresados.status')
    ->select('egresados.*','codigos.color_rgb','codigos.description','codigos.orden')
    ->get();

  $Codigos=DB::table('codigos')->where('internet','=',0)
  ->orderBy('color')->get();
  
  return view('muestras.act16.show',compact('muestra','Carrera','Codigos','carrera','plantel'));
}



public function show_22($carrera,$plantel){

  $Carrera= Carrera::where('clave_carrera',$carrera)->where('clave_plantel',$plantel)->first();
  $muestra=DB::table('egresados')->where('muestra','=','5')->where('egresados.carrera','=',$carrera)->where('plantel','=',$plantel)
    ->leftJoin('codigos','codigos.code','=','egresados.status')
    ->select('egresados.*','codigos.color_rgb','codigos.description','codigos.orden')
    ->get();

  $Codigos=DB::table('codigos')->where('internet','=',0)
  ->orderBy('color')->get();
  
  return view('muestras.seg20.show22',compact('muestra','Carrera','Codigos','carrera','plantel'));

}





public function revisiones_index(){
  return view('muestras.revisiones.index');
}


//Revisar encuenstas de seg 2020
public function revision(){
  $Encuestas=respuestas20::leftJoin('carreras', function($join)
  {
      $join->on('carreras.clave_carrera', '=', 'respuestas20.nbr2');
      $join->on('carreras.clave_plantel', '=', 'respuestas20.nbr3');                             
  })
  ->leftjoin('users','users.clave','=','respuestas20.aplica')
  ->leftJoin('egresados', 'egresados.cuenta', '=', 'respuestas20.cuenta')
  ->select('respuestas20.*','carreras.carrera','carreras.plantel','users.name')
  ->where('egresados.anio_egreso', 2020)
  ->where('egresados.muestra', 3)
  ->where('completed',1)
  //->where('aplica',Auth::user()->clave) 
  ->get();
  if(Auth::user()->confidential<2){
    $Encuestas=$Encuestas->where('aplica',Auth::user()->clave);
  }
  return view('muestras.seg20.revision',compact('Encuestas'));
}

//Revisar encuenstas de seg 2022
public function revision22(){

  $Encuestas=respuestas20::leftJoin('carreras', function($join)
    {
        $join->on('carreras.clave_carrera', '=', 'respuestas20.nbr2');
        $join->on('carreras.clave_plantel', '=', 'respuestas20.nbr3');
    })
    ->leftjoin('users','users.clave','=','respuestas20.aplica')
    ->leftJoin('egresados', 'egresados.cuenta', '=', 'respuestas20.cuenta')
    ->select('respuestas20.*','carreras.carrera','carreras.plantel','users.name')
    ->where('egresados.anio_egreso', 2022)
    ->where('completed',1)
    ->where('egresados.muestra', 5)
    //->where('aplica',Auth::user()->clave)
    ->get();

    if(Auth::user()->confidential<2){
        $Encuestas=$Encuestas->where('aplica',Auth::user()->clave);
    }
    return view('muestras.seg20.revision22',compact('Encuestas'));
}


//Revisar encuenstas de act 2016

public function revision16(){
  $Encuestas=respuestas16::leftJoin('carreras', function($join)
  {
    $join->on('carreras.clave_carrera', '=', 'respuestas16.nbr2');
    $join->on('carreras.clave_plantel', '=', 'respuestas16.nbr3');
  })
  ->leftjoin('users','users.clave','=','respuestas16.aplica')
  ->select('respuestas16.*','carreras.carrera','carreras.plantel','users.name')
  ->where('completed',1)
  ->get();

  if(Auth::user()->confidential<2){
    $Encuestas=$Encuestas->where('aplica',Auth::user()->clave);
  }
  return view('muestras.act16.revision', compact('Encuestas'));
}

public function completar_encuesta($id){
  $Egresado=Egresado::find($id);
  if($Egresado->act_suvery==1){
    $Encuesta=respuestas16::where('cuenta',$Egresado->cuenta)->first();
    if($Encuesta){
      return redirect()->route('edit_16',$Encuesta->registro);
    }else{
      return redirect()->back();
    }
  }
  if($Egresado->muestra==3){
    $Encuesta=respuestas20::where('cuenta',$Egresado->cuenta)->first();
    if($Encuesta){
      return redirect()->route('edit_20',[$Encuesta->registro,'SEARCH']);
    }else{
      return redirect()->back();
    }
  }
}

//funciones para posgrado
public function programas_index(){
  $Programas=EgresadoPosgrado::distinct()->get(['programa']);
   return view('muestras.posgrado.programas_index',compact('Programas'));
}

public function index_posgrado($programa){
  $planes = EgresadoPosgrado::where('programa', $programa)
    ->select('plan')
    ->distinct()
    ->get();


  
  foreach ($planes as $p) {
    $queryBase = EgresadoPosgrado::where('programa', $programa)
      ->where('plan', $p->plan);

    // Encuestas por teléfono
    $p->nencuestas_tel = $queryBase->where('status', 1)->count();

    // Encuestas por internet
    $p->nencuestas_int = $queryBase->where('status', 2)->count();

    // Encuestas requeridas
    $p->requeridas = $queryBase->count();
  }

  return view('muestras.posgrado.index', compact('planes', 'programa'));



}

public function show_posgrado($programa, $plan){
  
  $muestra = DB::table('egresados_posgrado')
    ->where('programa', '=', $programa)
    ->where('plan', '=', $plan)
    ->leftJoin('codigos', 'codigos.code', '=', 'egresados_posgrado.status')
    ->select('egresados_posgrado.*', 'codigos.color_rgb', 'codigos.description', 'codigos.orden')
    ->get();

  $Codigos = DB::table('codigos')
    ->where('internet', '=', 0)
    ->orderBy('color')
    ->get();
  
  return view('muestras.posgrado.show', compact('muestra', 'programa', 'plan', 'Codigos'));
}

}
