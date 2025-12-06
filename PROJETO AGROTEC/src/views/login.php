 
<?php
$cpf   = $_POST['cpf']   ?? '';
$senha = $_POST['senha'] ?? '';

$conn = new mysqli("localhost", "root", "", "agrotech_db", 3306);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Usando prepared statement para evitar SQL Injection
$stmt = $conn->prepare("SELECT * FROM agricultores WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    if (password_verify($senha, $usuario['senha'])) {
        echo "Login realizado com sucesso!";
        // Aqui você pode redirecionar para a página inicial
        // header("Location: index.html");
        // exit();
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}

$stmt->close();
$conn->close();
?>
