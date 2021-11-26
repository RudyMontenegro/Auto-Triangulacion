@extends('layouts.app', ['page' => __('ENTEL'), 'pageSlug' => 'icons'])
@section('content')

<link href="{{ asset('table') }}/css/viewEntel.css" rel="stylesheet" />
    

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title text-center">Tabla de Relacion</h4>
          </div>
          <div class="card-body">
            
            
            <div class="row justify-content-center">
              <div class="col-md-10">
                  <div class="card" >

                <div class="content">
                  <div id="resp-table" >
                    @for ($i = 0; $i < $v; $i++)
                      <div class="resp-table-row">
                        @for ($j = 0; $j < $h; $j++)
                          
                            @if ($i==0 || $j==0)
                            <div class="table-body-cell2">
                                <div class="text-center text-white">
                                  @if ($Matriz[$i][$j] != 0)
                                     {{$Matriz[$i][$j]}}
                                     
                                  @endif
                                </div>
                            </div>
                            @else
                            
                                  @if ($Matriz[$i][$j] != 0)
                                  <div class="table-body-cell3">
                                    <div class="text-white text-center">
                                          {{ $Matriz[$i][$j]}}
                                    </div>
                                   
                                  </div>
                                  @else
                                  <div class="table-body-cell">
                                  </div>  
                                  @endif
                                  
                                
                            @endif
                           
                          
                        @endfor
                        
                    </br>
                    </div>
                    @endfor
                  </div>
                </div>
                  

                  <br>
                  
                  </div>
            

                  <a href="{{ url('#') }}" class="btn btn-sm btn-danger" id="crearImagen">Siguiente</a>
              </div>
            </div>
          </div>
        </div>
    </div>
    
      </div>
      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    
      <script>
        $(document).ready(function(){

          var element = $('.content');

          $('#crearImagen').on('click', function(){
              html2canvas(element, {
                  background: '#ffffff',
                  onrendered: function(canvas){
                      var imgData = canvas.toDataURL('image/jpg');
                      $.ajax({
                          url: 'view/tabla',
                          type: 'post',
                          dataType: 'text',
                          data: {
                            base64data: imgData,
                            _token: $("meta[name='csrf-token']").attr("content"),
                          }
                      });
                      alert('Success!');
                      console.log(imgData);
                  }
              });
          });

          });
      </script>
    

@endsection