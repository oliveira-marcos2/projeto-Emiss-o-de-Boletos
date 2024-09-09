<?php
session_start();
if(empty($_SESSION)){
  print "<script>location.href='index.php';</script>";
}

$autoload = realpath(__DIR__ . "/vendor/autoload.php");
if (!file_exists($autoload)) {
	die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

$gerar = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(isset($gerar['gerarBoleto'])){
    unset($gerar['gerarBoleto']);
    
	$id = $gerar['id'];
    include('conexao.php');
        $sql_cliente = "SELECT * FROM clientes WHERE id = $id";
        $query_cliente = $conn -> query($sql_cliente) or die($conn->error);
        $cliente = $query_cliente->fetch_assoc();
	$matricula = $cliente['matricula'];
	$nome_fantasia = $cliente['nome_fantasia'];
	$forma_pagamento = $gerar['forma_pagamento'];
    $vencimento = date('d/m/Y', strtotime($gerar['data']));
    $cnpj = preg_replace('/\W+/u','', $cliente['cnpj']);
	$valor = intval(preg_replace("/[^0-9]/", "", $gerar['valor']));

	//echo $cnpjBD;
	
    //echo "Nome: {$cliente->nome} data: {$vencimento} plano: {$gerar['plano']} Valor: {$gerar['valor']}";
	
	// codigo para dividir os boletos
	if($forma_pagamento == "avista"){
		$qtde_meses = 1;
	}if($forma_pagamento == "6x"){
		$qtde_meses = 6;
	}if($forma_pagamento == "12x"){
		$qtde_meses = 12;
	}

		//divide o valor total pela quantidade de pagamentos
		$valor = $valor / $qtde_meses;

		//arredonda o valor
		$valor = round($valor, 0);

		//tira os caracteres que separam centena de dezena
		$valor = preg_replace("/[^0-9]/", "", $valor);
		
		
		// aloca em uma variavel ano e mês 
		$cur_date = date('Y-m');
		
		// aloca em uma variavel o dia do vencimento
		$dia_lancado = date('d', strtotime($gerar['data'])); 
		
		$date = new DateTime($cur_date);

		// Define o último dia do mês atual
		$date->modify('last day of this month');

		for ($i = 0; $i < $qtde_meses; $i++) {
			// Pega o ultimo dia do mês atual
			$dia = $date->format('d');
		 
			// Limita os dias ao 30 (conforme a variável)
			if ($dia > $dia_lancado) $dia = $dia_lancado;
		 
			$my_dates = $date->format('Y-m') . '-' . $dia;
			
			// Vai para o último dia do próximo mês
			$date->modify('last day of +1 month');
			
			//inicia a sequencia de boletos

			$options = [
				"clientId" => "Client_Id_ee4dcaf07a6aec70de79422a3b7ff7afb9e95c36",
				"clientSecret" => "Client_Secret_8e0dd784a38d42e66f6c08a57229ed4de873df92",
				//"certificate" => realpath(__DIR__ . "/arquivoCertificado.p12"), // Caminho absoluto para o certificado no formato .p12 ou .pem
				//"pwdCertificate" => "", // Opcional | Padrão = "" | Senha de criptografia do certificado
				"sandbox" => true, // Opcional | Padrão = false | Define o ambiente de desenvolvimento entre Produção e Homologação
				"debug" => false, // Opcional | Padrão = false | Ativa/desativa os logs de requisições do Guzzle
				"timeout" => 30, // Opcional | Padrão = 30 | Define o tempo máximo de resposta das requisições
			];
		
		$items = [
			[
				"name" => $gerar['plano'],
				"amount" => 1,
				"value" => intval($valor)
			],
			
		];
		
		$metadata = [
			//"custom_id" => "Order_00007",
			"notification_url" => "https://www.overise.com.br/callback/retornoBoleto.php"
		];
		
		$customer = [
			//"name" => $cliente['empresa'],
			//"cpf" => $cpf,
			"email" => $cliente['email'],
			// "phone_number" => "",
			// "birth" => "",
			"juridical_person" => [
			 "corporate_name" => $cliente['nome_fantasia'],
			"cnpj" => $cnpj],
			// "address" => [
			// 	"street" => "",
			// 	"number" => "",
			// 	"neighborhood" => "",
			// 	"zipcode" => "",
			// 	"city" => "",
			// 	"complement" => "",
			// 	"state" => ""
			// ],
		];
		
		
		
		/*$conditional_discount = [
			"type" => "percentage", // "currency", "percentage"
			"value" => 500,
			"until_date" => "2024-12-20"
		];*/
		
		
		$bankingBillet = [
			"expire_at" => $my_dates,
			"message" => "Boleto Gerado com sucesso!",
			"customer" => $customer,
		];
		
		$payment = [
			"banking_billet" => $bankingBillet
		];
		
		$body = [
			"items" => $items,
			"payment" => $payment,
			"metadata" => $metadata
		];
		
		try {
			$api = new EfiPay($options);
			$response = $api->createOneStepCharge($params = [], $body);
			header("Location: ".$response['data']['link']);
			//print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
			$codigo = json_encode($response['data']);
			$codigo2 = json_decode($codigo);
			$id_efi = $codigo2->charge_id;
			$cliente_id = $cliente['id'];

			
			//altera o formato da data para inserir no BD
			$my_dates = DateTime::createFromFormat('Y-m-d', $my_dates);
			$vencimento = $my_dates->format('d/m/Y');

			// insere Id boleto na tabela de pagamentos
			$sqlCobranca = "INSERT INTO pagamento (matricula,cnpj,nome_fantasia,id_usuario,id_efi,forma_pagamento,valor,data_venc) VALUES( '$matricula','$cnpj','$nome_fantasia','$cliente_id','$id_efi','$forma_pagamento','$valor','$vencimento')";
			$inserirCobranca = $conn->query($sqlCobranca) or die($mysqli->error);
			
		
		} catch (EfiException $e) {
			print_r($e->code . "<br>");
			print_r($e->error . "<br>");
			print_r($e->errorDescription) . "<br>";
		} catch (Exception $e) {
			print_r($e->getMessage());
		}
			
		}
		 

}

?>