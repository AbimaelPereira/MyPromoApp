<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Style_and_Js/style.css">
    <script src="Style_and_Js/notify.min.js"></script>
    <script src="Style_and_Js/jquery-3.6.0.min.js"></script>
    <title>Login Adm</title>
    <style>
        .cardx {
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto;
            height: 215px;
            width: 650px;
        }

        .x {
            background-color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card cardx col text-center">
                <div class="card-body text-center">
                    <form action="processAdm.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <h3 class="card-title">Digite a Senha de Administrador</h3>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm">
                                <input type="password" class="form-control" name="passAdm" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <input type="submit" value="Logar" class="btn btn-block btn-success" name="btnloginAdm">
                        </div>
                    </form>
                </div>
                <a href="../index.php" class="col-sm-12">Ir para Pagina de Login de Usuarios</a>
            </div>

        </div>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="../Style_and_Js/jquery.mask.js"></script>
    <script type="text/javascript" src="../Style_and_Js/javascript.js"></script>
</body>

</html>