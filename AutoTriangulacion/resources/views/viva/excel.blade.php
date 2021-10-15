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
        <div class="alert alert-info">
          <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
          </button>
          <span>This is a notification with close button.</span>
        </div>
        <div class="alert alert-info alert-with-icon" data-notify="container">
          <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
          </button>
          <span data-notify="icon" class="tim-icons icon-bell-55"></span>
          <span data-notify="message">This is a notification with close button and icon.</span>
        </div>
        <div class="alert alert-info alert-with-icon" data-notify="container">
          <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
          </button>
          <span data-notify="icon" class="tim-icons icon-bell-55"></span>
          <span data-notify="message">This is a notification with close button and icon and have many lines. You can see that the icon and the close button are always vertically aligned. This is a beautiful notification. So you don't have to worry about the style.'</span>
        </div>
      </div>
    </div>
</div>

  </div>
@endsection