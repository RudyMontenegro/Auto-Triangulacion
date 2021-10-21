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
        $viva = new viva();

        $viva -> numero_usuario = request('numero_usuario');
        $viva -> nombre = request('nombre');
        $viva -> ci = request('ci');

        //dd($viva);

        $viva -> save();
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

    public function subirExcel()
    {
        return view('viva.excel');
    }
}
