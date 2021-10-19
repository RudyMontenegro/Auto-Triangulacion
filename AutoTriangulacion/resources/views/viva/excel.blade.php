@extends('layouts.app', ['page' => __('Icons'), 'pageSlug' => 'icons'])

@section('content')
  <style>
    .subir{
      padding: 10px 50px;
      background: #d752ff;
      color:#fff;
      border:0px solid #fff;
  }
   
  .subir:hover{
      color:#fff;
      background: #d752ff;
  }
  </style>
  <script>
    function cambiar(){
      var pdrs = document.getElementById('file-upload').files[0].name;
      document.getElementById('info').innerHTML = pdrs;
  }
  
  </script>
  
<div class="row justify-content-center">
<div class="col-md-10">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title text-center">Subir Archivo Excel</h4>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          
          <label for="file-upload" class="subir">
            <i class="fas fa-cloud-upload-alt"></i> Subir archivo
        </label>
        <input id="file-upload" onchange='cambiar()' type="file" style='display: none;'/>
        <div id="info"></div>
        <input type="submit" value="Enviar"> 
        </div>
        <div class="row justify-content-center">
          <div class="col-md-10">
              <div class="card">
                   <form action="{{url('viva/create')}}" method="POST">
                      <table class="table table-striped" id="tabla">
                          <thead style="background : rgb(225, 78, 202)">
                              <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Archivo</th>
                                  <th class="text-center">Eliminar</th>
                              </tr>
                          </thead> 
                          <tbody id="tabla3">
                              <span id="estadoBoton"></span>
                              <tr id="columna-0">
                                  <th>
                                      <input class="form-control" name="numeroUsuario[]" id="numeroUsuario"  style="border-color: rgb(225, 78, 202)" onkeyup="existe()"  
                                      list="codigo" >
                                      <datalist id="codigo">
                                      </datalist>
                                      <span id="estadoCodigo"></span>
                                      <span id="estadoCodigoI"></span>
                                  </th>
                                  <td>
                                    <label for="file-upload" class="subir">
                                      <i class="fas fa-cloud-upload-alt"></i> Subir archivo
                                  </label>
                                  <input id="file-upload" onchange='cambiar()' type="file" style='display: none;'/>
                                  </td>
                                  <td class="eliminar" id="deletRow" name="deletRow">
                                      <button class="btn btn-icon btn-danger"  type="button">
                                          <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
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