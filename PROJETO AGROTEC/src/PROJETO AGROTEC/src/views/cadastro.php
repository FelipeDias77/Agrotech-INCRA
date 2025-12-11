<?php 
$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$email = $_POST['email'] ?? '';
$senha_clara = $_POST['senha'] ?? '';
$tipoUsuario = $_POST['tipoUsuario'] ?? '';

$mensagem_status = "";
$sucesso = false;

// 1. VERIFICA SE O FORMULÁRIO FOI SUBMETIDO E SE OS CAMPOS CRÍTICOS ESTÃO PREENCHIDOS
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($email) && !empty($senha_clara)) {

    // Cria o hash seguro da senha
    $senha_hash = password_hash($senha_clara, PASSWORD_DEFAULT);

    $tabela_destino = '';
    $campos_sql = '';
    $tipos_param = '';
    $valores = [];

    // --- 2. LÓGICA DE DECISÃO: QUAL TABELA USAR? ---
    if ($tipoUsuario === 'produtor') {
        $tabela_destino = 'agricultores';
        $campos_sql = ' (nome, cpf, email, senha) ';
        $tipos_param = 'ssss';
        $valores = [$nome, $cpf, $email, $senha_hash];
    } elseif ($tipoUsuario === 'comprador') {
        // Adaptado para inserir cliente na tabela 'clientes' (assumindo que tem cpf e senha)
        $tabela_destino = 'clientes';
        $campos_sql = ' (nome, cpf, email, senha) ';
        $tipos_param = 'ssss';
        $valores = [$nome, $cpf, $email, $senha_hash];
    } else {
        $mensagem_status = "Erro: Seleção de tipo de usuário inválida. Por favor, tente novamente.";
        goto exibe_status;
    }


    // --- 3. CONEXÃO E INSERÇÃO SEGURA (Prepared Statements) ---
    $conn = new mysqli("localhost", "root", "", "agrotech_db", 3306);

    if ($conn->connect_error) {
        $mensagem_status = "Erro na conexão com o banco de dados: " . $conn->connect_error;
    } else {
        // Constrói a query com placeholders (?)
        $sql = "INSERT INTO $tabela_destino $campos_sql VALUES (?, ?, ?, ?)";

        // Usa Prepared Statements para evitar SQL Injection
        $stmt = $conn->prepare($sql);
        
        // Atribui os valores
        $stmt->bind_param($tipos_param, ...$valores); 

        if ($stmt->execute()) {
            $mensagem_status = "Cadastro de usuário realizado com sucesso!";
            $sucesso = true;
        } else {
            // Código 1062 para erro de duplicidade (UNIQUE key)
            if ($conn->errno == 1062) {
                $mensagem_status = "Erro: Este e-mail ou CPF já está cadastrado.";
            } else {
                $mensagem_status = "Erro ao cadastrar na tabela $tabela_destino: " . $conn->error;
            }
        }
        $stmt->close();
        $conn->close();
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mensagem_status = "Erro: Por favor, preencha todos os campos obrigatórios.";
} else {
    $mensagem_status = "Acesso inválido. Por favor, use o formulário de cadastro.";
}

exibe_status: 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status do Cadastro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../public/assets/css/cadastro.css"> 
</head>
<body>
    
    <a href="javascript:history.back()" class="back-button">Voltar</a>

    <div class="container status-box">
        
        <h2 class="status-message <?php echo $sucesso ? 'status-success' : 'status-error'; ?>">
            <?php echo $mensagem_status; ?>
        </h2>
        
        <?php if ($sucesso): ?>
            <p>Seu cadastro foi concluído com sucesso. Clique abaixo para fazer login.</p>
            <div class="containex">
                <a href="login.php" class="action-link btn-primary">Ir para o Login</a>
            </div>
        <?php else: ?>
            <p>Houve um erro no seu cadastro. Por favor, verifique os dados e tente novamente.</p>
            <div class="containex">
                <a href="javascript:history.back()" class="action-link btn-primary">Tentar Novamente</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>