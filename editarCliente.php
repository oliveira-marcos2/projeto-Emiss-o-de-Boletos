<?php

session_start();
  if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>";
  }


  include_once('conexao.php');
  $id = $_GET['id'];
  $sql_select = "SELECT * FROM clientes WHERE id=$id";
  $query_cliente = $conn->query($sql_select) or die($conn->error);;
  $cliente = $query_cliente->fetch_assoc();

  function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
  }


  if(count($_POST) > 0){

    $erro = false;
    $empresa = addslashes($_POST['empresa']);
    $email = addslashes($_POST['email']);
    $fone = limpar_texto($_POST['fone']);
    $cnpj = limpar_texto($_POST['cnpj']);

    if(empty($empresa)){
      $erro = print"<script>alert('Preencha o Nome da Empresa');</script>";
      print "<script>location.href='financeiro.php';</script>";
    }
    if(empty($cnpj)){
      $erro = print"<script>alert('Preencha o CNPJ');</script>";
      print "<script>location.href='financeiro.php';</script>";
    }
    if ($erro){
      echo "<p><b>$erro</b></p>";
    }else{
      $sql_code = "UPDATE clientes 
      SET nome_fantasia = '$empresa', 
      email = '$email', 
      fone = '$fone', 
      cnpj = '$cnpj'
      WHERE id = '$id'";
        
        $deu_certo = $conn->query($sql_code) or die($mysqli->error);
  
        if($deu_certo){
          unset($_POST);
          print"<script>location.href='financeiro.php';</script>";
        }
    }
  }

?>
