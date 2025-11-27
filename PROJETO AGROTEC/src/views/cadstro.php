<?php
$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$email = $_POST['email'] ?? '';
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$conn = new mysqli("localhost", "root", "", "agrotech_db", 3306);

if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}

$sql = "INSERT INTO agricultores (nome, cpf, email, senha) VALUES ('$nome', '$cpf', '$email', '$senha')";

if ($conn->query($sql) === TRUE) {
  echo "Cadastro realizado com sucesso!";
} else {
  echo "Erro: " . $conn->error;
}

$conn->close();
?>
