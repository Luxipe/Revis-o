<?php
// Nome: Gustavo De Oliveira Vital. PHP
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dados_da_empresa";
                                                               // o codigo para funcionar so funciona no botão direito, php server: reload server  ai mostra o nome, meio de transporte etc.
$conn = new mysqli($servername, $username, $password);                                                // mas a tabela ta criada no database dados da empresa com as informações solicitadas.
                                                                                                     //o comentario acima fala tudo
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sqlCreateDB);
$conn->select_db($dbname);

// Função para verificar se a tabela existe
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

// Criação da tabela fornecedores
$tableFornecedores = "fornecedores";
if (!tableExists($conn, $tableFornecedores)) {
    $sqlCreateTableFornecedores = "CREATE TABLE $tableFornecedores (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome_fornecedor VARCHAR(255) NOT NULL,
        tipo_produto VARCHAR(255) NOT NULL,
        localizacao VARCHAR(255) NOT NULL
    )";
    $conn->query($sqlCreateTableFornecedores);
}

// Criação da tabela producao_carne
$tableProducaoCarne = "producao_carne";
if (!tableExists($conn, $tableProducaoCarne)) {
    $sqlCreateTableProducaoCarne = "CREATE TABLE $tableProducaoCarne (
        id INT PRIMARY KEY AUTO_INCREMENT,
        tipo_animal VARCHAR(255) NOT NULL,
        data_abate DATE NOT NULL,
        quantidade_produzida INT NOT NULL
    )";
    $conn->query($sqlCreateTableProducaoCarne);
}

// Criação da tabela controle_qualidade
$tableControleQualidade = "controle_qualidade";
if (!tableExists($conn, $tableControleQualidade)) {
    $sqlCreateTableControleQualidade = "CREATE TABLE $tableControleQualidade (
        id INT PRIMARY KEY AUTO_INCREMENT,
        amostra_analisada VARCHAR(255) NOT NULL,
        resultados_analise VARCHAR(255) NOT NULL,
        nivel_contaminacao INT NOT NULL
    )";
    $conn->query($sqlCreateTableControleQualidade);
}

// Criação da tabela distribuicao
$tableDistribuicao = "distribuicao";
if (!tableExists($conn, $tableDistribuicao)) {
    $sqlCreateTableDistribuicao = "CREATE TABLE $tableDistribuicao (
        id INT PRIMARY KEY AUTO_INCREMENT,
        destino_entrega VARCHAR(255) NOT NULL,
        quantidade_enviada INT NOT NULL,
        meio_transporte VARCHAR(255) NOT NULL
    )";
    $conn->query($sqlCreateTableDistribuicao);
}

// Criação do trigger (mantido o mesmo do código anterior)

// Operações CRUD para a tabela distribuicao
// Inserção
$sqlInsertDistribuicao = "INSERT INTO $tableDistribuicao (destino_entrega, quantidade_enviada, meio_transporte) VALUES ('Gustavo', 50, 'Jadlog')";
$conn->query($sqlInsertDistribuicao);

// Atualização
$sqlUpdateDistribuicao = "UPDATE $tableDistribuicao SET quantidade_enviada = 40 WHERE destino_entrega = 'Gustavo'";
$conn->query($sqlUpdateDistribuicao);

// Consulta
$sqlSelectDistribuicao = "SELECT * FROM $tableDistribuicao";
$resultDistribuicao = $conn->query($sqlSelectDistribuicao);

if ($resultDistribuicao->num_rows > 0) {
    while ($row = $resultDistribuicao->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Destino de Entrega: " . $row["destino_entrega"] . " - Quantidade Enviada: " . $row["quantidade_enviada"] . " - Meio de Transporte: " . $row["meio_transporte"] . "<br>";
    }
} else {
    echo "Nenhum resultado encontrado na tabela $tableDistribuicao.<br>";
}

// Deleção
$sqlDeleteDistribuicao = "DELETE FROM $tableDistribuicao WHERE destino_entrega = 'Gustavo'";
$conn->query($sqlDeleteDistribuicao);

$conn->close();
?>
