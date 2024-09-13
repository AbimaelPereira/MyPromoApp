<?php

require_once "../process/funcoes.php";

$query = "SELECT * FROM mercado_santa_ritta";
$y = getConnection()->prepare($query);
$y->execute();

    $array_de_dados = array();
    
    while ($dado = $y->fetch(PDO::FETCH_OBJ)) {
        $array_de_dados[] = array(
            "titulo" => $dado->titulo,
            "precoa" => $dado->precoa,
            "precob" => $dado->precob,
            "qtd_max" => $dado->qtd_max,
            "und_kg" => $dado->und_kg,
            "validade" => $dado->validade,
            "image_name" => $dado->image_name
        );
    }

    echo json_encode($array_de_dados);

