<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\respuestas20;

use App\Models\Egresado;
use App\Models\Reactivo;
use App\Models\Option;
class FastPollController extends Controller
{
   public array $reactives20=[
      'nar8',
      'nar9',
      'nar10',
      // 'nar3a',
      // 'nar4a',
      // 'nar5a',
      'nar11',
      'nar11a',
      'nar12',
      'nar12a',
      'nar13',
      'nar13a',
      'nar14',
      'nar14otra',
      'nar15',
      'nar15otra',
      'nar16',
      'nar16otra',
      'nbr3_a',
      'nbr6',
      'nbr7',
      'nbr8',
      'ncr1',
      'ncr2',
      'ncr2a',
      'ncr3',
      'ncr4',
      'ncr4otra',
      'ncr5',
      'ncr6',
      'ncr6_a',
      'ncr7_a',
      'ncr7b',
      'ncr8',
      'ncr9',
      'ncr10',
      'ncr11',
      'ncr12_a',
      'ncr15',
      'ncr16',
      'ncr17',
      'ncr18',
      'ncr19',
      'ncr20',
      'ncr21',
      'ncr21_a',
      'ncr21b',
      'ncr22',
      'ncr23',
      'ncr24',
      'ncr24porque',
      'ncr24_a',
      'ndr1',
      'ndr2',
      'ndr2_a',
      'ndr3',
      'ndr4',
      'ndr5',
      'ndr6',
      'ndr9',
      'ndr7',
      'ndr8',
      'ndr10',
      'ndr11',
      'ndr12',
      'NDR12A',
      'NDR12B',
      'NDR12C',
      'ndr13a',
      'ndr14',
      'ndr15',
      'ndr16',
      'ndr17',
      'ndr18',
      'ndr19',
      'ner1',
      'ner1a',
      'ner2',
      'ner3',
      'ner4',
      'ner5',
      'ner6',
      'ner7',
      'ner7_a',
      'ner7int',
      'ner8',
      'ner9',
      'ner10',
      'ner10a',
      'ner11',
      'ner12',
      'ner12a',
      'ner12b',
      'ner13',
      'ner14',
      'ner15',
      'ner16',
      'ner17',
      'ner18',
      'ner19',
      'ner19a',
      'ner20',
      'ner20txt',
      'ner20a',
      'nfr0',
      'nfr1',
      'nfr1a',
      'nfr2',
      'nfr3',
      'nfr7',
      'nfr4',
      'nfr4_a',
      'nfr5',
      'nfr5_a',
      'nfr6',
      'nfr6_a',
      'nfr8',
      'nfr9',
      'nfr10',
      'nfr11',
      'nfr11a',
      'nfr12',
      'nfr13',
      'nfr22',
      'nfr23',
      'nfr24',
      'nfr25',
      'nfr26',
      'nfr27',
      'nfr28',
      'nfr29',
      'nfr29a',
      'nfr30',
      'nfr31',
      'nfr32',
      'nfr33',
      'ngr1',
      'ngr2',
      'ngr3',
      'ngr3b',
      'ngr3c',
      'ngr3d',
      'ngr3e',
      'ngr4',
      'ngr5',
      'ngr6',
      'ngr6a',
      'ngr6b',
      'ngr6c',
      'ngr6d',
      'ngr6e',
      'ngr6f',
      'ngr6g',
      'ngr6_t',
      'ngr7a',
      'ngr7b',
      'ngr7c',
      'ngr7d',
      'ngr7e',
      'ngr7f',
      'ngr7g',
      'ngr8',
      'ngr9a',
      'ngr9b',
      'ngr9c',
      'ngr9d',
      'ngr9e',
      'ngr11a',
      'ngr11',
      'ngr11_a',
      'ngr13',
      'ngr13b',
      'ngr13c',
      'ngr13d',
      'ngr13e',
      'ngr14',
      'ngr15',
      'ngr16',
      'ngr17',
      'ngr18',
      'ngr19',
      'ngr20',
      'ngr21',
      'ngr22',
      'ngr23',
      'ngr24',
      'ngr25',
      'ngr26',
      'ngr27',
      'ngr28',
      'ngr29',
      'ngr30',
      'ngr31',
      'ngr32',
      'ngr33',
      'ngr34',
      'ngr35',
      'ngr36',
      'ngr37',
      'ngr37m',
      'ngr37_a',
      'ngr38',
      'ngr39',
      'ngr40',
      'ngr40a',
      'ngr40_a',
      'ngr40_b',
      'ngr41',
      'ngr42',
      'ngr43',
      'ngr44',
      'ngr45',
      'ngr45_a',
      'ngr45otra',
      'conoce',
      'cue_cre',
      'utiliza',
      'nrx',
      'nrxx',
      'ngr11b',
      'ngr11c',
      'ngr11d',
      'ngr11e',
      'ngr11f',
      'ncr2ext',
      'ner12ext',
      'ner15ext',
      'ner18ext',
      'ndr17a',
      'ngr40interes',
      'ngr40otro',];



   public function begin(){
      
      return view('fast.begin');
     }
     
     public function check_cuenta(Request $request){
      $Cuenta=$request->cuenta;
      $Egresado=Egresado::where('cuenta',$request->cuenta)->first();
      if($Egresado){
         if($Egresado->anio_egreso==2020){
            //crea una nueva instancia de encuesta
            $Encuesta=respuestas20::where('cuenta','=',$Cuenta)->first();
           if(!$Encuesta){
            $Encuesta=new respuestas20();
            $Encuesta->cuenta=$Cuenta;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->paterno=$Egresado->paterno;
            $Encuesta->materno=$Egresado->materno;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->nbr2=$Egresado->carrera;
            $Encuesta->nbr3=$Egresado->plantel;
            $Encuesta->gen_dgae=2020;
            $Encuesta->completed=0;
            $Encuesta->save();}
            //find next
           return redirect()->route('fast.find',[ $Encuesta->registro,'2020']);
         }  
      }
      return view('fast.begin');
     }


   function find_next($registro,$type){
      $Encuesta=respuestas20::find($registro);
      if($type=='2020'){
         foreach($this->reactives20 as $r){
            if(!$Encuesta->$r){
               return redirect()->route('fast.show',[ $Encuesta->registro,$r,'2020']);
         
            }
            
         }
             
      }

   }
   
   public function show($registro,$reactivo,$type){
    $Encuesta=respuestas20::find($registro);
    $Reactivo=Reactivo::where('clave',$reactivo)->first();
    $Options=Option::where('reactivo',$reactivo)->get();
    return view('fast.show',compact('Encuesta','Reactivo','Options','type'));
   }

   public function store(Request $request,$registro,$reactivo,$type){

      $Encuesta=respuestas20::find($registro);
      $Reactivo=Reactivo::where('clave',$reactivo)->first();
      // TODO: implementar validacion
      // $request->validate($Reactivo->rules)
     
      $Encuesta->$reactivo = $request->respuesta;
      
      $Encuesta->save();
      return redirect()->route('fast.find',[ $Encuesta->registro,'2020']);
         

   }
}
