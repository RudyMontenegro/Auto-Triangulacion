@extends('layouts.app', ['page' => __('ENTEL'), 'pageSlug' => 'icons'])
@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title text-center">Subir Archivo Excel</h4>
          </div>
          <div class="card-body">
            
            <div class="row justify-content-center">
              <div class="col-md-10">
                  <div class="card">
                          
                          <div class="text-center">
                            <span id="mensaje">d</span>
                          </div>

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
    

@endsection