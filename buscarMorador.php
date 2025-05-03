<?php
$host = "localhost";
$port = 3306;
$user = "root";
$password = "admin";
$dbName = "senac";

$conexao = "mysql:host=$host;port=$port;dbname=$dbName";

try {
    $db = new PDO($conexao, $user, $password);

    // Alteração aqui:
    $query = "SELECT * FROM moradores WHERE bloco =:username";

    $statement = $db->prepare($query);
    $statement->bindParam(":username", $_POST["usuario"]);

    $statement->execute();

    $usuario = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
