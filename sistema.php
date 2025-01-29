<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();// caso nao esteja encerra a sessao
}

// Função para verificar permissões
function verificaPermissao($id_usuario_alvo) {
    if ($_SESSION['tipo'] === 'admin') return true; // Admin pode tudo
    return ($_SESSION['id'] == $id_usuario_alvo); // Usuário comum só pode editar/excluir a própria conta
}

// Lógica de pesquisa
if (!empty($_GET['search'])) {
    $data = $_GET['search'];// a variavel data recebe os dados do serch pela url atraves do metodo get
    $sql = "SELECT * FROM users WHERE id LIKE '%$data%' OR nome LIKE '%$data%' OR email LIKE '%$data%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM users ORDER BY id DESC";
}

$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doces da Gio</title>
    <style>
        .table-bg {
            background: rgba(236, 100, 207, 0.92);
            border-radius: 15px;
            overflow: hidden;
        }
        .table-bg th,
        .table-bg td {
            text-align: center;
            border: 1px solid #ddd;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
        
    
</head>
<body>
    <header>
        <div class="search-bar">
            <a href="sair.php">
                <button id="search-sair">Sair</button>
            </a>
        </div>
    
    <div class="box-search">
        <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
     <!-- chama funcao search data feita em javscript com a funcao onlick(-->
        <button onclick="searchData()" class="btn btn-primary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
    </div>
    </header>
    <div class="m-5">
        <table class="table text-black table-bg">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Senha</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //mysqli_fetch_assoc($result) pega uma linha do resultado da consulta SQL e 
        //a retorna como um array associativo, onde as chaves são os nomes das colunas do banco.
                while ($user_data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $user_data['id'] . "</td>";
                    echo "<td>" . $user_data['nome'] . "</td>";
                    echo "<td>" . $user_data['email'] . "</td>";
                    echo "<td>" . $user_data['senha'] . "</td>";
                    echo "<td>" . $user_data['telefone'] . "</td>";
                    echo "<td>" . $user_data['cpf'] . "</td>";
                    echo "<td>" . $user_data['endereco'] . "</td>";
                    
                    // Verifica permissões antes de exibir os botões de editar/excluir
                    if (verificaPermissao($user_data['id'])) {
                        echo "<td>
                                <a class='btn btn-primary btn-sm' href='edit.php?id=$user_data[id]'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                                    </svg>
                                </a>
                                <a class='btn btn-danger btn-sm' href='delete.php?id=$user_data[id]'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                        <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                                    </svg>
                                </a>
                              </td>";
                    } else {
                        echo "<td></td>"; // Não mostra ações para outros usuários
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        // funcao javascrippt que  redireciona o usuário para sistema.php com o termo de busca como parâmetro na URL
        //Usa document.getElementById('pesquisar') para obter o elemento HTML com o id="pesquisar" com o boto de input no caso
        var search = document.getElementById('pesquisar');
        // evento de javascriptt que é ativado ao pressionar a tecla nesse caso a enter
        //  caso a tecla enter seja pressionada no campo de pesquisa chama  funcao
        search.addEventListener("keydown", function(event) {
            if (event.key == "Enter") {
                searchData();
            }
        });
        // funcao que pega dados do 'sistema.ph' com os valores digitaos na brra de pesquisa
        // nesse caso joga pro id nome ou email que é como esta definido as funcoes no codigo php
        function searchData() {
            window.location = 'sistema.php?search=' + search.value;
        }
    </script>
</body>
</html>