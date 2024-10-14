<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\respuestas2;
use App\Models\respuestas3;

use App\Models\respuestas14;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;
use File;
class EncuestasController extends Controller
{
   
    public function completar_cuenta($cuenta){

    }
    public function show($id){

        if(strlen(strval($id))<9){
            $cuenta='0'.strval($id);
        }else{
            $cuenta=strval($id);
        }
        
        $Encuesta=respuestas2::where('cuenta','=',$cuenta)->first();
        if(!$Encuesta){
            $Egresado=Egresado::where('cuenta',(int)$cuenta)->first();
            $Encuesta= new respuestas2();
            $Encuesta->cuenta=$cuenta;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->paterno=$Egresado->paterno;
            $Encuesta->materno=$Egresado->materno;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->nbr2=$Egresado->carrera;
            $Encuesta->nbr3=$Egresado->plantel;
            $Encuesta->save();
            
        }
        $Egresado=Egresado::where('cuenta','=',$id)->first();
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
        $Comentario=''.comentario::where('cuenta','=',$Encuesta->cuenta)->first();
        
        return view('encuesta.show',compact('Encuesta','Egresado','Carrera','Plantel','Comentario'));
}
public function edit($id){
    
    $Encuesta=respuestas2::where('registro','=',$id)->first();
    if(!$Encuesta){
        $Encuesta= new respuestas2();
    }
    $Egresado=Egresado::where('cuenta','=',$Encuesta->cuenta)->first();
    $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
    $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
    $Coment=comentario::where('cuenta','=',$Encuesta->cuenta)->first();
    if($Coment){
$Comentario=$Coment->comentario;
    }  else{
        $Comentario='';
    }
    // dd($Comentario);
    return view('encuesta.show',compact('Encuesta','Egresado','Carrera','Plantel','Comentario'));

}
public function create(){

}
public function store( Request $request){




}
public function update2(Request $request,$id){
    
$Encuesta=respuestas2::where('registro',$id)->first();
$fileName = time().$Encuesta->cuenta.'.json';
$fileStorePath = public_path('storage/'.$fileName);
File::put($fileStorePath, json_encode($request->all()));

$Encuesta-> aplica  = Auth::user()->clave;
if($request->fec_capt=="2023-01-01"){
    $Encuesta-> fec_capt  = now() ;
}else{
    $Encuesta-> fec_capt  = $request-> fec_capt ;
}

$Encuesta-> telcasa  = $request-> telcasa ;
$Encuesta-> TELCEL  = $request-> TELCEL ;
$Encuesta-> teltra  = $request-> teltra ;
$Encuesta-> exttra  = $request-> exttra ;
$Encuesta-> dianac  = substr($request->fechaNac,-2);
$Encuesta-> mesnac  = substr($request->fechaNac,5,-3);
$Encuesta-> yernac  = substr($request->fechaNac,0,4);

if(strlen(strval($request-> telcasa ))>0){
    $Encuesta-> telcasa  = $request-> telcasa ;}
if(strlen(strval($request-> TELCEL ))>0){
    $Encuesta-> TELCEL  = $request-> TELCEL ;}
if(strlen(strval($request-> teltra ))>0){
    $Encuesta-> teltra  = $request-> teltra ;}
if(strlen(strval($request-> exttra ))>0){
    $Encuesta-> exttra  = $request-> exttra ;}
if(strlen(strval($request-> dianac ))>0){
    $Encuesta-> dianac  = $request-> dianac ;}
if(strlen(strval($request-> mesnac ))>0){
    $Encuesta-> mesnac  = $request-> mesnac ;}
if(strlen(strval($request-> yernac ))>0){
    $Encuesta-> yernac  = $request-> yernac ;}
if(strlen(strval($request-> nar1 ))>0){
    $Encuesta-> nar1  = $request-> nar1 ;}
if(strlen(strval($request-> nar1_a ))>0){
    $Encuesta-> nar1_a  = $request-> nar1_a ;}
if(strlen(strval($request-> nar2a ))>0){
    $Encuesta-> nar2a  = $request-> nar2a ;}
if(strlen(strval($request-> nar3a ))>0){
    $Encuesta-> nar3a  = $request-> nar3a ;}
if(strlen(strval($request-> nar4a ))>0){
    $Encuesta-> nar4a  = $request-> nar4a ;}
if(strlen(strval($request-> nar5a ))>0){
    $Encuesta-> nar5a  = $request-> nar5a ;}
if(strlen(strval($request-> nar7 ))>0){
    $Encuesta-> nar7  = $request-> nar7 ;}
if(strlen(strval($request-> nar8 ))>0){
    $Encuesta-> nar8  = $request-> nar8 ;}
if(strlen(strval($request-> nar9 ))>0){
    $Encuesta-> nar9  = $request-> nar9 ;}
if(strlen(strval($request-> nar10 ))>0){
    $Encuesta-> nar10  = $request-> nar10 ;}
if(strlen(strval($request-> nar11 ))>0){
    $Encuesta-> nar11  = $request-> nar11 ;}
if(strlen(strval($request-> nar11a ))>0){
    $Encuesta-> nar11a  = $request-> nar11a ;}
if(strlen(strval($request-> nar12 ))>0){
    $Encuesta-> nar12  = $request-> nar12 ;}
if(strlen(strval($request-> nar12a ))>0){
    $Encuesta-> nar12a  = $request-> nar12a ;}
if(strlen(strval($request-> nar13 ))>0){
    $Encuesta-> nar13  = $request-> nar13 ;}
if(strlen(strval($request-> nar13a ))>0){
    $Encuesta-> nar13a  = $request-> nar13a ;}
if(strlen(strval($request-> nar14 ))>0){
    $Encuesta-> nar14  = $request-> nar14 ;}
if(strlen(strval($request-> nar14otra ))>0){
    $Encuesta-> nar14otra  = $request-> nar14otra ;}
if(strlen(strval($request-> nar15 ))>0){
    $Encuesta-> nar15  = $request-> nar15 ;}
if(strlen(strval($request-> nar15otra ))>0){
    $Encuesta-> nar15otra  = $request-> nar15otra ;}
if(strlen(strval($request-> nar16 ))>0){
    $Encuesta-> nar16  = $request-> nar16 ;}
if(strlen(strval($request-> nar16otra ))>0){
    $Encuesta-> nar16otra  = $request-> nar16otra ;}
if(strlen(strval($request-> nbr1 ))>0){
    $Encuesta-> nbr1  = $request-> nbr1 ;}
if(strlen(strval($request-> nbr2 ))>0){
    $Encuesta-> nbr2  = $request-> nbr2 ;}
if(strlen(strval($request-> nbr3 ))>0){
    $Encuesta-> nbr3  = $request-> nbr3 ;}
if(strlen(strval($request-> nbr3_a ))>0){
    $Encuesta-> nbr3_a  = $request-> nbr3_a ;}
if(strlen(strval($request-> nbr6 ))>0){
    $Encuesta-> nbr6  = $request-> nbr6 ;}
if(strlen(strval($request-> nbr7 ))>0){
    $Encuesta-> nbr7  = $request-> nbr7 ;}
if(strlen(strval($request-> nbr8 ))>0){
    $Encuesta-> nbr8  = $request-> nbr8 ;}
if(strlen(strval($request-> ncr1 ))>0){
    $Encuesta-> ncr1  = $request-> ncr1 ;}
if(strlen(strval($request-> ncr2 ))>0){
    $Encuesta-> ncr2  = $request-> ncr2 ;}
if(strlen(strval($request-> ncr2a ))>0){
    $Encuesta-> ncr2a  = $request-> ncr2a ;}
if(strlen(strval($request-> ncr3 ))>0){
    $Encuesta-> ncr3  = $request-> ncr3 ;}
if(strlen(strval($request-> ncr4 ))>0){
    $Encuesta-> ncr4  = $request-> ncr4 ;}
if(strlen(strval($request-> ncr4otra ))>0){
    $Encuesta-> ncr4otra  = $request-> ncr4otra ;}
if(strlen(strval($request-> ncr5 ))>0){
    $Encuesta-> ncr5  = $request-> ncr5 ;}
if(strlen(strval($request-> ncr6 ))>0){
    $Encuesta-> ncr6  = $request-> ncr6 ;}
    else{
        if(strval($request-> ncr6t)>0){
            $Encuesta-> ncr6  = $request-> ncr6t ;
        }
    }
if(strlen(strval($request-> ncr6_a ))>0){
    $Encuesta-> ncr6_a  = $request-> ncr6_a ;}
if(strlen(strval($request-> ncr7_a ))>0){
    $Encuesta-> ncr7_a  = $request-> ncr7_a ;}
if(strlen(strval($request-> ncr7b ))>0){
    $Encuesta-> ncr7b  = $request-> ncr7b ;}
if(strlen(strval($request-> ncr8 ))>0){
    $Encuesta-> ncr8  = $request-> ncr8 ;}
if(strlen(strval($request-> ncr9 ))>0){
    $Encuesta-> ncr9  = $request-> ncr9 ;}
if(strlen(strval($request-> ncr10 ))>0){
    $Encuesta-> ncr10  = $request-> ncr10 ;}
if(strlen(strval($request-> ncr11 ))>0){
    $Encuesta-> ncr11  = $request-> ncr11 ;}
if(strlen(strval($request-> ncr12_a ))>0){
    $Encuesta-> ncr12_a  = $request-> ncr12_a ;}
if(strlen(strval($request-> ncr15 ))>0){
    $Encuesta-> ncr15  = $request-> ncr15 ;}
if(strlen(strval($request-> ncr16 ))>0){
    $Encuesta-> ncr16  = $request-> ncr16 ;}
if(strlen(strval($request-> ncr17 ))>0){
    $Encuesta-> ncr17  = $request-> ncr17 ;}
if(strlen(strval($request-> ncr18 ))>0){
    $Encuesta-> ncr18  = $request-> ncr18 ;}
if(strlen(strval($request-> ncr19 ))>0){
    $Encuesta-> ncr19  = $request-> ncr19 ;}
if(strlen(strval($request-> ncr20 ))>0){
    $Encuesta-> ncr20  = $request-> ncr20 ;}
if(strlen(strval($request-> ncr21 ))>0){
    $Encuesta-> ncr21  = $request-> ncr21 ;}
if(strlen(strval($request-> ncr21_a ))>0){
    $Encuesta-> ncr21_a  = $request-> ncr21_a ;}
if(strlen(strval($request-> ncr21b ))>0){
    $Encuesta-> ncr21b  = $request-> ncr21b ;}
if(strlen(strval($request-> ncr22 ))>0){
    $Encuesta-> ncr22  = $request-> ncr22 ;}
if(strlen(strval($request-> ncr23 ))>0){
    $Encuesta-> ncr23  = $request-> ncr23 ;}
if(strlen(strval($request-> ncr24 ))>0){
    $Encuesta-> ncr24  = $request-> ncr24 ;}
if(strlen(strval($request-> ncr24porque ))>0){
    $Encuesta-> ncr24porque  = $request-> ncr24porque ;}
if(strlen(strval($request-> ncr24_a ))>0){
    $Encuesta-> ncr24_a  = $request-> ncr24_a ;}
if(strlen(strval($request-> ndr1 ))>0){
    $Encuesta-> ndr1  = $request-> ndr1 ;}
if(strlen(strval($request-> ndr2 ))>0){
    $Encuesta-> ndr2  = $request-> ndr2 ;}
if(strlen(strval($request-> ndr2_a ))>0){
    $Encuesta-> ndr2_a  = $request-> ndr2_a ;}
if(strlen(strval($request-> ndr3 ))>0){
    $Encuesta-> ndr3  = $request-> ndr3 ;}
if(strlen(strval($request-> ndr4 ))>0){
    $Encuesta-> ndr4  = $request-> ndr4 ;}
if(strlen(strval($request-> ndr5 ))>0){
    $Encuesta-> ndr5  = $request-> ndr5 ;}
if(strlen(strval($request-> ndr6 ))>0){
    $Encuesta-> ndr6  = $request-> ndr6 ;}
if(strlen(strval($request-> ndr9 ))>0){
    $Encuesta-> ndr9  = $request-> ndr9 ;}
if(strlen(strval($request-> ndr7 ))>0){
    $Encuesta-> ndr7  = $request-> ndr7 ;}
if(strlen(strval($request-> ndr8 ))>0){
    $Encuesta-> ndr8  = $request-> ndr8 ;}
if(strlen(strval($request-> ndr10 ))>0){
    $Encuesta-> ndr10  = $request-> ndr10 ;}
if(strlen(strval($request-> ndr11 ))>0){
    $Encuesta-> ndr11  = $request-> ndr11 ;}
if(strlen(strval($request-> ndr12 ))>0){
    $Encuesta-> ndr12  = $request-> ndr12 ;}
if(strlen(strval($request-> NDR12A ))>0){
    $Encuesta-> NDR12A  = $request-> NDR12A ;}
if(strlen(strval($request-> NDR12B ))>0){
    $Encuesta-> NDR12B  = $request-> NDR12B ;}
if(strlen(strval($request-> NDR12C ))>0){
    $Encuesta-> NDR12C  = $request-> NDR12C ;}
if(strlen(strval($request-> ndr13a ))>0){
    $Encuesta-> ndr13a  = $request-> ndr13a ;}
if(strlen(strval($request-> ndr14 ))>0){
    $Encuesta-> ndr14  = $request-> ndr14 ;}
if(strlen(strval($request-> ndr15 ))>0){
    $Encuesta-> ndr15  = $request-> ndr15 ;}
if(strlen(strval($request-> ndr16 ))>0){
    $Encuesta-> ndr16  = $request-> ndr16 ;}
if(strlen(strval($request-> ndr17 ))>0){
    $Encuesta-> ndr17  = $request-> ndr17 ;}
if(strlen(strval($request-> ndr18 ))>0){
    $Encuesta-> ndr18  = $request-> ndr18 ;}
if(strlen(strval($request-> ndr19 ))>0){
    $Encuesta-> ndr19  = $request-> ndr19 ;}
if(strlen(strval($request-> ner1 ))>0){
    $Encuesta-> ner1  = $request-> ner1 ;}
if(strlen(strval($request-> NER1A ))>0){
    $Encuesta-> NER1A  = $request-> NER1A ;}
if(strlen(strval($request-> ner2 ))>0){
    $Encuesta-> ner2  = $request-> ner2 ;}
if(strlen(strval($request-> ner3 ))>0){
    $Encuesta-> ner3  = $request-> ner3 ;}
if(strlen(strval($request-> ner4 ))>0){
    $Encuesta-> ner4  = $request-> ner4 ;}
if(strlen(strval($request-> ner5 ))>0){
    $Encuesta-> ner5  = $request-> ner5 ;}
if(strlen(strval($request-> ner6 ))>0){
    $Encuesta-> ner6  = $request-> ner6 ;}
if(strlen(strval($request-> ner7 ))>0){
    $Encuesta-> ner7  = $request-> ner7 ;}
if(strlen(strval($request-> ner7_a ))>0){
    $Encuesta-> ner7_a  = $request-> ner7_a ;}
if(strlen(strval($request-> ner7int ))>0){
    $Encuesta-> ner7int  = $request-> ner7int ;}
if(strlen(strval($request-> ner8 ))>0){
    $Encuesta-> ner8  = $request-> ner8 ;}
if(strlen(strval($request-> ner9 ))>0){
    $Encuesta-> ner9  = $request-> ner9 ;}
if(strlen(strval($request-> ner10 ))>0){
    $Encuesta-> ner10  = $request-> ner10 ;}
if(strlen(strval($request-> ner10a ))>0){
    $Encuesta-> ner10a  = $request-> ner10a ;}
if(strlen(strval($request-> ner11 ))>0){
    $Encuesta-> ner11  = $request-> ner11 ;}
if(strlen(strval($request-> ner12 ))>0){
    $Encuesta-> ner12  = $request-> ner12 ;}
if(strlen(strval($request-> ner12a ))>0){
    $Encuesta-> ner12a  = $request-> ner12a ;}
if(strlen(strval($request-> ner12b ))>0){
    $Encuesta-> ner12b  = $request-> ner12b ;}
if(strlen(strval($request-> ner13 ))>0){
    $Encuesta-> ner13  = $request-> ner13 ;}
if(strlen(strval($request-> ner14 ))>0){
    $Encuesta-> ner14  = $request-> ner14 ;}
if(strlen(strval($request-> ner15 ))>0){
    $Encuesta-> ner15  = $request-> ner15 ;}
if(strlen(strval($request-> ner16 ))>0){
    $Encuesta-> ner16  = $request-> ner16 ;}
if(strlen(strval($request-> ner17 ))>0){
    $Encuesta-> ner17  = $request-> ner17 ;}
if(strlen(strval($request-> ner18 ))>0){
    $Encuesta-> ner18  = $request-> ner18 ;}
if(strlen(strval($request-> ner19 ))>0){
    $Encuesta-> ner19  = $request-> ner19 ;}
if(strlen(strval($request-> ner19a ))>0){
    $Encuesta-> ner19a  = $request-> ner19a ;}
if(strlen(strval($request-> ner20 ))>0){
    $Encuesta-> ner20  = $request-> ner20 ;}
if(strlen(strval($request-> ner20txt ))>0){
    $Encuesta-> ner20txt  = $request-> ner20txt ;}
if(strlen(strval($request-> ner20a ))>0){
    $Encuesta-> ner20a  = $request-> ner20a ;}
if(strlen(strval($request-> nfr0 ))>0){
    $Encuesta-> nfr0  = $request-> nfr0 ;}
if(strlen(strval($request-> nfr1 ))>0){
    $Encuesta-> nfr1  = $request-> nfr1 ;}
if(strlen(strval($request-> nfr1a ))>0){
    $Encuesta-> nfr1a  = $request-> nfr1a ;}
if(strlen(strval($request-> nfr2 ))>0){
    $Encuesta-> nfr2  = $request-> nfr2 ;}
if(strlen(strval($request-> nfr3 ))>0){
    $Encuesta-> nfr3  = $request-> nfr3 ;}
if(strlen(strval($request-> nfr7 ))>0){
    $Encuesta-> nfr7  = $request-> nfr7 ;}
if(strlen(strval($request-> nfr4 ))>0){
    $Encuesta-> nfr4  = $request-> nfr4 ;}
if(strlen(strval($request-> nfr4_a ))>0){
    $Encuesta-> nfr4_a  = $request-> nfr4_a ;}
if(strlen(strval($request-> nfr5 ))>0){
    $Encuesta-> nfr5  = $request-> nfr5 ;}
if(strlen(strval($request-> nfr5_a ))>0){
    $Encuesta-> nfr5_a  = $request-> nfr5_a ;}
if(strlen(strval($request-> nfr6 ))>0){
    $Encuesta-> nfr6  = $request-> nfr6 ;}
if(strlen(strval($request-> nfr6_a ))>0){
    $Encuesta-> nfr6_a  = $request-> nfr6_a ;}
if(strlen(strval($request-> nfr8 ))>0){
    $Encuesta-> nfr8  = $request-> nfr8 ;}
if(strlen(strval($request-> nfr9 ))>0){
    $Encuesta-> nfr9  = $request-> nfr9 ;}
if(strlen(strval($request-> nfr10 ))>0){
    $Encuesta-> nfr10  = $request-> nfr10 ;}
if(strlen(strval($request-> nfr11 ))>0){
    $Encuesta-> nfr11  = $request-> nfr11 ;}
if(strlen(strval($request-> nfr11a ))>0){
    $Encuesta-> nfr11a  = $request-> nfr11a ;}
if(strlen(strval($request-> nfr12 ))>0){
    $Encuesta-> nfr12  = $request-> nfr12 ;}
if(strlen(strval($request-> nfr13 ))>0){
    $Encuesta-> nfr13  = $request-> nfr13 ;}
if(strlen(strval($request-> nfr22 ))>0){
    $Encuesta-> nfr22  = $request-> nfr22 ;}
if(strlen(strval($request-> nfr23 ))>0){
    $Encuesta-> nfr23  = $request-> nfr23 ;}
if(strlen(strval($request-> nfr24 ))>0){
    $Encuesta-> nfr24  = $request-> nfr24 ;}
if(strlen(strval($request-> nfr25 ))>0){
    $Encuesta-> nfr25  = $request-> nfr25 ;}
if(strlen(strval($request-> nfr26 ))>0){
    $Encuesta-> nfr26  = $request-> nfr26 ;}
if(strlen(strval($request-> nfr27 ))>0){
    $Encuesta-> nfr27  = $request-> nfr27 ;}
if(strlen(strval($request-> nfr28 ))>0){
    $Encuesta-> nfr28  = $request-> nfr28 ;}
if(strlen(strval($request-> nfr29 ))>0){
    $Encuesta-> nfr29  = $request-> nfr29 ;}
if(strlen(strval($request-> nfr29a ))>0){
    $Encuesta-> nfr29a  = $request-> nfr29a ;}
if(strlen(strval($request-> nfr30 ))>0){
    $Encuesta-> nfr30  = $request-> nfr30 ;}
if(strlen(strval($request-> nfr31 ))>0){
    $Encuesta-> nfr31  = $request-> nfr31 ;}
if(strlen(strval($request-> nfr32 ))>0){
    $Encuesta-> nfr32  = $request-> nfr32 ;}
if(strlen(strval($request-> nfr33 ))>0){
    $Encuesta-> nfr33  = $request-> nfr33 ;}
if(strlen(strval($request-> ngr1 ))>0){
    $Encuesta-> ngr1  = $request-> ngr1 ;}
if(strlen(strval($request-> ngr2 ))>0){
    $Encuesta-> ngr2  = $request-> ngr2 ;}
if(strlen(strval($request-> ngr3 ))>0){
    $Encuesta-> ngr3  = $request-> ngr3 ;}
if(strlen(strval($request-> ngr3b ))>0){
    $Encuesta-> ngr3b  = $request-> ngr3b ;}
if(strlen(strval($request-> ngr3c ))>0){
    $Encuesta-> ngr3c  = $request-> ngr3c ;}
if(strlen(strval($request-> ngr3d ))>0){
    $Encuesta-> ngr3d  = $request-> ngr3d ;}
if(strlen(strval($request-> ngr3e ))>0){
    $Encuesta-> ngr3e  = $request-> ngr3e ;}
if(strlen(strval($request-> ngr4 ))>0){
    $Encuesta-> ngr4  = $request-> ngr4 ;}
if(strlen(strval($request-> ngr5 ))>0){
    $Encuesta-> ngr5  = $request-> ngr5 ;}
if(strlen(strval($request-> ngr6 ))>0){
    $Encuesta-> ngr6  = $request-> ngr6 ;}
if(strlen(strval($request-> ngr6a ))>0){
    $Encuesta-> ngr6a  = $request-> ngr6a ;}
if(strlen(strval($request-> ngr6b ))>0){
    $Encuesta-> ngr6b  = $request-> ngr6b ;}
if(strlen(strval($request-> ngr6c ))>0){
    $Encuesta-> ngr6c  = $request-> ngr6c ;}
if(strlen(strval($request-> ngr6d ))>0){
    $Encuesta-> ngr6d  = $request-> ngr6d ;}
if(strlen(strval($request-> ngr6e ))>0){
    $Encuesta-> ngr6e  = $request-> ngr6e ;}
if(strlen(strval($request-> ngr6f ))>0){
    $Encuesta-> ngr6f  = $request-> ngr6f ;}
if(strlen(strval($request-> ngr6g ))>0){
    $Encuesta-> ngr6g  = $request-> ngr6g ;}
if(strlen(strval($request-> ngr6_t ))>0){
    $Encuesta-> ngr6_t  = $request-> ngr6_t ;}
if(strlen(strval($request-> ngr7a ))>0){
    $Encuesta-> ngr7a  = $request-> ngr7a ;}
if(strlen(strval($request-> ngr7b ))>0){
    $Encuesta-> ngr7b  = $request-> ngr7b ;}
if(strlen(strval($request-> ngr7c ))>0){
    $Encuesta-> ngr7c  = $request-> ngr7c ;}
if(strlen(strval($request-> ngr7d ))>0){
    $Encuesta-> ngr7d  = $request-> ngr7d ;}
if(strlen(strval($request-> ngr7e ))>0){
    $Encuesta-> ngr7e  = $request-> ngr7e ;}
if(strlen(strval($request-> ngr7f ))>0){
    $Encuesta-> ngr7f  = $request-> ngr7f ;}
if(strlen(strval($request-> ngr7g ))>0){
    $Encuesta-> ngr7g  = $request-> ngr7g ;}
if(strlen(strval($request-> ngr8 ))>0){
    $Encuesta-> ngr8  = $request-> ngr8 ;}
if(strlen(strval($request-> ngr9a ))>0){
    $Encuesta-> ngr9a  = $request-> ngr9a ;}
if(strlen(strval($request-> ngr9b ))>0){
    $Encuesta-> ngr9b  = $request-> ngr9b ;}
if(strlen(strval($request-> ngr9c ))>0){
    $Encuesta-> ngr9c  = $request-> ngr9c ;}
if(strlen(strval($request-> ngr9d ))>0){
    $Encuesta-> ngr9d  = $request-> ngr9d ;}
if(strlen(strval($request-> ngr9e ))>0){
    $Encuesta-> ngr9e  = $request-> ngr9e ;}
if(strlen(strval($request-> ngr11a ))>0){
    $Encuesta-> ngr11a  = $request-> ngr11a ;}
if(strlen(strval($request-> ngr11 ))>0){
    $Encuesta-> ngr11  = $request-> ngr11 ;}
if(strlen(strval($request-> ngr11_a ))>0){
    $Encuesta-> ngr11_a  = $request-> ngr11_a ;}
if(strlen(strval($request-> ngr13 ))>0){
    $Encuesta-> ngr13  = $request-> ngr13 ;}
if(strlen(strval($request-> ngr13b ))>0){
    $Encuesta-> ngr13b  = $request-> ngr13b ;}
if(strlen(strval($request-> ngr13c ))>0){
    $Encuesta-> ngr13c  = $request-> ngr13c ;}
if(strlen(strval($request-> ngr13d ))>0){
    $Encuesta-> ngr13d  = $request-> ngr13d ;}
if(strlen(strval($request-> ngr13e ))>0){
    $Encuesta-> ngr13e  = $request-> ngr13e ;}
if(strlen(strval($request-> ngr14 ))>0){
    $Encuesta-> ngr14  = $request-> ngr14 ;}
if(strlen(strval($request-> ngr15 ))>0){
    $Encuesta-> ngr15  = $request-> ngr15 ;}
if(strlen(strval($request-> ngr16 ))>0){
    $Encuesta-> ngr16  = $request-> ngr16 ;}
if(strlen(strval($request-> ngr17 ))>0){
    $Encuesta-> ngr17  = $request-> ngr17 ;}
if(strlen(strval($request-> ngr18 ))>0){
    $Encuesta-> ngr18  = $request-> ngr18 ;}
if(strlen(strval($request-> ngr19 ))>0){
    $Encuesta-> ngr19  = $request-> ngr19 ;}
if(strlen(strval($request-> ngr20 ))>0){
    $Encuesta-> ngr20  = $request-> ngr20 ;}
if(strlen(strval($request-> ngr21 ))>0){
    $Encuesta-> ngr21  = $request-> ngr21 ;}
if(strlen(strval($request-> ngr22 ))>0){
    $Encuesta-> ngr22  = $request-> ngr22 ;}
if(strlen(strval($request-> ngr23 ))>0){
    $Encuesta-> ngr23  = $request-> ngr23 ;}
if(strlen(strval($request-> ngr24 ))>0){
    $Encuesta-> ngr24  = $request-> ngr24 ;}
if(strlen(strval($request-> ngr25 ))>0){
    $Encuesta-> ngr25  = $request-> ngr25 ;}
if(strlen(strval($request-> ngr26 ))>0){
    $Encuesta-> ngr26  = $request-> ngr26 ;}
if(strlen(strval($request-> ngr27 ))>0){
    $Encuesta-> ngr27  = $request-> ngr27 ;}
if(strlen(strval($request-> ngr28 ))>0){
    $Encuesta-> ngr28  = $request-> ngr28 ;}
if(strlen(strval($request-> ngr29 ))>0){
    $Encuesta-> ngr29  = $request-> ngr29 ;}
if(strlen(strval($request-> ngr30 ))>0){
    $Encuesta-> ngr30  = $request-> ngr30 ;}
if(strlen(strval($request-> ngr31 ))>0){
    $Encuesta-> ngr31  = $request-> ngr31 ;}
if(strlen(strval($request-> ngr32 ))>0){
    $Encuesta-> ngr32  = $request-> ngr32 ;}
if(strlen(strval($request-> ngr33 ))>0){
    $Encuesta-> ngr33  = $request-> ngr33 ;}
if(strlen(strval($request-> ngr34 ))>0){
    $Encuesta-> ngr34  = $request-> ngr34 ;}
if(strlen(strval($request-> ngr35 ))>0){
    $Encuesta-> ngr35  = $request-> ngr35 ;}
if(strlen(strval($request-> ngr36 ))>0){
    $Encuesta-> ngr36  = $request-> ngr36 ;}
if(strlen(strval($request-> ngr37 ))>0){
    $Encuesta-> ngr37  = $request-> ngr37 ;}
if(strlen(strval($request-> ngr37m ))>0){
    $Encuesta-> ngr37m  = $request-> ngr37m ;}
if(strlen(strval($request-> ngr37_a ))>0){
    $Encuesta-> ngr37_a  = $request-> ngr37_a ;}
if(strlen(strval($request-> ngr38 ))>0){
    $Encuesta-> ngr38  = $request-> ngr38 ;}
if(strlen(strval($request-> ngr39 ))>0){
    $Encuesta-> ngr39  = $request-> ngr39 ;}
if(strlen(strval($request-> ngr40 ))>0){
    $Encuesta-> ngr40  = $request-> ngr40 ;}
if(strlen(strval($request-> ngr40a ))>0){
    $Encuesta-> ngr40a  = $request-> ngr40a ;}
if(strlen(strval($request-> ngr40_a ))>0){
    $Encuesta-> ngr40_a  = $request-> ngr40_a ;}
if(strlen(strval($request-> ngr40_b ))>0){
    $Encuesta-> ngr40_b  = $request-> ngr40_b ;}
if(strlen(strval($request-> ngr41 ))>0){
    $Encuesta-> ngr41  = $request-> ngr41 ;}
if(strlen(strval($request-> ngr42 ))>0){
    $Encuesta-> ngr42  = $request-> ngr42 ;}
if(strlen(strval($request-> ngr43 ))>0){
    $Encuesta-> ngr43  = $request-> ngr43 ;}
if(strlen(strval($request-> ngr44 ))>0){
    $Encuesta-> ngr44  = $request-> ngr44 ;}
if(strlen(strval($request-> ngr45 ))>0){
    $Encuesta-> ngr45  = $request-> ngr45 ;}
if(strlen(strval($request-> ngr45_a ))>0){
    $Encuesta-> ngr45_a  = $request-> ngr45_a ;}
if(strlen(strval($request-> ngr45otra ))>0){
    $Encuesta-> ngr45otra  = $request-> ngr45otra ;}
if(strlen(strval($request-> conoce ))>0){
    $Encuesta-> conoce  = $request-> conoce ;}
if(strlen(strval($request-> cue_cre ))>0){
    $Encuesta-> cue_cre  = $request-> cue_cre ;}
if(strlen(strval($request-> utiliza ))>0){
    $Encuesta-> utiliza  = $request-> utiliza ;}
if(strlen(strval($request-> nrx ))>0){
    $Encuesta-> nrx  = $request-> nrx ;}
if(strlen(strval($request-> nrxx ))>0){
    $Encuesta-> nrxx  = $request-> nrxx ;}
if(strlen(strval($request-> ngr11b ))>0){
    $Encuesta-> ngr11b  = $request-> ngr11b ;}
if(strlen(strval($request-> ngr11c ))>0){
    $Encuesta-> ngr11c  = $request-> ngr11c ;}
if(strlen(strval($request-> ngr11d ))>0){
    $Encuesta-> ngr11d  = $request-> ngr11d ;}
if(strlen(strval($request-> ngr11e ))>0){
    $Encuesta-> ngr11e  = $request-> ngr11e ;}
if(strlen(strval($request-> ngr11f ))>0){
    $Encuesta-> ngr11f  = $request-> ngr11f ;}

$Encuesta->save();
$fileName = $Encuesta->cuenta.'.json';
$fileStorePath = public_path('storage/json/'.$fileName);

File::put($fileStorePath, json_encode($request->all()));
$comentario=comentario::where('cuenta',$Encuesta->cuenta)->first();
if($comentario){
    $comentario->comentario=$request->comentario;
    $comentario->save();
}else{
    $comentario=new comentario();
    $comentario->cuenta=$Encuesta->cuenta;
    $comentario->comentario=$request->comentario;
    $comentario->save();
}

// $r3=respuestas3::where('cuenta',$Encuesta->cuenta)->first;
// $r3->APLICA='TELEFONICA';
// $r3->save();
return view('encuesta.saved',compact('Encuesta'));

}

public function json($id){
    $fileName = $id.'.json';
    $fileStorePath = public_path('storage/json/'.$fileName);
return response()->download($fileStorePath);
}

public function verificar($id){
    $Encuesta=respuestas2::where('registro',$id)->first();
    //dd($Encuesta);
    foreach ($Encuesta->toArray() as $key => $value) {
    
    //     $unserialize_obj_check = @unserialize($value);

    //     if($value === '' || is_null($value) || $value === FALSE || $value === '0' || $value === 'b:0;')
    //     {
    //         $obj->{$key} = FALSE;
    //     }
    //     elseif ($unserialize_obj_check  !== false) {

    //         //unserialize for php use 
    //         $obj->{$key} = unserialize($value);
    //     } 
    // }
   
    if(is_null($value)){
        echo($key.' ,  ');
        
    }
    
}
}

public function show_14($id){

  
    
    $Encuesta=respuestas14::where('registro','=',$id)->first();
    if(!$Encuesta){

        return Redirect::back();
        
    }
    $Carrera=Carrera::where('clave_carrera','=',$Encuesta->NBR2)->first()->carrera;
    $Plantel=Carrera::where('clave_plantel','=',$Encuesta->NBR3)->first()->plantel;
    $Comentario=''.comentario::where('cuenta','=',$Encuesta->cuenta)->first();
    
    return view('encuesta.show_14',compact('Encuesta','Carrera','Plantel','Comentario'));
}


function update14(Request $request,$id){
    $Encuesta=respuestas14::where('registro',$id)->first();
    
    $Encuesta-> aplica  = Auth::user()->clave;
    if($request->fec_capt=="2023-01-01"){
        $Encuesta-> fec_capt  = now() ;
    }else{
        $Encuesta-> fec_capt  = $request-> fec_capt ;
    }

    $Encuesta-> TELCASA = $request-> telcasa ;
    $Encuesta-> TELTRA  = $request-> teltra ;
    $Encuesta-> EXTTRA  = $request-> exttra ;

    if(strlen(strval($request-> nar8 ))>0){
        $Encuesta-> NAR8  = $request-> nar8 ;}
  if(strlen(strval($request-> nar9 ))>0){
        $Encuesta-> NAR9  = $request-> nar9 ;}
  if(strlen(strval($request-> nar10 ))>0){
        $Encuesta-> NAR10  = $request-> nar10 ;}
  if(strlen(strval($request-> nar1_a ))>0){
        $Encuesta-> NAR1_A  = $request-> nar1_a ;}
  if(strlen(strval($request-> nar11 ))>0){
        $Encuesta-> NAR11  = $request-> nar11 ;}
  if(strlen(strval($request-> nar11a ))>0){
        $Encuesta-> NAR11A  = $request-> nar11a ;}
  if(strlen(strval($request-> nar14 ))>0){
        $Encuesta-> NAR14  = $request-> nar14 ;}
  if(strlen(strval($request-> nar14otra ))>0){
        $Encuesta-> NAR14OTRA  = $request-> nar14otra ;}
  if(strlen(strval($request-> ner20 ))>0){
        $Encuesta-> NER20  = $request-> ner20 ;}
  if(strlen(strval($request-> ner20txt ))>0){
        $Encuesta-> NER20TXT  = $request-> ner20txt ;}
  if(strlen(strval($request-> ner20a ))>0){
        $Encuesta-> NER20A  = $request-> ner20a ;}
  if(strlen(strval($request-> nar1 ))>0){
        $Encuesta-> NAR1  = $request-> nar1 ;}
  if(strlen(strval($request-> ncr1 ))>0){
        $Encuesta-> NCR1  = $request-> ncr1 ;}
  if(strlen(strval($request-> ncr2 ))>0){
        $Encuesta-> NCR2  = $request-> ncr2 ;}
  if(strlen(strval($request-> ncr2a ))>0){
        $Encuesta-> NCR2A  = $request-> ncr2a ;}
  if(strlen(strval($request-> ncr3 ))>0){
        $Encuesta-> NCR3  = $request-> ncr3 ;}
  if(strlen(strval($request-> ncr4 ))>0){
        $Encuesta-> NCR4  = $request-> ncr4 ;}
  if(strlen(strval($request-> ncr4a ))>0){
        $Encuesta-> NCR4OTRA  = $request-> ncr4a ;}
  if(strlen(strval($request-> ncr5 ))>0){
        $Encuesta-> NCR5  = $request-> ncr5 ;}
  if(strlen(strval($request-> ncr6 ))>0){
        $Encuesta-> NCR6  = $request-> ncr6 ;}
  if($request-> ncr6t >0){
        $Encuesta-> NCR6  = $request-> ncr6t ;}
  if(strlen(strval($request-> ncr6_a ))>0){
        $Encuesta-> NCR6_A  = $request-> ncr6_a ;}
  if(strlen(strval($request-> ncr7a ))>0){
        $Encuesta-> NCR7_A  = $request-> ncr7a ;}
  if(strlen(strval($request-> ncr7b ))>0){
        $Encuesta-> NCR7B  = $request-> ncr7b ;}
  if(strlen(strval($request-> ncr8 ))>0){
        $Encuesta-> NCR8  = $request-> ncr8 ;}
  if(strlen(strval($request-> ncr9 ))>0){
        $Encuesta-> NCR9  = $request-> ncr9 ;}
  if(strlen(strval($request-> ncr10 ))>0){
        $Encuesta-> NCR10  = $request-> ncr10 ;}
  if(strlen(strval($request-> ncr11 ))>0){
        $Encuesta-> NCR11  = $request-> ncr11 ;}
  if(strlen(strval($request-> ncr12_a ))>0){
        $Encuesta-> NCR12_A  = $request-> ncr12_a ;}
  if(strlen(strval($request-> ncr15 ))>0){
        $Encuesta-> NCR15  = $request-> ncr15 ;}
  if(strlen(strval($request-> ncr16 ))>0){
        $Encuesta-> NCR16  = $request-> ncr16 ;}
  if(strlen(strval($request-> ncr17 ))>0){
        $Encuesta-> NCR17  = $request-> ncr17 ;}
  if(strlen(strval($request-> ncr18 ))>0){
        $Encuesta-> NCR18  = $request-> ncr18 ;}
  if(strlen(strval($request-> ncr19 ))>0){
        $Encuesta-> NCR19  = $request-> ncr19 ;}
  if(strlen(strval($request-> ncra20 ))>0){
        $Encuesta-> NCRA20  = $request-> ncra20 ;}
  if(strlen(strval($request-> ncr20 ))>0){
        $Encuesta-> NCR20  = $request-> ncr20 ;}
  if(strlen(strval($request-> ncr21_a ))>0){
        $Encuesta-> NCR21_A  = $request-> ncr21_a ;}
  if(strlen(strval($request-> ncr22 ))>0){
        $Encuesta-> NCR22  = $request-> ncr22 ;}
  if(strlen(strval($request-> ncr24 ))>0){
        $Encuesta-> NCR24  = $request-> ncr24 ;}
  if(strlen(strval($request-> ncr24a ))>0){
        $Encuesta-> NCR24_A  = $request-> ncr24a ;}
  if(strlen(strval($request-> ncr24porque ))>0){
        $Encuesta-> NCR24PORQUE  = $request-> ncr24porque ;}
  if(strlen(strval($request-> ncr23 ))>0){
        $Encuesta-> NCR23  = $request-> ncr23 ;}
  if(strlen(strval($request-> ndr17 ))>0){
        $Encuesta-> NDR17  = $request-> ndr17 ;}
  if(strlen(strval($request-> ndr18 ))>0){
        $Encuesta-> NDR18  = $request-> ndr18 ;}
  if(strlen(strval($request-> ndr19 ))>0){
        $Encuesta-> NDR19  = $request-> ndr19 ;}
  if(strlen(strval($request-> ner1 ))>0){
        $Encuesta-> NER1  = $request-> ner1 ;}
  if(strlen(strval($request-> ner2 ))>0){
        $Encuesta-> NER2  = $request-> ner2 ;}
//   if(strlen(strval($request-> ner1a ))>0){
//         $Encuesta-> NER1A  = $request-> ner1a ;}
  if(strlen(strval($request-> ner3 ))>0){
        $Encuesta-> NER3  = $request-> ner3 ;}
  if(strlen(strval($request-> ner4 ))>0){
        $Encuesta-> NER4  = $request-> ner4 ;}
  if(strlen(strval($request-> ner5 ))>0){
        $Encuesta-> NER5  = $request-> ner5 ;}
  if(strlen(strval($request-> ner6 ))>0){
        $Encuesta-> NER6  = $request-> ner6 ;}
  if(strlen(strval($request-> ner7 ))>0){
        $Encuesta-> NER7  = $request-> ner7 ;}
  if(strlen(strval($request-> ner7int ))>0){
        $Encuesta-> NER7INT  = $request-> ner7int ;}
  if(strlen(strval($request-> ner7a ))>0){
         $Encuesta-> NER7_A  = $request-> ner7a ;}
  if(strlen(strval($request-> ner8 ))>0){
        $Encuesta-> NER8  = $request-> ner8 ;}
  if(strlen(strval($request-> ner9 ))>0){
        $Encuesta-> NER9  = $request-> ner9 ;}
  if(strlen(strval($request-> ner10 ))>0){
        $Encuesta-> NER10  = $request-> ner10 ;}
  if(strlen(strval($request-> ner10a ))>0){
        $Encuesta-> NER10A  = $request-> ner10a ;}
  if(strlen(strval($request-> ner11 ))>0){
        $Encuesta-> NER11  = $request-> ner11 ;}
  if(strlen(strval($request-> ner12 ))>0){
        $Encuesta-> NER12  = $request-> ner12 ;}
  if(strlen(strval($request-> ner13 ))>0){
        $Encuesta-> NER13  = $request-> ner13 ;}
  if(strlen(strval($request-> ner14 ))>0){
        $Encuesta-> NER14  = $request-> ner14 ;}
  if(strlen(strval($request-> ner15 ))>0){
        $Encuesta-> NER15  = $request-> ner15 ;}
  if(strlen(strval($request-> ner12a ))>0){
        $Encuesta-> NER12A  = $request-> ner12a ;}
  if(strlen(strval($request-> ner12b ))>0){
        $Encuesta-> NER12B  = $request-> ner12b ;}
  if(strlen(strval($request-> ner16 ))>0){
        $Encuesta-> NER16  = $request-> ner16 ;}
  if(strlen(strval($request-> ner17 ))>0){
        $Encuesta-> NER17  = $request-> ner17 ;}
  if(strlen(strval($request-> ner18 ))>0){
        $Encuesta-> NER18  = $request-> ner18 ;}
  if(strlen(strval($request-> ner19 ))>0){
        $Encuesta-> NER19  = $request-> ner19 ;}
  if(strlen(strval($request-> nfr27 ))>0){
        $Encuesta-> NFR27  = $request-> nfr27 ;}
  if(strlen(strval($request-> nfr28 ))>0){
        $Encuesta-> NFR28  = $request-> nfr28 ;}
  if(strlen(strval($request-> nfr29 ))>0){
        $Encuesta-> NFR29  = $request-> nfr29 ;}
  if(strlen(strval($request-> nfr29a ))>0){
        $Encuesta-> NFR29A  = $request-> nfr29a ;}
if(strlen(strval($request-> ngr13 ))>0){
        $Encuesta-> NGR13  = $request-> ngr13 ;}
  if(strlen(strval($request-> ngr13a ))>0){
        $Encuesta-> NGR13A  = $request-> ngr13a ;}
  if(strlen(strval($request-> ngr13b ))>0){
        $Encuesta-> NGR13B  = $request-> ngr13b ;}
  if(strlen(strval($request-> ngr13c ))>0){
        $Encuesta-> NGR13C  = $request-> ngr13c ;}
  if(strlen(strval($request-> ngr13d ))>0){
        $Encuesta-> NGR13D  = $request-> ngr13d ;}
  if(strlen(strval($request-> ngr11a ))>0){
        $Encuesta-> NGR11  = $request-> ngr11a ;}
  
        $Encuesta->save();
        $fileName = $Encuesta->CUENTA.'.json';
        $fileStorePath = public_path('storage/json/'.$fileName);
        
        File::put($fileStorePath, json_encode($request->all()));
        
        return view('encuesta.saved',compact('Encuesta'));
        
 }
}
