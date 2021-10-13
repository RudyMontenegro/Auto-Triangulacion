@extends('layouts.app', ['page' => __('Icons'), 'pageSlug' => 'icons'])

@section('content')
<div class="row justify-content-center">
<div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title text-center">Subir Archivo Excel</h4>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          <span>This is a plain notification</span>
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