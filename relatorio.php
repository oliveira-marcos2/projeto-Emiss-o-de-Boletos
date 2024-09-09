<?php

session_start();
  if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>";
  }
  include('conexao.php');
  $sql_busca = "SELECT * FROM pagamento WHERE forma_pagamento = 'avista'";
  $query_busca = $conn -> query($sql_busca) or die($conn->error);
 
  
/*
  if ($query_busca != null){
    while($cliente = $query_busca->fetch_assoc()){
      var_dump($cliente);
      extract($cliente);
      echo "Matricula: $matricula <br>";
      echo "Cnpj: $cnpj <br>";
      echo "Nome Fantasia: $nome_fantasia <br>";
      echo "ID de pagamento: $id_efi <br>";
      echo "Status de pagamento: $status_cobranca <br>";
      echo "Valor: $valor <br>";
      echo "Data do Vencimento: $data_venc <br><br>";
      
    }
  }
  
  /*
  while($num_rows > 0){
    //$num_rows = count($cliente);
    //var_dump($cliente);
    
    

    // aceitar CSV
    header('Content-Type: text/csv; charset=UTF-8');

    //nome do arquivo
    header('Content-Disposition: attachment; filename=relatorioavista.csv');

    //grava no buffer
    $resultado=fopen("php://output", 'W');

    //criar o cabeçalho- usa função mb_convert_enconding para converter caracters especiais
    $cabeçalho = ['Matricula','Cnpj','Nome Fantasia','ID de pagamento','Status de pagamento','Valor','Data do Vencimento'];

    //escrever o cabeçalho no arquivo
    fputcsv($resultado, $cabeçalho, ';');

    //fecha o arquivo
    fclose($resultado);
    



    var_dump($cliente);
    extract($cliente);
    echo "Matricula: $matricula <br>";
    echo "Cnpj: $cnpj <br>";
    echo "Nome Fantasia: $nome_fantasia <br>";
    echo "ID de pagamento: $id_efi <br>";
    echo "Status de pagamento: $status_cobranca <br>";
    echo "Valor: $valor <br>";
    echo "Data do Vencimento: $data_venc <br><br>";
    
 }
    */

?>

<!DOCTYPE html>
<html lang="pt-br">
<head >
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Gerador de Boletos</title>
        <link rel="stylesheet" href="assets/css/app.min.css">
      
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<!-- Main Content -->
<div align = "center" style="padding:20px; margin-top:40px;" >
 
        <div class="col-md-10"> 


            <!-- inicio topo menu -->
            <?php

            require_once('dashboard.php');
            ?>
            <br>

            <div class="row">
              <div class="col-md-12">
                <div class="card mb-0">
                  <div class="card-body">
                    
                    <ul class="nav nav-pills" >
                      <li class="nav-item" style="margin:2px">
                        <a class="nav-link " href="addClientes.php">Cadastrar Clientes</a>
                      </li>
                    
                      <li class="nav-item" style="margin:2px">
                        <a class="nav-link " href="financeiro.php">Financeiro</a>
                      </li>
                      
                      <li class="nav-item" style="margin:2px">
                        <a class="nav-link active" href="relatorio.php">Relatorio Financeiro</a>
                      </li>
                    </ul>

                  </div>
                </div>
              </div>
            </div>

            
      
            <!-- fim topo menu -->


           <br>
          <!-- INICIO TABELA -->
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Relatorios</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                        <tbody>
                          <tr>
                            <th>Extrato pagamento: A vista</th> <th><a href='gerar_excel.php' class='btn btn-primary'>Imprimir</a></th>
                          </tr>
                          <tr>
                            <th>Extrato pagamento: Em aberto</th> <th><a href='gerar_excel_em_aberto.php' class='btn btn-primary'>Imprimir</a></th>
                          </tr>
                          <tr>
                            <th>Extrato pagamento: Geral</th> <th><a href='gerar_excel_geral.php' class='btn btn-primary'>Imprimir</a></th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          
      <!-- fim tabela-->
      </div>
        
       
    </div>

  <script src="assets/js/custom.js"></script>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>