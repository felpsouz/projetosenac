<?php
// Configurações de conexão com o banco de dados
require 'conexao.php';

// criação das variaveis que serão utilizadas
$resultados = [];
$mensagem = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tipo_busca"]) && isset($_POST["valor_busca"])) {
    
    $tipo_busca = $_POST["tipo_busca"];
    $valor_busca = $_POST["valor_busca"];
    
    try {
        $db = new PDO($conexao, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Buscando dados no banco
        switch ($tipo_busca) {
            case "bloco":
                $query = "SELECT * FROM apartamentos WHERE bloco = :valor_busca";
                break;
            case "apartamento":
                $query = "SELECT * FROM apartamentos WHERE apartamento = :valor_busca";
                break;
            case "morador":
                $query = "SELECT * FROM apartamentos WHERE morador LIKE :valor_busca";
                $valor_busca = "%" . $valor_busca . "%";
                break;
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

include 'index.html';
?>

<?php
    // Verifica se há resultados para exibir
    if (isset($resultados) && count($resultados) > 0) {
    ?>
        <div class="buscar-morador">
            <h3  style="display: inline-block;">Resultados da Busca</h3>
            <a href="http://localhost/dashboard/projetosenac/index.html" style="display: inline-block;"><button type="reset">Limpar tela</button></a>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Bloco</th>
                        <th>Apartamento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $morador): ?>
                    <tr>
                        <td><?php echo $morador['morador']; ?></td>
                        <td><?php echo $morador['bloco']; ?></td>
                        <td><?php echo $morador['apartamento']; ?></td>
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
