<?php

namespace App\Http\Controllers;

use App\viva;
use Illuminate\Http\Request;

class VivaController extends Controller
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
        return view('viva.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\viva  $viva
     * @return \Illuminate\Http\Response
     */
    public function show(viva $viva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\viva  $viva
     * @return \Illuminate\Http\Response
     */
    public function edit(viva $viva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\viva  $viva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, viva $viva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\viva  $viva
     * @return \Illuminate\Http\Response
     */
    public function destroy(viva $viva)
    {
        //
    }

    public function subirExcel(Request $request)
    {
        
        $producto = new viva();

        if($request->hasfile('foto')){
    
            $file =$request->foto;
            
            $producto['ruta_foto']=$request->file('foto')->store('fotos','public');
            
            //$file->move(public_path().'/firmas',$file->getClientOriginalName());
            $producto->foto=$file->getClientOriginalName();
        }

        $producto->save();
        return view('viva.excel');
    }
}
