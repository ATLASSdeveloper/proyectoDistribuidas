<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserva de Asientos</title>

  <link rel="stylesheet" href="{{ asset('estilos/estiloReserva.css') }}">
  <link rel="stylesheet" href="{{ asset('estilos/estilosReserva2.css') }}">
  <link rel="stylesheet" href="{{ asset('estilos/estilosGenerales.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">

    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"> </script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"> </script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <header class="cabezaReserva">
    <i class="fas fa-plane" id="avionReserva"></i>
    <h1>Sistemas de Reservas - Aerolinea FISEI</h1>
    <a href="{{route('ObtenerInformacionVuelos')}}" class="etiqueta">Regresar</a>
    <a href="{{route('login')}}" class="etiqueta">Cerrar Sesion</a>
  </header>

  <h2 class="selecciona">Selecciona tu asiento</h2>

  <div class="avion">

    @php
        $asientos = $result->ObtenerInformacionVueloAsientosResult->Asiento;
        $cantidad=4;
        $inicial=0;
    @endphp

    @for ($i = 0; $i < count($asientos) / 4; $i += 1)
        <div class="fila">
        @for ($j = $inicial; $j < $cantidad; $j += 1)
          @if($j % 2 == 0)
          <div class="pasillo"></div>
          @endif
          @if($asientos[$j]->estado == 'Disponible')
          <div class="asiento" id="{{ $asientos[$j]->id_detalle_vuelo }}">{{ $asientos[$j]->asiento }}</div>
          @else
          <div class="asientoOcupado" id="{{ $asientos[$j]->id_detalle_vuelo }}">{{ $asientos[$j]->asiento }}</div>
          @endif
        @endfor
        </div>
        @php
          $cantidad=$cantidad + 4;
          $inicial= $inicial + 4;
        @endphp
    @endfor
</div>

<button type="button" class="botonReserva" disabled data-bs-toggle="modal" data-bs-target="#modalReserva">Reservar Asiento</button>

<!-- Modal -->
<div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="popupContent">
        <!-- Contenido dinámico del modal -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="reservar">
          @csrf
          <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function () {
    var numeroAsiento = null;
    var asiento = null;

    $(".asiento").click(function () {
      $(".asiento").removeClass("asientoSeleccionado");
      $(this).addClass("asientoSeleccionado");
      numeroAsiento = $(this).attr("id");
      asiento = $(this).text();
      $('.botonReserva').prop('disabled', false);
    });

    $(".botonReserva").click(function () {
      mostrarPopup(asiento);
    });

    $("#reservar").submit(function (event) {
      event.preventDefault();
      var formData = $(this).serialize();
      formData += "&asiento=" + numeroAsiento;

      $.ajax({
        url: "{{route('GenerarReserva')}}",
        type: "POST",
        data: formData,
        success: function (data) {
          mostrarModalExito();
          setTimeout(function () {
            window.location.reload();
          }, 1000);
        },
        error: function (xhr, status, error) {
          mostrarModalError();
        }
      });
    });
  });

  function mostrarPopup(numeroAsiento) {
    $('#modalReserva').modal('show');
    $('#popupContent').html(`¿Está seguro de reservar el asiento: ${numeroAsiento}?`);
  }

  function mostrarModalExito() {
    $('#modalExito').modal('show');
  }

  function mostrarModalError() {
    $('#modalError').modal('show');
  }
</script>




<div class="modal fade" id="modalExito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reserva Exitosa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¡La reserva se realizó con éxito!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Error en la Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¡Hubo un error al procesar la reserva!. Asiento Ocupado
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</body>

</html>