@extends('layouts.app', ['page' => __('ENTEL'), 'pageSlug' => 'icons'])
@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title text-center">Tabla de Relacion</h4>
          </div>
          <div class="card-body">
            
            <div class="row justify-content-center">
              <div class="col-md-10">
                  <div class="card">
                          
                          <div class="text-center">
                          

                          @for ($i = 0; $i < $v; $i++)
                              @for ($j = 0; $j < $h; $j++)
                                  {{$Matriz[$i][$j]}}
                              @endfor
                        </br>
                          @endfor

                          </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    
      </div>
    

@endsection