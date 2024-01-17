<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Formulario de Registro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="{{ asset('estilos/estilos.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
  <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    /* Estilos para el botón "Registrarse" */
    #registroForm button {
      background-color: #007bff;
      color: #fff;
    }

    /* Estilos adicionales para el enlace de "Inicia sesión" */
    .iniciar-sesion a {
      color: #007bff;
    }
  </style>
</head>

<body class="registroUsuario">
  <div class="container">
    <div class="formularioRegistro">
    <div class="avion">
      <span class="icono-avion">&#9992;</span>
      <h1 class="TituloRegistro">Registro</h1>
    </div>
      <form id="registroForm">
        @csrf
        <div class="campo">
          <label for="numeroDocumento">Número de Documento:</label>
          <input type="text" id="numeroDocumento" name="numeroDocumento" required>
        </div>
        <div class="campo">
          <label for="tipoDocumento">Tipo de Documento:</label>
          <select id="tipoDocumento" name="tipoDocumento" required>
            <option value="dni">Cédula</option>
            <option value="pasaporte">Pasaporte</option>
          </select>
        </div>
<div class="columnas">
        <div class="campo columna">
          <label for="primerNombre">Primer Nombre:</label>
          <input type="text" id="primerNombre" name="primerNombre" required>
        </div>
        <div class="campo columna">
          <label for="segundoNombre">Segundo Nombre:</label>
          <input type="text" id="segundoNombre" name="segundoNombre">
        </div>
        <div class="campo columna">
          <label for="apellidoPaterno">Apellido Paterno:</label>
          <input type="text" id="apellidoPaterno" name="apellidoPaterno" required>
        </div>
        <div class="campo columna">
          <label for="apellidoMaterno">Apellido Materno:</label>
          <input type="text" id="apellidoMaterno" name="apellidoMaterno" required>
        </div>
        <div class="campo columna">
          <label for="fechaNacimiento">Fecha de Nacimiento:</label>
          <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
        </div>
        <div class="campo columna">
          <label for="genero">Género:</label>
          <select id="genero" name="genero" required>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
          </select>
        </div>
      </div>
        <div class="campo">
          <label for="correoElectronico">Correo Electrónico:</label>
          <input type="email" id="correoElectronico" name="correoElectronico" required>
        </div>
        <div class="campo">
          <label for="contrasena">Contraseña:</label>
          <input type="password" id="contrasena" name="contrasena" required>
        </div>
        <button type="submit">Registrarse</button>
        <div class="iniciar-sesion">
          <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal de Registro Exitoso -->
  <div class="modal fade" id="registroExitosoModal" tabindex="-1" aria-labelledby="registroExitosoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registroExitosoModalLabel">Registro Exitoso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Registro Exitoso
        </div>
        <div class="modal-footer">
          <!-- Puedes agregar botones o contenido adicional aquí si es necesario -->
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $("#registroForm").submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
          url: "{{route('crearUsuario')}}",
          type: "POST",
          data: formData,
          success: function (data) {
            $('#registroExitosoModal').modal('show');

            setTimeout(function () {
              window.location.href = "{{ route('login') }}";
            }, 1000);
          },
          error: function (xhr, status, error) {
            // Manejo de errores si es necesario
          }
        });
      });
    });
  </script>

</body>

</html>


