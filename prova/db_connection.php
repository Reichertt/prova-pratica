<?php
// Configuração do banco de dados
$servername = "db"; // Nome do serviço do banco no docker-compose.yml
$username = "root";
$password = "rootpassword";
$dbname = "prova_pratica";

// Criando a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Opcional: Definir o charset para evitar problemas com acentuação
$conn->set_charset("utf8");