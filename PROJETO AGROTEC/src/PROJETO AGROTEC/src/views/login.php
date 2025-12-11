<?php
// Inicia a sessão no topo do script (essencial para o redirecionamento)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$cpf   = $_POST['cpf']   ?? '';
$senha = $_POST['senha'] ?? '';
$mensagem_status = "";
$status_class = "";

// 1. Apenas processa se o formulário foi submetido (POST)
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($cpf) && !empty($senha)) {

    // Limpa o CPF de pontos e hífens, pois o BD armazena sem pontuação
    $cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);
    
    $conn = new mysqli("localhost", "root", "", "agrotech_db", 3306);

    if ($conn->connect_error) {
        $mensagem_status = "Erro na conexão com o banco de dados: " . $conn->connect_error;
        $status_class = "error";
        goto exibe_status;
    }

    $usuario = false;
    $tabela_encontrada = '';
    
    // --- FUNÇÃO PARA TENTAR LOGIN EM UMA TABELA ESPECÍFICA ---
    function tentarLogin($conn, $cpf, $tabela) {
        $stmt = $conn->prepare("SELECT cpf, senha FROM $tabela WHERE cpf = ?");
        // Verifica se a preparação da query foi bem-sucedida
        if ($stmt === false) {
             error_log("Erro na preparação da query para tabela $tabela: " . $conn->error);
             return false;
        }
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            $stmt->close();
            return $usuario;
        }
        $stmt->close();
        return false;
    }

    // --- BUSCA DUPLA: AGRICULTOR OU CLIENTE ---
    
    // 1. Tenta Agricultores (Produtores)
    $usuario = tentarLogin($conn, $cpf_limpo, 'agricultores');
    if ($usuario) {
        $tabela_encontrada = 'agricultores';
    } else {
        // 2. Tenta Clientes (Compradores)
        $usuario = tentarLogin($conn, $cpf_limpo, 'clientes');
        if ($usuario) {
            $tabela_encontrada = 'clientes';
        }
    }

    // --- VERIFICAÇÃO FINAL DE SENHA E REDIRECIONAMENTO ---
    if ($usuario) {
        if (password_verify($senha, $usuario['senha'])) {
            
            // SUCESSO! INICIA SESSÃO E REDIRECIONA
            $_SESSION['logged_in'] = true;
            $_SESSION['cpf'] = $usuario['cpf'];
            $_SESSION['tipo_usuario'] = $tabela_encontrada; 
            
            // REDIRECIONA PARA A PÁGINA PRINCIPAL
            header("Location: index.php"); 
            exit(); 
            
        } else {
            $mensagem_status = "Senha incorreta.";
            $status_class = "error";
        }
    } else {
        $mensagem_status = "Usuário não encontrado. Verifique o CPF e a senha.";
        $status_class = "error";
    }

    $conn->close();
}

exibe_status:
// ... o restante do seu HTML começa aqui
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INCRA - Login</title>
    <link rel="stylesheet" href="../public/assets/css/entrinha.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="logo">
                <img src="../public/assets/img/logo/incra-logo2.png" alt="INCRA">
            </div>
        </div>
        <div class="right">
            
            <form class="login-form" method="POST" action=""> 
                
                <?php if (!empty($mensagem_status)): ?>
                    <p class="status-message <?php echo $status_class; ?>">
                        <?php echo $mensagem_status; ?>
                    </p>
                <?php endif; ?>
                
                <label for="cpf">N° CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF (apenas números ou com pontuação)" required />
                
                <label for="senha">Senha</label>
                <input id="senha" type="password" name="senha" placeholder="Digite sua senha" required />
                
                <div class="containex">
                    <button type="submit" class="btn-primary-submit">
                        ENTRAR
                    </button>
                </div>
                
                <div class="containex">
                    <a href="https://acesso.gov.br/" class="btn-link-action">
                        ENTRAR PELO GOV.BR
                    </a>
                </div>
                
                <a href="redefinir-senha.php" class="link" id="forgotPassword">Esqueceu a senha?</a>
            </form>
        </div>
    </div>
    <script src="../public/assets/js/javinha.js"></script>
</body>
</html>