<?php

require_once 'db_connection.php'; // Importa a conexão com o banco

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