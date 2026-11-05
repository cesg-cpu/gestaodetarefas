<?php
require 'conexao.php';

if (R::testConnection()) { 
    if (isset($_POST['id_tarefa'])) {
        $tarefa = R::load('tarefa', $_POST['id_tarefa']);
        if ($tarefa->id != 0) {
            R::trash($tarefa); 
        }
    }

    if (isset($_POST['id_excluir_lista'])) {
        $lista = R::load('lista', $_POST['id_excluir_lista']);
        if ($lista->id != 0) {
            $tarefas = R::find('tarefa', ' lista_id = ? ', [$lista->id]);
            R::trashAll($tarefas);

            R::trash($lista);
        }
    }
    
    header("Location: index.php");
    exit;
} else {
    echo ('<h2>Não conectado...</h2>');
}
?>