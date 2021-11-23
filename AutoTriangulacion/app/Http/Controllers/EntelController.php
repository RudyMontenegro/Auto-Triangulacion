<?php

namespace App\Http\Controllers;

use App\entel;
use App\excelModel;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel as Ex;

class EntelController extends Controller
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
        return view('entel.create');
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
                $viva = new entel();
                $viva -> numero_usuario = $numero_usuario[$i];
                $viva -> nombre = $nombre[$i];
                $viva -> ci = $ci[$i];

                $viva -> save();
            }
        }
        return view('entel.excel');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\entel  $entel
     * @return \Illuminate\Http\Response
     */
    public function show(entel $entel)
    {
        return view('entel.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\entel  $entel
     * @return \Illuminate\Http\Response
     */
    public function edit(entel $entel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\entel  $entel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, entel $entel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\entel  $entel
     * @return \Illuminate\Http\Response
     */
    public function destroy(entel $entel)
    {
        //
    }

    public function excel(entel $viva)
    {
        return view('entel.excel');
    }

    public function subirExcel(Request $request)
    {
        try {
            if ($request->hasFile('archivos')){

            $archivos = request('archivos');
            $numero = request('numero');
            $file = $request->file('archivos');
            for ($i=0; $i < sizeOf($archivos); $i++) { 
                
                Ex::import(new excelModel,$file[$i]);

                DB::table('excels')
                ->where('identificador', null)
                ->update(['identificador' => $numero[$i]]);
                
                
            }
            

            $vertical = DB::table('entels')             //contar arreglo con count($vertical)
                            ->select('numero_usuario')
                            ->get();

            $horizontal = DB::table('excels')           //contar arreglo con count($horizontal)
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

                    $consulta = DB::table('excels')
                                ->select('*')
                                ->where('numeroA','=',$Matriz[$i][0])
                                ->orWhere('numeroB','=',$Matriz[$i][0])
                                ->exists();

                    if($consulta){
                        $Matriz[$i][$j] = 1;
                    }else{
                        $Matriz[$i][$j] = 0;
                    }
                }
             
            }
            $v = count($vertical)+1;
            $h= count($horizontal)+1;

          
            return view('entel.view',compact('Matriz','v','h'));
        }
        } catch (\Throwable $th) {

            return view('errors.alerta');
        }
        
        
        
    }

    public function gps(entel $entel)
    {


        $coordenadasA = DB::table('excels')
                        ->select('coordenadaA')
                        ->where('coordenadaA','<>','-')
                        ->groupBy('coordenadaA')
                        ->get();
                        
        $coordenadasB = DB::table('excels')
                        ->select('coordenadaB')
                        ->where('coordenadaB','<>','-')
                        ->groupBy('coordenadaB')
                        ->get();
        $coordenadas = [];
        foreach ($coordenadasA as $coordenadasA ) {
            array_push($coordenadas, $coordenadasA->coordenadaA );
        }
        foreach ($coordenadasB as $coordenadasB) {
            array_push($coordenadas, $coordenadasB->coordenadaB);
        }
        $coordenadasUnicas = array_unique($coordenadas);

         $final = [];

        foreach ($coordenadasUnicas as $coordenadasUnicas) {
            
            $cordenadaA = DB::table('excels')
                        ->select('radio_baseA as radio_base','coordenadaA as coordenada')
                        ->where('coordenadaA','=',$coordenadasUnicas)
                        ->first();
            $cordenadaB = DB::table('excels')
                        ->select('radio_baseB as radio_base','coordenadaB as coordenada')
                        ->where('coordenadaB','=',$coordenadasUnicas)
                        ->first();

            if ($cordenadaA == null) {
                array_push($final, $cordenadaB);
            }else{
                array_push($final, $cordenadaA);
            }
                
        }

        /*
        $gmapconfig['center'] = '-17.012306, -65.058917';
        $gmapconfig['zoom'] = '14';
        $gmapconfig['map_height'] = '500px';
        $gmapconfig['map_type'] = 'SATELLITE';
        $gmapconfig['scrollwheel'] = false;
        $gmapconfig['disableDefaultUI'] = true;

        //GMaps::initialize($config);
        $livegooglemap = new GMaps();
        $livegooglemap->initialize($gmapconfig);
        
        $marker['position'] = '-17.012306, -65.058917';
        $marker['infowindow_content'] = 'dddddd';
        //$marker['icon'] = 'https://chart.googleapis.com/chart?chst=d_map_xpin_icon&chld=pin';

        //https://chart.googleapis.com/chart?chst=d_bubble_icon_text_small&chld=ski|bb|Wheeee!|FFFFFF|000000

        $livegooglemap->add_marker($marker);
        $map = $livegooglemap->create_map();
        
        */

        
//dd($var);
        return view('entel.location',compact('final'));
    }

    public function localizacion(entel $entel)
    {
        return view('entel.location');
    }

}
