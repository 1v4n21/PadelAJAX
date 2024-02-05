<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="icon" href="web/images/favicon.jpg" type="image/x-icon">
    <link rel="shortcut icon" href="web/images/favicon.jpg" type="image/x-icon">

    <!-- bootstrap y font-awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>ManchaPadel-Inicio</title>

    <!-- Link jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- CSS -->
    <style>
        .error {
            display: none;
            padding: 15px;
            border-radius: 8px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .correcto {
            display: none;
            padding: 15px;
            border-radius: 8px;
            background-color: #28a745;
            border: 1px solid #218838;
            color: black;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-light">

    <!-- Mensaje de error -->
    <?php imprimirMensaje(); ?>

    <!-- Mensaje de correcto -->
    <?php imprimirMensajeC(); ?>

    <!--JavaScript-->
    <script>
        // Muestra el mensaje de error al cargar la página
        $(document).ready(function() {
            $(".error").fadeIn().delay(5000).fadeOut();
        });
    </script>

    <script>
        // Muestra el mensaje de correcto al cargar la página
        $(document).ready(function() {
            $(".correcto").fadeIn().delay(5000).fadeOut();
        });
    </script>

<div class="container-fluid text-center bg-success py-3">
        <h1 class="text-light">Mancha Padel</h1>
    </div>

    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="text-success">¡Hola, <?= Sesion::getUsuario()->getNombre() ?>!</h4>
            <a href="index.php?accion=logout" class="btn btn-danger">Cerrar Sesión</a>
        </div>

        <!-- Contenido de la página aquí -->

    </div>

    <!-- Scripts de Bootstrap (jQuery y Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8y+uEzrPLnFkZ8ulnM/Aaw2NDBXvzWlF7sJXe7O06Q3TMKXf6N9S5aIKzGx" crossorigin="anonymous"></script>
</body>


</html>