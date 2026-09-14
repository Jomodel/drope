<?php

# VERIFICANDO SE EXISTE USUARIO LOGADO PARA PERMITIR ACESSO #
include_once '../usuario_admin.php';


#CONEXAO BANCO DE DADO#
require_once __DIR__ . "/../../conexao/conecta.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PAINEL ADMINISTRATIVO</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- CUSTOMIZAÇÃO DO TEMPLATE -->
    <link rel="stylesheet" href="../../assets/css/dashboard.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.min.css">
    <link rel="stylesheet" href="../../custom/admin.css?v=12">

    <!-- FAVICON -->
    <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">


</head>

<body class="admin-body">

    <?php
    #Início TOPO
    include('../Topo.php');
    #Final TOPO
    ?>

    <div class="container-fluid">
        <div class="row">
            <?php
            #Início MENU
            include('../Navegacao.php');
            #Final MENU
            ?>

            <main class="admin-main ms-auto col-lg-10 px-md-4">
                <?php
                include('../Log.php');
                include('../mensagem.php');

                if (isset($_GET['codigo_produto']) && $_GET['codigo_produto'] != '') {
                    $codigo = $_GET['codigo_produto'];

                    $sql = "SELECT * FROM produto WHERE codigo_produto = $codigo";

                    $query = mysqli_query($conexao, $sql);

                    $produto = mysqli_fetch_assoc($query);
                ?>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="m-0">Editar Produto</h4>
                            <!-- btn = cria o botao btn-primary= da cor para botao btn-sm= diminui o botao -->
                            <a href="index.php" class="btn btn-dark btn-sm">
                                <i class="bi bi-arrow-left-short"></i>

                                Voltar
                            </a>
                        </div>

                        <div class="card-body">
                            <form action="acoes.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-2 imagem-container mx-2 ">
                                        <?php
                                        if (empty($produto['foto'])) {
                                            echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" class="w-100" alt="" name="imagem" id="imagem" style="width: 50px; aspect-ratio: 1/1; object-fit: cover;';
                                        } else {
                                            echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '" class="w-100" alt="" name="imagem" id="imagem" style="width: 50px; aspect-ratio: 1/1; object-fit: cover;">';
                                        }
                                        ?>
                                        <div class="input-group mb-3">
                                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="categoria"><strong class="text-danger">*</strong>Categoria:</label>
                                            <select name="categoria" id="categoria" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <?php
                                                $sql_categoria = "SELECT codigo_categoria, nome FROM categoria WHERE status = 1";
                                                $query_categoria = mysqli_query($conexao, $sql_categoria);
                                                foreach ($query_categoria as $categoria) {
                                                ?>
                                                    <option value="<?php echo $categoria['codigo_categoria'] ?>" <?php if ($produto['codigo_categoria'] == $categoria['codigo_categoria']) echo 'selected' ?>><?php echo $categoria['nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="tamanho"><strong class="text-danger">*</strong>Tamanho:</label>
                                            <input type="text" name="tamanho" id="tamanho" class="form-control" maxlength="3" value="<?php echo $produto['tamanho'] ?>" required>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="cor"><strong class="text-danger">*</strong>Cor:</label>
                                            <select name="cor" id="cor" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option value="Verde" <?php if ($produto['cor'] == 'Verde') echo 'selected'; ?>>Verde</option><option value="Azul" <?php if ($produto['cor'] == 'Azul') echo 'selected'; ?>>Azul</option><option value="Preto" <?php if ($produto['cor'] == 'Preto') echo 'selected'; ?>>Preto</option><option value="Branco" <?php if ($produto['cor'] == 'Branco') echo 'selected'; ?>>Branco</option><option value="Vermelho" <?php if ($produto['cor'] == 'Vermelho') echo 'selected'; ?>>Vermelho</option><option value="Amarelo" <?php if ($produto['cor'] == 'Amarelo') echo 'selected'; ?>>Amarelo</option><option value="Rosa" <?php if ($produto['cor'] == 'Rosa') echo 'selected'; ?>>Rosa</option><option value="Roxo" <?php if ($produto['cor'] == 'Roxo') echo 'selected'; ?>>Roxo</option><option value="Laranja" <?php if ($produto['cor'] == 'Laranja') echo 'selected'; ?>>Laranja</option><option value="Cinza" <?php if ($produto['cor'] == 'Cinza') echo 'selected'; ?>>Cinza</option><option value="Marrom" <?php if ($produto['cor'] == 'Marrom') echo 'selected'; ?>>Marrom</option><option value="Bege" <?php if ($produto['cor'] == 'Bege') echo 'selected'; ?>>Bege</option><option value="Nude" <?php if ($produto['cor'] == 'Nude') echo 'selected'; ?>>Nude</option><option value="Dourado" <?php if ($produto['cor'] == 'Dourado') echo 'selected'; ?>>Dourado</option><option value="Prata" <?php if ($produto['cor'] == 'Prata') echo 'selected'; ?>>Prata</option><option value="Vinho" <?php if ($produto['cor'] == 'Vinho') echo 'selected'; ?>>Vinho</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6 p-0">

                                        <div class="col-12">
                                            <label for="nome"><strong class="text-danger">*</strong>Nome do Produto:</label>
                                            <input type="text" name="nome" id="nome" class="form-control mt-2" maxlength="60" value="<?php echo $produto['nome'] ?>" required>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <label for="descricao">Descrição:</label>
                                            <textarea class="form-control mt-2" name="descricao" id="descricao" style="height: 50px" value="<?php echo $produto['descricao'] ?>" maxlength="200"><?php echo $produto['descricao'] ?></textarea>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <label for="status">Status:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" <?php if ($produto['status'] == '1') echo 'Selected' ?>>Ativo</option>
                                                <option value="0" <?php if ($produto['status'] == '0') echo 'Selected' ?>>Inativo</option>
                                            </select>
                                        </div>

                                        <div class="col-12 imagem-container mx-2 mt-2">

                                        <label for="galeria">
                                            Imagens adicionais:
                                        </label>

                                        <div class="row g-1 mt-1">

                                            <div class="col-6">
                                                
                                                <input type="file"
                                                    name="galeria_foto1"
                                                    id="galeria1"
                                                    class="form-control form-control-sm"
                                                    accept="image/*" value="<?php echo $produto['galeria_foto1'] ?>">
                                            </div>

                                            <div class="col-6">
                                                <input type="file"
                                                    name="galeria_foto2"
                                                    id="galeria2"
                                                    class="form-control form-control-sm"
                                                    accept="image/*" value="<?php echo $produto['galeria_foto2'] ?>">
                                            </div>

                                            <div class="col-6">
                                                <input type="file"
                                                    name="galeria_foto3"
                                                    id="galeria3"
                                                    class="form-control form-control-sm"
                                                    accept="image/*" value="<?php echo $produto['galeria_foto3'] ?>">
                                            </div>

                                            <div class="col-6">
                                                <input type="file"
                                                    name="galeria_foto4"
                                                    id="galeria4"
                                                    class="form-control form-control-sm"
                                                    accept="image/*" value="<?php echo $produto['galeria_foto4'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-3 ms-4">
                                        <div class="col-12">
                                            <label for="genero">Genero:</label>

                                            <select name="genero" id="genero" class="form-control mt-2" required>
                                                <option value="">Selecione</option>
                                                <option value="Masculino" <?php if ($produto['genero'] == 'Masculino') echo 'Selected' ?>>Masculino</option>
                                                <option value="Feminino" <?php if ($produto['genero'] == 'Feminino') echo 'Selected' ?>>Feminino</option>
                                                <option value="Unissex" <?php if ($produto['genero'] == 'Unissex') echo 'Selected' ?>>Unissex</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <label for="qtde_produto"><strong class="text-danger">*</strong>Quantidade de Produto:</label>
                                            <input type="text" name="qtde_produto" id="qtde_produto" class="form-control mt-2" maxlength="4" value="<?php echo $produto['qtde_estoque'] ?>" required>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <label for="marca"><strong class="text-danger ">*</strong>Marca:</label>

                                            <select name="marca" id="marca" class="form-control " required>
                                                <option value="">Selecione</option>
                                                <?php
                                                $sql_marca = "SELECT codigo_marca, nome FROM marca WHERE status = 1";

                                                $query_marca = mysqli_query($conexao, $sql_marca);

                                                foreach ($query_marca as $marca) {

                                                ?>
                                                    <option value="<?php echo $marca['codigo_marca'] ?>" <?php if ($produto['codigo_marca'] == $marca['codigo_marca']) echo 'selected' ?>>
                                                        <?php echo $marca['nome'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-2  d-flex">
                                    </div>

                                    <div class="col-9 mt-3 admin-product-prices admin-product-edit-prices">
                                        <div class="d-flex gap-3 mx-2">
                                            <div class="col-3">
                                                <label for="preco_custo"><strong class="text-danger">*</strong>Preço de Custo(R$):</label>
                                                <input type="text" name="preco_custo" id="preco_custo" class="form-control mt-2" maxlength="7" value="<?php echo $produto['preco_custo'] ?>" required oninput="calcular()" data-mask="0000,00" data-mask-reverse="true">
                                            </div>

                                            <div class="col-3">
                                                <label for="lucro"><strong class="text-danger">*</strong>Lucro(%):</label>
                                                <input type="text" name="lucro" id="lucro" class="form-control mt-2" maxlength="7" value="<?php echo $produto['lucro'] ?>" required oninput="calcular()">
                                            </div>



                                            <div class="col-3 ms-3">
                                                <label for="status_desconto">Status_desc:</label>

                                                <select name="status_desconto" id="status_desconto" class="form-control mt-2" required onchange="alternarDesconto()">
                                                    <option value="0" <?php if ($produto['status_promocao'] == '0') echo 'Selected'  ?>>Desativado</option>
                                                    <option value="1" <?php if ($produto['status_promocao'] == '1') echo 'Selected'  ?>>Ativado </option>
                                                </select>

                                            </div>

                                            <div class="col-3">
                                                <label for="desconto"><strong class="text-danger">*</strong>Desconto(%):</label>
                                                <input type="text" name="desconto" id="desconto" class="form-control mt-2" maxlength="7" value="<?php echo $produto['desconto_promocao'] ?>" <?php if ($produto['status_promocao'] != '1') echo 'disabled' ?> oninput="calculoDesconto()">
                                            </div>
                                        </div>

                                        <div class="d-flex gap-5">
                                            <div class="col-6 ms-2 mt-4">
                                                <label for="preco_venda"><strong class="text-danger">*</strong>Preço de Venda(R$):</label>
                                                <input type="text" name="preco_venda" id="preco_venda" class="form-control mt-2" maxlength="7" value="<?php echo $produto['preco_venda'] ?>" readonly>

                                            </div>

                                            <div class="col-6  mt-4">
                                                <label for="preco_desconto"><strong class="text-danger">*</strong>Preço de Venda com Desconto(R$):</label>
                                                <input type="text" name="preco_desconto" id="preco_desconto" class="form-control mt-2" value="<?php echo $produto['preco_promocao'] ?>" maxlength="7" readonly>

                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-12 d-flex justify-content-end admin-product-submit">
                                        <input type="hidden" name="editar" value="editar_produto">
                                        <input type="hidden" name="codigo_produto" value="<?php echo $codigo ?>">
                                        <input type="submit" value="Atualizar" class="btn btn-primary mx-3 ">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                    Nenhum produto encontrado
                   </div>';
                }
                ?>
            </main>
        </div>
    </div>

    <!-- JQUERY CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <!-- JQUERY MASK -->
    <script src="../../assets/js/jquery.mask.js"></script>

    <!-- JS -->
    <script src="../../custom/js/script.js"></script>

    <!-- Calcular Js -->
    <script src="../../assets/js/calculo.lucros.js"></script>

    <!-- Calcular desconto js -->
    <script src="../../assets/js/calculo.descontos.js"></script>

</body>

</html>
