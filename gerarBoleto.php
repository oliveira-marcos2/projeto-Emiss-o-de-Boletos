<?php

session_start();
  if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>";
  }

  
  $id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="pt-br" >
<head >
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Gerar Boleto</title>
        <link rel="stylesheet" href="assets/css/app.min.css">
      
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- FIM DO CSS  SHEEP FRAMEWORK PHP - MAYKONSILVEIRA.COM.BR -->

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>


<!-- Main Content -->
<div align="center" style="padding:20px; margin-top:40px;" >
 
        <div class="col-md-10"> 
      <section class="section" >


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
                        <a class="nav-link" href="relatorio.php">Relatorio Financeiro</a>
                      </li>
        
                    </ul>
                  </div>
                </div>
              </div>
            </div>

      
            <!-- fim topo menu -->


           <br>
         <!-- inicio formulario  topo menu -->
          <form action="salvar.php" method="post" enctype="multipart/form-data">


         <div class="section-body" >
          <div class="row" >
            <div class="col-md-12">
              <div class="card">
                  
                    
                <div class="card-header">
                  <h4>Gerar Boletos</h4><br>
                </div>
                  <div class="card-body">
                  <div class="form-group row mb-4">
                    <div class="col-md-12">
                      <select name="forma_pagamento" class="form-control">
                        <option value="avista">A Vista</option>
                        <option value="6x">6X</option>
                        <option value="12x">12X</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row mb-4">
                    <div class="col-md-12">
                      <input type="date" class="form-control" name="data">
                    </div>
                  </div>

                  <div class="form-group row mb-4">
                    <div class="col-md-12">
                     <select name="id" class="form-control"> 
                     <?php
                        include('conexao.php');
                        $sql_cliente = "SELECT * FROM clientes WHERE id= $id ";
                        $query_cliente = $conn -> query($sql_cliente) or die($conn->error);
                        while($cliente = $query_cliente->fetch_assoc()){   
                      ?>
                      <option value="<?php echo $cliente['id']?>"><?php echo $cliente['nome_fantasia']?></option>
                      <?php
                              }
                       ?>
                     </select>
                    </div>
                  </div>

                  <div class="form-group row mb-4">
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="plano" placeholder="Nome dos Planos / Serviços">
                    </div>
                  </div>

                  <div class="form-group row mb-4">
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="valor" name="valor" placeholder="Valor">
                    </div>
                  </div>

                  <div class="form-group row mb-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-primary"  style="width:100%;" name="gerarBoleto" >Gerar</button>
                    </div>
                  </div>

                  <p><a href="">OVERISE</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
            </form>
      <!-- fim formulario  topo menu -->
      </section>
      </div>
        
       
    </div>

  <script src="assets/js/custom.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
  <script src="assets/js/jquery.maskMoney.min.js" type="text/javascript"></script>
  <script>
        $(function(){
            $('#valor').maskMoney({
              prefix:'R$ ',
              allowNegative: true,
              thousands:'.', decimal:',',
              affixesStay: true});
        })
  </script>

</body>
</html>
