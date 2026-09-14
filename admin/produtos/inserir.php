<?php

# VERIFICANDO SE EXISTE USUARIO LOGADO PARA PERMITIR ACESSO #
include_once '../usuario_comum.php';


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
                ?>

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="m-0">Novo Produto</h4>
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
                                    <img src="../../assets/img/placeholder-produto.jpg" class="w-100 mt-2" alt="" name="imagem" id="imagem" style="width: 50px; height: 230px; object-fit: cover">
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
                                                echo '<option value="' . $categoria['codigo_categoria'] . '">' . $categoria['nome'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="tamanho"><strong class="text-danger">*</strong>Tamanho:</label>
                                        <input type="text" name="tamanho" id="tamanho" class="form-control" maxlength="3" required>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="cor"><strong class="text-danger">*</strong>Cor:</label>
                                        <select name="cor" id="cor" class="form-control" required>
                                            <option value="">Selecione</option>
                                            <option value="Verde">Verde</option><option value="Azul">Azul</option><option value="Preto">Preto</option><option value="Branco">Branco</option><option value="Vermelho">Vermelho</option><option value="Amarelo">Amarelo</option><option value="Rosa">Rosa</option><option value="Roxo">Roxo</option><option value="Laranja">Laranja</option><option value="Cinza">Cinza</option><option value="Marrom">Marrom</option><option value="Bege">Bege</option><option value="Nude">Nude</option><option value="Dourado">Dourado</option><option value="Prata">Prata</option><option value="Vinho">Vinho</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-6 p-0">

                                    <div class="col-12">
                                        <label for="nome"><strong class="text-danger">*</strong>Nome do Produto:</label>
                                        <input type="text" name="nome" id="nome" class="form-control mt-2" maxlength="60" required>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="descricao">Descrição:</label>
                                        <textarea class="form-control mt-2" name="descricao" id="descricao" style="height: 117px" maxlength="200"></textarea>
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
                                                    accept="image/*">
                                            </div>

                                            <div class="col-6">
                                                <input type="file"
                                                    name="galeria_foto2"
                                                    id="galeria2"
                                                    class="form-control form-control-sm"
                                                    accept="image/*">
                                            </div>

                                            <div class="col-6">
                                                <input type="file"
                                                    name="galeria_foto3"
                                                    id="galeria3"
                                                    class="form-control form-control-sm"
                                                    accept="image/*">
                                            </div>

                                            <div class="col-6">
                                                <input type="file"
                                                    name="galeria_foto4"
                                                    id="galeria4"
                                                    class="form-control form-control-sm"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 ms-4">
                                    <div class="col-12">
                                        <label for="genero">Genero:</label>

                                        <select name="genero" id="genero" class="form-control mt-2" required>
                                            <option value="">Selecione</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Feminino">Feminino</option>
                                            <option value="Unissex">Unissex</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="qtde_produto"><strong class="text-danger">*</strong>Quantidade de Produto:</label>
                                        <input type="text" name="qtde_produto" id="qtde_produto" class="form-control mt-2 " maxlength="4" required>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="marca"><strong class="text-danger ">*</strong>Marca:</label>

                                        <select name="marca" id="marca" class="form-control " required>
                                            <option value="">Selecione</option>
                                            <?php
                                            $sql_marca = "SELECT codigo_marca, nome FROM marca WHERE status = 1";

                                            $query_marca = mysqli_query($conexao, $sql_marca);

                                            foreach ($query_marca as $marca) {
                                                echo '<option value="' . $marca['codigo_marca'] . '">' . $marca['nome'] . '</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-2  d-flex">
                                </div>

                                <div class="col-9 mt-3 admin-product-prices">
                                    <div class="d-flex gap-3 mx-2">
                                        <div class="col-3">
                                            <label for="preco_custo"><strong class="text-danger">*</strong>Preço de Custo(R$):</label>
                                            <input type="text" name="preco_custo" id="preco_custo" class="form-control mt-2" maxlength="7" required oninput="calcular()" data-mask="0000,00" data-mask-reverse="true">
                                        </div>

                                        <div class="col-3">
                                            <label for="lucro"><strong class="text-danger">*</strong>Lucro(%):</label>
                                            <input type="text" name="lucro" id="lucro" class="form-control mt-2" maxlength="7" required oninput="calcular()">
                                        </div>



                                        <div class="col-3 ms-3">
                                            <label for="status_desconto">Status do desconto:</label>

                                            <select name="status_desconto" id="status_desconto" class="form-control mt-2" required onchange="alternarDesconto()">
                                                <option value="0">Desativado</option>
                                                <option value="1">Ativado</option>
                                            </select>

                                        </div>

                                        <div class="col-3">
                                            <label for="desconto"><strong class="text-danger">*</strong>Desconto(%):</label>
                                            <input type="text" name="desconto" id="desconto" class="form-control mt-2" maxlength="7" disabled oninput="calculoDesconto()">
                                        </div>
                                    </div>

                                    <div class="d-flex gap-5">
                                        <div class="col-6 ms-2 mt-4">
                                            <label for="preco_venda"><strong class="text-danger">*</strong>Preço de Venda(R$):</label>
                                            <input type="text" name="preco_venda" id="preco_venda" class="form-control mt-2" maxlength="7" readonly>

                                        </div>

                                        <div class="col-6  mt-4">
                                            <label for="preco_desconto"><strong class="text-danger">*</strong>Preço de Venda com Desconto(R$):</label>
                                            <input type="text" name="preco_desconto" id="preco_desconto" class="form-control mt-2" maxlength="7" readonly>

                                        </div>
                                    </div>


                                </div>
                                <div class="col-12 d-flex justify-content-end admin-product-submit">
                                    <input type="hidden" name="cadastrar" value="cadastrar_produto">
                                    <input type="submit" value="cadastrar" class="btn btn-primary mx-3 ">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
