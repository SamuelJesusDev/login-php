<?php 
require('config/conexao.php');
//exemplo
if(isset($_POST['nome']) && empty($_POST['nome'])){
$name= $_POST['nome'];

$sql->prepare("INSERT INTO usuarios VALUES(?)");
$sql->execute(array($name));

echo "cadastrado com sucesso!";
}

// // verificar se tem autorização
// $sql = $pdo->prepare("SELECT * FROM usuarios WHERE token=? LIMIT 1");
// $sql->execute(array($_SESSION['TOKEN']));
// $usuario = $sql->fetch(PDO::FETCH_ASSOC);

// //se nao encontrar o usuário
// // if(!$usuario){
// //     // header('location: login.php');
// // } else{ 
    ?>
    <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Restrita</title>
</head>
<body>
    <div class="container">
    <form action="" method="post">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control">
        </div>
    </form>
    </div>
</body>
</html>
<!-- <?php
//  }
  ?> -->



