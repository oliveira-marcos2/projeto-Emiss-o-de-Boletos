<?php

session_start();

if(isset($_POST['enviar'])){
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $erro = null;
    if(empty($usuario)){
        $erro = print"<script>alert('Preencha o Usuario');</script>";
        print "<script>location.href='index.php';</script>";
    }
    if(empty($senha)){
        $erro = print"<script>alert('Preencha a Senha');</script>";
        print "<script>location.href='index.php';</script>";
    }
}

if(empty($_POST) or (empty($_POST["usuario"]) or (empty($_POST["senha"])))){
   print "<script>location.href='index.php';</script>";
}

include('conexao.php');

$usuario = addslashes($_POST["usuario"]);
$senha = addslashes($_POST["senha"]);


$sql = "SELECT * FROM usuarios
        WHERE usuario = '{$usuario}'
        AND senha = '{$senha}'";

$res = $conn->query($sql) or die($conn->error);

$row = $res->fetch_object();

$qtd = $res->num_rows;

if($qtd > 0){
    $_SESSION["usuario"] = $usuario;
    $_SESSION["nome"] = $row->nome;
    $_SESSION["tipo"] = $row->tipo;
    print"<script>location.href='financeiro.php';</script>";
}else{
    print"<script>alert('Usuario e/ou senha incorreto(s)');</script>";
    print"<script>location.href='index.php';</script>"; 
}

?>