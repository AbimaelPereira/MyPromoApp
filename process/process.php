<?php
include 'funcoes.php';
session_start();

if (isset($_POST['logar'])) {
    if (isset($_POST['user']) &&  !empty($_POST['user']) && isset($_POST['password']) && !empty($_POST['password'])) {

        $user = addslashes($_POST['user']);
        $pass = addslashes($_POST['password']);

        $stmt = getConnection()->prepare("SELECT * FROM users WHERE user = :user");
        $stmt->bindParam(":user", $user);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $dado = $stmt->fetch(PDO::FETCH_OBJ);
                $pass_verify = password_verify($pass, $dado->pass);
                if ($pass_verify) {
                    session_start();
                    $_SESSION['nome_mercado'] = $dado->nome_mercado;
                    $_SESSION['logo'] = $dado->logo;
                    $_SESSION['topicApp'] = $dado->topicApp;
                    header('location: ../sistema/home.php');
                } else {
                    notify("mensagemLogin", "Usuário ou Senha Incorretos! Senha", "error", "../index.php", "center");
                }
            } else {
                notify("mensagemLogin", "Usuário ou Senha Incorretos! User", "error", "../index.php", "center");
            }
        } else {
            notify("mensagemLogin", "Erro ao conectar com Banco de Dados", "error", "../index.php", "top center");
        }
    }
}

if (isset($_POST['cadastrarPromocao'])) {
    session_start();
    $titulo = $_POST['titulo'];
    $precoa = 'R$ ' . $_POST['precoa'];
    $precob = 'R$ ' . $_POST['precob'];


    if (isset($_POST['qtd_max'])) {
        $qtd_max = $_POST['qtd_max'];
    } else {
        $qtd_max = 0;
    }

    if (isset($_POST['und_kg'])) {
        $und_kg = $_POST['und_kg'];
    } else {
        $und_kg = 0;
    }

    if (isset($_POST['validade'])) {
        $validade = $_POST['validade'];
    } else {
        $validade = "x";
    }


    $nome_mercado_replace = str_replace(" ", "_", strtolower($_SESSION["nome_mercado"]));
    $imagem = uploadArquivo($_FILES['imagePromo']);
    if ($imagem == false) {
        notify(
            "userMensagem",
            "Erro! Somente arquivos com extenção: png, jpg ou jpeg com tamanho maximo 1mb!",
            "error",
            "../sistema/home.php",
            null
        );
    } else {
        $query = "INSERT INTO $nome_mercado_replace (titulo, precoa, precob, qtd_max, und_kg, validade, image_name) VALUES ( :TITULO , :PRECOA, :PRECOB, :QTD_MAX, :UND_KG, :VALIDADE, :IMAGE_NAME)";
        $stmt = getConnection()->prepare($query);
        $stmt->bindParam(':TITULO', $titulo);
        $stmt->bindParam(':PRECOA', $precoa);
        $stmt->bindParam(':PRECOB', $precob);
        $stmt->bindParam(':QTD_MAX', $qtd_max);
        $stmt->bindParam(':UND_KG', $und_kg);
        $stmt->bindParam(':VALIDADE', $validade);
        $stmt->bindParam(':IMAGE_NAME', $imagem["nomeNovo"]);
        if ($stmt->execute()) {
            notify(
                "userMensagem",
                "Promoção salva com sucesso!",
                "success",
                "../sistema/home.php",
                null
            );
            $diretorio = "../img/uploads_images/" . $nome_mercado_replace . "/";
            move_uploaded_file($imagem["nomeTemporario"], $diretorio . $imagem["nomeNovo"]);
        } else {
            notify(
                "userMensagem",
                "Não foi possivel salvar Promoção!",
                "error",
                "../sistema/home.php",
                null
            );
        }
    }
}

if (isset($_POST['alterarPromocao'])) {
    $id = $_POST['id_up'];
    $image_name = $_POST['image_name'];
    $nome_mercado = $_POST['nome_mercado'];
    $nome_mercado_replace = str_replace(" ", "_", strtolower($nome_mercado));



    $titulo = $_POST['titulo'];
    $precoa = 'R$ ' . $_POST['precoa'];
    $precob = 'R$ ' . $_POST['precob'];


    if (isset($_POST['qtd_max'])) {
        $qtd_max = $_POST['qtd_max'];
    } else {
        $qtd_max = 0;
    }

    if (isset($_POST['und_kg'])) {
        $und_kg = $_POST['und_kg'];
    } else {
        $und_kg = 0;
    }

    if (isset($_POST['validade'])) {
        $validade = $_POST['validade'];
    } else {
        $validade = "x";
    }

    $imagem = uploadArquivo($_FILES["imagemPromocao"]);
    if ($imagem == false) {
        notify(
            "userMensagem",
            "Erro! Somente arquivos com extenção: png, jpg ou jpeg com tamanho maximo 1mb!",
            "error",
            "../sistema/home.php",
            null
        );
    } else {

        $query = "UPDATE $nome_mercado_replace SET titulo = :TITULO, precoa = :PRECOA, precob = :PRECOB, qtd_max = :QTD_MAX, und_kg = :UND_KG, validade = :VALIDADE, image_name = :IMAGE_NAME WHERE id = :ID";
        $stmt = getConnection()->prepare($query);

        if ($stmt->execute([':TITULO' => $titulo, ':PRECOA' => $precoa, ':PRECOB' => $precob, ':QTD_MAX' => $qtd_max, ':UND_KG' => $und_kg, ':VALIDADE' => $validade, ':IMAGE_NAME' => $imagem["nomeNovo"], ':ID' => $id])) {

            $diretorio = "../img/uploads_images/" . $nome_mercado_replace . "/";
            move_uploaded_file($imagem["nomeTemporario"], $diretorio . $imagem["nomeNovo"]);
            unlink('../img/uploads_images/' . $nome_mercado_replace . '/' . $image_name);

            notify(
                "userMensagem",
                "Promoção alterada com Sucesso!",
                "warn",
                "../sistema/home.php",
                null
            );
        } else {
            notify(
                "userMensagem",
                "Não foi possivel alterar Promoção!",
                "error",
                "../sistema/home.php",
                null
            );
        }
    }
}

if (isset($_POST['del_promo'])) {
    session_start();
    $id = $_POST['id_del'];
    $nome_mercado = $_POST['nome_mercado'];
    $nome_mercado_replace = str_replace(" ", "_", strtolower($nome_mercado));
    $image_name = $_POST['image_name'];
    
    $query = "DELETE FROM $nome_mercado_replace WHERE id = :id";
    $stmt = getConnection()->prepare($query);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        unlink('../img/uploads_images/' . $nome_mercado_replace . '/' . $image_name);
        notify(
            "userMensagem",
            "Promoção deletada!",
            "success",
            "../sistema/home.php",
            null
        );
    } else {
        notify(
            "userMensagem",
            "Erro ao deletar Promoção!",
            "error",
            "../sistema/home.php",
            null
        );
    }
}

if (isset($_POST['btn-limpar-tabela'])) {
    $nome_mercado = $_POST['nome_mercado'];
    $nome_mercado_replace = str_replace(" ", "_", strtolower($nome_mercado));
    $query = 'DELETE FROM ' . $nome_mercado_replace;
    $stmt = getConnection()->prepare($query);
    if ($stmt->execute()) {
        $path = '../img/uploads_images/' . $nome_mercado_replace . '/';
        foreach (scandir($path) as $arquivo) {
            $caminho_arquivo = "$path$arquivo";
            if (is_file($caminho_arquivo)) {
                unlink($caminho_arquivo);
            }
        }
        notify(
            "userMensagem",
            "Promoções deletadas com Sucesso!",
            "success",
            "../sistema/home.php",
            null
        );
    } else {

        notify(
            "userMensagem",
            "Não foi possivel deletar as Promoções!",
            "error",
            "../sistema/home.php",
            null
        );
    };
}

if(isset($_POST['notify'])){
    $titleNotify = $_POST['titleNotify'];
    $bodyNotify = $_POST['bodyNotify'];
    $topicApp = $_POST['topicApp'];
    
    //echo $titleNotify."<br><br>".$bodyNotify."<br><br>".$topicApp;
    $notif = sendNotify($titleNotify,$bodyNotify,$topicApp);

    $y = explode(":",$notif);
    
    
    if($y[0] == '{"message_id"'){
        notify(
            "userMensagem",
            "Notificação Enviada com Sucesso!",
            "success",
            "../sistema/home.php",
            null
        );
    } else {
        notify(
            "userMensagem",
            "Erro ao Enviar Notificação",
            "error",
            "../sistema/home.php",
            null
        );
    }

}
