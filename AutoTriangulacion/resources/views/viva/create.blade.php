@extends('layouts.app', ['page' => __('User Management'), 'pageSlug' => 'users'])

@section('content')
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
                        <thead style="background : rgb(225, 78, 202)">
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
                                    <input class="form-control" name="numeroUsuario[]" id="numeroUsuario"  style="border-color: rgb(225, 78, 202)" onkeyup="existe()"  
                                    list="codigo" >
                                    <datalist id="codigo">
                                    </datalist>
                                    <span id="estadoCodigo"></span>
                                    <span id="estadoCodigoI"></span>
                                </th>
                                <td>
                                    <input type="text"  class="form-control  {{$errors->has('nombre')?'is-invalid':'' }}" name="nombre[]" style="border-color: rgb(225, 78, 202)" 
                                        id="nombre" value="{{ isset($transferencia->nombre)?$transferencia->nombre:old('nombre')  }}">
                                        <span id="estadoNombre"></span>
                                </td>
                                <td>
                                    <input type="number" class="form-control  {{$errors->has('unidad')?'is-invalid':'' }}" name="ci[]" style="border-color: rgb(225, 78, 202)" 
                                    onkeyup="validarUnidad()"  id="ci" value="{{ isset($transferencia->unidad)?$transferencia->unidad:old('unidad')  }}"> <span id="estadoUnidad"></span>
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

<script>
    
var iman = 0;
$(function() {
    $("#adicional").on('click', function() {
        if (validaciones()) {
            iman = iman + 1;
            $("#tabla tbody tr:eq(0)").clone().appendTo("#tabla").attr("id", "columna-" + (iman)).find(
                'input').attr('readonly', true).show();
            calcularTotal();
            $("#stateRow").html("<span  class='menor'><h5 class='menor'></h5></span>");
        } else {
            $("#stateRow").html("<h5 class='menor'>Revise todos los campos </h5>");
            vacio("numero");
            vacio("nombre");
            vacio("ci");
        }
    });
    $(document).on("click", ".eliminar", function() {
        var variableRestar = $(this).closest('tr').find('input[id="subTotal"]').val();
        if ($(this).parents('tr').attr('id') != "columna-0") {
            variableRestar = parseFloat(variableRestar).toFixed(2);
            res = res - variableRestar;
            res = res.toFixed(2);
            $("#total").val(res);
            $(this).parents('tr').remove();
        } else {
            var bb2 = ($("#total").val() - $("#subTotal").val());
            $("#total").val(bb2.toFixed(2));
            res = $("#total").val();
            res = parseFloat(res).toFixed(2);
            limpiarCampos();
        }
    });
});

function validaciones() {
    if (!existeValor("numeroUsuario") && !existeValor("nombre") && !existeValor("ci")
    ) {
        lleno("numeroUsuario");
        lleno("nombre");
        lleno("ci");
        return true
    } else {
        return false
    }
}
function existeValor($dato) {
    var boolean = false;
    var aux = document.getElementById($dato).value;
    if (aux == "") {
        boolean = true;
    }
    return boolean;
}
function vacio($valor) {
    var dato = document.getElementById($valor).value;
    var prueba = document.getElementById($valor);
    if (dato == "" || dato == "0.00") {
        prueba.style.borderColor = 'red';
    } else {
        if (validarCantidad() || validarNombre() || validarPrecio() || validarUnidad()) {
            prueba.style.borderColor = '#cad1d7';
        }
    }
}
function lleno($valor) {
    var prueba = document.getElementById($valor);
        prueba.style.borderColor = '#cad1d7';
}
</script>

   
@endsection