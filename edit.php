<?php
session_start();
include_once('config.php');


function validarCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais (ex: 111.111.111-11 não é válido)
    if (preg_match('/^(\\d)\\1{10}$/', $cpf)) {
        return false;
    }

    // Cálculo dos dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

// Verifica se o usuário tem permissão para editar
if (!isset($_SESSION['tipo']) || ($_SESSION['tipo'] !== 'admin' && $_SESSION['id'] != $_GET['id'])) {
    header('Location: sistema.php');
    exit();
}
// verifica se o parametro id nao esta vazio
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sqlSelect = "SELECT * FROM users WHERE id = $id";
    $result = $conexao->query($sqlSelect);
 // mysqlnumrows cnta a qunatidade de rows na querey passando como paremtro a var result 
    // caso o resultado seja maior que 0(caso a query esteja vazia o resultado ai ser 0) executa os comandos
    if ($result->num_rows > 0) {
        //  a var user data receb o comando  mysqli_fetch_assoc que:
        //pega uma linha do resultado da consulta SQL e 
        //a retorna como um array associativo, onde as chaves são os nomes das colunas do banco.
        $user_data = mysqli_fetch_assoc($result);
        $nome = $user_data['nome'];
        $email = $user_data['email'];
        $senha = $user_data['senha'];
        $telefone = $user_data['telefone'];
        $cpf = $user_data['cpf'];
        $endereco = $user_data['endereco'];

        if (!validarCPF($cpf)) {// caso o cpf seja invalido da um exit
            echo "CPF inválido.";
            exit;
        }

    } else {
        header('Location: sistema.php');
    }
}
?>
<!Doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="'IE=edge">
    <title>Cadastro</title>
    <style>
    .container a {
        display: block; /* Garante que os links fiquem em linhas separadas */
        margin-top: 10px; /* Adiciona um espaço superior */
        text-align: left; /* Centraliza os links */
    }

    .container a:last-child {
        margin-top: 20px; /* Adiciona um espaço maior apenas para o último link */
    }
</style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    
    <link href="cadastro.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="left">
            <h2>CADASTRE-SE</h2>
            <p>Faça seu cadastro e garanta os melhores doces!</p>
            <form action="saveedit.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input  value="<?php echo '   '.$nome ?>" type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input value="<?php echo '   '.$email ?>" type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input value="<?php echo '   '.$senha ?>" type="password" id="senha" name="senha" required>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input value="<?php echo '    '.$telefone ?>" type="text" id="telefone" name="telefone" required>
            </div>
            <div class="input-group">
                <i class="fa fa-address-card" aria-hidden="true"></i>
            <input value="<?php echo $cpf ?>" type="text" id="cpf" name="cpf"required>   
            </div>
            <div class="input-group">
                <i class=" fa fa-map-marker" aria-hidden="true"></i>
            <input value="<?php echo '   '.$endereco ?>" type="text" id="endereco" name="endereco" required>
            </div>


            </div>
            <input type="hidden" name="id" value="<?php echo $id ?>"> 
            <input type="submit" name="update" id="update">
            
         </form>
            <a href="login.php">Já tenho conta</a>
            <a  href="sistema.php">voltar</a>
        
        </div>
        <div class="right">
            <img alt="chocotone trufado com nutella" src="imagens/foto-login.png" />
            <div class="icon">
                <i class="fas fa-sun"></i>
            </div>
        </div>
    </div>
    
</body>

</html> 