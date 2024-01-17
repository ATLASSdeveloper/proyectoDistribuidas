<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('estilos/estilos.css') }}">
  <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"> </script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"> </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Iniciar Sesion</title>
</head>

<body class="iniciarSesion" id="inicia">
  <div class="formulario">
    <div class="titulo">
      <span class="icono-avion">&#9992;</span>
      <h1>Inicio de Sesion</h1>
    </div>

    <form id='loginForm'>
        @csrf
      <div class="usuario">
        <input type="email" name="email" id="email" required placeholder="Correo Electrónico">
      </div>
      <div class="usuario">
        <input type="password" name="contrasena" id="contrasena" required placeholder="Contraseña">
      </div>
      <div class="iniciar">
        <button type="submit" class="registro"> Iniciar</button>
      <span id="error" style="color:red" hidden>Credenciales Incorrectas</span>
      </div>
      <div class="registrarse">Usuario nuevo?<a href="{{route('registro')}}" class="linea"> Registrarse</a></div>
    </form>
  </div>

</body>


<script>
$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var formData = {
        email: $("#email").val(),
        contrasena: $("#contrasena").val(),
        _token: csrfToken 
        };
        $.ajax({
            url: "{{route('comprobarCredenciales')}}",
            type: "POST",
            data: formData,
            success: function (data) {
                window.location.href = "{{ route('ObtenerInformacionVuelos') }}";
            },
            error: function (xhr, status, error) {
              $("#error").show();
            }
        });
    });
});
    </script>
</html>