<?php
session_start();
if (isset($_SESSION['usuario_id'])) { header('Location: index.php'); exit; }
require 'conexao.php'; // Sua conexão com o banco (RedBeanPHP)

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca o usuário no banco pelo e-mail
    $usuario = R::findOne('usuario', ' email = ? ', [$email]);

    // Verifica se achou o usuário e se a senha está correta
    if ($usuario && password_verify($senha, $usuario->senha)) {
        session_regenerate_id(true); 
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nome'] = $usuario->nome;
        header('Location: index.php');
        exit;
    } else {
        $erro = 'E-mail ou senha incorretos.';
    }

}
?>
<!DOCTYPE html> 
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão CG - Login</title>
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body class="tela-login">

    <main class="container-centralizado">
        <div class="cabecalho-formulario" style="text-align: center;">
            <div class="cabecalho-logo" style="justify-content: center; margin-bottom: 1rem;">
                <span class="icone-logo"><img src="assets/img/logogdt.jpg" alt="Logo Gestão CG"></span>
                <span>Gestão CG</span>
            </div>
            <h1>Bem-vindo de volta!</h1>
            <p>Faça login para acessar suas listas.</p>
        </div>

        <div class="caixa-formulario">
            <?php if ($erro): ?>
                <div class="msg-erro"><?= $erro; ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET['sucesso'])): ?>
                <div class="msg-sucesso">Cadastro realizado com sucesso! Faça login.</div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="grupo-input">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                
                <div class="grupo-input">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>

           <button type="submit" class="btn-primario" style="width: 100%; margin-top: 1rem;">Entrar</button>
    </form> <!-- FECHA O FORMULÁRIO AQUI -->

    <!-- O LINK FICA LOGO ABAIXO -->
    <a href="cadastro.php" class="link-secundario">Não tem cadastro? Cadastre-se</a>
</div> <!-- Fecha a caixa-formulario -->
    </main>

</body>
</html>