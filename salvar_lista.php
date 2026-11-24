<?php
session_start(); // 1. Inicia a sessão para ter acesso aos dados do usuário

// 2. Proteção: Se alguém tentar acessar esse arquivo direto sem estar logado, manda pro login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'conexao.php';

if (R::testConnection()) { 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titulo_lista'])) {
        $titulo = $_POST['titulo_lista'];
        
        $lista = R::dispense('lista'); 
        $lista->titulo = $titulo; 
        
        // 3. A MUDANÇA PRINCIPAL: Vincula a lista ao usuário que está logado no momento
        $lista->usuario_id = $_SESSION['usuario_id']; 
        
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