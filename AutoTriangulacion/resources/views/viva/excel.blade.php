@extends('layouts.app', ['page' => __('Icons'), 'pageSlug' => 'icons'])

@section('content')
  <style>
    .subir{
      padding: 10px 60px;
      background: #419EF9;
      color:#fff;
      border:0px solid #fff;
  }
   
  .subir:hover{
      color:#fff;
      background: #419EF9;
  }
  </style>
  <script>
    function cambiar(){
      var pdrs = document.getElementById('file-upload').files[0].name;
      document.getElementById('info').value = pdrs;
  }
  
  </script>
  
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
                   <form action="{{url('viva/create')}}" method="POST">
                      <table class="table table-striped" id="tabla">
                          <thead style="background : rgb(78, 137, 225)">
                              <tr>
                                  <th class="text-center">w</th>
                                  <th class="text-center">Archivo</th>
                                  <th class="text-center"></th>
                                  <th class="text-center">Eliminar</th>
                              </tr>
                          </thead> 
                          <tbody id="tabla3">
                              <span id="estadoBoton"></span>
                              <tr id="columna-0">
                                  <th>
                                      
                                  </th>
                                  <td>
                                   <div class="text-center">
                                    <label for="file-upload" class="subir">
                                      <i class="fas fa-cloud-upload-alt"></i> Subir archivo</label>
                                    <input id="file-upload" name="archivos[]" onchange='cambiar()' type="file" style='display: none;'/>
                                   </div>
                                  </td>
                                  <td>
                                    <div class="text-center">
                                      <input type="text"  class="form-control"  
                                      style="border-color: rgb(78, 137, 225) ; width: 300px;" id="info" ></input>
                                      <span id="estadoNombre"></span>
                                    </div>
                                  </td>
                                  <td class="eliminar" id="deletRow" name="deletRow">
                                      <div class="text-center">
                                        <button class="btn btn-icon btn-danger"  type="button">
                                        <i class="tim-icons icon-trash-simple"></i></button>
                                      </div>
                                      </button>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
  
                  <button type="button" class="btn btn-success btn-lg btn-block" id="adicional" name="adicional">Añadir</button>
      </form>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

  </div>
@endsection