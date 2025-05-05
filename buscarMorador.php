<?php
// Configurações de conexão com o banco de dados
$host = "localhost";
$port = 3306;
$user = "root";
$password = "senac";
$dbName = "senac";

$conexao = "mysql:host=$host;port=$port;dbname=$dbName";

// Inicializa variáveis
$resultados = [];
$mensagem = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tipo_busca"]) && isset($_POST["valor_busca"])) {
    
    $tipo_busca = $_POST["tipo_busca"];
    $valor_busca = $_POST["valor_busca"];
    
    try {
        $db = new PDO($conexao, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Monta a consulta SQL baseada no tipo de busca selecionado
        switch ($tipo_busca) {
            case "bloco":
                $query = "SELECT * FROM moradores WHERE bloco = :valor_busca";
                break;
            case "apartamento":
                $query = "SELECT * FROM moradores WHERE apartamento = :valor_busca";
                break;
            case "nome":
                $query = "SELECT * FROM moradores WHERE nome LIKE :valor_busca";
                $valor_busca = "%$valor_busca%"; // Adiciona curingas para busca parcial por nome
                break;
            default:
                throw new Exception("Tipo de busca inválido");
        }
        
        $statement = $db->prepare($query);
        $statement->bindParam(":valor_busca", $valor_busca);
        $statement->execute();
        
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($resultados) == 0) {
            $mensagem = "Nenhum morador encontrado com os critérios de busca informados.";
        }
        
    } catch (PDOException $e) {
        $mensagem = "Erro no banco de dados: " . $e->getMessage();
    } catch (Exception $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}

// Inclui o arquivo com o formulário de busca e exibição dos resultados
include 'index.html';
?>

<?php
    // Verifica se há resultados para exibir (este código só será executado se este arquivo for incluído em buscarMorador.php)
    if (isset($resultados) && count($resultados) > 0) {
    ?>
        <div class="buscar-morador">
            <h3>Resultados da Busca</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Bloco</th>
                        <th>Apartamento</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $morador): ?>
                    <tr>
                        <td><?php echo $morador['nome']; ?></td>
                        <td><?php echo $morador['bloco']; ?></td>
                        <td><?php echo $morador['apartamento']; ?></td>
                        <td><?php echo $morador['telefone']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php
    } elseif (isset($mensagem)) {
        echo "<div class='buscar-morador'><p>$mensagem</p></div>";
    }
    ?>
