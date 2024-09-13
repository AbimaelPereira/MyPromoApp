<?php
session_start();
if (!isset($_SESSION['nome_mercado']) && !isset($_SESSION['logo'])) {
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Style_and_Js/emojionearea.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../Style_and_Js/emojionearea.min.js"></script>
    <link rel="stylesheet" href="../Style_and_Js/style.css">
    <script src="../Style_and_Js/notify.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    <title><?= $_SESSION['nome_mercado'] ?> - Criar Notificação</title>
</head>

<body>


    <?php include 'cabecalho.php'; ?>
    <?php require_once "../process/funcoes.php"; ?>
    <?php
    if (isset($_SESSION["userMensagem"])) {
        viewNotify($_SESSION["userMensagem"], $_SESSION["type"], $_SESSION["position"]);
    }
    unset($_SESSION["userMensagem"]);
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <hr class="col-12">
            <div class="card col cardAdd">
                <div class="card-body text-center">
                    <form action="../process/process.php" method="POST" autocomplete="off">
                        <h3 class="card-title"><img src="../img/logo.ico" style="width:35px; margin-right:20px;">Criar Notificação</h3>
                        <hr>
                        <div class="form-group row">
                            <label for="titulopromo" class="col-sm-3 col-form-label">Titulo da Notificação</label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="titleNotify" name="titleNotify" placeholder="Ex: Novas Ofertas/Promoções Cadastradas..." required>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="titulopromo" class="col-sm-3 col-form-label">Texto da Notificação</label>
                            <div class="col-sm">
                                <input type="text" class="form-control" name="bodyNotify" id="bodyNotify" placeholder="Ex: Clique para conferir as ofertas..." required>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <input type="hidden" value="<?= $_SESSION['topicApp'] ?>" name="topicApp">
                            <input type="submit" value="Gerar Notificação" class="btn btn-block btn-success" name="notify">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="../Style_and_Js/jquery.mask.js"></script>
    <script type="text/javascript" src="../Style_and_Js/javascript.js"></script>
    <script>
        $(document).ready(function() {
            $("#titleNotify").emojioneArea({
                pickerPosition: "bottom",
                alignText: "center"
            });
        });
        $(document).ready(function() {
            $("#bodyNotify").emojioneArea({
                pickerPosition: "bottom"
            });
        });
    </script>

</body>

</html>