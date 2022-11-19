<?php
session_start();

// requerimento do PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// dois modos possíveis -> local, producao
$modo= 'local';

if($modo == 'local'){
    $servidor ="localhost";
    $usuario ="test";
    $senha="test123";
    $banco ="login";
}
if($modo == 'proudcao'){
    $servidor ="";
    $usuario ="";
    $senha="";
    $banco = "";
}
$pdo = new PDO("mysql:host=$servidor; dbname=$banco", $usuario, $senha);

// try{
//     $pdo = new PDO("mysql:host=$servidor;dbname =$banco",$usuario,$senha);
//     // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     // echo "Conectado com sucesso!";
// }catch(PDOException $erro){
//     echo "Falha ao se conectar com o banco!";
// }

//função para sanitizar (limpar entradas)
function limparPost($dado){
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}

function auth($token){
    // verificar se tem autorização
global $pdo;
$sql = $pdo->prepare("SELECT * FROM usuarios WHERE token=? LIMIT 1");
$sql->execute(array($token));
$usuario = $sql->fetch(PDO::FETCH_ASSOC);

// se nao encontrar o usuário
if(!$usuario){
   return false;
} else { 
    return $usuario;
}

}
?>