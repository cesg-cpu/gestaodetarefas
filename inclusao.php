<?php
require 'conexao.php';

if (R::testConnection()) { 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nova_tarefa'])) {
        $descricao = $_POST['nova_tarefa'];
        $id_lista = $_POST['id_lista'];
        
        $tarefa = R::dispense('tarefa');
        $tarefa->descricao = $descricao; 
        $tarefa->status = 'pendente';
        $tarefa->lista_id = $id_lista;
        
        R::store($tarefa); 
        
        header("Location: index.php");
        exit;
    }
} else {
    echo ('<h2>Não conectado...</h2>');
}