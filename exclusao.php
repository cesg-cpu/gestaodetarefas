<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }
require 'conexao.php';

$uid = $_SESSION['usuario_id'];

if (isset($_POST['id_tarefa'])) {
    $tarefa = R::load('tarefa', (int)$_POST['id_tarefa']);
    if ($tarefa->id) {
        $lista = R::load('lista', $tarefa->lista_id);
        if ($lista->usuario_id == $uid) {
            R::trash($tarefa);
        }
    }
}

if (isset($_POST['id_excluir_lista'])) {
    $lista = R::load('lista', (int)$_POST['id_excluir_lista']);
    if ($lista->id && $lista->usuario_id == $uid) {
        R::trashAll(R::find('tarefa', ' lista_id = ? ', [$lista->id]));
        R::trash($lista);
    }
}

header('Location: index.php');
exit;