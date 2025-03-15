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

// Pegando os dados via POST
$titulo = $_POST['title'];
$tarefa = $_POST['tarefa'];
$data = $_POST['data']; // A data já vem no formato ISO (yyyy-mm-ddTHH:mm:ss)
$status = $_POST['status'];
$importancia = $_POST['importancia']; // Recebe o valor da importância

// Preparando e executando a consulta SQL
$sql = "INSERT INTO tarefas (titulo, descricao, data, status, importancia) VALUES (?, ?, ?, ?, ?)";

// Preparando a declaração
$stmt = $conn->prepare($sql);

// Verificando se a preparação foi bem-sucedida
if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Ligando os parâmetros
$stmt->bind_param("sssii", $titulo, $tarefa, $data, $status, $importancia); // Ajuste os tipos conforme necessário

// Executando a consulta
if ($stmt->execute()) {
    echo "success";
} else {
    echo "Erro ao executar a consulta: " . $stmt->error;
}

// Fechando a conexão
$stmt->close();
$conn->close();
