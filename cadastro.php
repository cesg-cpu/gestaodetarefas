<?php
session_start();
require 'conexao.php';

// Se já estiver logado, não faz sentido cadastrar
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome  = trim($_POST['nome']);
    $email = strtolower(trim($_POST['email']));
    $senha = $_POST['senha'];
    $senha_confirmacao = $_POST['senha_confirmacao'];

    if (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $senha_confirmacao) {
        $erro = 'As senhas não coincidem.';
    } else {
        // Verifica se o e-mail já existe no banco
        $existe = R::findOne('usuario', ' email = ? ', [$email]);
        
        if ($existe) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            // Cria um novo usuário
            $user = R::dispense('usuario');
            $user->nome = $nome;
            $user->email = $email;
            // password_hash cria uma criptografia forte para a senha
            $user->senha = password_hash($senha, PASSWORD_DEFAULT); 
            
            R::store($user);
            
            // Redireciona para o login com mensagem de sucesso
            header('Location: login.php?sucesso=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão CG - Cadastro</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="tela-login">

    <main class="container-centralizado">
        <div class="cabecalho-formulario" style="text-align: center;">
            <h1>Crie sua conta</h1>
            <p>Cadastre-se para começar a organizar suas tarefas.</p>
        </div>

        <div class="caixa-formulario">
            <?php if ($erro): ?>
                <div class="msg-erro"><?= $erro; ?></div>
            <?php endif; ?>

            <form action="cadastro.php" method="POST">
                <div class="grupo-input">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" placeholder="Ex: João da Silva" required>
                </div>

                <div class="grupo-input">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="seu@email.com" required>
                </div>
                
                <div class="grupo-input">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>
                </div>

                <div class="grupo-input">
                    <label for="senha_confirmacao">Confirme a Senha</label>
                    <input type="password" id="senha_confirmacao" name="senha_confirmacao" placeholder="Repita a senha" required>
                </div>

                <button type="submit" class="btn-primario" style="width: 100%; margin-top: 1rem;">Cadastrar</button>
            </form>

            <a href="login.php" class="link-secundario">Já tem uma conta? Faça login</a>
        </div>
    </main>

</body>
</html>