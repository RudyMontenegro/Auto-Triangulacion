<?php

namespace App\Http\Controllers;

use App\tigo;
use Illuminate\Http\Request;

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
                $viva = new tigo();
                $viva -> numero_usuario = $numero_usuario[$i];
                $viva -> nombre = $nombre[$i];
                $viva -> ci = $ci[$i];

                $viva -> save();
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
}
