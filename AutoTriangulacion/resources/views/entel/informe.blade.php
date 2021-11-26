@extends('layouts.app', ['page' => __('ENTEL'), 'pageSlug' => 'icons'])
@section('content')


<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title text-center">Informe de Geolocalizacion Basado en Registro de Llamadas</h4>
          </div>
          <div class="card-body">
            
            <div class="row justify-content-center">
              <div class="col-md-10">
                  <div class="card">

                
                      @for ($i = 0; $i < $cant; $i++)
                          @for ($j = 0; $j < count($lista[$i]) ; $j++)
                            
                             {{$lista[$i][$j]->identificador}}
                            
                          @endfor
                          
                      </br>
                      </div>
                      @endfor
                    </div>
                  
                  
                  </div>
                  <a href="{{ url('entel/register/XLSX/view') }}" class="btn btn-sm btn-danger float-left">Atras</a>
                  <a href="{{ url('entel/informe') }}" class="btn btn-sm btn-success float-right">Siguiente</a>
              </div>
            </div>
          </div>
        </div>
    </div>
    
      </div>
    

@endsection