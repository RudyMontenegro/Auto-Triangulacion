<style>
    #formulario1 {
        margin: 0 auto;
        text-align: center;
        border-radius: 10px;
        border: 1px solid #ffffff;
        width: 800px;

    }

        .card .table td,
        .card .table th {
        padding-right: 0.1rem;
        padding-left: 0.1rem;
        }
    </style>
    <form action="{{url('viva/createViva')}}" method="POST">
                    <table class="table table-responsive" id="tabla">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Numero Usuario</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Unidad</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead> 
                        <tbody id="tabla3">
                            <span id="estadoBoton"></span>
                            <tr id="columna-0">
                                <th>
                                    <input class="form-control" name="codigoI[]" id="codigoI"  onkeyup="existe()"  
                                    list="codigo" >
                                    <datalist id="codigo">
                                    </datalist>
                                    <span id="estadoCodigo"></span>
                                    <span id="estadoCodigoI"></span>
                                </th>
                                <td>
                                    <input type="text"  class="form-control  {{$errors->has('nombre')?'is-invalid':'' }}" name="nombre[]"
                                        id="nombre" value="{{ isset($transferencia->nombre)?$transferencia->nombre:old('nombre')  }}">
                                        <span id="estadoNombre"></span>
                                </td>
                                <td>
                                    <input type="text" class="form-control  {{$errors->has('unidad')?'is-invalid':'' }}" name="unidad[]"
                                    onkeyup="validarUnidad()"  id="unidad" value="{{ isset($transferencia->unidad)?$transferencia->unidad:old('unidad')  }}"> <span id="estadoUnidad"></span>
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