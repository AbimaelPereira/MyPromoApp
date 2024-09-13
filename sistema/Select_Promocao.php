<?php

if (!isset($_SESSION['nome_mercado']) && !isset($_SESSION['logo'])) {
    header('location: ../index.php');
}
?>
<div class="container text-center" style="margin-top: 40px;">
    <div class="row">

        <?php

        $nome_mercado_replace = str_replace(" ", "_", strtolower($_SESSION['nome_mercado']));
        $stmt = getConnection()->prepare("SELECT * FROM $nome_mercado_replace");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
        ?>

            <h3 class="card-text col-12" style="margin-bottom: 15px;"><img src="../img/logo.ico" style="width:35px; margin-right:20px;">Promoções Cadastradas:</h3>

        <?php } else { ?>

            <h3 class="card-text col-12" style="margin-bottom: 15px;"><img src="../img/logo.ico" style="width:35px; margin-right:20px;">Nenhuma Promoção Cadastrada</h3>

        <?php }
        $feathImage = $stmt->fetchAll();

        foreach ($feathImage as $key => $value) {
            $id = $value['id'];

            if ($value['qtd_max'] == 0) {
                $limitemax = '<br>';
            } else {
                if ($value['und_kg'] == 1) {
                    $und_kg = 'Unidade(s)';
                } elseif ($value['und_kg'] == 2) {
                    $und_kg = 'Kg';
                } 
                $limitemax = 'Limite até: ' . $value['qtd_max'] . ' ' . $und_kg;
            }




            if ($value['validade'] == "x") {
                $validade = '<br>';
            } else {
                $validade = 'Validade: ' . $value['validade'];
            }

        ?>
            <div class="col-sm-3">
                <div class="card card_select text-center" style="margin-top: 4px;">
                    <div class="imacontent">
                        <img src="<?= "../img/uploads_images/" . $nome_mercado_replace . "/" . $value['image_name'] ?>" class="imgdiv">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $value["titulo"]; ?></h4>
                        <h6 class="preco2"><?php echo $value["precoa"]; ?></h6>
                        <h5 class="preco1"><?php echo $value["precob"]; ?></h5>
                        <div style="padding-bottom: 15px;">
                            <p class="textcard"><?= $limitemax; ?></p>
                            <p class="textcard"><?= $validade ?></p>
                        </div>
                        <div class="row">
                            <div class="col-2"></div>
                            <form action="Atualizar_Promocao.php" method="POST" class="col-4">
                                <input type="hidden" name="id_up" value="<?= $id ?>">
                                <button type="submit" class="btn btns btns_up" name="btnAtualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                    </svg>
                                </button>
                            </form>
                            <form action="../process/process.php" method="POST" class="col-4">
                                <input type="hidden" name="id_del" value="<?= $id ?>">
                                <input type="hidden" name="image_name" value="<?= $value['image_name'] ?>">
                                <input type="hidden" name="nome_mercado" value="<?= $_SESSION["nome_mercado"]; ?>">
                                <button name="del_promo" class="btn btns btns_del" type="submit" onclick="return confirm('Tem certeza que deseja deletar <?php echo $value['titulo']; ?>?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                    </svg>
                                </button>
                            </form>
                            <div class="col-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>






























































<?php
/*
    include 'conexao.php';

    $sql_read = "SELECT * FROM contatos";
    $dados = $PDO->query($sql_read);

    $resultado = array();

    while($contato = $dados->fetch(PDO::FETCH_OBJ)) {
        
        $resultado[] = array("id"=>$contato->id, "nome"=>$contato->nome, "fone"=>$contato->fone);
    }

    echo json_encode($resultado);*/

?>