<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reactivo;

use App\Models\Option;

class ReactivosController extends Controller
{
  public function index(){
  $Reactivos=Reactivo::all();
  return view('admin.reactivos.index',compact('Reactivos'));
  }
  
  public function edit( $id){
   $Reactivo=Reactivo::find($id);
   //  dd($Reactivo);
   $Opciones=Option::where('reactivo',$Reactivo->clave)->OrderBy('clave')->get();
   if($Reactivo->archtype){
     $Opciones=Option::where('reactivo',$Reactivo->archtype)->OrderBy('clave')->get();  
   }
    return view('admin.reactivos.edit',compact('Reactivo','Opciones'));
  }

  public function create(){
    return view('admin.reactivos.create');
  }

  public function store(Request $request){

  }

  public function delete(){

  }
  public function update(Request $request,$id){
        $Reactivo=Reactivo::find($id);
        $Reactivo->update($request->except(['_token', '_method']));
        $Reactivo->save();
        return redirect()->route('reactivos.index');
  }
}

