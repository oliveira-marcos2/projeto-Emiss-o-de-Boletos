<?php
header('Content-Type: application/json');

// Obtendo o CNPJ da solicitação
$cnpj = filter_input(INPUT_GET, 'cnpj', FILTER_SANITIZE_STRING);

if (strlen($cnpj) !== 14) {
    echo json_encode(['status' => 'error', 'message' => 'CNPJ inválido.']);
    exit;
}

// URL da API da Receita Federal
$url = "https://www.receitaws.com.br/v1/cnpj/$cnpj";

// Executa a solicitação GET
$response = file_get_contents($url);

if ($response === FALSE) {
    echo json_encode(['status' => 'error', 'message' => 'Não foi possível consultar o CNPJ.']);
    exit;
}

// Decodifica a resposta JSON da API
$data = json_decode($response, true);

if (isset($data['status']) && $data['status'] === 'ERROR') {
    echo json_encode(['status' => 'error', 'message' => 'CNPJ não encontrado.']);
    exit;
}

// Prepara os dados para retorno
$result = [
    'status' => 'success',
    'nome_fantasia' => $data['fantasia'] ?? 'N/A',
    'razao_social' => $data['nome'] ?? 'N/A',
    'endereco' => $data['logradouro'] . ', ' . $data['numero'] . ' - ' . $data['bairro'] . ', ' . $data['municipio'] . ' - ' . $data['uf'] . ' - ' . $data['cep']
];

echo json_encode($result);
