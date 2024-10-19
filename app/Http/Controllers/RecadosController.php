<?php

namespace App\Http\Controllers;

use App\Models\respuestas2;
use App\Models\respuestas3;
use App\Models\respuestas14;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Comentario;
use App\Models\Recado;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Telefono;
use Illuminate\Http\Request;

class RecadosController extends Controller
{


  public function index(){
    $Recados=DB::table('recados')
    ->leftJoin('codigos','codigos.code','=','recados.status')
    ->join('telefonos','telefonos.id','=','recados.tel_id')
    ->select('recados.*','codigos.color_rgb','codigos.description')
    ->where('recados.user_id','=',Auth::user()->id)
    ->select('recados.*','codigos.color_rgb','codigos.description','telefonos.telefono','telefonos.cuenta')
    ->get();
    $Codigos=DB::table('codigos')->where('internet','=',0)
    ->orderBy('color')->get();
    return view('recados.index',compact('Recados','Codigos'));
  }

    public function recado_14($id){
    $Egresado=respuestas14::find($id);
    $Recados=Recado::where('cuenta','=',$Egresado->cuenta)->get();
    foreach($Recados as $r){
        $color='';
        switch ($r->status) {
          
          case 3:
              $color="rgba(245, 66, 66, 0.45)";
              break;
          case 4:
            $color="rgba(147, 66, 245,0.45)";
              break;
          case 5:
            $color="rgba(64, 64, 64,0.7)";
              break;
          case 6:
            $color="rgba(59, 173, 196,0.45)";
              break;
      }
      $r->color=$color;
    }
    return view('muestras.act14.recados',compact('Egresado','Recados'));


    }
    public function marcar_14(Request $request,$id){
        $Egresado=respuestas14::find($id);
        $Recado= new Recado();
        $Recado->recado=$request->recado;
        $Recado->status=$request->code;
        $Recado->cuenta=$Egresado->cuenta;
        $Recado->fecha=now()->modify('-6 hours');
        $Recado->save();


        $Egresado->status=$request->code;
        $Egresado->recado=$request->recado;
        $Egresado->llamadas=$Recados=Recado::where('cuenta','=',$Egresado->cuenta)->get()->count();
        $Egresado->save();

       
        return redirect()->route('muestras14.show',[$Egresado->carrera,$Egresado->plantel]);
        }
        
    public function marcar_20(Request $request,$tel_id,$eg_id){
      $Egresado=Egresado::find($eg_id);
      $telefono=Telefono::find($tel_id);
      $Recado= new Recado();
      $Recado->recado=$request->recado;
      $Recado->status=$request->code;
      $Recado->tel_id=$telefono->id;
      $Recado->cuenta=$Egresado->cuenta;
      
      $Recado->user_id=Auth::user()->id;
      $Recado->fecha=now()->modify('-6 hours');
      $Recado->save();

      $telefono->status=$request->code;
      $telefono->save();
      $Egresado->llamadas=$Recados=Recado::where('cuenta','=',$Egresado->cuenta)->get()->count();
      if($Egresado->status!=1&&$Egresado->status!=2){
     
         if(($Recado->status == 6)||($Recado->status==11)){
            

             $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();
          
             $flag=1;
             foreach( $Telefonos as $r){ if($r->status != 6&&$r->status != 11){$flag=0;}}
             if($flag==1){
                $Egresado->status=$request->code; 
                $Egresado->save(); 
              }
       
           }else{
            
            $Egresado->status=$request->code; 
            $Egresado->save(); 
           }
    }
      
      //verificar si todos los telefonos no existen (egresado ilocalizable)
      $Telefonos=Telefono::where('cuenta',$Egresado->cuenta);
      
      
      return redirect()->route('llamar_20',$Egresado->cuenta);
      }

      public function destroy($id){
        $Recado=Recado::find($id);
        // dd($Recado);
        $Egresado=Egresado::where('cuenta',$Recado->cuenta)->first();
        $Telefono=Telefono::find($Recado->tel_id);
        Recado::destroy($id);
        $Recados=Recado::where('cuenta','=',$Egresado->cuenta)->get();
        $Egresado->llamadas=$Recados->count();
        $Egresado->status=$Recados->sortBy('created_at')->reverse()->first()->status;
        $Telefono->status=$Recados->where('tel_id',$Telefono->id)->sortBy('created_at')->reverse()->first()->status;
        //verificar los no existe unu
        $Egresado->save();
        $Telefono->save();
        return back();
      }
}
