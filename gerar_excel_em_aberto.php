<?php

session_start();
  if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>";
  }
  //limpar o buffer
  ob_start();

include('conexao.php');

$sql_busca = "SELECT * FROM pagamento WHERE status_cobranca != 'Pago'";
$query_busca = $conn -> query($sql_busca) or die($conn->error);



//função para inserir ponto e virgula na variavel valor
function insertInPosition($str, $pos, $c){
  return substr($str, 0, $pos) . $c . substr($str, $pos);
}

if($query_busca != null){
    
    // aceitar CSV
    header('Content-Type: text/csv; charset=UTF-8');

    //nome do arquivo
    header('Content-Disposition: attachment; filename=relatorio_em_aberto.csv');

    //grava no buffer
    $resultado = fopen("php://output", 'W');

    //criar o cabeçalho- usa função mb_convert_enconding para converter caracters especiais
    $cabeçalho = ['Matricula','Cnpj','Nome Fantasia','ID de pagamento','Status de pagamento','Valor','Data do Vencimento'];

    //escrever o cabeçalho no arquivo
    fputcsv($resultado, $cabeçalho, ';');
    
    //Ler os registros no banco de dados
    while($cliente = $query_busca->fetch_assoc()){
      
      //extrai e aloca em uma variavel com mesmo nome da coluna
      extract($cliente);

      //condição para colocar pontos e virgula na posição correta
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

      $conteudo = [$matricula,$cnpj,$nome_fantasia,$id_efi,$status_cobranca,$valor,$data_venc];
      
      //escrever o conteudo no arquivo
      fputcsv($resultado, $conteudo, ';');
    }

    //fecha o arquivo
    fclose($resultado);
}else{
    echo "nenhum registro encontrado";
}


?>