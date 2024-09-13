<?php
require_once '../process/funcoes.php';
//--------------------------------------------------------------------------------------------
//--------------------------- L  O  G  I  N  -  A  D  M  -------------------------------------

if (isset($_POST['btnloginAdm'])) {

    if (isset($_POST['passAdm']) && !empty($_POST['passAdm'])) {

        if ($_POST['passAdm'] == '9113339791007679') {
            session_start();
            $_SESSION['admLogado'] = "logado";
            header('location: admSystem.php');
        } else {
            header('location: admLogin.php');
        }
    }
}

//--------------------------------------------------------------------------------------------
//------------------------------------- S  A  I  R  ------------------------------------------

if (isset($_POST['sair'])) {
    sair("index.php");
}

//--------------------------------------------------------------------------------------------
//---------------- C  A  D  A  S  T  R  A  R  -  U  S  U  A  R  I  O  ------------------------

if (isset($_POST['cadastrarUsuario'])) {


    $nome_mercado = addslashes($_POST['nome_mercado']);
    $user = addslashes($_POST['user']);
    $password = addslashes($_POST['password_confirmed']);
    $pass_security = password_hash($password, PASSWORD_DEFAULT);

    $imagem = uploadArquivo($_FILES['logo']);
    $topicApp = $_POST['topicApp'];

    if ($imagem == false) {
        echo "<script>alert('Somente arquivos com extenção: png, jpg ou jpeg com tamanho maximo 1mb!');top.location.href='admSystem.php';</script>";
    } else {
        $stmt = getConnection()->prepare('INSERT INTO users (user, pass, logo, nome_mercado, topicApp) 
        VALUES (:USER, :PASS, :LOGO, :NOME_MERCADO, :TOPICAPP)');
        $stmt->bindParam(':USER', $user);
        $stmt->bindParam(':PASS', $pass_security);
        $stmt->bindParam(':LOGO', $imagem["nomeNovo"]);
        $stmt->bindParam(':NOME_MERCADO', $nome_mercado);
        $stmt->bindParam(':TOPICAPP', $topicApp);

        if ($stmt->execute()) {
            $diretorio = "../img/logos/";
            move_uploaded_file($imagem["nomeTemporario"], $diretorio . $imagem["nomeNovo"]);
            $nome_mercado_replace = str_replace(" ", "_", strtolower($nome_mercado));

            $stmt2 = getConnection()->prepare("CREATE TABLE $nome_mercado_replace (
                id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
                titulo varchar(255) NOT NULL,
                precoa varchar(20) NOT NULL,
                precob varchar(20) NOT NULL,
                qtd_max int(20) NOT NULL,
                und_kg int(2) NOT NULL,
                validade varchar(20) NOT NULL,
                image_name varchar(20) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ");

            if ($stmt2->execute()) { //Criar tabela de Promoções

                if (is_dir("uploads_images/" . $nome_mercado_replace)) {
                    echo "<script>alert('Cliente Cadastrado com Sucesso! Diretório de Imagens já Existente!');top.location.href='admSystem.php';</script>";
                } else {
                    if (mkdir("../img/uploads_images/" . $nome_mercado_replace, 0777)) {
                        echo "<script>alert('Cliente Cadastrado com Sucesso!');top.location.href='admSystem.php';</script>";
                    } else {
                        echo "<script>alert('Cliente Cadastrado com Sucesso! Erro ao criar Diretório de Imagens!');top.location.href='admSystem.php';</script>";
                    }
                }
            } else {
                echo "<script>alert('Usuário cadastrado com sucesso\\nPorem não foi possivel criar tabela de Promoções (Banco de dados)');top.location.href='admSystem.php';</script>";
            }
        } else {
            echo "<script>alert('Erro ao Criar Usuário no Banco de Dados\\n(Obs: Logotipo foi Salvo!)');top.location.href='admSystem.php';</script>";
        }
    }
}


//--------------------------------------------------------------------------------------------
//------------------ D  E  L  E  T  A  R  -  U  S  U  A  R  I  O  ----------------------------

if (isset($_POST['deletarUsuario'])) {
    $id = $_POST['id_user'];

    $stmt = getConnection()->prepare("SELECT * FROM users WHERE id_user = :id");
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        $feath = $stmt->fetch(PDO::FETCH_OBJ);

        $stmt = getConnection()->prepare("DELETE FROM users WHERE id_user = :id");

        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $nome_mercado_replace = str_replace(" ", "_", strtolower($feath->nome_mercado));
            $query = "DROP TABLE $nome_mercado_replace";
            $stmt = getConnection()->prepare($query);
            if ($stmt->execute()) {
                if (is_dir("../img/uploads_images/" . $nome_mercado_replace)) {
                    if (unlink('../img/logos/' . $feath->logo)) {
                        rmdir("../img/uploads_images/" . $nome_mercado_replace);
                        echo "<script>alert('Cliente Deletado com Sucesso!');top.location.href='admSystem.php';</script>";
                    } else {
                        echo "<script>alert('Cliente Deletado com Sucesso, Porem não foi possivel localizar o Logo!');top.location.href='admSystem.php';</script>";
                    }
                } else {
                    if (unlink('../img/logos/' . $feath->logo)) {
                        echo "<script>alert('Cliente Deletado com Sucesso!, Porem não foi possivel localizar o Diretório!');top.location.href='admSystem.php';</script>";
                    } else {
                        echo "<script>alert('Cliente Deletado com Sucesso, Poren não foi possivel localizar Logotipo e o Diretório!');top.location.href='admSystem.php';</script>";
                    }
                }
                echo "<script>alert('Usuário deletado com sucesso!');top.location.href='admSystem.php';</script>";
            } else {
                echo "<script>alert('Não foi possivel Deletar Usuário!');top.location.href='admSystem.php';</script>";
            }
        } else {
            echo "<script>alert('Não foi possivel Deletar Usuário!');top.location.href='admSystem.php';</script>";
        }
    } else {
        echo "<script>alert('Não foi possivel Deletar Usuário por ausencia do ID!');top.location.href='admSystem.php';</script>";
    }
}
