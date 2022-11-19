<?php
require('config/conexao.php');

if(isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])){
    // receber os dados vindo do post e limpar
    $email = limparPost($_POST['email']);
    $senha2 = limparPost($_POST['senha']);
    $senha_cript = sha1($senha2);

    // verificar se existe este usuário
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND senha=?  LIMIT 1");
    $sql->execute(array($email,$senha_cript));
    $usuario1 = $sql->fetch(PDO::FETCH_ASSOC);
    if($usuario1){
        //existe o usuario
        //verificar se o cadastro foi confimado
        if($usuario1['status']!== 'confirmado'){
            //criar um token
            $token = sha1(uniqid().date('d-m-Y-H-i-s'));

            //atualizar o token deste usuario no banco
            $sql = $pdo->prepare("UPDATE usuarios SET token=? WHERE email=? AND senha=?");
            if($sql->execute(array($token,$email,$senha_cript))){
                //armazenar este token na sessao(session)
                $_SESSION['TOKEN'] = $token;
                header('location: table.php');
            }
        }else{
            $erro_login = "Por favor confirme seu cadastro no e-mail cadastrado!";
        }
        
    }else{
        //já existe usuario mostrar erro
        $erro_login = "Usuário ou Senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Login</title>
    <style>
        .oculto {
            display: none;
        }
    </style>
</head>

<body>
    <form class="container col-md-3 mt-5" method="post">
        <h1 class="text-center">Login</h1>
        <?php if (isset($_GET['result']) && ($_GET['result'] == 'ok')) { ?>
            <p class="text-center" style="color:green">Usuário cadastrado com sucesso!</p>
        <?php } ?>
        <?php if (isset($erro_login)) { ?>
            <p class="text-center" style="color:red"><?php echo $erro_login; ?></p>
        <?php } ?>
        <div class="form-group">
            <label for="user">Email:</label>
            <input class="form-control" id="user" name="email" type="email">
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input class="form-control" id="password" name="senha" type="password">
        </div>
        <div class="d-flex flex-column">
            <Button class="btn btn-secondary mb-3">Fazer Login</Button>
            <a href="cadastro.php"> Ainda não tenho cadastro</a>
        </div>
    </form>
    <!-- <script>
        setTimeout(() => {
            // $('sucesso').addClass('oculto')
            $('sucesso').hide();
        }, 3000);
    </script> -->
</body>

</html>