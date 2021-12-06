<?php

namespace App\Http\Controllers;

use App\entel;
use App\excelModel;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel as Ex;

use function Complex\add;

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
   
    public function informeRegistro(){
        $registro = DB::table('excels')             
                        ->select('identificador')
                        ->distinct()
                        ->get();
                        
        $lista = [];

        foreach ($registro as $registro) {
            $temp = [];
            $nombre = DB::table('entels')             
                    ->select('nombre')
                    ->where('numero_usuario','=',$registro->identificador)
                    ->exists(); 
                    
            if ($nombre) {
                $nombres = DB::table('entels')             
                    ->select('nombre')
                    ->where('numero_usuario','=',$registro->identificador)
                    ->first();
                    
                    $datos = [
                        "nombre" => $nombres,
                        "identificador" => $registro->identificador,
                    ];
                    
            }else{

                $datos = [
                    'nombre' => "vacio",
                    'identificador' => $registro->identificador,
                ];

            }
            array_push($lista, $datos);

        }     
        
        //dd($lista);
        return view('entel.registro', compact('lista'));
    }

    public function informeFecha(entel $viva, $registro, $fecha)
    {
        $fecha_inicial = $fecha . ' 00:00:00';
        $fecha_fin= $fecha . ' 23:59:59';

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

            $lista = [];
            

            for ($i=1; $i < count($vertical)+1 ; $i++) { 
                
                for ($j=1; $j < count($horizontal)+1 ; $j++) { 

                    
                    $temp = [];  
                    if ($Matriz[$i][$j] == 1) {
                      
                        if ($Matriz[0][$j] == $registro) {
                            $consulta = DB::table('excels')
                                    ->select('*')
                                    ->where('identificador','=',$registro)
                                    ->where('fecha', '>=' ,$fecha_inicial)
                                    ->where('fecha', '<=' ,$fecha_fin)
                                    ->where('tiempo', '<>' ,'-')
                                    ->get();
                            
                            foreach ($consulta as $aux1) {
                                array_push($temp, $aux1);
                            }

                            
                            
                            array_push($lista, $temp);
                        }
                        
                    }

                }
            }

            $nuevo = [];
            $cant = 0;

            for ($i=0; $i < count($lista); $i++) { 
                $temp = [];
                for ($j=0; $j < count($lista[$i])-1; $j++) { 
                    
                    $a = $j+1;
                    if (($lista[$i][$j]->tiempo == $lista[$i][$a]->tiempo || $lista[$i][$j]->fecha == $lista[$i][$a]->fecha) && $lista[$i][$j]->llamada == "ENTRANTE") {
                        
                        if ($lista[$i][$j]->radio_baseB == '-') {
                            $lista[$i][$j]->radio_baseB = $lista[$i][$a]->radio_baseB;
                            $lista[$i][$j]->coordenadaB = $lista[$i][$a]->coordenadaB;
                        } else {
                            $lista[$i][$j]->radio_baseA = $lista[$i][$a]->radio_baseA;
                            $lista[$i][$j]->coordenadaA = $lista[$i][$a]->coordenadaA;
                        }
                        
                        //unset($lista[$i][$a]); 
                        array_push($temp, $lista[$i][$j]);
                        
                         $j = $j+1;
                    } else {
                        if (($lista[$i][$j]->tiempo == $lista[$i][$a]->tiempo || $lista[$i][$j]->fecha == $lista[$i][$a]->fecha) && $lista[$i][$j]->llamada == "SALIENTE") {
                         
                            if ($lista[$i][$j]->radio_baseB == '-') {
                                $lista[$i][$j]->radio_baseB = $lista[$i][$a]->radio_baseB;
                                $lista[$i][$j]->coordenadaB = $lista[$i][$a]->coordenadaB;
                            } else {
                                $lista[$i][$j]->radio_baseA = $lista[$i][$a]->radio_baseA;
                                $lista[$i][$j]->coordenadaA = $lista[$i][$a]->coordenadaA;
                            }
                              
                            //unset($lista[$i][$a]); 
                            array_push($temp, $lista[$i][$j]);
                            $j = $j+1;
                             
                        } else {
                                array_push($temp, $lista[$i][$j]);
                                
                        }
                        
                    }
                    
                }
                $cant = $cant+1;
                array_push($nuevo, $temp);
               
            }
        return view('entel.fecha', compact('nuevo','cant','registro'));
    }

    public function informe(entel $viva, $registro)
    {

        $fechas = DB::table('excels')             //fechas de todas las llamadas
                    ->select('fecha')
                    ->where('identificador' ,'=', $registro)
                    ->get();
        $fecha = [];

        foreach ($fechas as $fechas) {
            array_push($fecha, substr($fechas->fecha, 0, -9));
        }

        $fecha = array_unique($fecha);

        $nuevo = [];
        foreach ($fecha as $fecha) {
            array_push($nuevo, $fecha);
        }

        /*
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
            
            $lista = [];
            $cant = 0;

            for ($i=1; $i < count($vertical)+1 ; $i++) { 
                for ($j=1; $j < count($horizontal)+1 ; $j++) { 


                    $consulta = DB::table('excels')
                                ->select('*')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->orWhere('numeroA','=',$Matriz[$i][0])
                                ->orWhere('numeroB','=',$Matriz[$i][0])
                                ->exists();

                    if($consulta){

                        $temp = [];

                       $aux1 = DB::table('excels')
                                ->select('*')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroA','=',$Matriz[$i][0])
                                ->get();

                    
                        $aux2 = DB::table('excels')
                                ->select('*')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroB','=',$Matriz[$i][0])
                                ->get();
                        
                        $aux3 = DB::table('excels')
                                ->select('*')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroA','=',$Matriz[$i][0])
                                ->count();

                    
                        $aux4 = DB::table('excels')
                                ->select('*')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroB','=',$Matriz[$i][0])
                                ->count();
                        
                        foreach ($aux1 as $aux1) {
                            array_push($temp, $aux1);
                        }

                        foreach ($aux2 as $aux2) {
                            array_push($temp, $aux2);
                        }

                        $cant = $cant + 1;

                    }
                    array_push($lista, $temp);
                }
             
            }

            //FRONTEND
            
            @for ($i = 0; $i < $cant; $i++)
                          @for ($j = 0; $j < count($lista[$i]) ; $j++)
                            
                             {{$lista[$i][$j]->identificador}}
                            
                          @endfor
                          <br>
                         @endfor
           
            return view('entel.informe',compact('lista','cant'));
            */

        return view('entel.informe',compact('nuevo','registro'));
    }
    
    public function mostrarTabla(entel $viva)
    {
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
                                ->where('identificador','=',$Matriz[0][$j])
                                ->orWhere('numeroA','=',$Matriz[$i][0])
                                ->orWhere('numeroB','=',$Matriz[$i][0])
                                ->exists();

                    if($consulta){

                        $aux1 = DB::table('excels')
                                ->select('numeroA')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroA','=',$Matriz[$i][0])
                                ->count();

                                
                        $aux2 = DB::table('excels')
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

          
            return view('entel.view',compact('Matriz','v','h'));
    }
    
    public function subirExcel(Request $request)
    {
        try {
            if ($request->hasFile('archivos')){

            $archivos = request('archivos');
            $numero = request('numero');
            $file = $request->file('archivos');
            for ($i=0; $i < sizeOf($archivos); $i++) { 
                

                $existe = DB::table('excels')
                            ->select('*')
                            ->where('identificador', $numero[$i])
                            ->exists();

                if (!$existe) {
                    Ex::import(new excelModel,$file[$i]);

                    DB::table('excels')
                    ->where('identificador', null)
                    ->update(['identificador' => $numero[$i]]);
                }
                
                
                
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
                                ->where('identificador','=',$Matriz[0][$j])
                                ->orWhere('numeroA','=',$Matriz[$i][0])
                                ->orWhere('numeroB','=',$Matriz[$i][0])
                                ->exists();

                    if($consulta){

                        $aux1 = DB::table('excels')
                                ->select('numeroA')
                                ->where('identificador','=',$Matriz[0][$j])
                                ->Where('numeroA','=',$Matriz[$i][0])
                                ->count();

                                
                        $aux2 = DB::table('excels')
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

   

}
