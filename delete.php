<?php
session_start();
include_once('config.php');

// Verifica se o usuário tem permissão para excluir
if (!isset($_SESSION['tipo']) || ($_SESSION['tipo'] !== 'admin' && $_SESSION['id'] != $_GET['id'])) {
    header('Location: sistema.php');
    exit();
}

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sqlDelete = "DELETE FROM users WHERE id = $id";
    $resultDelete = $conexao->query($sqlDelete);
}
header('Location: sistema.php');