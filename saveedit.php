<?php
session_start();
include_once('config.php');

// Verifica se o usuário tem permissão para editar
if (!isset($_SESSION['tipo']) || ($_SESSION['tipo'] !== 'admin' && $_SESSION['id'] != $_POST['id'])) {
    header('Location: sistema.php');
    exit();
}
// verifica se o botao de update foi submitado e nao esta vazio
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];

    $sqlUpdate = "UPDATE users SET nome='$nome', email='$email', senha='$senha', telefone='$telefone', cpf='$cpf', endereco='$endereco' WHERE id='$id'";
    $result = $conexao->query($sqlUpdate);
}
header('Location: sistema.php');