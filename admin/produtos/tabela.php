<?php

#CONEXAO BANCO DE DADO#
require_once __DIR__ . "/../../conexao/conecta.php";

# FILTROS #

$status = $_POST['status'];
$categoria = $_POST['categoria'];
$marca = $_POST['marca'];

# CAMPO DE BUSCA #
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);

?>
<table class="table admin-table">
    <?php
    $sql = "SELECT produto.codigo_produto, produto.nome, produto.qtde_estoque, produto.preco_venda, produto.status, produto.foto, marca.nome 'marca', categoria.nome 'categoria' FROM produto JOIN marca on produto.codigo_marca = marca.codigo_marca JOIN categoria on categoria.codigo_categoria = produto.codigo_categoria WHERE 1=1";

   
    //FILTRO POR STATUS
    if ($status != '') 
        {
        $sql .= " AND produto.status = $status ";
    }

    //FILTRO POR CARGO
    if ($categoria != '')
         {
        $sql .= " AND produto.codigo_categoria = $categoria ";
    }

    //FILTRO POR CARGO
    if ($marca != '')
         {
        $sql .= " AND produto.codigo_marca = $marca ";
    }

    //CAMPO FILTRO POR NOME
    if(!empty($nome) )
        {
            $sql .= " AND produto.nome LIKE '%$nome%' ";
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
                <th>Estoque</th>
                <th>Preco Venda</th>
                <th>Marca</th>
                <th>Categoria</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <!-- Conteudo -->
        <tbody class="table-group-divider align-middle">
            <?php
            foreach ($query as $produto) {
            ?>

                <tr>
                    <td><?php echo $produto['codigo_produto'] ?></td>
                    <td><?php
                        if (empty($produto['foto'])) {
                            echo '<img src="/info_52/pi/assets/img/placeholder-produto.png" alt="" class="rounded-circle" style="width: 50px; aspect-ratio: 1/1; object-fit: cover;">';
                        } else {
                            echo '<img src="/info_52/pi/images/produto/' . htmlspecialchars($produto['foto']) . '" alt="" class="rounded-circle" style="width: 50px; aspect-ratio: 1/1; object-fit: cover;">';
                        }
                        ?>
                    </td>
                    <td><?php echo $produto['nome'] ?></td>

                    <td><?php echo $produto['qtde_estoque'] ?></td>
                    <td><?php echo $produto['preco_venda'] ?></td>
                    <td><?php echo $produto['marca'] ?></td>
                    <td><?php echo $produto['categoria'] ?></td>

                    <td> <?php

                            if ($produto['status'] == 1) {
                                echo '<span class="badge rounded-pill text-bg-success">Ativo</span>';
                            } else {
                                echo '<span class="badge rounded-pill text-bg-danger">Inativo</span>';
                            }

                            ?>
                    </td>

                    <td>
                        <a href="editar.php?codigo_produto=<?php echo $produto['codigo_produto']?>" class="btn btn-outline-success btn-sm" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <!-- <a href="#" class="btn btn-outline-danger btn-sm" title="Excluir">
                            <i class="bi bi-trash"></i>
                        </a> -->

                        <form action="acoes.php" method="post" class="d-inline">
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="deletar_produto" value="<?php echo $produto['codigo_produto'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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
