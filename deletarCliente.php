<?php

session_start();
  if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>";
  }
  
  
if(isset($_POST['deletar'])){
  include_once('conexao.php');
  $id = addslashes($_GET['id']);
  $sql_code = "DELETE FROM clientes WHERE id = '$id'";
  $sql_query = $conn->query($sql_code) or die($conn-> error);
  print"<script>location.href='financeiro.php';</script>";
  
 }

?>

