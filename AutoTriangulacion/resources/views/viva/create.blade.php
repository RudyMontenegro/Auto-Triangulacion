@extends('layouts.app', ['page' => __('User Management'), 'pageSlug' => 'users']).
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style>
    table {
        padding: 130px; 
    button{
        width: 150px;
    margin-left: auto;
    margin-right: auto;
    }
</style> 
      <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                 <form action="{{url('viva/create')}}" method="POST">
                    <table class="table table-striped" id="tabla">
                        <thead style="background : rgb(78, 137, 225">
                            <tr>
                                <th scope="col">Numero de Usuario</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">C.I</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead> 
                        <tbody id="tabla3">
                            <span id="estadoBoton"></span>
                            <tr id="columna-0">
                                <th>
                                    <input class="form-control" name="numeroUsuario[]" id="numeroUsuario"  style="border-color: rgb(78, 137, 225)"
                                    value="{{old('nombreUsuario')}}" >
                                    <datalist id="numeroUsuario">
                                    </datalist>
                                    <span id="estadoCodigo"></span>
                                    <span id="estadoCodigoI"></span>
                                </th>
                                <td>
                                    <input type="text"  class="form-control  {{$errors->has('nombre')?'is-invalid':'' }}" name="nombre[]" style="border-color: rgb(78, 137, 225)" 
                                        id="nombre" value="{{old('nombre')}}">
                                        <span id="estadoNombre"></span>
                                </td>
                                <td>
                                    <input type="number" class="form-control  {{$errors->has('unidad')?'is-invalid':'' }}" name="ci[]" style="border-color: rgb(78, 137, 225)" 
                                      id="ci" value="{{old('ci')}}"> 
                                      <span id="estadoUnidad"></span>
                                </td>
                                <td class="eliminar" id="deletRow" name="deletRow">
                                    <button class="btn btn-icon btn-danger"  type="button">
                                        <span class="btn-inner--icon "><i class="ni ni-fat-remove"></i></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <button type="button" class="btn btn-secundary btn-lg btn-block" id="add" name="add">Añadir</button>
    </form>
            </div>
            <a href="{{ url('viva/create') }}" class="btn btn-sm btn-danger">Cancelar</a>
            <a href="{{url('/create/XLSX')}}" class="btn btn-sm btn-secundary float-right">Siguiente</a>
        </div>
      </div>

<script>
    
var bb = 0;
$(function() {
        $("#add").on('click', function() {
            $("#tabla tbody tr:eq(0)").clone().appendTo("#tabla").find('input').attr('readonly', true);
            bb = bb + 1;
            limpiarCampos();
        });
        $(document).on("click", ".eliminar", function() {
            if (bb > 0) {
                var parent = $(this).parents().get(0);
                $(parent).remove();
                bb = bb - 1;
            }
        });
   
});
</script>

   
@endsection