<?php

namespace App\Http\Controllers;

use App\excelModel;
use App\tigo;
use App\tigoExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel as Exx;

class TigoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tigo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request -> input('numero_usuario') && $request -> input('nombre') && $request -> input('ci')){
            $numero_usuario = request('numero_usuario');
            $nombre = request('nombre');
            $ci = request('ci');

            for($i=0; $i < sizeof($nombre); $i++){
                $tigo = new tigo();
                $tigo -> numero_usuario = $numero_usuario[$i];
                $tigo -> nombre = $nombre[$i];
                $tigo -> ci = $ci[$i];

                $tigo -> save();
            }
        }
        return view('tigo.excel');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tigo  $tigo
     * @return \Illuminate\Http\Response
     */
    public function show(tigo $tigo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tigo  $tigo
     * @return \Illuminate\Http\Response
     */
    public function edit(tigo $tigo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tigo  $tigo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tigo $tigo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tigo  $tigo
     * @return \Illuminate\Http\Response
     */
    public function destroy(tigo $tigo)
    {
        //
    }

    public function excel(tigo $viva)
    {
        return view('tigo.excel');
    }

    public function mostrarTabla(tigo $tigo)
    {
        $vertical = DB::table('tigos')             //contar arreglo con count($vertical)
                            ->select('numero_usuario')
                            ->get();

            $horizontal = DB::table('tigo_excels')           //contar arreglo con count($horizontal)
                            ->select('identificador')
                            ->groupBy('identificador')
                            ->get();

            $Matriz[0][0] = 0;

            for ($i=1; $i < count($vertical)+1 ; $i++) { 
                for ($j=0; $j < count($horizontal)+1 ; $j++) { 

                    if ($j==0) {
                        $Matriz[$i][0] = $vertical[$i-1]->numero_usuario;
                    }else{
                        $Matriz[$i][$j]=0;
                    }
                   
                }
            }


            for ($i=0; $i < count($horizontal) ; $i++) { 
                $Matriz[0][$i+1] = $horizontal[$i]->identificador;
            }

            /*
            for ($i=0; $i < count($vertical)+1 ; $i++) { 
                for ($j=1; $j < count($horizontal)+1 ; $j++) { 

                    if ($i==0) {
                        $Matriz[0][$j] = $horizontal[$j-1]->identificador;
                    }else{
                        $Matriz[$i][$j]=0;
                    }
                   
                }
            }*/

            for ($i=1; $i < count($vertical)+1 ; $i++) { 
                for ($j=1; $j < count($horizontal)+1 ; $j++) { 

                    $consulta = DB::table('tigo_excels')
                                ->select('*')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->orWhere('numeroA','=',$Matriz[$i][0])
                                ->orWhere('numeroB','=',$Matriz[$i][0])
                                ->exists();

                    if($consulta){

                        $aux1 = DB::table('tigo_excels')
                                ->select('numeroA')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroA','=',$Matriz[$i][0])
                                ->count();

                                
                        $aux2 = DB::table('tigo_excels')
                                ->select('numeroB')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroB','=',$Matriz[$i][0])
                                ->count();

                        $Matriz[$i][$j] = $aux1+$aux2;
                    }else{
                        $Matriz[$i][$j] = 0;
                    }
                }
             
            }
            $v = count($vertical)+1;
            $h= count($horizontal)+1;

          
            return view('tigo.view',compact('Matriz','v','h'));
    }

    public function subirExcel(Request $request)
    {
        try {
            
            if ($request->hasFile('archivos')){

            $archivos = request('archivos');
            $numero = request('numero');
            $file = $request->file('archivos');
            
            for ($i=0; $i < sizeOf($archivos); $i++) { 
                
                $existe = DB::table('tigo_excels')
                            ->select('*')
                            ->where('identificador', $numero[$i])
                            ->exists();
                            
                if (!$existe) {
                    
                    Exx::import(new tigo , $file[$i]);
                    DB::table('tigo_excels')
                    ->where('identificador', null)
                    ->update(['identificador' => $numero[$i]]);
                }
                
                
                
            }
            

            $vertical = DB::table('tigos')             //contar arreglo con count($vertical)
                            ->select('numero_usuario')
                            ->get();

            $horizontal = DB::table('tigo_excels')           //contar arreglo con count($horizontal)
                            ->select('identificador')
                            ->groupBy('identificador')
                            ->get();

            $Matriz[0][0] = 0;

            for ($i=1; $i < count($vertical)+1 ; $i++) { 
                for ($j=0; $j < count($horizontal)+1 ; $j++) { 

                    if ($j==0) {
                        $Matriz[$i][0] = $vertical[$i-1]->numero_usuario;
                    }else{
                        $Matriz[$i][$j]=0;
                    }
                   
                }
            }


            for ($i=0; $i < count($horizontal) ; $i++) { 
                $Matriz[0][$i+1] = $horizontal[$i]->identificador;
            }

            /*
            for ($i=0; $i < count($vertical)+1 ; $i++) { 
                for ($j=1; $j < count($horizontal)+1 ; $j++) { 

                    if ($i==0) {
                        $Matriz[0][$j] = $horizontal[$j-1]->identificador;
                    }else{
                        $Matriz[$i][$j]=0;
                    }
                   
                }
            }*/

            for ($i=1; $i < count($vertical)+1 ; $i++) { 
                for ($j=1; $j < count($horizontal)+1 ; $j++) { 

                    $consulta = DB::table('tigo_excels')
                                ->select('*')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->orWhere('numeroA','=',$Matriz[$i][0])
                                ->orWhere('numeroB','=',$Matriz[$i][0])
                                ->exists();

                    if($consulta){

                        $aux1 = DB::table('tigo_excels')
                                ->select('numeroA')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroA','=',$Matriz[$i][0])
                                ->count();

                                
                        $aux2 = DB::table('tigo_excels')
                                ->select('numeroB')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroB','=',$Matriz[$i][0])
                                ->count();

                        $Matriz[$i][$j] = $aux1+$aux2;

                        
                    }else{
                        $Matriz[$i][$j] = 0;
                    }
                }
             
            }
            $v = count($vertical)+1;
            $h= count($horizontal)+1;

          
            return view('tigo.view',compact('Matriz','v','h'));
        }
        } catch (\Throwable $th) {

            return view('errors.alertaTigo');
        }
        
        
        
    }
}
