<?php
require('config/conexao.php');
//verificar se a postagem existe de acordo com os campos
if (isset($_POST['nome_completo']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['repete_senha'])) {
    //verificar se os campos foram preenchidos
    if (empty($_POST['nome_completo']) or empty($_POST['email']) or empty($_POST['senha']) or empty($_POST['repete_senha']) or empty($_POST['termos'])) {
        $erro_geral = "Todos os campos são obrigatórios!";
    } else {
        //receber valores vindo do post e limpar
        $nome = limparPost($_POST['nome_completo']);
        $email = limparPost($_POST['email']);
        $senha2 = limparPost($_POST['senha']);
        $senha_cript = sha1($senha2);
        $repete_senha = limparPost($_POST['repete_senha']);
        $checkbox = $_POST['termos'];

        if (!preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
            $erro_nome = "Somente permitido letras e espaços em branco";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro_email = "Formato de email inválido!";
        }
        //verificar se senha tem mais de 6 dígitos
        if (strlen($senha2) < 6) {
            $erro_senha = "Senha deve ter 6 caracteres ou mais!";
        }
        //verificar se repete senha é igual a senha
        if ($senha2 !== $repete_senha) {
            $erro_repete_senha = "Senhas são diferentes!";
        }
        //verrificar se checkbox foi marcado
        if ($checkbox != true) {
            $erro_checkbox = "Checkbox desativado";
        }
        if(!isset($erro_geral)&& !isset($erro_nome) && !isset($erro_email) && !isset($erro_senha) && !isset($erro_repete_senha) && !isset($erro_checkbox)){
            // verificar se este email já esta cadastrado no banco
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? LIMIT 1");
            $sql-> execute(array($email));
            $usuario1 = $sql->fetch();
            //se não existir o usuario vai add no banco
            if(!$usuario1){
                $repete_senha="";
                $token="";
                $codigo_confimacao= uniqid();
                $status ="novo";
                $data_cadastro = date('d-m-Y');
                $sql = $pdo->prepare("INSERT INTO usuarios VALUES(null,?,?,?,?,?,?,?)");
                if($sql->execute(array($nome,$email,$senha_cript,$repete_senha,$token,$codigo_confimacao,$status,$data_cadastro))){
                    if($modo=="local"){
                        header('location: login.php?result=ok');
                    }
                    if($modo=="producao"){
                        $mail = new PHPMailer(true);
                        try{
                            //Recipients
                            $mail->setFrom('sistema@sistema.com', 'Sistema de Login');// quem está mandando o Email
                            $mail->addAddress($email, $nome);

                            //Content
                            $mail->isHTML(true);//corpo do email como HTML
                            $mail->Subject = 'Confirme seu cadastro'; // titulo do email
                            $mail->Body    = '<h1>Por favor confirme seu e-mail abaixo:</h1><br><br> <a href="https://seusistema.com.br/confirmacao.php?cod_confirm='.$codigo_confirmacao.'">Confirmar E-mail</a>';
                            
                            $mail->send();
                            header('location: obrigado.php');
                        }catch (Exception $e) {
                            echo "Houve um problema ao enviar o email de confirmação: {$mail->ErrorInfo}";
                        }
                    }
                }
            }else{
                //já existe usuario mostrar erro
                $erro_geral = "Usuário já cadastrado";
            }
        }
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
        <title>Cadastro</title>
    </head>

    <body>
        <form class="container col-md-4 mt-5" method="post">
            <h1 class="text-center">Cadastrar</h1>
            <?php if (isset($erro_geral)) { ?>
                <p class="text-center" style="color:red"><?php echo $erro_geral; ?></p>
            <?php } ?>

            <div class="form-group">
                <label for="user">Usuário:</label>
                <input class="form-control" name="nome_completo" id="user" type="text" <?php if(isset($nome)){echo "value='$nome'";} ?> >
                <?php if (isset($erro_nome)) { ?>
                    <p class="text-center" style="color:red"><?php echo $erro_nome; ?></p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" name="email" id="email" type="email" <?php if(isset($email)){echo "value='$email'";} ?> >
                <?php if (isset($erro_email)) { ?>
                    <p class="text-center" style="color:red"><?php echo $erro_email; ?></p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input class="form-control" name="senha" id="password" type="password" <?php if(isset($senha2)){echo "value='$senha2'";} ?> >
                <?php if(isset($erro_senha)){?>
                    <p class="text-center" style="color:red"><?php echo $erro_senha; ?></p>
            <?php }?>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirmar senha:</label>
                <input class="form-control" name="repete_senha" id="confirmPassword" type="password" <?php if(isset($repete_senha)){echo "value='$repete_senha'";} ?> >
                <?php if(isset($erro_repete_senha)){?>
                    <p class="text-center" style="color:red"><?php echo $erro_repete_senha; ?></p>
            <?php }?>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="termos" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Ao se cadastrar você concorda com nossa <a href="#">Politica de Privacidade </a> e <a href="#">Termos de uso</a> </label>
                <?php if(isset($erro_checkbox)){?>
                    <p class="text-center" style="color:red"><?php echo $erro_checkbox; ?></p>
            <?php }?>
            </div>
            <div class="d-flex flex-column">
                <Button class="btn btn-secondary mb-3">Cadastrar</Button>
                <a href="login.php" class="text-center">Já tenho conta</a>
            </div>
        </form>
    </body>

</html>