<?php
require('config/conexao.php');
//  comando para deletar
// $sql = $pdo->prepare("DELETE FROM usuarios WHERE id=?");
// $sql->execute(array(4));

$user = auth($_SESSION['TOKEN']);
if(!$user){
    header('location: login.php');
}else{
    
// // verificar se tem autorização
// $sql = $pdo->prepare("SELECT * FROM usuarios WHERE token=? LIMIT 1");
// $sql->execute(array($_SESSION['TOKEN']));
// $usuario = $sql->fetch(PDO::FETCH_ASSOC);

// //se nao encontrar o usuário
// if(!$usuario){
//     header('location: login.php');
// } else{
     ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Tabela de Usuários</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .oculto {
            display: none;
        }

        button {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="app">
        <div>
            <div class="d-flex flex-column justify-content-center mt-5">
                <div class="d-flex justify-content-center align-items-center my-3">
                <h1 class="text-center mr-3"><?php echo "Bem-vindo! ".$user['nome'] ?></h1><a href="logout.php" class="btn btn-secondary py-1 px-4">Sair</a>
                </div>
                <h1 class="text-center pr-3">Tabela de Usuários</h1>
            </div>
            <!-- <form id="form_salva" method="post" class="d-flex m-3">
                <input class="form-control mr-3" type="text" name="nome">
                <input class="form-control mr-3" type="email" name="email">
                <button class="btn btn-secondary" type="submit" name="salvar">Salvar</button>
            </form> -->
            <form class="oculto" id="form_atualiza" method="post" class="d-flex m-3">
                <div class="d-flex">
                    <input class="form-control mr-3" type="hidden" id="id_editado" name="id_editado">
                    <input class="form-control mr-3" type="text" id="nome_editado" name="nome_editado">
                    <input class="form-control mr-3" type="email" id="email_editado" name="email_editado">
                    <button class="btn btn-secondary mr-2" type="submit" id="atualizar" name="atualizar">Atualizar</button>
                    <button class="btn btn-secondary mr-2" id="cancelar" name="cancelar">cancelar</button>
                </div>
            </form>
            <form class="oculto" id="form_deleta" method="post" class="d-flex m-3">
                <input class="form-control mr-3" type="hidden" id="id_deleta" name="id_deleta">
                <strong>Tem certeza que deseja deletar o cliente <span id="cliente"></span>?</strong>
                <button class="btn btn-secondary" type="submit" id="deletar" name="deletar">Confimar</button>
                <button class="btn btn-secondary" id="cancelar_delete" name="cancelar_delete">cancelar</button>
            </form>
            </br>
            <?php
            //inserir um dado no banco modo simples
            //  $sql = $pdo->prepare("INSERT INTO usuarios VALUES (null, 'samuel','test@test.com','27/08/2022')");
            //  $sql->execute();

            // modo correto anti sql injection
            if (isset($_POST['salvar']) && isset($_POST['nome']) && isset($_POST['email'])) {
                $nome = limparPost($_POST['nome']);
                $email = limparPost($_POST['email']);
                $data = date('d/m/Y');

                //validação de campo vazio
                if ($nome == "" || $nome == null) {
                    echo "<strong style='color:red'>Nome não pode ser vazio</strong>";
                    exit();
                }
                // if ($nome == "" || $nome == null) {
                //     echo "<strong style='color:red'>Nome não pode ser vazio</strong>";
                //     exit();
                // }
                //validação de nome e email
                if (!preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
                    echo "<strong style='color:red'>Somente permitido letras e espaços em branco para o nome</strong>";
                    exit();
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<strong style='color:red'>Formato de email inválido!</strong>";
                    exit();
                }

                $sql = $pdo->prepare("INSERT INTO usuarios VALUES (null, ?,?,?)");
                $sql->execute(array($nome, $email, $data));

                echo "<strong style='color:green'>Cliente inserido com sucesso!</strong>";
            }
            ?>
            <?php
            //processo de atualização
            if (isset($_POST['atualizar']) && isset($_POST['id_editado']) && isset($_POST['nome_editado']) && isset($_POST['email_editado'])) {
                $id = limparPost($_POST['id_editado']);
                $nome = limparPost($_POST['nome_editado']);
                $email = limparPost($_POST['email_editado']);
                //validação de campo vazio
                if ($nome == "" || $nome == null) {
                    echo "<strong style='color:red'>Nome não pode ser vazio</strong>";
                    exit();
                }
                // if ($nome == "" || $nome == null) {
                //     echo "<strong style='color:red'>Nome não pode ser vazio</strong>";
                //     exit();
                // }
                //validação de nome e email
                if (!preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
                    echo "<strong style='color:red'>Somente permitido letras e espaços em branco para o nome</strong>";
                    exit();
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<strong style='color:red'>Formato de email inválido!</strong>";
                    exit();
                }
                //comando para atualizar
                $sql = $pdo->prepare("UPDATE usuarios SET nome=?, email=? WHERE id=?");
                $sql->execute(array($nome, $email, $id));
                echo "Atualizado " . $sql->rowCount() . " registro!";
            }
            ?>
            <?php
            if (isset($_POST['deletar']) && ($_POST['id_deleta'])) {
                $id = limparPost($_POST['id_deleta']);
                //  comando para deletar
                $sql = $pdo->prepare("DELETE FROM usuarios WHERE id=?");
                $sql->execute(array($id));
                echo "Cliente deletado com sucesso!";
            }
            ?>
            <?php
            //selecionar dados da tabela
            $sql = $pdo->prepare("SELECT * FROM usuarios");
            $sql->execute();
            $dados =  $sql->fetchAll();
            // var_dump($dados);
            
            ?>
            <?php
            $valor2 = "";
            // echo $valor2;
            if (count($dados) > 0) {
                echo "<table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>";
                foreach ($dados as $chave => $valor) {
                    echo "
                <tr>
                    <td>" . $valor['id'] . "</td>
                    <td>" . $valor['nome'] . "</td>
                    <td>" . $valor['email'] . "</td>
                    <th><button href='#' class='btn-atualizar btn btn-secondary' id='btn' @click='test' data-id='" . $valor['id'] . "' data-nome='" . $valor['nome'] . "' data-email='" . $valor['email'] . "'>Atualizar</button> | <button href='#' class='btn-deletar btn btn-danger' data-id='" . $valor['id'] . "' data-nome='" . $valor['nome'] . "' data-email='" . $valor['email'] . "'>Deletar</button></th>
                </tr>";
                    //  $valor2 = $_GET['data-nome'];
                }
                echo "</table>";
            } else {
                echo "<p>Nenhum cliente cadastrado</p>";
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(".btn-atualizar").click(function() {
            var id = $(this).attr('data-id');
            var nome = $(this).attr('data-nome');
            var email = $(this).attr('data-email');

            $("#form_salva").addClass('oculto');
            $("#form_atualiza").removeClass('oculto');
            $("#form_deleta").addClass('oculto');

            $("#id_editado").val(id);
            $("#nome_editado").val(nome);
            $("#email_editado").val(email);
        });
        $(".btn-deletar").click(function() {
            var id = $(this).attr('data-id');
            var nome = $(this).attr('data-nome');
            var email = $(this).attr('data-email');

            $("#form_salva").addClass('oculto');
            $("#form_atualiza").addClass('oculto');
            $("#form_deleta").removeClass('oculto');

            $("#id_deleta").val(id);
            $("#cliente").html(nome);
        });
        $('#cancelar').click(function() {
            $("#form_salva").removeClass('oculto');
            $("#form_atualiza").addClass('oculto');
            $("#form_deleta").addClass('oculto');

        });
        $('#cancelar_delete').click(function() {
            $("#form_salva").removeClass('oculto');
            $("#form_atualiza").addClass('oculto');
            $("#form_deleta").addClass('oculto');
        })
    </script>
</body>

<script src="https://cdn.jsdelivr.net/npm/vue@2.7.8/dist/vue.js"></script>

</html>
<?php } ?>
<!-- <script>
    new Vue({
        el: '#app',
        data() {
            return {
                name:"",
            }
        },
        methods: {
            test() {
                var el = document.querySelector("#btn");
                var dataId = el.getAttribute("data-id");
                var dataNome = el.getAttribute("data-nome");
                var dataEmail = el.getAttribute("data-email");

                console.log("id: " +dataId+ " nome: "+dataNome+ " email: " +dataEmail)
                document.querySelector('#id_editado').value = dataId;
                document.querySelector('#nome_editado').value = dataNome;
                document.querySelector('#email_editado').value = dataEmail;
            },
            atualizar() {
                var b = document.querySelector("button")
                this.id = b.getAttribute('data-nome')
                console.log(this.id)
            }
        }
    });
</script> -->