    <?php 
    if(isset($_POST['submit'])){// seleciona a variavel caso exista um submit

        /*print_r($_POST['nome']);
        print_r($_POST['email']);
        print_r($_POST['senha']);*/
        include_once('config.php');// inclui p arwuivo config.php que faz a integração com o banco de dados

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
        
        $nome = $_POST['nome']; // atribui valores as variaveis
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $cpf = $_POST['cpf'];
        $endereco = $_POST['endereco'];

        if (!validarCPF($cpf)) {// caso o cpf seja invalido da um exit
            echo "CPF inválido.";
            exit;
        }
        // da insert na tablea especificada
        $result = mysqli_query($conexao, "INSERT INTO users(nome, email, senha, telefone, cpf, endereco) VALUES ('$nome', '$email', '$senha', '$telefone', '$cpf', '$endereco')");
    
        header('Location: login.php');
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
                <form action="cadastro.php" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input placeholder="  Nome completo" type="text" id="nome" name="nome" />
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input placeholder=" E-mail" type="email" id="email" name="email" />
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input placeholder="  Senha" type="password" id="senha" name="senha" />
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input placeholder=" telefone" type="text" id="telefone" name="telefone"/>
                </div>
                <div class="input-group">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                <input placeholder="cpf" type="text" id="cpf" name="cpf"/>   
                </div>
                <div class="input-group">
                    <i class=" fa fa-map-marker" aria-hidden="true"></i>
                <input placeholder="endereço completo" type="text" id="endereco" name="endereco">
                </div>


                </div>
                <button class="btn" type="submit" name="submit">Cadastrar</button>
                
            </form>
                <a href="login.php">Já tenho conta</a>
                <a  href="index.html">voltar</a>
            
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