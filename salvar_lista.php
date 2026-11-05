<?php
require 'conexao.php';

if (R::testConnection()) { 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titulo_lista'])) {
        $titulo = $_POST['titulo_lista'];
        
        $lista = R::dispense('lista'); 
        $lista->titulo = $titulo; 
        $id_lista = R::store($lista); 

        if (isset($_POST['tarefas'])) {
            foreach ($_POST['tarefas'] as $desc) {
                if (!empty($desc)) {
                    $tarefa = R::dispense('tarefa'); 
                    $tarefa->descricao = $desc;
                    $tarefa->status = 'pendente';
                    $tarefa->lista_id = $id_lista; 
                    
                    R::store($tarefa);
                }
            }
        }
        header("Location: index.php");
        exit;
    }
} else {
    echo ('<h2>Não conectado...</h2>');
}
