<?php
    include('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Curso de PDO</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <div class="container">
    <header class="masthead">
        <h1 class="text-muted">PDO na Prática</h1>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Curso PDO</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Página Inicial</a></li>
                        <li><a href="#">Inserir [C]</a></li>
                        <li><a href="#">Ler [R]</a></li>
                        <li><a href="#">Atualizar [U]</a></li>
                        <li><a href="#">Excluir [D]</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <?php
            if(isset($_POST['enviar'])){
                $nome = $_POST['nome'];
                $email = $_POST['email'];

                $sql = 'INSERT INTO cadastro (nome, email)';
                $sql .= 'VALUES (:nome, :email)';

                try {
                    // Variavel "create" abaixo é um exemplo.
                    // Ou seja, pode ser qualquer nome
                    $create = $db->prepare($sql);
                    $create->bindValue(':nome', $nome, PDO::PARAM_STR);
                    $create->bindValue(':email', $email, PDO::PARAM_STR);
                    if($create->execute()){
                        echo "
                        <p class=\"alert alert-success\">
                            Inserido com sucesso!
                        </p>";
                    } else {
                        echo "
                        <p class=\"alert alert-danger\">
                            Erro ao inserir dados! " . $e->getMessage() . "
                        </p>";

                    }
                } catch(PDOException $e){

                }
            }
            #UPDATE
            if(isset($_POST['atualizar'])){
                $id = (int)$_GET['id'];
                $nome = $_POST['nome'];
                $email = $_POST['email'];

                $sqlUpdate = 'UPDATE cadastro SET nome = :nome, email = :email WHERE id = :id';

                try{
                    // Variavel "update" abaixo é um exemplo.
                    // Ou seja, pode ser qualquer nome
                    $update = $db->prepare($sqlUpdate);
                    $update->bindValue(':id', $id, PDO::PARAM_INT);
                    $update->bindValue(':nome', $nome, PDO::PARAM_STR);
                    $update->bindValue(':email', $email, PDO::PARAM_STR);
                    if($update->execute()){
                        echo "
                        <p class=\"alert alert-success\">
                            Atualizado com sucesso!
                        </p>";
                        }
                    }
                catch (PDOException $e){
                        echo "
                        <p class=\"alert alert-danger\">
                            Erro ao atualizar dados! " . $e->getMessage() . "
                        </p>";
                }
            }

            # DELETE
            if(isset($_GET['action']) && $_GET['action'] == 'delete'){
                $id = (int)$_GET['id'];

                $sqlDelete = 'DELETE FROM cadastro WHERE id = :id';

                try{
                    // Variavel "delete" abaixo é um exemplo.
                    // Ou seja, pode ser qualquer nome
                    $delete = $db->prepare($sqlDelete);
                    $delete->bindValue(':id', $id, PDO::PARAM_INT);
                    //$delete->bindValue(':nome', $nome, PDO::PARAM_STR);
                    //$delete->bindValue(':email', $email, PDO::PARAM_STR);
                    if($delete->execute()){
                        echo "
                        <p class=\"alert alert-success\">
                            Deletado com sucesso!
                        </p>";
                    }
                }
                catch (PDOException $e){
                    echo "
                        <p class=\"alert alert-danger\">
                            Erro ao deletar dados! <br  />
                             Erro: " . $e->getMessage() . "
                        </p>";
                }
            }
        ?>

    </header>

    <article>
        <section class="jumbotron">

            <?php
                if(isset($_GET['action']) && $_GET['action'] == 'update'){
                    $id = (int)$_GET['id'];

                    $sqlSelect = 'SELECT * FROM cadastro WHERE id = :id';

                    try{
                        // Variavel "select" abaixo é um exemplo.
                        // Ou seja, pode ser qualquer nome
                        $select = $db->prepare($sqlSelect);
                        $select->bindValue(':id', $id, PDO::PARAM_INT);
                        $select->execute();
                    } catch (PDOException $e){
                        echo $e->getMessage();
                    }

                    $result = $select->fetch(PDO::FETCH_OBJ);
            ?>

                <ul class="breadcrumb">
                    <li><a href="index.php">Página Inicial</a> <span class="divider"></span> </li>
                    <li>Atualizar</li>
                </ul>
                <form method="post" action="">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="nome" class="form-control" value="<?= $result->nome; ?>"/>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" name="email" class="form-control"  value="<?= $result->email; ?>" />
                    </div>
                    <input type="submit" class="btn-primary btn" value="Atualizar Dados" name="atualizar"/>
                </form>
            <?php } else { ?>
                <form method="post" action="">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="nome" class="form-control" placeholder="Nome: "/>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="E-mail: "/>
                    </div>
                    <input type="submit" class="btn-primary btn" value="Cadastrar Dados" name="enviar"/>
                </form>
            <?php } ?>
        </section>
    <article>

    <article>
        <section class="jumbotron">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome:</th>
                    <th>E-mail:</th>
                    <th>Ações:</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $sqlRead = 'SELECT * FROM cadastro';
                        try{
                            // Variavel "read" abaixo é um exemplo.
                            // Ou seja, pode ser qualquer nome
                            $read = $db->prepare($sqlRead);
                            $read->execute();
                        } catch (PDOException $e){
                            echo $e->getMessage();
                        }
                        while( $rs = $read->fetch(PDO::FETCH_OBJ)){
                        ?>

                    <tr>
                        <td><?=$rs->id;?></td>
                        <td><?=$rs->nome;?></td>
                        <td><?=$rs->email;?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Editar ou Deletar Registro">
                                <a href="index.php?action=update&id=<?= $rs->id; ?>" class="btn btn-default" aria-label="Editar">
                                    <i aria-hidden="true" class="glyphicon-pencil glyphicon"></i>
                                </a>
                                <a href="index.php?action=delete&id=<?= $rs->id; ?>" class="btn btn-danger" aria-label="Apagar" onclick="return confirm('Deseja deletar este registro?')">
                                    <i aria-hidden="true" class="glyphicon-remove glyphicon"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                        <?php } ?>
                </tbody>

                </thead>
            </table>
        </section>
    </article>




    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>