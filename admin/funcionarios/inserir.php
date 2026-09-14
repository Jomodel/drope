<?php

#CONEXAO BANCO DE DADO#
require_once __DIR__ . "/../../conexao/conecta.php";

# RESTRINGINDO ACESSO APENAS USUARIOS ADMIN #
include_once '../usuario_admin.php';

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
    <link rel="stylesheet" href="../../custom/admin.css?v=6">

    <!-- FAVICON -->
    <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="../../custom/css/style.css">

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
                        <h4 class="m-0">Novo Funcionario</h4>
                        <!-- btn = cria o botao btn-primary= da cor para botao btn-sm= diminui o botao -->
                        <a href="index.php" class="btn btn-dark btn-sm">
                            <i class="bi bi-arrow-left-short"></i>

                            Voltar
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="acoes.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-2 imagem-container" >
                                    <img src="../../assets/img/placeholder-funcionario.png" class="w-100" alt="" name="imagem" id="imagem" style="width: 50px; aspect-ratio: 1/1; object-fit: cover">
                                    <div class="input-group mb-3">
                                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                                    </div>
                                </div>


                                <!-- Seção Dados Pessoais -->
                                <div class="col-5 ">

                                    <div class="col-11">
                                        <label for="nome"><strong class="text-danger">*</strong>Nome:</label>
                                        <input type="text" name="nome" id="nome" class="form-control " maxlength="60" required>
                                    </div>

                                    <div class="d-flex mb-1 gap-5 mt-1">
                                        <div class="col-5">
                                            <label for="nome_social">Nome Social:</label>
                                            <input type="text" name="nome_social" id="nome_social" class="form-control  " maxlength="60">
                                        </div>

                                        <div class="col-5">
                                            <label for="data_nascimento"><strong class="text-danger">*</strong>Data Nascimento:</label>
                                            <input type="date" name="data_nascimento" id="data_nascimento" class="form-control " id="dateInput" required>
                                        </div>
                                    </div>

                                    <div class="d-flex mb-1 gap-5">
                                        <div class="col-5">
                                            <label for="estado_civil">Estado Civil:</label>
                                           
                                                <select name="estado_civil" id="estado_civil" class="form-control " required>
                                                    <option value="Solteiro(a)">Solteiro(a)</option>
                                                    <option value="Casado(a)">Casado(a)</option>
                                                    <option value="Divorciado(a)">Divorciado(a)</option>
                                                    <option value="Viuvo(a)">Viúvo(a)</option>
                                                </select>
                                        </div>

                                        <div class="col-5">
                                            <label for="sexo"><strong class="text-danger">*</strong>Sexo:</label>
                                            
                                                <select name="sexo" id="sexo" class="form-control " required>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Feminino</option>
                                                    <option value="N">Não Informado</option>
                                                </select>
                                        </div>

                                    </div>

                                    <div class="d-flex mb-2 gap-5">
                                        <div class="col-5">
                                            <label for="cpf"><strong class="text-danger">*</strong>CPF:</label>
                                            <input type="text" name="cpf" id="cpf" class="form-control " maxlength="14" required data-mask="000.000.000-00">
                                        </div>

                                        <div class="col-5">
                                            <label for="rg">RG:</label>
                                            <input type="text" name="rg" id="rg" class="form-control " maxlength="12" data-mask="00.000.000-A">
                                        </div>

                                    </div>

                                </div>
                                <!-- Fim Dados Pessoais -->

                                <!-- Seção Endereço -->
                                <div class="col-5 ">
                                    <div class="d-flex gap-1 mb-3">
                                        <div class="col-2">
                                            <label for="cep">CEP:</label>
                                            <input type="text" name="cep" id="cep" class="form-control mb-2" maxlength="9" data-mask="00000-000" onblur="pesquisacep(this.value)">
                                        </div>

                                        <div class="col-6">
                                            <label for="endereco"><strong class="text-danger">*</strong>Endereço:</label>
                                            <input type="text" name="endereco" id="endereco" class="form-control mb-2" maxlength="70" required>
                                        </div>

                                        <div class="col-2">
                                            <label for="numero"><strong class="text-danger">*</strong>Numero:</label>
                                            <input type="text" name="numero" id="numero" class="form-control mb-2" maxlength="4" required>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-1 mb-3">
                                        <div class="col-5">
                                            <label for="bairro"><strong class="text-danger">*</strong>Bairro:</label>
                                            <input type="text" name="bairro" id="bairro" class="form-control mb-2" maxlength="30" required>
                                        </div>

                                        <div class="col-5 ">
                                            <label for="complemento">Complemento:</label>
                                            <input type="text" name="complemento" id="complemento" class="form-control  " maxlength="40"></input>
                                        </div>

                                    </div>

                                    <div class="d-flex gap-1">
                                        <div class="col-5">
                                            <label for="cidade"><strong class="text-danger">*</strong>Cidade:</label>
                                            <input type="text" name="cidade" id="cidade" class="form-control mb-2" maxlength="40" required>
                                        </div>

                                        <div class="col-5 ">
                                            <label for="estado"><strong class="text-danger">*</strong>Estado:</label>
                                            
                                                <select name="estado" id="estado" class="form-control mb-2" required>
                                                    <option value="AC">Acre</option>
                                                    <option value="AL">Alagoas</option>
                                                    <option value="AP">Amapá</option>
                                                    <option value="AM">amazonas</option>
                                                    <option value="BA">Bahia</option>
                                                    <option value="CE">Ceará</option>
                                                    <option value="ES">Espírito Santo</option>
                                                    <option value="GO">Goáis</option>
                                                    <option value="MA">Maranhão</option>
                                                    <option value="MT">Mato Grosso</option>
                                                    <option value="MS">Mato Grosso do Sul</option>
                                                    <option value="MG">Minas Gerais</option>
                                                    <option value="PA">Pará</option>
                                                    <option value="PB">Paraíba</option>
                                                    <option value="PR">Paraná</option>
                                                    <option value="PE">Pernambuco</option>
                                                    <option value="PI">Piauí</option>
                                                    <option value="RJ">Rio de Janeiro</option>
                                                    <option value="RN">Rio Grande do Norte</option>
                                                    <option value="RS">Rio Grande do Sul</option>
                                                    <option value="RO">Rondônia</option>
                                                    <option value="RR">Roraima</option>
                                                    <option value="SC">Santa Catarina</option>
                                                    <option value="SP" selected>São Paulo</option>
                                                    <option value="SE">Sergipe</option>
                                                    <option value="TO">Tocantins</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fim Endereço -->

                                <!-- Seção Contato -->
                                <div class="col-2 mt-3">

                                    <label for="email">Email:</label>
                                    <input type="text" name="email" id="email" class="form-control mb-2" maxlength="50">

                                    <label for="telefone_celular">Telefone Celular:</label>
                                    <input type="text" name=telefone_celular id=telefone_celular class="form-control mb-2" maxlength="14" data-mask="(00)00000-0000">

                                    <label for="telefone_residencial">Telefone Residencial:</label>
                                    <input type="text" name="telefone_residencial" id="telefone_residencial" class="form-control mb-2" maxlength="13" data-mask="(00)0000-0000">


                                </div>
                                <!-- Fim Contato -->

                                <!-- Seção Usuario -->
                                <div class="col-5 ">
                                    <div class="d-flex gap-5 mt-5">
                                        <div class="col-5">
                                            <label for="usuario"><strong class="text-danger">*</strong>Usuario:</label>
                                            <input type="text" name="usuario" id="usuario" class="form-control mb-3" maxlength="15" required>
                                        </div>

                                        <div class="col-5">
                                            <label for="senha"><strong class="text-danger">*</strong>Senha:</label>
                                            <input type="text" name="senha" id="senha" class="form-control mb-2" maxlength="8" required>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-5 mt-2">
                                        <div class="col-5">
                                            <label for="tipo_acesso">Tipo de Acesso:</label>
                                            <select name="tipo_acesso" id="tipo_acesso" class="form-control mb-2">
                                                <option value="0">Comum</option>
                                                <option value="1">Admin</option>
                                            </select>
                                        </div>

                                        <div class="col-5">
                                            <label for="status">Status:</label>
                                            <select name="status" id="status" class="form-control" disabled>
                                                <option value="1">Ativo</option>
                                                <option value="0">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fim Usuario -->

                                <!-- Inicio Cargo -->
                                <div class="col-5">
                                    <div class="col-10 mt-5">
                                        <label for="salario">Salario(R$):</label>
                                        <input type="text" name="salario" id="salario" class="form-control mb-4 " maxlength="10" data-mask="0000,00" data-mask-reverse="true">


                                        <label for="cargo"><strong class="text-danger ">*</strong>Cargo:</label>
                                        
                                            <select name="cargo" id="cargo" class="form-control " required>
                                                <option value="">Selecione</option>
                                                <?php
                                                $sql_cargo = "SELECT codigo_cargo, nome FROM cargo WHERE status = 1";

                                                $query_cargo = mysqli_query($conexao, $sql_cargo);

                                                foreach ($query_cargo as $cargo) {
                                                    echo '<option value="' . $cargo['codigo_cargo'] . '">' . $cargo['nome'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        
                                    </div>


                                    <div class=" d-flex justify-content-md-end ">
                                        <input type="hidden" name="cadastrar" value="cadastrar_funcionario">
                                        <input type="submit" value="cadastrar" class="btn btn-primary mt-3">
                                    </div>

                                </div>
                                <!-- Fim Cargo -->
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

    <!-- Adicionando JQuery -->
    <script src="../../assets/js/cep.js"></script>

    <!-- JS -->
    <script src="../../custom/js/script.js"></script>
</body>

</html>
