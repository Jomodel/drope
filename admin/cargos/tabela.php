<?php

#CONEXAO COM BANCO#
require_once __DIR__ . "/../../conexao/conecta.php";


# FILTROS #
$status = $_POST['status'];

# CAMPO DE BUSCA #
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
?>


<table class="table admin-table">
    <?php

    $sql = "SELECT * FROM cargo WHERE 1=1";



    //FILTRO POR STATUS
    if ($status != '') 
        {
        $sql .= " AND cargo.status = $status ";
    }


    //CAMPO FILTRO POR NOME
    if(!empty($nome) )
        {
            $sql .= " AND cargo.nome LIKE '%$nome%'  ";
        }

    //A funcao mysqli_query() realiza a conexão com o banco de dados e executa o comando sql
    $query = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($query) > 0) {

    ?>
        <!-- Cabeçalho -->
        <thead>
            <tr>
                <th>#</th>
                <th>Cargo</th>
                <th>Observação</th>
                <th>Status</th>
                <th>Data Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <!-- Conteudo -->
        <tbody class="table-group-divider align-middle">

            <?php
            foreach ($query as $cargo) {
            ?>

                <tr>

                    <td><?php echo $cargo['codigo_cargo'] ?></td>

                    <td><?php echo $cargo['nome'] ?></td>
                    <td><?php echo $cargo['observacao'] ?></td>
                    <td>
                        <?php

                        if ($cargo['status'] == 1) {
                            echo '<span class="badge rounded-pill text-bg-success">Ativo</span>';
                        } else {
                            echo '<span class="badge rounded-pill text-bg-danger">Inativo</span>';
                        }

                        ?>
                    </td>
                    <td><?php echo date('d/m/Y', strtotime($cargo['data_cadastro'])) ?></td>
                    <td>
                        <a href="editar.php?codigo_cargo=<?php echo $cargo['codigo_cargo'] ?>" class="btn btn-outline-success btn-sm" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <!-- <a href="#" class="btn btn-outline-danger btn-sm" title="Excluir">
                            <i class="bi bi-trash"></i>
                        </a> -->

                        <form action="acoes.php" method="post" class="d-inline">
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="deletar_cargo" value="<?php echo $cargo['codigo_cargo'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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
