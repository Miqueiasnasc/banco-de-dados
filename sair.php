<?php
// funcao do botao sair
    session_start();// inicia uma sessao
    unset($_SESSION['email']);// destroi os dados de email da sessao
    unset($_SESSION['senha']);//destroi os dados de senga da sessao
    header("location: login.php");// redireciona para a pagina login.php
   
   ?>