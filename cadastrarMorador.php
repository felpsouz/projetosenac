<?php
// Configurações de conexão com o banco de dados
$host = "localhost";
$port = 3306;
$user = "root";
$password = "admin";
$dbName = "comdominio";

$conexao = "mysql:host=$host;port=$port;dbname=$dbName";

// Inicializa variáveis de mensagem
$mensagem = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = trim($_POST['nome'] ?? '');
    $bloco = trim($_POST['bloco'] ?? '');
    $ap = trim($_POST['ap'] ?? '');
    
    // Validação básica
    if (empty($nome) || empty($bloco) || empty($ap)) {
        $mensagem = "Todos os campos são obrigatórios.";
    } else {
        try {
            // Estabelece conexão com o banco de dados
            $db = new PDO($conexao, $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Prepara a consulta SQL para inserir novo morador
            $query = "INSERT INTO condominio (morador, bloco, ap) VALUES (:nome, :bloco, :ap)";
            
            // Prepara e executa a declaração
            $statement = $db->prepare($query);
            $statement->bindParam(":nome", $nome);
            $statement->bindParam(":bloco", $bloco);
            $statement->bindParam(":ap", $ap);
            
            // Executa a inserção
            if ($statement->execute()) {
                $mensagem = "Morador cadastrado com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar morador.";
            }
            
        } catch (PDOException $e) {
            // Verifica se é um erro de duplicidade (chave única)
            if ($e->getCode() == '23000') {
                $mensagem = "Já existe um morador cadastrado neste apartamento.";
            } else {
                $mensagem = "Erro no banco de dados: " . $e->getMessage();
            }
        }
    }
}

// Inclui o arquivo com o formulário de cadastro
include 'CadastroMorador.html';
?>