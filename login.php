<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--<link href ="bootstrap.min.css" rel="stylesheet">-->
    <title>Inciar sesion</title>
    <!--dentro del style se encuentra la ruta de la imagen que aparece en el login-->
    <style>
        body{
            background:#000000;
            background: linear-gradient(to right,#A43737, #000000)
        }
        .bg{
            background-image: url(./img/fondo.jpg);
            background-position: center center;
        }
    </style>
</head>
<body>

    <div class="container w-75 bg-primary mt-5 rounded shadow">
        <div class="row align-items-stretch">
            <div class="col bg d-done d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">
        
        </div>
        <div class="col bg-white p-5 rounded-end">
            <div class="tex-end">
                <img src="img/logo.png" width="48" alt="">
            </div>

            <h2 class="fw-bold text-center py-5">Bienvenido</h2>
            
            <!--inicio del login, todo el formulario-->
            <form action="#">
                <div class="mb-4">
                    <label for="email" class="form-label">Correo elecronico</label>
                    <input type="email" class="form-control" name="email">
                </div>

            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" name="connected" class="form-check-input">
                <label for="connected" class="form-check-label">Mantenerme conectado</label>
            </div>
                
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Iniciar sesion</button>
            </div>

            <div class="my-3">
                <span>No tienes cuenta?<a href="enlace">Registrate</a></span>
            </div>
        </form>

        <!--opciones para iniciar sesion con tus redes social, tal vez se agregen para el pryecto-->
        <div class="container w-100 my-5">
            <div class="row text-center">
                <div class="col-12">Iniciar sesion</div>
            </div>
            <div class="row">
                <div class="col">
                    <button class="btn btn-outline-primary w-100 my-1">
                        <div class="row alingn-items-center">
                            <div class="col-2 d-none d-md-block">
                                <img src="./img/facebook.png" width="32" alt="">
                            </div>
                            <div class="col-12 col-md-10 text-center">
                                Facebook
                            </div>
                        </div>
                    </button>
                </div>
                <div class="col">
                <button class="btn btn-outline-danger w-100 my-1">
                        <div class="row alingn-items-center">
                            <div class="col-2 d-none d-md-block">
                                <img src="./img/google.png" width="32" alt="">
                            </div>
                            <div class="col-12 col-md-10 text-center">
                                Google
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
    <script src="bootstrap.bundle.min.js"></script>
    <!--video de referencia para hacer el diseño -->
    <!--https://www.youtube.com/watch?v=NDQfhTWyD8E -->
</body>
</html>