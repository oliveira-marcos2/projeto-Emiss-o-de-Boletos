// Conta o tamanho do array data (que armazena o resultado)
    $i = count($response["data"]);
    // Pega o último Object de reponse
    $ultimoStatus = $response["data"][$i-1];
    // Acessando o array Status
    $status =  $ultimoStatus["status"];
    // Obtendo o ID da transação    
    $charge_id = $ultimoStatus["identifiers"]["charge_id"];
    // Obtendo a String do status atual
    $statusAtual = $status["current"];

	//var_dump("o status é $statusAtual e o charge id é $charge_id");

	//seleciona id da cobrança no BD
        include_once('conexao.php');
        $sql = "SELECT id_pagamento FROM pagamento WHERE id_efi = '$charge_id";
        $sql_id = $conn->query($sql) or die($mysqli->error);
        var_dump($sql_id);

        //atualiza o charge_id e statusAtual
        /*$sql2 = "UPDATE pagamento SET token_cobranca = '$token', 
        status_cobranca = '$statusAtual' WHERE id_pagamento = $sql_id ";
        $sql_atualiza = $conn->query($sql2) or die($mysqli->error);
        */
        
        
    

	//print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");


-------------------------------------------------

//cria um arquivo .json para salvar os dados
    $nomeArquivo = 'dados.json';
    $dadosGravados = json_decode(file_get_contents($nomeArquivo), true);
    $arquivo = fopen($nomeArquivo, 'w');

    //incrementa as informações enviada com o que ja havia gravado
    array_push($dadosGravados, $response);

    if(fwrite($arquivo, json_encode($dadosGravados))){
        header("HTTP/1.1 200");
        echo "Notificação recebida com sucesso!";
    }else{
        header("HTTP/1.1 300");
        echo "Falha ao salvar os dados da requisição";
    }
	fclose($arquivo);

    Proximo Passo:

    ---------------------------------
    <a href="" class="btn btn-primary">
        ---------------------------------------------------------------------
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
-------------------------------------------------------------------------------------

