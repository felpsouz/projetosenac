<?php 
$host = "localhost";
$port = 3306;
$user = "root";
$password = "admin";
$dbName = "senac";

// Criar conexão mysqli (não apenas uma string)
$conexao = mysqli_connect($host, $user, $password, $dbName, $port);

// Verificar conexão
if (mysqli_connect_errno()) {
    die("Falha na conexão: " . mysqli_connect_error());
}
if (isset($_POST['createUsuario'])){
    $bloco = mysqli_real_escape_string($conexao, trim($_POST['bloco']));
    $apartamento = mysqli_real_escape_string($conexao, trim($_POST['apartamento']));
    $morador = mysqli_real_escape_string($conexao, trim($_POST['morador']));
    

    $sql = "INSERT INTO apartamentos (bloco, apartamento, morador) VALUES ('$bloco', '$apartamento', '$morador')";

     mysqli_query($conexao, $sql);
    
    if(mysqli_affected_rows($conexao) > 0){
        $_SESSION['mensagem'] = 'Usuário criado com sucesso';
        header('location: index.html');
        exit;
    }
    else{
        header('location: index.html');
        $_SESSION['mensagem'] = 'Usuário não foi criado';
        exit;
    }
}
?>