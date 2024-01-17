<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('estilos/estilosIndex.css') }}">
  <link rel="stylesheet" href="{{ asset('estilos/estilosGenerales.css') }}">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"> </script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"> </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
  <title>Tickets Aereos</title>
</head>

<body class="prueba">
  <header class="airport-header">
    <div class="container">
      <span class="icono-avion" id="avion">&#9992;</span>
      <h1 class="tituloAero">Aeropuerto Internacional FISEI</h1>
      <a href="{{route('ObtenerInformacionReservas')}}" class="etiqueta">Mis Reservas</a>
      <a href="{{route('login')}}" class="etiqueta">Cerrar Sesion</a>
    </div>
  </header>

  <div class="contenedor">
    <h2>Búsqueda de vuelos</h2>

    <form id="filtroForm" class="flight-search">
      @csrf
      <div class="form-group">
        <label for="origen">Origen:</label>
        <select id="origen" name="origen" required>
        @foreach ($sedes->ObtenerSedesResult->Sede as $s)
            <option value="{{ $s->id_sede }}">{{ $s->ciudad }} , {{ $s->pais }}</option>
        @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="destino">Destino:</label>
        <select id="destino" name="destino" required>
        @foreach ($sedes->ObtenerSedesResult->Sede as $s)
            <option value="{{ $s->id_sede }}">{{ $s->ciudad }} , {{ $s->pais }}</option>
        @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="fecha">Fecha de salida:</label>
        <input type="date" id="fecha" name="fecha" required>
      </div>
      <div class="form-group">
        <button type="submit" class="buscarVuelos">Buscar vuelos</button>
      </div>
    </form>
  </div>

  <section class="container">
    <div class="contenido">
        <div class="row">
    @if (is_array($result->ObtenerInformacionVuelosResult->Vuelo))
      @foreach ($result->ObtenerInformacionVuelosResult->Vuelo as $vuelo)
        <div class="col-lg-4 col-md-12 my-3">
                <div class="card mx-auto" style="width: 18rem; cursor: pointer;" onclick="mostrarInformation('{{ $vuelo->id_vuelo }}')">
                    <img src="{{ asset('recursos/Colombia.jpg') }}" class="card-img-top" alt="..." style="width: 100%; height: 220px;">
                    <div class="card-body">
                        <p class="card-text"><span class="blue-text">Aerolínea: {{ $vuelo->aerolinea }}</span> </p>
                        <p class="card-text"><span class="yellow-background">Asientos Disponibles: {{ $vuelo->asientos_disponibles }}</span> </p>
                        <p class="card-text">Destino: {{ $vuelo->ciudad_destino }} , {{ $vuelo->pais_destino }}</p>
                        <p class="card-text">Origen: {{ $vuelo->ciudad_origen }} , {{ $vuelo->pais_origen }}</p>
                        <p class="card-text salida">Fecha de Salida:{{ $vuelo->fecha_salida }}</p>
                    </div>
                </div>
        </div>
      @endforeach
    @else
    <div class="col-lg-4 col-md-12 my-3">
                <div class="card mx-auto" style="width: 18rem; cursor: pointer;" onclick="mostrarInformation('{{ $result->ObtenerInformacionVuelosResult->Vuelo->id_vuelo }}')">
                    <img src="{{ asset('recursos/Colombia.jpg') }}" class="card-img-top" alt="..." style="width: 100%; height: 220px;">
                    <div class="card-body">
                        <p class="card-text"><span class="blue-text">Aerolínea: {{ $result->ObtenerInformacionVuelosResult->Vuelo->aerolinea }}</span> </p>
                        <p class="card-text"><span class="yellow-background">Asientos Disponibles: {{ $result->ObtenerInformacionVuelosResult->Vuelo->asientos_disponibles }}</span> </p>
                        <p class="card-text">Destino: {{ $result->ObtenerInformacionVuelosResult->Vuelo->ciudad_destino }} , {{ $result->ObtenerInformacionVuelosResult->Vuelo->pais_destino }}</p>
                        <p class="card-text">Origen: {{ $result->ObtenerInformacionVuelosResult->Vuelo->ciudad_origen }} , {{ $result->ObtenerInformacionVuelosResult->Vuelo->pais_origen }}</p>
                        <p class="card-text salida">Fecha de Salida:{{ $result->ObtenerInformacionVuelosResult->Vuelo->fecha_salida }}</p>
                    </div>
                </div>
        </div>
    @endif
        </div>
      </div>
    </section>

</body>

<script>
$(document).ready(function () {
    $("#filtroForm").submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            url: "{{route('ObtenerInformacionVuelosEspecificos')}}",
            type: "POST",
            data: formData,
            success: function (data) {
                $(".row").empty();

                if (data.ObtenerInformacionVuelosEspecificosResult.Vuelo instanceof Array) {
                    $.each(data.ObtenerInformacionVuelosEspecificosResult.Vuelo, function (index, vuelo) {
                        $(".row").append(`
                        <div class="col-lg-4 col-md-12 my-3">
                          <div class="card mx-auto" style="width: 18rem; cursor: pointer;" onclick="mostrarInformation('${vuelo.id_vuelo}')">
                            <img src="{{ asset('recursos/Colombia.jpg') }}" class="card-img-top" alt="..." style="width: 100%; height: 220px;">
                            <div class="card-body">
                              <p class="card-text"><span class="blue-text">Aerolínea:${vuelo.aerolinea}</span> </p>
                              <p class="card-text"><span class="yellow-background">Asientos Disponibles: ${vuelo.asientos_disponibles}</span> </p>
                              <p class="card-text">Ciudad Destino: ${vuelo.ciudad_destino}</p>
                              <p class="card-text">Ciudad Origen: ${vuelo.ciudad_origen}</p>
                              <p class="card-text salida">Fecha de Salida:${vuelo.fecha_salida}</p>
                            </div>
                          </div>
                        </div>

                        `);
                    });
                } else if (data.ObtenerInformacionVuelosEspecificosResult.Vuelo) {
                    var vuelo = data.ObtenerInformacionVuelosEspecificosResult.Vuelo;
                    $(".row").append(`
                        <div class="col-lg-4 col-md-12 my-3">
                          <div class="card mx-auto" style="width: 18rem; cursor: pointer;" onclick="mostrarInformation('${vuelo.id_vuelo}')">
                            <img src="{{ asset('recursos/Colombia.jpg') }}" class="card-img-top" alt="..." style="width: 100%; height: 220px;">
                            <div class="card-body">
                              <p class="card-text"><span class="blue-text">Aerolínea:${vuelo.aerolinea}</span> </p>
                              <p class="card-text"><span class="yellow-background">Asientos Disponibles: ${vuelo.asientos_disponibles}</span> </p>
                              <p class="card-text">Ciudad Destino: ${vuelo.ciudad_destino}</p>
                              <p class="card-text">Ciudad Origen: ${vuelo.ciudad_origen}</p>
                              <p class="card-text salida">Fecha de Salida:${vuelo.fecha_salida}</p>
                            </div>
                          </div>
                        </div>
                    `);
                } else {
                    console.error("La respuesta no tiene la estructura esperada.");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

function mostrarInformation(idVuelo) {
  window.location.href = '/home/asientos/'+idVuelo;
}
    </script>

</html>