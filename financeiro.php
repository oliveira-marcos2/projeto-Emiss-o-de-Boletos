<?php
session_start();
  if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>";
  }

  $busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);
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
<div align ="center" style="padding:20px; margin-top:40px;" >
 
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
                        <a class="nav-link active" href="">Financeiro</a>
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
          <!-- INICIO TABELA -->
           
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Lista De Clientes</h4>
                  </div>
                  <section>
                    <form method="get">
                        <div class="row my-4">
                          <div class="col-6" style="margin-left:2%; text-align:left;">
                            <label>Buscar pela matricula:</label>
                            <input type="text" class="form-control" name="busca" placeholder="Matricula:" value="<?=$busca ?>">
                          </div>
                          <div class="col-1 align-itens-end d-flex" style="margin-top:30px;">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                          </div>
                        </div>
                    </form>
                  </section>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Matricula</th>
                            <th>CNPJ</th>
                            <th>Nome da Empresa</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                           
                          </tr>
                        </thead>
                        <tbody>
                           
                            <?php
                            if(isset($busca)){

                              //função para inserir caracter nas posições
                              function insertInPosition($str, $pos, $c){
                                return substr($str, 0, $pos) . $c . substr($str, $pos);
                              }

                              include('conexao.php');
                              $sql_busca = "SELECT * FROM clientes WHERE matricula LIKE '%$busca%'";
                              $query_busca = $conn -> query($sql_busca) or die($conn->error);
                              while($cliente = $query_busca->fetch_assoc()){
                                ?>

                                <tr>
                                  <td><?php echo $cliente['matricula']?></td>
                                  <td><?php echo $cliente['cnpj'] ?></td>
                                  <td>
                                    <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#Boleto<?php echo $cliente['id'] ?>" data-whatever="@mdo"><?php echo $cliente['nome_fantasia'] ?></button>
                                  </td>
                                  <td><?php echo $cliente['fone'] ?></td>
                                  <td><?php echo $cliente['email'] ?></td>
                              
                                  <td>
                                    <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#atualizarCliente<?php echo $cliente['id'] ?>" data-whatever="@mdo"><i class="far fa-edit"></i></button>
                                  </td>
                                  <td>
                                      <button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#excluirCliente<?php echo $cliente['id'] ?>" data-whatever="@mdo"><i class="fas fa-trash-alt"></i></button>
                                  </td>
                                


                                  <!-- Modal Atualizar Cliente -->

                                <div class="modal fade" id="atualizarCliente<?php echo $cliente['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Atualizar Cliente</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="editarCliente.php?id=<?php echo $cliente['id'] ?>" method="post">
                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">Empresa:</label>
                                            <input type="text" class="form-control" name="empresa" value="<?php echo $cliente['nome_fantasia'] ?>" placeholder="Nome Empresa">
                                          </div>
                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">Email:</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $cliente['email'] ?>" placeholder="e-mail">
                                          </div>
                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">Fone:</label>
                                            <input type="text" class="form-control" name="fone" value="<?php echo $cliente['fone'] ?>" placeholder="Telefone">
                                          </div>
                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">CNPJ:</label>
                                            <input type="text" class="form-control" name="cnpj" value="<?php echo $cliente['cnpj'] ?>" placeholder="CNPJ">
                                          </div>

                                      
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                              <input type="hidden" name="id" value="<?php $cliente['id'] ?>">
                                              <button type="submit" value="atualizar" name="atualizar" class="btn btn-primary">Salvar</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>


                                  <!-- Modal Excluir Cliente -->
                                <div class="modal fade" id="excluirCliente<?php echo $cliente['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deletar Cliente</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="deletarCliente.php?id=<?php echo $cliente['id'] ?>" method="post">

                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">Deseja realmente excluir o cliente:<h5> <?php echo $cliente['nome_fantasia'] ?></h5>  </label>
                                          </div>

                                      
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                              <input type="hidden" name="id" value="<?php $cliente['id'] ?>">
                                              <button type="submit" value="deletar" name="deletar" class="btn btn-primary">Excluir</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                
                                <!-- Modal Boletos -->
                                <div class="modal fade" id="Boleto<?php echo $cliente['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Boletos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="" method="post">

                                        <?php
                                          $id = $cliente['id'];
                                          $sql3 = "SELECT * FROM pagamento WHERE id_usuario = $id";
                                          $query_pagamento = $conn -> query($sql3) or die($conn->error);
                                          while($pagamento = $query_pagamento->fetch_assoc()){
                                          
                                          $valor = $pagamento['valor'];
                                          $qtd = strlen($valor);
                                          if($qtd === 3){
                                            $valor = insertInPosition($valor, 1, ',');
                                          }elseif($qtd === 4){
                                            $valor = insertInPosition($valor, 2, ',');
                                          }elseif($qtd === 5){
                                            $valor = insertInPosition($valor, 3, ',');
                                          }else{
                                            $valor = insertInPosition($valor, 1, '.');
                                            $valor = insertInPosition($valor, 5, ',');
                                          };
                                          
                                        ?>
                                          <div class="modal-body" style='text-align:left'>

                                            <label for="recipient-name" class="col-form-label"><h5> Nº Boleto: <?php echo $pagamento['id_efi'] ?></h5></label><br>
                                            <label for="recipient-name" class="col-form-label"> Valor: R$<?php echo $valor ?></label><br>
                                            <label for="recipient-name" class="col-form-label"> Status: <?php echo $pagamento['status_cobranca'] ?></label><br>
                                            <label for="recipient-name" class="col-form-label"> Vencimento: <?php echo $pagamento['data_venc'] ?></label>
                                            <hr size="10">
                                          </div>
                                        <?php

                                          }
                                        ?>

                                      
                                          <div class="modal-footer">
                                            <div class="container">
                                              <div class="row">
                                                <div class="col-sm d-flex">
                                                  <a class="btn btn-secondary "  href="gerarBoleto.php?id=<?php echo $cliente['id'] ?>">Gerar Boleto </a>
                                                </div>
                                                <div class="col-sm-2 d-flex">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            
                          
                            

                            }else{
                                //função para inserir caracter nas posições
                                function insertInPosition($str, $pos, $c){
                                  return substr($str, 0, $pos) . $c . substr($str, $pos);
                                }
                                include('conexao.php');
                                $sql_cliente = "SELECT * FROM clientes ORDER BY data DESC";
                                $query_cliente = $conn -> query($sql_cliente) or die($conn->error);
                                while($cliente = $query_cliente->fetch_assoc()){


                                ?>

                                <tr>
                                  <td><?php echo $cliente['matricula']?></td>
                                  <td><?php echo $cliente['cnpj'] ?></td>
                                  <td>
                                    <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#Boleto<?php echo $cliente['id'] ?>" data-whatever="@mdo"><?php echo $cliente['nome_fantasia'] ?></button>
                                  </td>
                                  <td><?php echo $cliente['fone'] ?></td>
                                  <td><?php echo $cliente['email'] ?></td>
                              
                                  <td>
                                    <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#atualizarCliente<?php echo $cliente['id'] ?>" data-whatever="@mdo"><i class="far fa-edit"></i></button>
                                  </td>
                                  <td>
                                      <button type="button" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#excluirCliente<?php echo $cliente['id'] ?>" data-whatever="@mdo"><i class="fas fa-trash-alt"></i></button>
                                  </td>
                                


                                  <!-- Modal Atualizar Cliente -->

                                <div class="modal fade" id="atualizarCliente<?php echo $cliente['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Atualizar Cliente</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="editarCliente.php?id=<?php echo $cliente['id'] ?>" method="post">
                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">Empresa:</label>
                                            <input type="text" class="form-control" name="empresa" value="<?php echo $cliente['nome_fantasia'] ?>" placeholder="Nome Empresa">
                                          </div>
                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">Email:</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $cliente['email'] ?>" placeholder="e-mail">
                                          </div>
                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">Fone:</label>
                                            <input type="text" class="form-control" name="fone" value="<?php echo $cliente['fone'] ?>" placeholder="Telefone">
                                          </div>
                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">CNPJ:</label>
                                            <input type="text" class="form-control" name="cnpj" value="<?php echo $cliente['cnpj'] ?>" placeholder="CNPJ">
                                          </div>

                                      
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                              <input type="hidden" name="id" value="<?php $cliente['id'] ?>">
                                              <button type="submit" value="atualizar" name="atualizar" class="btn btn-primary">Salvar</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>


                                  <!-- Modal Excluir Cliente -->
                                <div class="modal fade" id="excluirCliente<?php echo $cliente['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deletar Cliente</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="deletarCliente.php?id=<?php echo $cliente['id'] ?>" method="post">

                                          <div style='text-align:left'>
                                            <label for="recipient-name" class="col-form-label">Deseja realmente excluir o cliente:<h5> <?php echo $cliente['nome_fantasia'] ?></h5>  </label>
                                          </div>

                                      
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                              <input type="hidden" name="id" value="<?php $cliente['id'] ?>">
                                              <button type="submit" value="deletar" name="deletar" class="btn btn-primary">Excluir</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                
                                <!-- Modal Boletos -->
                                <div class="modal fade" id="Boleto<?php echo $cliente['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Boletos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="gerarBoleto.php?id=<?php echo $cliente['id'] ?>" method="post">

                                        <?php
                                          $id = $cliente['id'];
                                          $sql3 = "SELECT * FROM pagamento WHERE id_usuario = $id";
                                          $query_pagamento = $conn -> query($sql3) or die($conn->error);
                                          while($pagamento = $query_pagamento->fetch_assoc()){
                                          
                                          $valor = $pagamento['valor'];
                                          $qtd = strlen($valor);
                                          if($qtd === 3){
                                            $valor = insertInPosition($valor, 1, ',');
                                          }elseif($qtd === 4){
                                            $valor = insertInPosition($valor, 2, ',');
                                          }elseif($qtd === 5){
                                            $valor = insertInPosition($valor, 3, ',');
                                          }else{
                                            $valor = insertInPosition($valor, 1, '.');
                                            $valor = insertInPosition($valor, 5, ',');
                                          };
                      
                                          
                                        ?>
                                          <div class="modal-body" style='text-align:left'>

                                            <label for="recipient-name" class="col-form-label"><h5> Nº Boleto: <?php echo $pagamento['id_efi'] ?></h5></label><br>
                                            <label for="recipient-name" class="col-form-label"> Valor: R$<?php echo $valor ?></label><br>
                                            <label for="recipient-name" class="col-form-label"> Status: <?php echo $pagamento['status_cobranca'] ?></label><br>
                                            <label for="recipient-name" class="col-form-label"> Vencimento: <?php echo $pagamento['data_venc'] ?></label>
                                            <hr size="10">
                                          </div>
                                        <?php

                                          }
                                        ?>

                                      
                                          <div class="modal-footer">
                                            <div class="container">
                                              <div class="row">
                                                <div class="col-sm d-flex">
                                                  <a class="btn btn-secondary "  href="gerarBoleto.php?id=<?php echo $cliente['id'] ?>">Gerar Boleto </a>
                                                </div>
                                                <div class="col-sm-2 d-flex">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                    

                                <?php

                                }
                              }
                               
                                
                            ?>

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