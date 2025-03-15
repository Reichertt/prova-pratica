<?php

$servername = "db"; // Nome do serviço do banco no docker-compose.yml
$username = "root";
$password = "rootpassword";
$dbname = "prova_pratica";

// Conectando ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Pegando o id da tarefa via POST
$id = $_POST['id'];

// Atualizando o status da tarefa para 0 (excluída)
$sql = "UPDATE tarefas SET status = 0 WHERE id = ?";

// Preparando a declaração
$stmt = $conn->prepare($sql);

// Ligando o parâmetro
$stmt->bind_param("i", $id);

// Executando a consulta
if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

// Fechando a conexão
$stmt->close();
$conn->close();
