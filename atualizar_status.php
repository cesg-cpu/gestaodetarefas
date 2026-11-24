<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_tarefa'])) {
    $tarefa = R::load('tarefa', (int)$_POST['id_tarefa']);
    $lista  = $tarefa->id ? R::load('lista', $tarefa->lista_id) : null;

    // Só altera se a tarefa pertence a uma lista do usuário logado
    if ($lista && $lista->usuario_id == $_SESSION['usuario_id']) {
        // Checkbox desmarcado não envia nada, então o padrão é "pendente"
        $tarefa->status = (($_POST['status'] ?? '') === 'concluido') ? 'concluido' : 'pendente';
        R::store($tarefa);
    }
}
header('Location: index.php');
exit;