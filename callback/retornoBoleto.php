<?php

$autoload = realpath(__DIR__ . "/../vendor/autoload.php");
if (!file_exists($autoload)) {
    die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

include('conexao.php');
$pago = 'paid';
$marcpago = 'settled';
$devolvido ='refunded';
$cancelado ='canceled';
$vencido ='expired';


$options = [
    "clientId" => "Client_Id_ee4dcaf07a6aec70de79422a3b7ff7afb9e95c36",
    "clientSecret" => "Client_Secret_8e0dd784a38d42e66f6c08a57229ed4de873df92",
    "sandbox" => true, // Opcional | Padrão = false | Define o ambiente de desenvolvimento entre Produção e Homologação
];

$token = $_POST["notification"];

$params = [
	"token" => $token // Notification token example: "00000000-0000-0000-0000-000000000000"
];

try {
	$api = new EfiPay($options);
	$response = $api->getNotification($params, []);

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

	echo "o status é $statusAtual e o charge id é $charge_id";
    if($statusAtual === $pago){
        $sql = "UPDATE pagamento SET 
        status_cobranca = 'Pago' WHERE id_efi = $charge_id ";
        $sql_atualiza = $conn->query($sql) or die($mysqli->error);
    }if($statusAtual === $marcpago){
        $sql = "UPDATE pagamento SET 
        status_cobranca = 'Marcado como pago' WHERE id_efi = $charge_id ";
        $sql_atualiza = $conn->query($sql) or die($mysqli->error);
    }if($statusAtual === $devolvido){
        $sql = "UPDATE pagamento SET 
        status_cobranca = 'Devolvido' WHERE id_efi = $charge_id ";
        $sql_atualiza = $conn->query($sql) or die($mysqli->error);
    }if($statusAtual === $cancelado){
        $sql = "UPDATE pagamento SET 
        status_cobranca = 'Cancelado' WHERE id_efi = $charge_id ";
        $sql_atualiza = $conn->query($sql) or die($mysqli->error);
    }if($statusAtual === $vencido){
        $sql = "UPDATE pagamento SET 
        status_cobranca = 'Vencido' WHERE id_efi = $charge_id ";
        $sql_atualiza = $conn->query($sql) or die($mysqli->error);
    }
    

} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
	header("HTTP/1.1 400");
} catch (Exception $e) {
	print_r($e->getMessage());
	header("HTTP/1.1 403");
}

?>