<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('estilos/estilosReserva2.css') }}">
    <link rel="stylesheet" href="{{ asset('estilos/estilosGenerales.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Tickets Aereos</title>
</head>

<body class="prueba">
    <header class="airport-header">
        <div class="container">
            <span class="icono-avion" id="avion">&#9992;</span>
            <h1 class="tituloAero">Aeropuerto Internacional FISEI</h1>
            <a href="{{route('ObtenerInformacionVuelos')}}" class="etiqueta">Regresar</a>
            <a href="{{route('login')}}" class="etiqueta">Cerrar Sesion</a>
        </div>
    </header>

    <div class="contenedor">
        <h2>Historial de reservas</h2>
    </div>

    <main class="container d-flex justify-content-center align-items-center">
    @if(property_exists($result->ObtenerDetallesVueloPorPersonaReservaResult, 'Reservas'))
        <table class="table">
            <thead>
                <tr>
                    <th>Aerolínea</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
                    @if(is_array($result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas))
                        @foreach ($result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas as $reservas)
                <tr>
                    <td>{{$reservas->Aerolinea}}</td>
                    <td>{{$reservas->Ciudad_de_Origen}} , {{$reservas->Pais_de_Origen}}</td>
                    <td>{{$reservas->Ciudad_de_Destino}} , {{$reservas->Pais_de_Destino}}</td>
                    <td>
                        <button class="btn btn-primary" onclick="mostrarPopup('{{$reservas->ID_Detalle_Vuelo}}',
                        '{{$reservas->ID_Maestro_Vuelo}}',
                        '{{$reservas->ID_RESERVA}}',
                        '{{$reservas->Aerolinea}}',
                        '{{$reservas->Asiento}}',
                        '{{$reservas->Ciudad_de_Origen}}',
                        '{{$reservas->Pais_de_Origen}}',
                        '{{$reservas->Ciudad_de_Destino}}',
                        '{{$reservas->Pais_de_Destino}}',
                        '{{$reservas->Fecha_de_Salida}}',
                        '{{$reservas->Estado_del_Vuelo}}',
                        '{{$reservas->Modelo_del_Avion}}')">Detalles</button>
                    </td>
                </tr>
                        @endforeach
                    @else
                <tr>
                    <td>{{ $result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Aerolinea }}</td>
                    <td>{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Ciudad_de_Origen}} , {{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Pais_de_Origen}}</td>
                    <td>{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Ciudad_de_Destino}} , {{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Pais_de_Destino}}</td>
                    <td>
                        <button class="btn btn-primary" onclick="mostrarPopup('{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->ID_Detalle_Vuelo}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->ID_Maestro_Vuelo}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->ID_RESERVA}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Aerolinea}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Asiento}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Ciudad_de_Origen}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Pais_de_Origen}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Ciudad_de_Destino}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Pais_de_Destino}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Fecha_de_Salida}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Estado_del_Vuelo}}',
                        '{{$result->ObtenerDetallesVueloPorPersonaReservaResult->Reservas->Modelo_del_Avion}}')">Detalles</button>
                    </td>
                </tr>
                    @endif

            </tbody>
        </table>
    @else
    <h1>No tiene registros disponibles</h1>
    @endif
    </main>

    <div class="modal" id="popup" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles de Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="popupContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="eliminacionBoton"onclick="eliminarReserva()">Eliminar</button>
                    <form id="modificarReserva">
                        @csrf
                        <button type="submit" class="btn btn-primary">Cambiar Reserva</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="modal" id="confirmarEliminarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar esta reserva?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="eliminar">
                    @csrf
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="informativo" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sistema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Proceso realizado con exito</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

    <script>
        var id_maestro_vuelo=null;
        var id_detalle_vuelo=null;
        var id_reserva= null;
        var estado_vuelo = null;

        function mostrarPopup(idDetalleVuelo, idMaestroVuelo, idReserva, aerolinea, asiento, ciudadOrigen, paisOrigen, ciudadDestino, paisDestino, fechaSalida, estadoVuelo, modeloAvion) {
            id_maestro_vuelo=idMaestroVuelo;
            id_detalle_vuelo=idDetalleVuelo;
            id_reserva= idReserva;
            estado_vuelo = estadoVuelo;
            var contenido = `
            <p>Aerolínea: ${aerolinea}</p>
            <p>Asiento: ${asiento}</p>
            <p>Origen: ${ciudadOrigen}, ${paisOrigen}</p>
            <p>Destino: ${ciudadDestino}, ${paisDestino}</p>
            <p>Fecha de Salida: ${fechaSalida}</p>
            <p>Estado del Vuelo: ${estadoVuelo}</p>
            <p>Modelo del Avión: ${modeloAvion}</p>
        `;

        document.getElementById('popupContent').innerHTML = contenido;
        var popup = new bootstrap.Modal(document.getElementById('popup'));
        if(estado_vuelo == 'FINALIZADO'){
            $("#eliminacionBoton").hide();
            $("#edicionBoton").hide();
        }
        $("#popup").modal("show");
        }

        function eliminarReserva() {
            var confirmarEliminarModal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
            $("#popup").modal("hide");
            $("#confirmarEliminarModal").modal("show");
        }

        function cambiarReserva() {
            var mensaje = 'Reserva cambiada';
            $("#popup").modal("hide");
        }

        function ocultarPopup() {
            var popup = new bootstrap.Modal(document.getElementById('popup'));
            popup.hide();
        }

        function mostrarMensajeEnPopup(mensaje) {
            var mensajeElement = document.createElement('p');
            mensajeElement.innerHTML = mensaje;
            document.getElementById('popupContent').appendChild(mensajeElement);
        }

    $(document).ready(function(){
        $("#eliminar").submit(function (event) {
        event.preventDefault();
        $("#confirmarEliminarModal").modal("hide");
        alert(id_reserva);
        var formData = $(this).serialize();
        formData= formData+ "&reserva="+id_reserva;

            $.ajax({
                url: "{{route('EliminarReserva')}}",
                type: "DELETE",
                data: formData,
                success: function (data) {
                    $("#informativo").modal("show");
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                },
                error: function (xhr, status, error) {
                    alert("no");
                }
            });
        });

        
        $("#modificarReserva").submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        formData= formData+ "&reserva="+id_reserva+"&asiento_old="+id_detalle_vuelo+"&vuelo="+id_maestro_vuelo;

        $.ajax({
            url: "{{route('EstablecerParametros')}}",
            type: "GET",
            data: formData,
            success: function (data) {
                window.location.href="/home/reservas/"+id_maestro_vuelo;
            },
            error: function (xhr, status, error) {
                alert("no");
            }
        });
    
    });
});
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

