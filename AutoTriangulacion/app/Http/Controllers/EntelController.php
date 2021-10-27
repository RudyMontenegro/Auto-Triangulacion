<?php

namespace App\Http\Controllers;

use App\entel;
use App\excelModel;
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
        //
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
        return view('viva.excel');
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

            return view('pages.icons');
        }
        } catch (\Throwable $th) {

            return view('errors.alerta',compact('th'));
        }
        
        


        
    }
}
