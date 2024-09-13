<?php

session_start();
if (!isset($_SESSION['admLogado'])) {
    header('location: index.php');
}
?>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Style_and_Js/style.css">
    <title>Cadastro de Usuário</title>
    <style>
        body {
            padding-top: 15px;
        }

        .cardcad {
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto;
            height: 460px;
            width: 900px;
        }

        .x {
            background-color: black;
        }

        .imacontentx {
            position: relative;
            height: 50px;
            width: 100%;
        }

        .imgdivx {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-12 text-center">
                <h3 class="card-title">Usuarios Cadastrados</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nome do Mercado</th>
                            <th>Usuário</th>
                            <th>Logotipo</th>
                            <th>Del User</th>
                        </tr>
                    </thead>

                    <?php
                    include '../process/funcoes.php';
                    $stmt = getConnection()->prepare("SELECT * FROM users");
                    $stmt->execute();
                    $feathImage = $stmt->fetchAll();
                    foreach ($feathImage as $key => $value) { ?>
                        <tbody>
                            <tr>
                                <th><?php
                                    $contar = $value['id_user'];
                                    while ($contar < 0) {
                                        $contar++;
                                    }
                                    ?></th>
                                <td><?= $value['nome_mercado'] ?></td>
                                <td><?= $value['user'] ?></td>
                                <td>
                                    <div class="imacontentx">
                                        <img src="../img/logos/<?=$value['logo']?>" class="imgdivx">
                                    </div>
                                </td>
                                <td>
                                    <form action="processAdm.php" method="POST">
                                        <input type="submit" value="Deletar" class="btn btn-danger" name="deletarUsuario" onclick="return confirm('Tem certeza que deseja deletar <?php echo $value['nome_mercado']; ?>?')">
                                        <input type="hidden" value="<?= $value['id_user'] ?>" name="id_user">
                                    </form>
                                </td>

                            </tr>
                        </tbody>

                    <?php } ?>
                </table>
            </div>
            <div class="card  col">
                <div class="card-body text-center">
                    <form action="processAdm.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <h3 class="card-title">Cadastrar Cliente</h3>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nome do Mercado</label>
                            <div class="col-sm">
                                <input type="text" class="form-control" name="nome_mercado" required>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Topic para Notificação do App</label>
                            <div class="col-sm">
                                <input type="text" class="form-control" name="topicApp" required>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Usuário</label>
                            <div class="col-sm">
                                <input type="text" class="form-control" name="user" required>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Senha</label>
                            <div class="col-sm">
                                <input type="password" class="form-control" id="pass_a" name="password" required>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Confirmar Senha</label>
                            <div class="col-sm">
                                <input type="password" class="form-control" id="pass_b" name="password_confirmed" required>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label for="imagem" class="col-sm-5 col-form-label">Logotipo</label>
                            <div class="col-sm">
                                <input type="file" class="form-control-file" id="imagem" name="logo">
                            </div>
                            <small class="arqHelp form-text col-sm-12 text-muted">Somente arquivos com extenção: png, jpg ou jpeg com tamanho maximo 1mb!</small>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <input type="submit" value="Cadastrar" class="btn btn-block btn-success" name="cadastrarUsuario" onclick="return validar()">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12">

                <form action="processAdm.php" method="POST">
                    <div class="row justify-content-center form-group">
                        <input type="submit" value="Sair" class="btn btn-danger" name="sair">
                    </div>
                </form>
            </div>

        </div>


    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="../Style_and_Js/jquery-3.6.0.min.js"></script>
    <script src="../Style_and_Js/jquery.mask.js"></script>
    <script type="text/javascript" src="../Style_and_Js/javascript.js"></script>
    <script>
        function validar() {
            var pass_a = document.getElementById('pass_a');
            var pass_b = document.getElementById('pass_b');
            var pass_admin = document.getElementById('pass_admin');

            if (pass_a.value == pass_b.value) {

                return true;


            } else {
                alert('Os Campos Senha e Confirmar Senha devem ser iguais!');
                return false;
            }
        }
    </script>
</body>

</html>