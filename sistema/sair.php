<?php

session_start();
if (!isset($_SESSION['nome_mercado']) && !isset($_SESSION['logo'])) {
    header('location: ../index.php');
}

require_once "../process/funcoes.php";
sair("../index.php");
