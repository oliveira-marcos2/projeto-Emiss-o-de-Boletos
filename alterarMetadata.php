<?php

$autoload = realpath(__DIR__ . "/vendor/autoload.php");
if (!file_exists($autoload)) {
    die("Autoload file not found or on path <code>$autoload</code>.");
}
require_once $autoload;

use Efi\Exception\EfiException;
use Efi\EfiPay;

$options = [
    "clientId" => "Client_Id_ee4dcaf07a6aec70de79422a3b7ff7afb9e95c36",
    "clientSecret" => "Client_Secret_8e0dd784a38d42e66f6c08a57229ed4de873df92",
    "sandbox" => true, // Opcional | Padrão = false | Define o ambiente de desenvolvimento entre Produção e Homologação
];
$params = [
	"id" => 44069581
];

$body = [
	"custom_id" => "Order_0010",
	"notification_url" => "https://www.overise.com.br/callback/retornoBoleto.php"
];

try {
	$api = new EfiPay($options);
	$response = $api->updateChargeMetadata($params, $body);

	print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
} catch (EfiException $e) {
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription) . "<br>";
} catch (Exception $e) {
	print_r($e->getMessage());
}

?>
