<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style_and_Js/style.css">
    <script src="Style_and_Js/jquery-3.6.0.min.js"></script>
    <script src="Style_and_Js/notify.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    <title>Faça seu Login!</title>
    <style>
        .logincard {
            height: 282px;
            width: 400px;
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto;
        }

        .logincard:hover {
            border-color: #00aeff;
            box-shadow: 0px 0px 10px #0099ff;
        }
    </style>

</head>


<body>



    <div class="container">
        <div class="row justify-content-center">
            <div class="card col logincard" id="x">
                <div class="card-body text-center">
                    <h4 class="card-title">Bem-vindo ao Sistema</h4>
                    <h6 class="card-title"><img src="../img/logo.ico" style="width:35px; margin-right:20px;">Faça seu Login</h6>
                    <form action="./process/process.php" method="post" autocomplete="off">
                        <div class="form-group row">
                            <input type="text" class="form-control col" id="us" name="user" placeholder="Usuário">
                        </div>
                        <div class="form-group row">
                            <input type="password" class="form-control col" id="pass_word" name="password" placeholder="Senha">
                        </div>
                        <div class="form-group row">
                            <button type="submit" onclick="return checarCampos()" name="logar" class="btn btn-primary btn-block">Logar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once "./process/funcoes.php";
    session_start();
    if (isset($_SESSION["mensagemLogin"])) {
        viewNotify($_SESSION["mensagemLogin"], $_SESSION["type"], $_SESSION['position']);
    }
    unset($_SESSION["mensagemLogin"]);
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
        function checarCampos() {
            var user = document.getElementById('us');
            var pass = document.getElementById('pass_word');

            if (user.value != '' && pass.value != '') {
                return true;
            } else {
                $(".logincard").notify(
                    "Os Campos Usuario e Senha devem ser Preenchidos!", {
                        position: "top center"
                    }
                );
                return false;
            }
        }
    </script>
</body>

</html>