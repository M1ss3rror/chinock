<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class imageController extends Controller
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
        return view('imagenes.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Traer la ubicación del archivo
        $archivo_original =  $request->file('nombre_archivo'); //Traer archivo desde el formulario
        //Objeto intervention de operación con imágenes
        $intervention = new ImageManager;
        //construir la imagen a partir del
        $miniatura=$intervention->make($archivo_original);
        //Miniatura de la imagen
        $miniatura->resize(350,350)->contrast(33)->sharpen();;
        //guardar la imagen
        $ruta_imagenes = public_path().'/imagenes';
        $miniatura ->save($ruta_imagenes.'/Miniatura-'.$archivo_original->getClientOriginalName());
        
        var_dump($intervention); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
