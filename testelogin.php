<?php
session_start();
// verifca se existe um submit e se os campos email e senha existem
if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    include_once('config.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca o usuário no banco de dados
    $sql = "SELECT id, tipo FROM users WHERE email = '$email' AND senha = '$senha'";
    // var result recebe a  var de cnexao com o banco mandando executar o comando $sql na query
    $result = $conexao->query($sql);
    // mysqlnumrows cnta a qunatidade de rows na querey passando como paremtro a var result 
    // caso o resultado seja menor que 1 destroi os dados de email e senha da var sessao
    if (mysqli_num_rows($result) < 1) {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    } else {
       
        /*Exemplo:Se a consulta retorna um usuário com id = 5 e tipo = "admin", então:
    $user_data = ["id" => 5,"tipo" => "admin"];Isso permite acessar $user_data['id'] e $user_data['tipo'].*/
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        $_SESSION['id'] = $user_data['id']; // Armazena o ID do usuário na sessão
        $_SESSION['tipo'] = $user_data['tipo']; // Armazena o tipo de usuário (comum ou admin)
        header('Location: sistema.php');
    }
} else {
    header('Location: login.php');
}