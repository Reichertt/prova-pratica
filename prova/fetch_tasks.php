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
