<?php

session_start();
  if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>";
  }

  function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
  }

  if(count($_POST) > 0){

    include('conexao.php');
    $erro = false;
  
    $matricula = $_POST['matricula'];
    $cnpj = limpar_texto($_POST['cnpj']);
    $nome_fantasia = $_POST['nome_fantasia'];
    $razao_social = $_POST['razao_social'];
    $email = $_POST['email'];
    $fone = limpar_texto($_POST['fone']);
    $endereco = $_POST['endereco'];
    
  
    if(empty($matricula)){
      $erro = "Preencha o Numero da Matricula";
    }
    if(empty($cnpj)){
      $erro = "Preencha o CNPJ";
    }
    if ($erro){
      echo "<p><b>$erro</b></p>";
    }else{
      $sql_code = "INSERT INTO clientes (matricula, cnpj, nome_fantasia, razao_social, email, fone, endereco) 
        VALUES('$matricula','$cnpj','$nome_fantasia','$razao_social','$email','$fone','$endereco')";
        
        $deu_certo = $conn->query($sql_code) or die($mysqli->error);
  
        if($deu_certo){
          print"<script>location.href='financeiro.php';</script>";
          unset($_POST);
        }
    }
  }

?>
<!DOCTYPE html>
<html lang="pt-br" >
<head >
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Cadastro Overise</title>
        <link rel="stylesheet" href="assets/css/app.min.css">
      
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
        <!-- Faz a consulta do CNPJ -->
    <script>
        async function buscarCNPJ() {
            const cnpj = document.getElementById('cnpj').value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (cnpj.length !== 14) {
                alert('O CNPJ deve ter 14 dígitos.');
                return;
            }

            try {
                const response = await fetch(`consulta_cnpj.php?cnpj=${cnpj}`);
                const data = await response.json();
                if (data.status === 'success') {
                    document.getElementById('nome_fantasia').value = data.nome_fantasia;
                    document.getElementById('razao_social').value = data.razao_social;
                    document.getElementById('endereco').value = data.endereco;
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        }
    </script>
</head>
<body>


<!-- Main Content -->
<div align="center" style="padding:20px; margin-top:40px;" >
 
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
                        <a class="nav-link active" href="addClientes.php">Cadastrar Clientes</a>
                      </li>
                    
                      <li class="nav-item" style="margin:2px">
                        <a class="nav-link " href="financeiro.php">Financeiro</a>
                      </li>
                      
                      <li class="nav-item" style="margin:2px">
                        <a class="nav-link " href="relatorio.php">Relatorio Financeiro</a>
                      </li>
        
                    </ul>
                  </div>
                </div>
              </div>
            </div>

      
            <!-- fim topo menu -->


           <br>


         <div class="section-body" >
          <div class="row" >
            <div class="col-md-12">
              <div class="card">
                  
                    
                <div class="card-header">
                  <h4>Cadastro</h4><br>
                </div>

                <div class="card-body">


                <!-- inicio formulario  topo menu -->
                <form action="" method="post" enctype="multipart/form-data">

                <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="matricula" placeholder="Matricula:" required>
                   </div>
                   
                 </div>
                 <div class="form-group row mb-4">
                      <div class="col-12">
                        <input type="text" id="cnpj" maxlength="14" class="form-control" name="cnpj" placeholder="CNPJ:" onblur="buscarCNPJ()" required/>
                      </div>
                  </div>
         
                  <div class="form-group row mb-4">
                   
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" placeholder="Nome Fantasia:" required>
                    </div>
                    
                  </div>
                  <div class="form-group row mb-4">
                   
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="razao_social" name="razao_social" placeholder="Razão Social:" required>
                    </div>
                    
                  </div>

                  <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="email" class="form-control" name="email" placeholder="e-mail:">
                   </div>
                   
                 </div>

                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="fone" placeholder="Telefone:">
                   </div>
                   
                 </div>

                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço:">
                   </div>
                   
                 </div>

                  <div class="form-group row mb-4">
                   
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-primary"  style="width:100%;" name="SalvarCadastro" >Salvar</button>
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
      
      </div>
        
       
    </div>

  <script src="assets/js/custom.js"></script>

 
  

</body>
</html>

