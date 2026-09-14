 <?php

    #CONEXAO BANCO DE DADO#
    require_once __DIR__ . "/../../conexao/conecta.php";


    # FILTROS #

    $status = $_POST['status'];
    $cidade = $_POST['cidade'];
    $sexo = $_POST['sexo'];


    # CAMPO DE BUSCA #
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    ?>

 <table class="table admin-table">
     <?php
        $sql = "SELECT codigo_cliente, nome, nome_social, cpf, email, telefone_celular ,data_cadastro, status FROM cliente WHERE 1=1";

        //FILTRO POR STATUS
        if ($status != '') {
            $sql .= " AND cliente.status = $status ";
        }

        //FILTRO POR CIDADE
        if ($cidade != '') {
            $sql .= " AND cliente.cidade = '$cidade' ";
        }

        //FILTRO DE SEXO
        if ($sexo != '') {
            $sql .= " AND cliente.sexo = '$sexo' ";
        }



        //CAMPO FILTRO POR NOME
        if (!empty($nome)) {
            $sql .= " AND cliente.nome LIKE '%$nome%' OR  cliente.nome_social LIKE '%$nome%'  ";
        }



        $query = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($query) > 0) {

        ?>
         <!-- Cabeçalho -->
         <thead>
             <tr>
                 <th>#</th>
                 <th>Nome</th>
                 <th>CPF</th>
                 <th>Email</th>
                 <th>Telefone</th>
                 <th>Data Cadastro</th>
                 <th>Status</th>
                 <th>Ações</th>
             </tr>
         </thead>
         <!-- Conteudo -->
         <tbody class="table-group-divider align-middle">
             <?php
                foreach ($query as $cliente) {
                ?>

                 <tr>
                     <td><?php echo $cliente['codigo_cliente'] ?></td>
                     <td><?php if ($cliente['nome_social'] == '') {
                            echo $cliente['nome'];
                        } 
                        else {
                            echo $cliente['nome_social'];
                        }
                        ?></td>

                     <td><?php echo $cliente['cpf'] ?></td>
                     <td><?php echo $cliente['email'] ?></td>
                     <td><?php echo $cliente['telefone_celular'] ?></td>
                     <td><?php echo date('d/m/Y', strtotime($cliente['data_cadastro'])) ?></td>
                     <td>
                         <?php

                            if ($cliente['status'] == 1) {
                                echo '<span class="badge rounded-pill text-bg-success">Ativo</span>';
                            } else {
                                echo '<span class="badge rounded-pill text-bg-danger">Inativo</span>';
                            }

                            ?>
                     </td>

                     <td>
                         <a href="editar.php?codigo_cliente=<?php echo $cliente['codigo_cliente']?>" class="btn btn-outline-success btn-sm" title="Editar">
                             <i class="bi bi-pencil"></i>
                         </a>

                         <!-- <a href="#" class="btn btn-outline-danger btn-sm" title="Excluir">
                             <i class="bi bi-trash"></i>
                         </a> -->

                         <form action="acoes.php" method="post" class="d-inline">
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" name="deletar_cliente" value="<?php echo $cliente['codigo_cliente'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
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
