<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style>
    .table td {
    text-align: center;   
}
.table {
    
    background-color: #7e78f7;
    text-align: center;
    line-height: 30px;
}
</style>
<header>
      <p><strong>REGISTRO de GEOLOCALIZACION</strong></p>

      <img src="{{ public_path('/PDF/mapaPrueba.jpg') }}">
       

 </header>
    
    <body>

        <div class="card"></div>
        <main>
          <div class="container">
             
                <table class="table table-striped text-center">
                    <thead class=""> 
                    </thead>
                        <tbody>
                            <tr>
                                 <th rowspan="2" class="text-center"><b>Lista de Números Implicados</b></th>
                                 <th colspan="{{$v-1}}" class="text-center"><b>Registro de Llamadas de </b></th>
                            </tr>
                            @for ($i = 0; $i < $v; $i++)
                            <tr>
                                @for ($j = 0; $j < $h; $j++)
                                    @if($i==0 && $j==0)
                                        @else
                                        <td> {{$Matriz[$i][$j]}}</td>  
                                    @endif        
                                @endfor
                            </tr>
                            @endfor
                        </tbody>
                </table>
              
         </div>  
        </main>
        
       
        

    </body>

    

</html>