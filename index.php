<?php

 $pdo = new pdo('mysql:host=localhost;dbname=bootstrap_projeto','root','');

 $sobre = $pdo->prepare("select * from `tb_sobre`");
  $sobre->execute();
  $sobre = $sobre->fetch()['sobre'];


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Painel de controlo</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Painel de controlo</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul id="menu-principal" class="nav navbar-nav">
            <li class="active"><a ref_sys="sobre" href="#" > Editar Sobre</a></li>
            <li><a ref_sys="cadastrar_equipa" href="#about">Cadastrar Equipa</a></li>
            <li><a ref_sys="lista_equipa" href="#contact">Lista Equipa Equipa</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="?sair"><span class="glyphicon glyphicon-off"></span>  Sair</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row flex">
          <div class="col-md-9">
            <h2><span class="glyphicon glyphicon-cog"></span> Painel de controlo</h2>
          </div><!--col-md-6-->
          <div class="col-md-3">
            <p><span class="glyphicon glyphicon-time"></span> Seu último login foi em: 10/05/2021</p>
          </div><!--col-md-6-->
        </div><!--row-->
      </div><!--container-->
    </header>

    <section class="bread">
      <div class="container">
        <div class="breadcrumb">
          <li class="active">Home</li>
        </div><!--breadcrumb-->
      </div><!--container-->
    </section>

    <section class="principal">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a  ref_sys="sobre" href="#" class="list-group-item active cor-padrao">
                <span class="glyphicon glyphicon-home"> Sobre</span>
              </a> 
              <a ref_sys="cadastrar_equipa" href="#"  class="list-group-item  ">
                <span class="glyphicon glyphicon-pencil"> Cadastrar Equipa</span>
              </a>
              <a ref_sys="lista_equipa" href="#"   class="list-group-item  ">
                <span class="glyphicon glyphicon-list"> Lista equipa</span> 
                <span class="badge">4</span>
              </a>
            </div>
          </div>
          <div class="col-md-9">
            <?php
                if(isset($_POST['editar_sobre']))
                {
                  $sobre = $_POST['sobre'];
                  $pdo->exec(" delete from `tb_sobre`");
                  $sql = $pdo->prepare(" insert into `tb_sobre` values (null,?)");
                  $sql->execute(array($sobre));
                  echo '<div class="alert alert-success" role="alert"> O código <b>HTML</b> foi actualizado com sucesso</div>';
                  $sobre = $pdo->prepare("select * from `tb_sobre`");
                  $sobre->execute();
                  $sobre = $sobre->fetch()['sobre'];
                }
            ?>
            <div id="sobre_section" class="panel panel-default">
                <div class="panel-heading cor-padrao">
                  <h3 class="panel-title"> Sobre</h3>
                </div>
                <div class="panel-body">
                  <form method="post" >
                    <div class="form-group">
                      <label>Código Html:</label>
                      <textarea name="sobre" style="height: 160px;resize: none;" class="form-control" placeholder="Código para a página"> <?php echo $sobre; ?> </textarea>
                    </div>
                      <input type="hidden" name="editar_sobre" value="">
                      <button  type="submit" name="acao" class="btn btn-default"> Enviar</button>
                  </form>
                </div><!--panel-body-->
            </div><!--panel-default-->
              <div id="cadastrar_equipa_section" class="panel panel-default">
                <div class="panel-heading cor-padrao">
                  <h3 class="panel-title"> Cadastrar Equipa</h3>
                </div>
                <div class="panel-body">
                <?php 
                
                      if(isset($_POST['acao']))
                      {
                        $nome = $_POST['nome_membro'];
                        $descricao = $_POST['descricao_membro'];
                        $sql = $pdo->prepare('insert into `tb_equipa` values (null,?,?)');
                        $sql->execute(array($nome, $descricao));
                        echo '<div class="alert alert-success" role="alert"> Membro <br> '.$nome.'</br> cadastrado com sucesso!!!</div>';

                      }
                 ?>
                  <form method="post">
                    <div class="form-group">
                      <label>Nome do membro:</label>
                      <input type="text" name="nome_membro" class="form-control" placeholder="Nome do membro">
                    </div>
                      <div class="form-group">
                        <label>Descrição do membro:</label>
                        <textarea  name="descricao_membro" style="height: 160px;resize: none;" class="form-control" placeholder="Descrição"></textarea>
                      </div>
                      <button  type="submit" name="acao" class="btn btn-default"> Enviar</button>
                  </form>
                </div><!--panel-body-->
              </div><!--panel-default-->
              <div id="lista_equipa_section" class="panel panel-default">
                <div class="panel-heading cor-padrao">
                  <h3 class="panel-title"> Equipa</h3>
                </div>
                <div class="panel-body">
                    <div class="panel panel-default">
                      <div class="panel-heading"> Membros da equipa</div>
                      <table class="table">
                        <thead>
                          <tr>
                            <th>ID:</th>
                            <th>Nome do membro</th>
                            <th>Descrição</th>
                            <th>#</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $membro = $pdo->prepare(" select * from `tb_equipa`");
                            $membro->execute();
                            $membro = $membro->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($membro as $key => $value) {
                          ?>
                          <tr>
                            <td> <?php echo $value['id']; ?></td>
                            <td><?php echo $value['nome']; ?></td>
                            <td><?php echo $value['descricao']; ?></td>
                            <td><button id_membro ="<?php echo $value['id']; ?>" type="submit" class="deletar-membro btn btn-danger"><span class="glyphicon glyphicon-trash">
                               Eliminar </span></button></td>
                          </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                </div><!--panel-body-->
              </div><!--panel-default-->
          </div>
          </div><!--col-md-9-->
        </div><!--row-->
      </div><!--container-->
    </section>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    
    <script type="text/javascript">

      $( function(){

        cliqueMenu();
        scrollItem();

        function cliqueMenu()
        {
          
          $('#menu-principal a , .list-group a').click(function(){
            var ref = $(this).attr('ref_sys');
            $('.list-group a').removeClass('active').removeClass('cor-padrao');
            $('#menu-principal a').parent().removeClass('active');
            $('#menu-principal a[ref_sys=' + ref + ']').parent().addClass('active');
            $('.list-group a[ref_sys=' + ref + ']').addClass('active').addClass('cor-padrao');
            return false;
          });
        }

        function scrollItem()
        {
          $('#menu-principal a , .list-group a').click(function(){
            var ref = '#' + $(this).attr('ref_sys') + '_section';
            var offset = $(ref).offset().top - 60;
            $('html,body').animate({'scrollTop':offset});
            if($(window)[0].innerWidth <= 768 )
            {
              $('.icon-bar').click();
            }

          });
        }

        $('button.deletar-membro').click(function(){
            var el = $(this).parent().parent();
            var id_membro = $(this).attr('id_membro');
            $.ajax({
              method:'post',
              data:{'id_mem': id_membro},
              url:'delete.php'
            }).done(function(){
              el.fadeOut(function(){
                el.remove();
              });
            });
        });

      });
    
    </script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>