<?php

function conexao(){
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=trabalhofinal_tri01;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $pdo;
  } catch(PDOException $e) {
    echo 'Erro DE CONEXÃO: ' . $e->getMessage();
  }

}

?>