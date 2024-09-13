<?php

session_start();
if (!isset($_SESSION['nome_mercado']) && !isset($_SESSION['logo'])) {
    header('location: ../index.php');
}

require_once "../process/funcoes.php";
session_start();
if (isset($_POST['btnAtualizar'])) {
    $id = $_POST['id_up'];

    $nome_mercado_replace = str_replace(" ", "_", strtolower($_SESSION['nome_mercado']));
    $query = "SELECT * FROM $nome_mercado_replace WHERE id = :id";
    $stmt = getConnection()->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $value = $stmt->fetch(PDO::FETCH_OBJ);

    $titulo = $value->titulo;
    $precoa = $value->precoa;
    $precob = $value->precob;
    $qtd_max = $value->qtd_max;
    $und_kg = $value->und_kg;
    $validade = $value->validade;
    $image_name = $value->image_name;
} else {
    $titulo = '';
    $precoa = '';
    $precob = '';
    $qtd_max = '';
    $und_kg = '';
    $validade = '';
    $image_name = '';
}



?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Style_and_Js/style.css">
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    <title>Editar Promoção</title>
</head>

<body>

    <?php include "cabecalho.php" ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card cardmargin col">
                <div class="card-body text-center">
                <form action="../process/process.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <h3 class="card-title">Editar Promoção</h3>
                        <hr>
                        <div class="form-group row">
                            <label for="titulopromo" class="col-sm-3 col-form-label">Titulo da Promoção</label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="titulopromo" name="titulo" placeholder="Ex: Frango Congelado" value="<?= $titulo ?>">
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label">Preço Atual</label>
                            <div class="col-sm row">
                                <label class="col-2 col-form-label">R$</label>
                                <input type="text" class="col form-control money" placeholder="Ex: R$ 30,00" name="precoa" value="<?= $precoa ?>">
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label">Preço Promoção</label>
                            <div class="col-sm row">
                                <label class="col-2 col-form-label">R$</label>
                                <input type="text" class="col form-control money" placeholder="Ex: R$ 25,50" name="precob" value="<?= $precob ?>">
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group justify-content-center">
                            <label for="kg_uni" class="col-sm-3 col-form-label">Limite até</label>

                            <input type="text" class="form-control col-sm-3 limite_d" placeholder="" name="qtd_max" maxlength="2" value="<?= $qtd_max ?>">

                            <div class="form-check col-sm-3 row">


                                <?php ?>

                                <?php
                                if ($und_kg == 1) { ?>
                                    <div class="col-sm">
                                        <input class="form-check-input limite_d" type="radio" name="und_kg" value="1" checked>
                                        <label class="form-check-label">Unidades</label>
                                    </div>
                                    <div class="col-sm">
                                        <input class="form-check-input limite_d" type="radio" name="und_kg" value="2">
                                        <label class="form-check-label">Kg</label>
                                    </div>

                                <?php
                                } elseif ($und_kg == 2) { ?>
                                    <div class="col-sm">
                                        <input class="form-check-input limite_d" type="radio" name="und_kg" value="1">
                                        <label class="form-check-label">Unidades</label>
                                    </div>
                                    <div class="col-sm">
                                        <input class="form-check-input limite_d" type="radio" name="und_kg" value="2" checked>
                                        <label class="form-check-label">Kg</label>
                                    </div>
                                <?php } else { ?>

                                    <div class="col-sm">
                                        <input class="form-check-input limite_d" type="radio" name="und_kg" value="1" checked>
                                        <label class="form-check-label">Unidades</label>
                                    </div>
                                    <div class="col-sm">
                                        <input class="form-check-input limite_d" type="radio" name="und_kg" value="2">
                                        <label class="form-check-label">Kg</label>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-sm col-form-label">
                                <input type="checkbox" class="form-check-input" id="desabilitar_limite">
                                <label class="form-check-label">Desabilitar Limite</label>
                            </div>

                        </div>
                        <hr>
                        <div class="row form-group justify-content-center">
                            <label for="validade" class="col-sm-3 col-form-label">Validade do Produto</label>
                            <input type="text" class="form-control col-sm-3 validade_d" id="validade" name="validade" value="<?= $validade ?>">
                            <div class="col-sm col-form-label">
                                <input type="checkbox" class="form-check-input" id="desabilitar_validade">
                                <label class="form-check-label">Desabilitar Validade</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label for="imagem" class="col-sm-5 col-form-label">Imagem do Anuncio</label>
                            <div class="col-sm">
                                <input type="file" class="form-control-file" id="imagem" name="imagemPromocao" required>
                            </div>
                            <small id="arqHelp" class="form-text col-sm-12 text-muted">Somente arquivos com extenção: png, jpg ou jpeg com tamanho maximo 1mb!</small>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <input type="hidden" value="<?= $id ?>" name="id_up">
                            <input type="hidden" name="image_name" value="<?= $image_name; ?>">
                            <input type="hidden" name="nome_mercado" value="<?= $_SESSION["nome_mercado"]; ?>">
                            <input type="submit" value="Alterar" class="btn btn-block btn-warning" name="alterarPromocao">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="../Style_and_Js/jquery-3.6.0.min.js"></script>
    <script src="../Style_and_Js/jquery.mask.js"></script>
    <script type="text/javascript" src="../Style_and_Js/javascript.js"></script>
</body>

</html>