<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "the_gamer";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter o ID do usuário para carregar o carrinho (exemplo: usuário com id = 1)
$id_usuario = 1; // Isso geralmente viria da sessão do usuário logado

// Consulta SQL para obter produtos no carrinho do usuário
$sql = "SELECT 
            Compras.id_compra,
            Compras.quantidade,
            Compras.tipo_produto,
            Jogos.titulo AS titulo_jogo,
            Jogos.preco AS preco_jogo,
            Consoles.nome AS titulo_console,
            Consoles.preco AS preco_console
        FROM Compras
        LEFT JOIN Jogos ON Compras.tipo_produto = 'jogo' AND Compras.id_produto = Jogos.id_jogo
        LEFT JOIN Consoles ON Compras.tipo_produto = 'console' AND Compras.id_produto = Consoles.id_console
        WHERE Compras.id_usuario = $id_usuario";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - The Gamer</title>
    <style>
        /* Estilos gerais */
        body {
            background-color: #1c2a48;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .navbar, .carrinho-container {
            width: 90%;
            max-width: 600px;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 10px;
            background-color: #111;
        }

        /* Estilos da Navbar */
        .menu {
            display: flex;
            gap: 20px;
        }
        .menu a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
        }

        /* Produto no carrinho */
        .produto {
            display: flex;
            align-items: center;
            background-color: #293b5f;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .produto img {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }
        .produto-info {
            flex-grow: 1;
            text-align: left;
            margin-left: 10px;
        }
        .produto-info h3 {
            font-size: 18px;
            margin: 0;
        }
        .quantidade input {
            width: 50px;
            padding: 5px;
            text-align: center;
            border-radius: 4px;
            border: 1px solid #444;
            background-color: #111;
            color: white;
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="menu">
            <a href="#">Home</a>
            <a href="#">Jogos</a>
            <a href="#">Aparelhos</a>
            <a href="#">GiftCards</a>
        </div>
    </div>

    <!-- Carrinho de Compras -->
    <div class="carrinho-container">
        <h2>Carrinho de Compras</h2>

        <?php
        // Verificar se há produtos no carrinho
        if ($result->num_rows > 0) {
            // Iterar sobre cada item do carrinho
            while($row = $result->fetch_assoc()) {
                $titulo = $row['tipo_produto'] == 'jogo' ? $row['titulo_jogo'] : $row['titulo_console'];
                $preco = $row['tipo_produto'] == 'jogo' ? $row['preco_jogo'] : $row['preco_console'];
                $quantidade = $row['quantidade'];
                $id_compra = $row['id_compra'];
                $imagem = $row['tipo_produto'] == 'jogo' ? 'imagem_jogo.png' : 'imagem_console.png'; // Substitua pelas imagens reais
        ?>

        <div class="produto">
            <img src="<?php echo $imagem; ?>" alt="<?php echo $titulo; ?>">
            <div class="produto-info">
                <h3><?php echo htmlspecialchars($titulo); ?></h3>
                <p>Preço: R$ <?php echo number_format($preco, 2, ',', '.'); ?></p>
            </div>
            <div class="quantidade">
                <form action="atualizar_carrinho.php" method="post">
                    <input type="hidden" name="id_compra" value="<?php echo $id_compra; ?>">
                    <input type="number" name="quantidade" min="1" value="<?php echo $quantidade; ?>">
                    <button type="submit">Atualizar</button>
                </form>
            </div>
        </div>

        <?php
            }
        } else {
            echo "<p>Seu carrinho está vazio.</p>";
        }
        $conn->close();
        ?>
    </div>

</body>
</html>
