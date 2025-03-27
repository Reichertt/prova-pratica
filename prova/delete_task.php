<?php

require_once 'db_connection.php'; // Importa a conexão com o banco

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