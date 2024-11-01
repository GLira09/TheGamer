<?php
$servername = "localhost"; 
$username = "seu_usuario"; 
$password = "sua_senha";
$dbname = "the_gamer"; 

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
