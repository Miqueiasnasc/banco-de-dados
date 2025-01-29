<!Doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="'IE=edge">
    <title>
        Login Page
    </title>
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <link href="login.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="left">
       
            <h2>
                LOGIN
            </h2>
            <p>
                Faça o login para comprar o seu docinho!
            </p>
            <form action="testelogin.php" method = "POST">
            <div class="input-group">
                <i class="fas fa-user">
                </i>
                <input placeholder="E-mail" type="text" id="email" name="email" />
            </div>
            <div class="input-group">
                <i class="fas fa-lock">
                </i>
                <input placeholder="Senha" type="password" name="senha" id="senha"/>
            </div>
            <input class="btn" type="submit" name="submit"/>
            </form>

            

            <a href="index.html">voltar</a>
            <a href="cadastro.php">Não tenho conta</a>
            <p>
                Faça login com outros
            </p>
            <div class="social-login">
                <button>
                    <i class="fab fa-google">
                    </i>
                    Entrar com o Google
                </button>
            
                <button>
                    <i class="fab fa-facebook-f">
                    </i>
                    Entrar com o Facebook
                </button>
            </div>
        </div>
        <div class="right">
            <img alt="chocotone trufado com nutella" src="imagens/foto-login.png" />
            <div class="icon">
                <i class="fas fa-sun">
                </i>
            </div>
        </div>
    </div>
    
</body>

</html>
