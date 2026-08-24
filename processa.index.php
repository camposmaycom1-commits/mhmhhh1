<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['cpf'])) {
    // 1. Limpeza do CPF (Mantém apenas números)
    $cpf_limpo = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    
    // 2. Configuração da Requisição para sua API
    $url = "http://185.101.104.231:3001/search?cpf=" . $cpf_limpo;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // 3. Processamento do Retorno (Formato: CPF|NOME|GENERO|NASCIMENTO)
    if ($httpCode == 200 && !empty($response)) {
        $dados = explode('|', $response);

        if (count($dados) >= 4) {
            // Armazena na sessão para usar nas páginas index2 e index3
            $_SESSION['usuario_cpf']        = trim($dados[0]);
            $_SESSION['usuario_nome']       = trim($dados[1]);
            $_SESSION['usuario_genero']     = trim($dados[2]);
            $_SESSION['usuario_nascimento'] = trim($dados[3]);

            header("Location: index2.php");
            exit();
        } else {
            die("Erro: Formato de resposta da API desconhecido.");
        }
    } else {
        die("Erro: Não foi possível obter dados da API (Código: $httpCode).");
    }
} else {
    // Se tentar acessar o arquivo diretamente sem enviar o formulário
    header("Location: index.html");
    exit();
}
?>