<?php

#CONEXAO BANCO DE DADO#
require_once __DIR__ . "/../../conexao/conecta.php";


# FILTROS #
$sexo = $_POST['sexo'];
$status = $_POST['status'];
$cargo = $_POST['cargo'];
$cidade = $_POST['cidade'];

# CAMPO DE BUSCA #
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);



?>


<table class="table admin-table">
    <?php
    $sql = "SELECT funcionario.codigo_funcionario, funcionario.nome, funcionario.nome_social, funcionario.cpf, funcionario.email, funcionario.data_cadastro, funcionario.tipo_acesso, funcionario.status, funcionario.foto, cargo.nome 'cargo' FROM funcionario  JOIN cargo on funcionario.codigo_cargo = cargo.codigo_cargo WHERE 1=1";


    //FILTRO DE SEXO
    if ($sexo != '') {
        $sql .= " AND funcionario.sexo = '$sexo' ";
    }

    //FILTRO POR STATUS
    if ($status != '') {
        $sql .= " AND funcionario.status = $status ";
    }

    //FILTRO POR CARGO
    if ($cargo != '') {
        $sql .= " AND funcionario.codigo_Cargo = $cargo ";
    }

    //FILTRO POR CIDADE
    if ($cidade != '') {
        $sql .= " AND funcionario.cidade = '$cidade' ";
    }

    //CAMPO FILTRO POR NOME
    if (!empty($nome)) {
        $sql .= " AND funcionario.nome LIKE '%$nome%' OR  funcionario.nome_social LIKE '%$nome%'  ";
    }


    $query = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($query) > 0) {


    ?>
        <!-- Cabeçalho -->
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Data Cadastro</th>
                <th>Tipo Acesso</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <!-- Conteudo -->
        <tbody class="table-group-divider align-middle">
            <?php
            foreach ($query as $funcionario) {
              
            ?>

                <tr>
                    <td><?php echo $funcionario['codigo_funcionario'] ?></td>
                    <td><?php
                        if (empty($funcionario['foto'])) {
                            echo '<img src="/info_52/pi/assets/img/placeholder-funcionario.png" alt="" class="rounded-circle" style="width: 50px; aspect-ratio: 1/1; object-fit: cover;">';
                        } else {
                            echo '<img src="/info_52/pi/images/funcionario/' . htmlspecialchars($funcionario['foto']) . '" alt="" class="rounded-circle" style="width: 50px; aspect-ratio: 1/1; object-fit: cover;">';
                        }
                        ?>
                    </td>
                    <td><?php if ($funcionario['nome_social'] == '') {
                            echo $funcionario['nome'];
                        } else {
                            echo $funcionario['nome_social'];
                        }
                        ?></td>

                    <td><?php echo $funcionario['cargo'] ?></td>
                    <td><?php echo $funcionario['cpf'] ?></td>
                    <td><?php echo $funcionario['email'] ?></td>
                    <td><?php echo date('d/m/Y', strtotime($funcionario['data_cadastro'])) ?></td>
                    <td>
                        <?php

                        if ($funcionario['tipo_acesso'] == 1) {
                            echo '<span class="badge rounded-pill text-bg-warning">Admin</span>';
                        } else {
                            echo '<span class="badge rounded-pill text-bg-primary">Comum</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php

                        if ($funcionario['status'] == 1) {
                            echo '<span class="badge rounded-pill text-bg-success">Ativo</span>';
                        } else {
                            echo '<span class="badge rounded-pill text-bg-danger">Inativo</span>';
                        }

                        ?>
                    </td>
                    <td>
                        <a href="editar.php?codigo_funcionario=<?php echo $funcionario['codigo_funcionario']?>" class="btn btn-outline-success btn-sm" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <!-- <a href="#" class="btn btn-outline-danger btn-sm" title="Excluir">
                            <i class="bi bi-trash"></i>
                        </a> -->

                        <form action="acoes.php" method="post" class="d-inline">
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="deletar_funcionario" value="<?php echo $funcionario['codigo_funcionario'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    <?php
    } else {
        echo '<div class="alert alert-danger" role="alert">
                    Nenhum registro encontrado
                   </div>';
    }
    ?>

</table>
