<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nova_tarefa'])) {
    $lista = R::load('lista', (int)$_POST['id_lista']);

    if ($lista->id && $lista->usuario_id == $_SESSION['usuario_id']) {
        $tarefa = R::dispense('tarefa');
        $tarefa->descricao = trim($_POST['nova_tarefa']);
        $tarefa->status = 'pendente';
        $tarefa->lista_id = $lista->id;
        R::store($tarefa);
    }
}
header('Location: index.php');
exit;