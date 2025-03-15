<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$dbname = "prova_pratica";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se os dados foram recebidos via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Certifique-se de que os parâmetros do POST estão sendo acessados corretamente
    $id = $_POST["task_id"];  // Corrigido para task_id
    $titulo = $_POST['title'];
    $nome_tarefa = $_POST["nome_tarefa"];  // Corrigido para nome_tarefa
    $data = $_POST["data"];
    $taskImportance = $_POST['importancia']; // Novo campo
    $status = 1; // Se status for fixo, está correto, mas se for variável, trate aqui.

    // Atualizar a tarefa no banco de dados
    $sql = "UPDATE tarefas SET titulo = ?, descricao = ?, status = ?, importancia = ?, data = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Corrigir o tipo do bind_param: 'ssss' para quatro parâmetros string
    $stmt->bind_param("sssssi", $titulo, $nome_tarefa, $status, $taskImportance, $data, $id);

    if ($stmt->execute()) {
        echo "success";  // Apenas retorna "success" em vez de uma mensagem completa
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
