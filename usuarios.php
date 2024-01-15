<?php
    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION['usuario'])){
            die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
        }    
}
    include('conexao.php');
    $id = $_SESSION['usuario'];
    $sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
    $query = $mysqli->query($sqlcode);
    $cliente = $query->fetch_assoc();

    function formatar_data($data){
        return implode('/', array_reverse(explode('-', $data)));
    };
    // FORMATAR TELEFONE PARA VISUALIZAÇÃO COM CARACTERES
    function formatar_telefone($telefone){
        $ddd = substr ($telefone, 0, 2);
        $parte1 = substr ($telefone, 2, 5);
        $parte2 = substr ($telefone, 7);
        return "($ddd) $parte1-$parte2";
    }
    include('conexao.php');
    // COMANDO SQL PARA CONSULTAR CLIENTES
    $sql_clientes   = "SELECT * FROM clientes";
    // COMANDO QUERY, PARA EXECUTAR COMANDO SQL
    $query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
    // COMANDO NUM ROWS, PARA CONTAR QUANTIDADE DADOS NO BANCO
    $num_clientes   = $query_clientes->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<a href="http://127.0.0.1/projetoCadastro/cadastrar_cliente.php">Cadastrar cliente</a>
    <h1>Usuários cadastrados</h1>
    <p>Esses são os clientes cadastrados no seu sistema</p>
    <table border="1" cellpadding="10">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Data de cadastro</th>
            <th>Ações</th>
        </thead>
        <tbody> 
        <?php 
            if($num_clientes == 0) { 
        ?> 
        <tr>
            <td colspan="7">Nenhum cliente foi cadastrado</td>
        </tr>
        <?php }
            else{ 
                while($cliente = $query_clientes->fetch_assoc()){
                    $telefone ="Não informado!";
                    if(!empty($cliente['telefone'])){
                        $telefone = formatar_telefone($cliente['telefone']);   
                    }
                        $nascimento = "Nascimento não informada!";
                    if(!empty($cliente['nascimento'])){
                        $nascimento = formatar_data($cliente['nascimento']);
                        }
                        $data_cadastro = date("d/m/y H:i:s", strtotime($cliente['data']));
            ?>     
            <tr>
                <td><?php echo $cliente['id']?>     </td>
                <td><?php echo $cliente['nome']?>   </td>
                <td><?php echo $cliente['email']?>  </td>
                <td><?php echo $telefone; ?>  </td>
                <td><?php echo $nascimento ?>   </td>
                <td><?php echo $data_cadastro;?>    </td>
                <td>
                <a class="edit" href="editar_cliente.php?id=<?php echo $cliente['id']?>">Editar</a>
                <a class="error" href="deletar_cliente.php?id=<?php echo $cliente['id']?>">Deletar</a>
                </td>
            </tr>             
        <?php
            }
            }
        ?>
        </tbody>
    </table>
</body>
</html>