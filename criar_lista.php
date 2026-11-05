<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Criar Lista - MyKeep</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- CABEÇALHO -->
    <header class="cabecalho-principal">
        <div class="container-cabecalho">
            <div class="cabecalho-logo">
                <span class="icone-logo"><img src="assets/img/logogdt.jpg" alt="Logo Gestão CG"></span>
                <span>Gestão CG</span>
            </div>
            <div class="acoes-cabecalho">
                <a href="index.php" class="btn-primario">Voltar</a>
            </div>
        </div>
    </header>

    <main class="container-centralizado">

        <div class="cabecalho-formulario">

            <span class="subtitulo">NOVA LISTA</span>

            <h1>O que você quer organizar?</h1>

            <p>
                Crie uma lista e adicione as primeiras tarefas
                para começar sua organização.
            </p>

        </div>

        <form action="salvar_lista.php"
            method="POST"
            class="caixa-formulario">


            <div class="grupo-input">

                <label for="titulo_lista">
                    TÍTULO DA LISTA
                </label>

                <input type="text"
                    id="titulo_lista"
                    name="titulo_lista"
                    placeholder="Ex.: Planejamento da viagem"
                    required>

            </div>

            <div class="grupo-input">

                <div class="titulo-grupo">

                    <label>TAREFAS INICIAIS</label>

                    <span>Opcional</span>

                </div>


                <div class="campos-tarefas">

                    <input type="text"
                        name="tarefas[]"
                        placeholder="Descreva uma tarefa...">

                    <input type="text"
                        name="tarefas[]"
                        placeholder="Descreva outra tarefa...">

                    <input type="text"
                        name="tarefas[]"
                        placeholder="Adicione mais uma tarefa...">

                </div>

            </div>


            <div class="acoes-formulario">

                <a href="index.php" class="btn-secundario">
                    Cancelar
                </a>

                <button type="submit" class="btn-primario">
                    Criar lista
                </button>

            </div>

        </form>

    </main>

    <footer class="rodape-principal">
        <div class="container-rodape">
            <p>&copy; <?= date('Y'); ?> <strong>Gestor GC</strong> - Todos os direitos reservados.</p>
            <p>Desenvolvido para organização e gestão eficiente de tarefas.</p>
        </div>
    </footer>

</body>

</html>