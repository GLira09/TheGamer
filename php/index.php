<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de compras</title>
</head>
<body>

<?php
// Estabelece a conexão com o banco de dados
require("conexao.php");

// Consulta SQL para selecionar todos os produtos
$sql = "SELECT * FROM produtos";
$qr = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

// Loop pelos resultados da consulta
while ($ln = mysqli_fetch_assoc($qr)) {
    // Exibe o nome do produto
    echo '<h2>' . $ln['nome'] . '</h2> <br/>';
    // Exibe o preço do produto formatado
    echo 'Preço: R$' . number_format($ln['preco'], 2, ',', '.') . '<br>';
    // Exibe a imagem do produto
    echo '<img src="image/' . $ln['imagem'] . '" /> <br />';
    // Cria um link para adicionar o produto ao carrinho
    echo '<a href="carrinho.php?acao=add&id=' . $ln['id'] . '"> Comprar </a>';
    echo '<br/><hr/>';
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>

</body>
</html>