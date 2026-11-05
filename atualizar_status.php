<?php
require 'conexao.php';

if (R::testConnection()) { 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_tarefa'])) {
        $id = $_POST['id_tarefa'];
        $status = $_POST['status']; 
        
        $tarefa = R::load('tarefa', $id);
        
        if ($tarefa->id != 0) {
            $tarefa->status = $status; 
            R::store($tarefa);
        }
        
        header("Location: index.php");
        exit;
    }
} else {
    echo ('<h2>Não conectado...</h2>');
}
?>