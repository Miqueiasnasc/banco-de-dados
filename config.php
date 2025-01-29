<?php
// inicia o banco com o php
$dbHost = 'LocalHost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'doces_da_gio';
// cria a conexao com o banco
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// verifica se a conexao esta correta
/*if($conexao -> connect_errno)
{
    echo "erro";
}
else{
    echo "conexão realizada com sucesso";
}*/

?>