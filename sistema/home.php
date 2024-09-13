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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../Style_and_Js/style.css">
    <script src="../Style_and_Js/notify.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    <title><?= $_SESSION['nome_mercado'] ?></title>
</head>

<body>


    <?php include 'cabecalho.php'; ?>
    <?php require_once "../process/funcoes.php";?>
    <?php 
        if (isset($_SESSION["userMensagem"])) {
            viewNotify($_SESSION["userMensagem"], $_SESSION["type"], $_SESSION["position"]);
        }
        unset($_SESSION["userMensagem"]);
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <?php include "Select_Promocao.php" ?>
            <div class="col-12" id="">
                <div class="row">
                    <div class="col"></div>
                    <form action="../process/process.php" method="post">
                    <input type="hidden" name="nome_mercado" value="<?= $_SESSION["nome_mercado"]; ?>">
                        <button onclick="return confirm('ATENÇÃO!! Tem certeza que deseja apagar Apagar TODAS Promoções?')" class="btn btn-danger" type="submit" name="btn-limpar-tabela" id="btn-limpar-tabela" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                            </svg>
                            Apagar TODAS Promoções
                        </button>
                    </form>
                    <div class="col"></div>
                </div>
            </div>

            <hr class="col-12">
            <div class="card col cardAdd">
                <div class="card-body text-center">
                    <form action="../process/process.php" method="POST" enctype="multipart/form-data" autocomplete="off" name="formpromo">
                        <h3 class="card-title">Adicionar Promoção</h3>
                        <hr>
                        <div class="form-group row">
                            <label for="titulopromo" class="col-sm-3 col-form-label">Titulo da Promoção</label>
                            <div class="col-sm">
                                <input type="text" class="form-control" name="titulo" placeholder="Ex: Frango Congelado" required>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label">Preço Atual</label>
                            <div class="col-sm row">
                                <label class="col-2 col-form-label">R$</label>
                                <input type="text" class="col form-control money" id="moneyx" placeholder="Ex: R$ 30,00" name="precoa" required>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label">Preço Promoção</label>
                            <div class="col-sm row">
                                <label class="col-2 col-form-label">R$</label>
                                <input type="text" class="col form-control money" id="moneyy" placeholder="Ex: R$ 25,50" name="precob" required>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group justify-content-center">
                            <label for="kg_uni" class="col-sm-3 col-form-label">Limite até</label>

                            <input type="text" class="form-control col-sm-3 limite_d" placeholder="" name="qtd_max" maxlength="2" required>

                            <div class="form-check col-sm-3 row">
                                <div class="col-sm">
                                    <input class="form-check-input limite_d" type="radio" name="und_kg" value="1" checked required>
                                    <label class="form-check-label">Unidades</label>
                                </div>
                                <div class="col-sm">
                                    <input class="form-check-input limite_d" type="radio" name="und_kg" value="2" required>
                                    <label class="form-check-label">Kg</label>
                                </div>
                            </div>
                            <div class="col-sm col-form-label">
                                <input type="checkbox" class="form-check-input" id="desabilitar_limite">
                                <label class="form-check-label">Desabilitar Limite</label>
                            </div>

                        </div>
                        <hr>
                        <div class="row form-group justify-content-center">
                            <label for="validade" class="col-sm-3 col-form-label">Validade do Produto</label>
                            <input type="text" class="form-control col-sm-3 validade_d" id="validade" name="validade" required>
                            <div class="col-sm col-form-label">
                                <input type="checkbox" class="form-check-input" id="desabilitar_validade">
                                <label class="form-check-label">Desabilitar Validade</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label for="imagem" class="col-sm-5 col-form-label">Imagem do Anuncio</label>
                            <div class="col-sm">
                                <input type="file" class="form-control-file" id="imagem" name="imagePromo" required>
                            </div>
                            <small class="arqHelp form-text col-sm-12 text-muted">Somente arquivos com extenção: png, jpg ou jpeg com tamanho maximo 1mb!</small>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <input type="submit" value="Adicionar" class="btn btn-block btn-primary" name="cadastrarPromocao" onclick="return validar()">
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

</body>

</html>