<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="icon" href="web/images/favicon.jpg" type="image/x-icon">
    <link rel="shortcut icon" href="web/images/favicon.jpg" type="image/x-icon">
    <!-- css -->
    <link rel="stylesheet" href="web/css/login.css">
    <!-- bootstrap y font-awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8y+uEzrPLnFkZ8ulnM/Aaw2NDBXvzWlF7sJXe7O06Q3TMKXf6N9S5aIKzGx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login-Registro</title>

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
    </style>
</head>

<body>
    <?= imprimirMensaje() ?>

    <!--JavaScript-->
    <script>
        // Muestra el mensaje de error al cargar la página
        $(document).ready(function() {
            $(".error").fadeIn().delay(5000).fadeOut();
        });
    </script>

    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
                    <div class="card-img-left d-none d-md-flex">

                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">LOGIN</h5>
                        <!-- Formulario -->
                        <form action="index.php?accion=login" method="post">

                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="name@example.com" required>
                                <label for="floatingInputEmail">Correo Electrónico</label>
                            </div>

                            <hr>

                            <div class="form-floating mb-3">
                                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Contraseña</label>
                            </div>

                            <div class="d-grid mb-2">
                                <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">LOGIN</button>
                            </div>
                            <!-- Link -->
                            <a class="d-block text-center mt-2 small" href="index.php?accion=registrar">No tienes cuenta? Registrate</a>

                            <hr class="my-4">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>