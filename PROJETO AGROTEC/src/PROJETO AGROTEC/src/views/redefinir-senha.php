<?php
$cpf = $_POST['cpf'] ?? '';
$novaSenha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$conn = new mysqli("localhost", "root", "", "agrotech_db", 3306);

if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}

$sql = "UPDATE agricultores SET senha = '$novaSenha' WHERE cpf = '$cpf'";

if ($conn->query($sql) === TRUE) {
  echo "Senha atualizada com sucesso!";
} else {
  echo "Erro ao atualizar senha: " . $conn->error;
}

$conn->close();
?>
