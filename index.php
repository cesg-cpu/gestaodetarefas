<?php
require 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor GC - Minhas Listas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Cabecalho -->
    <header class="cabecalho-principal">
    <div class="container-cabecalho">
        <div class="cabecalho-logo">
            <span class="icone-logo"><img src="assets/img/logogdt.jpg" alt="Logo Gestor GC"></span>
            <span>Gestor GC</span>
        </div>
        <div class="acoes-cabecalho">
            <a href="criar_lista.php" class="btn-primario">+ Criar nova lista</a>
        </div>
    </div>
</header>

    <main class="container">

        <section class="cabecalho-secao">
            <div class="informacoes-secao">
                <span class="subtitulo">VISÃO GERAL</span>
                <h1>Minhas listas</h1>
                <p>Organize suas tarefas e acompanhe seu progresso.</p>
            </div>

            <div class="pilulas-info">
                <div class="pilula pilula-resumo">
                    <?php
                    if (R::testConnection()) {
                        $totalListas = R::count('lista');
                        $totalPendentes = R::count('tarefa', ' status = ? ', ['pendente']);

                        echo "<span>{$totalListas} listas</span>";
                        echo "<span>·</span>";
                        echo "<span>{$totalPendentes} tarefas pendentes</span>";
                    }
                    ?>
                </div>      
            </div>
        </section>

        <!-- Filtros -->
        <?php $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos'; ?>
        <section class="barra-filtro">
            <div class="filtro-texto">
                <strong>Filtrar tarefas</strong>
                <span>Escolha quais itens deseja visualizar.</span>
            </div>
            <div class="filtro-opcoes">
                <a href="index.php?filtro=todos" class="btn-filtro <?= ($filtro == 'todos') ? 'ativo' : '' ?>">
                    <span>Todos</span>
                </a>
                <a href="index.php?filtro=pendentes" class="btn-filtro <?= ($filtro == 'pendentes') ? 'ativo' : '' ?>">
                    <span>Pendentes</span>
                </a>
                <a href="index.php?filtro=concluidos" class="btn-filtro <?= ($filtro == 'concluidos') ? 'ativo' : '' ?>">
                    <span>Concluídos</span>
                </a>
            </div>
        </section>

        <section class="secao-listas">
            <div class="titulo-listas">
                <h2>Suas listas</h2>
                <span>Gerencie suas atividades</span>
            </div>

            <!-- Grid -->
            <div class="grid-cartoes">

                <?php
                if (R::testConnection()) {
                    $listas = R::findAll('lista');

                    foreach ($listas as $lista) {
                        $tarefas = R::find('tarefa', ' lista_id = ? ', [$lista->id]);
                        $qtdTarefas = count($tarefas);
                ?>

                        <article class="cartao">

                            <div class="cartao-cabecalho">
                                <div class="informacoes-cartao">
                                    <h3><?= htmlspecialchars($lista->titulo); ?></h3>
                                    <span><?= $qtdTarefas; ?> tarefas</span>
                                </div>

                                <form action="exclusao.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="id_excluir_lista" value="<?= $lista->id; ?>">
                                    <button type="submit" class="btn-icone" aria-label="Excluir lista" onclick="return confirm('Tem certeza que deseja excluir a lista e todas as tarefas?')">
                                        🗑️
                                    </button>
                                </form>
                            </div>

                            <!-- Pendentes-->
                            <?php if ($filtro == 'todos' || $filtro == 'pendentes') { ?>
                                <div class="secao-tarefas">
                                    <div class="titulo-tarefas">
                                        <span class="etiqueta">PENDENTES</span>
                                    </div>
                                    <div class="lista-tarefas">
                                        <?php
                                        foreach ($tarefas as $t) {
                                            if ($t->status == 'pendente') {
                                        ?>
                                                <form action="atualizar_status.php" method="POST" class="item-tarefa">
                                                    <input type="hidden" name="id_tarefa" value="<?= $t->id; ?>">
                                                    <input type="checkbox" name="status" value="concluido" onchange="this.form.submit()">
                                                    <span><?= htmlspecialchars($t->descricao); ?></span>
                                                    <button type="submit" formaction="exclusao.php" class="btn-icone" aria-label="Excluir tarefa">🗑️</button>
                                                </form>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php }
                            ?>

                            <!-- Concluídas-->
                            <?php if ($filtro == 'todos' || $filtro == 'concluidos') { ?>
                                <div class="secao-tarefas">
                                    <div class="titulo-tarefas">
                                        <span class="etiqueta">CONCLUÍDAS</span>
                                    </div>
                                    <div class="lista-tarefas">
                                        <?php
                                        foreach ($tarefas as $t) {
                                            if ($t->status == 'concluido') {
                                        ?>
                                                <form action="atualizar_status.php" method="POST" class="item-tarefa concluida">
                                                    <input type="hidden" name="id_tarefa" value="<?= $t->id; ?>">
                                                    <input type="checkbox" name="status" value="pendente" checked onchange="this.form.submit()">
                                                    <span><?= htmlspecialchars($t->descricao); ?></span>
                                                    <button type="submit" formaction="exclusao.php" class="btn-icone" aria-label="Excluir tarefa">🗑️</button>
                                                </form>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php }
                            ?>
                            <div class="area-adicionar-tarefa">
                                <form action="inclusao.php" method="POST" class="form-add-tarefa">
                                    <input type="hidden" name="id_lista" value="<?= $lista->id; ?>">
                                    <input type="text" name="nova_tarefa" placeholder="Adicionar uma tarefa..." required>
                                    <button type="submit" class="btn-add">+</button>
                                </form>
                            </div>

                        </article>

                <?php
                    }
                } else {
                    echo '<h2>Não conectado ao banco de dados...</h2>';
                }

                ?>

            </div>
        </section>

    </main>

    <footer class="rodape-principal">
        <div class="container-rodape">
            <p>&copy; <?= date('Y'); ?> <strong>Gestor GC</strong> - Todos os direitos reservados.</p>
            <p>Desenvolvido para organização e gestão eficiente de tarefas.</p>
        </div>
    </footer>

</body>

</html>