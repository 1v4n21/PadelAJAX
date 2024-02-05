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

        body {
            background: url('web/images/fondo2.webp') no-repeat center center fixed;
            background-size: cover;
        }

        .container-fluid {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
        }

        h4 {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>

<body>

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

    <div class="container-fluid text-center bg-success py-3 d-flex flex-column align-items-center">
        <div class="d-flex align-items-center mb-3">
            <h1 class="text-light mb-0 me-3">Mancha Padel</h1>
            <img src="web/images/favicon.jpg" alt="Icono" width="70" height="70">
        </div>
        <div class="d-flex justify-content-between align-items-center w-100">
            <h4 class="text-light mb-0 me-5 ms-5">¡Hola, <?= Sesion::getUsuario()->getNombre() ?>!</h4>
            <a href="index.php?accion=logout" class="btn btn-danger me-5 ms-5">Cerrar Sesión</a>
        </div>
    </div>

    <div class="container mt-5">

        <div class="text-center bg-light p-3 w-50 mx-auto border rounded">
            <h1 class="text-dark d-inline-block">RESERVA DE PISTA</h1>
        </div>

        <br>

        <div class="row mt-5">
            <div class="col-md-6 mx-auto">
                <!-- Input de Fecha -->
                <div class="input-group mb-3">
                    <label class="input-group-text" for="fechaInput">Fecha</label>
                    <input type="date" class="form-control" id="fechaInput" min="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
        </div>

        <br>
        <hr>

        <div class="container mt-5 mb-5">
            <table class="table table-bordered table-striped mx-auto">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">Tramos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = 0;

                    foreach ($tramos as $tramo) :
                        // Abre una nueva fila en cada segundo tramo
                        if ($contador % 2 === 0) :
                            echo '</tr><tr>';
                        endif;
                    ?>
                        <td class="text-center">
                            <!-- Aquí colocas el contenido de tu celda -->
                            <p>Tramo <?= $contador + 1 ?>: <?= $tramo->getHora() ?></p>
                        </td>
                    <?php $contador++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Scripts de Bootstrap (jQuery y Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>



</html>