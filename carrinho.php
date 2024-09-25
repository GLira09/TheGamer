<?php
// Inicia a sessão
session_start();

// Verifica se a variável de sessão 'carrinho' não está definida e a define como um array vazio
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

// Adiciona produto ao carrinho
if (isset($_GET['acao'])) {
    // ADICIONAR AO CARRINHO
    if ($_GET['acao'] == 'add') {
        $id = intval($_GET['id']);
        // Verifica se o produto já existe no carrinho, se sim, incrementa a quantidade
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id] += 1;
        } else {
            // Se o produto não existe no carrinho, adiciona-o com quantidade 1
            $_SESSION['carrinho'][$id] = 1;
        }
    }
    // REMOVER DO CARRINHO
    elseif ($_GET['acao'] == 'del') {
        $id = intval($_GET['id']);
        // Verifica se o produto está no carrinho e o remove
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
    }
    // ALTERAR QUANTIDADE
    elseif ($_GET['acao'] == 'up') {
        if (is_array($_POST['prod'])) {
            foreach ($_POST['prod'] as $id => $qtd) {
                // Converte o id e a quantidade para inteiros
                $id = intval($id);
                $qtd = intval($qtd);
                // Verifica se a quantidade é válida, se sim, atualiza a quantidade no carrinho, caso contrário, remove o produto do carrinho
                if (!empty($qtd) || $qtd <> 0) {
                    $_SESSION['carrinho'][$id] = $qtd;
                } else {
                    unset($_SESSION['carrinho'][$id]);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de compras</title>
</head>
<body>  
<table>
<thead>
    <tr>
        <th width="244">Produto</th>
        <th width="79">Quantidade</th>
        <th width="89">Pre&ccedil;o</th>
        <th width="100">SubTotal</th>
        <th width="64">Remover</th>
    </tr>
</thead>
<tbody>
<?php
// Verifica se há produtos no carrinho
if (count($_SESSION['carrinho']) == 0) {
    echo '<tr><td colspan="5">Não há produtos no carrinho</td></tr>';
} else {
    require("conexao.php");
    // Inicializa a variável total
    $total = 0;
    foreach ($_SESSION['carrinho'] as $id => $qtd) {
        // Consulta SQL para obter as informações do produto
        $sql = "SELECT * FROM produtos WHERE id = $id";
        $qr = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
        $in = mysqli_fetch_assoc($qr);
        // Calcula o subtotal do produto
        $sub = $in['preco'] * $qtd;
        // Incrementa o total
        $total += $sub;
        // Exibe os detalhes do produto no carrinho
        echo '<tr>
                <td>'.$in['nome'].'</td>
                <td><input type="text" size="3" name="prod['.$id.']" value="'.$qtd.'"></td>
                <td>R$'.number_format($in['preco'], 2, ',', '.').'</td>
                <td>R$'.number_format($sub, 2, ',', '.').'</td>
                <td><a href="?acao=del&id='.$id.'">Remover</a></td>
            </tr>';
    }
    // Exibe o total da compra
    echo '<tr>
            <td colspan="4">Total</td>
            <td>R$'.number_format($total, 2, ',', '.').'</td>
        </tr>';
}
?>
</tbody>
<tfoot>
    <form action='?acao=up' method="post">
        <tr>
            <td colspan="5"><input type="submit" value="Atualizar Carrinho" /></td>
        </tr>
    </form>
    <tr>
        <td colspan="5"><a href="index.php">Continuar Comprando</a></td>
    </tr>
</tfoot>
</table>
</body>
</html>