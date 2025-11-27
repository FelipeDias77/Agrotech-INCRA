<?php
$cpf = $_POST['cpf'] ?? '';
$senha = $_POST['senha'] ?? '';

$conn = new mysqli("localhost", "root", "", "agrotech_db", 3306);

if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}

$sql = "SELECT * FROM agricultores WHERE cpf = '$cpf'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
  $usuario = $result->fetch_assoc();
  if (password_verify($senha, $usuario['senha'])) {
    echo "Login realizado com sucesso!";
  } else {
    echo "Senha incorreta.";
  }
} else {
  echo "Usuário não encontrado.";
}

$conn->close();
?>
