<?php

require_once 'db_connection.php'; // Importa a conexão com o banco

// Consulta para buscar todas as tarefas ativas e formatar a data corretamente
$sql = "SELECT id, titulo, descricao, 
        DATE_FORMAT(data, '%Y-%m-%dT%H:%i') AS data, importancia
        FROM tarefas WHERE status = 1";

$result = $conn->query($sql);

// Criando um array para armazenar os dados
$tasks = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

// Retornando os dados em formato JSON
echo json_encode($tasks);

// Fechando a conexão
$conn->close();