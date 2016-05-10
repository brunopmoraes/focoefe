<?php
    require_once("../../classes/banners.class.php");

    $banners = new banners();
    $banners->selecionaTudo($banners);

    if ($_POST['cadastrar']){
        $acao = 'cadastrar';
        // Recupera os dados dos campos
        $descricao = $_POST['descricao'];
        $imagem = $_FILES['imagem'];
        $dtInicio = $_POST['dtInicio'];
        $dtFim = $_POST['dtFim'];
        // Se a foto estiver sido selecionada
        if (!empty($imagem["name"])):
            // Verifica se o arquivo é uma imagem
            if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])):
                $error[1] = "Isso não é uma imagem.";
            endif;
            // Se não houver nenhum erro
            if (count($error) == 0):
                // Pega extensão da imagem
                preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);

                // Gera um nome único para a imagem
                $nome_imagem = md5(uniqid(time())) . "." . $ext[1];

                // Caminho de onde ficará a imagem
                $caminho_imagem = $banners->pasta_raiz . $nome_imagem;

                // Faz o upload da imagem para seu respectivo caminho
                move_uploaded_file($imagem["tmp_name"], $caminho_imagem);

                // Recupera os dados dos campos
                $banners->setValor('descricao', $descricao);
                $banners->setValor('imagem', $nome_imagem);

                $banners->setValor('dt_inicio', $banners->convertDatetoDateTime($dtInicio));
                $banners->setValor('dt_fim', $banners->convertDatetoDateTime($dtFim));

                $banners->inserir($banners);
                $banners->selecionaTudo($banners);
            endif;

            // Se houver mensagens de erro, exibe-as
            if (count($error) != 0):
                foreach ($error as $erro) :
                    echo $erro . "<br />";
                endforeach;
            endif;
        endif;

    }

    if ($_POST['excluir']){
        $acao = 'excluir';
        $id = $_POST['id'];
        $imagem = $_POST['imagem'];
        $banners->valorpk=$id;
        $banners->deletar($banners);
        unlink($banners->pasta_raiz.$imagem);
        $banners->selecionaTudo($banners);
    }

    if ($_POST['editar']){
        $acao = 'editar';
        $id = $_POST['id'];
        $banners->extras_select = " WHERE 1=1 AND `id` = ".$id;
        $banners->selecionaTudo($banners);
        $editar = $banners->retornaDados();
    }

    if ($_POST['atualizar']){
        $acao = 'atualizar';
        $descricao = $_POST['descricao'];
        $dtInicio = $_POST['dtInicio'];
        $dtFim = $_POST['dtFim'];
        $id = $_POST['id'];
        $banners->setValor('descricao', $descricao);
        $banners->setValor('dt_inicio', $banners->convertDatetoDateTime($dtInicio));
        $banners->setValor('dt_fim', $banners->convertDatetoDateTime($dtFim));
        $banners->valorpk=$id;
        $banners->delCampo('imagem');
        $banners->atualizar($banners);
        $banners->selecionaTudo($banners);
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cadastro de Banners</title>
    <!-- Favicon -->
    <link rel="sortcut icon" type="image/png" href="../../img/logo_transparente.png" />
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/bs/css/bootstrap.css" />
    <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css" />
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../css/ie10-viewport-bug-workaround.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/jquery-ui.theme.min.css" />
    <link rel="stylesheet" href="../../css/jquery-ui.css" />
    <style>
        .demoHeaders {
            margin-top: 2em;
        }
    </style>



</head>
<body>
    <div id="main" class="container centered">
        <div class="row col-lg-3">
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h1 class="text-center">Cadastro de Banners</h1>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data"
                      name="<?php if($acao == 'editar'):?>atualizar<?php else: ?>cadastro<?php endif; ?>" >
                    <div class="form-group">
                        <label class="control-label" for="descricao">Descrição: </label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $editar->descricao ?>">
                    </div>

                    <?php if($acao != 'editar'):?>
                        <div class="form-group">
                            <label class="control-label" for="imagem">Banner: </label>
                            <input class="form-control" type="file" id="imagem" name="imagem" value="<?php echo $editar->imagem ?>">
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="control-label" for="dtInicio">Data Inicio: </label>
                        <input type="text" class="form-control" id="dtInicio" name="dtInicio" autocomplete="off"
                               value="<?php echo $banners->convertDateTimetoDate($editar->dt_inicio) ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="dtFim">Data Fim: </label>
                        <input type="text" class="form-control" id="dtFim" name="dtFim" autocomplete="off"
                               value="<?php echo $banners->convertDateTimetoDate($editar->dt_fim) ?>">
                    </div>

                    <?php if($acao != 'editar'):?>
                        <input class="btn btn-default" type="submit" value="Cadastrar" name="cadastrar">
                    <?php endif; ?>

                    <?php if($acao == 'editar'):?>
                        <input type="hidden" id="id" name="id" value="<?php echo $editar->id ?>"/>
                        <input class="btn btn-default" type="submit" value="Atualizar" name="atualizar">
                    <?php endif; ?>

                </form>
            </div>
        </div>
        <?php if($acao != 'editar'):?>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="1">#</th>
                    <th colspan="1">Descrição</th>
                    <th colspan="1">Imagem</th>
                    <th colspan="1">Data Início</th>
                    <th colspan="1">Data Fim</th>
                    <th colspan="1" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($res = $banners->retornaDados()):
                        echo '<tr>';
                            echo '<td colspan="1">'.$res->id.'</td>';
                            echo '<td colspan="1">'.$res->descricao.'</td>';
                            echo '<td colspan="1">'.$res->imagem.'</td>';
                            echo '<td colspan="1">'.$banners->convertDateTimetoDate($res->dt_inicio).'</td>';
                            echo '<td colspan="1">'.$banners->convertDateTimetoDate($res->dt_fim).'</td>';?>
                            <td colspan="1" class="text-center">
                                <form style="display: inline;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="excluir" >
                                    <input type="hidden" id="id" name="id" value="<?php echo $res->id ?>"/>
                                    <input type="hidden" id="imagem" name="imagem" value="<?php echo $res->imagem ?>"/>
                                    <button type="submit" class="btn btn-link" value="Excluir" name="excluir">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <form style="display: inline;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="editar" >
                                    <input type="hidden" id="id" name="id" value="<?php echo $res->id ?>"/>
                                    <button type="submit" class="btn btn-link" value="Editar" name="editar">
                                        <i class="fa fa-pencil  " aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        <?php echo '</tr>';
                    endwhile;
                ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    </body>
<!--JQuery UI-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!-- JavaScripts -->
<script src="../../css/bs/js/bootstrap.min.js"></script>
<script src="../../js/ie10-viewport-bug-workaround.js"></script>

<script type="text/javascript">
    $(function() {
        $( "#dtInicio" ).datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
                $("#dtFim").datepicker( "option", "minDate", selectedDate );
                d = $("#dtInicio").datepicker("getDate");
                d!=null?$("#dtFim").datepicker("setDate", new Date(d.getFullYear(),d.getMonth(),d.getDate()+7)):"";
            }
        });
        $( "#dtFim" ).datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy",
            onClose: function( selectedDate ) {
                $( "#dtInicio" ).datepicker( "option", "maxDate", selectedDate );
            }
        });

        $.datepicker.regional[ "pt-BR" ] = {
            closeText: "Fechar",
            prevText: "&#x3C;Anterior",
            nextText: "Próximo&#x3E;",
            currentText: "Hoje",
            monthNames: [ "Janeiro","Fevereiro","Março","Abril","Maio","Junho",
                "Julho","Agosto","Setembro","Outubro","Novembro","Dezembro" ],
            monthNamesShort: [ "Jan","Fev","Mar","Abr","Mai","Jun",
                "Jul","Ago","Set","Out","Nov","Dez" ],
            dayNames: [
                "Domingo",
                "Segunda-feira",
                "Terça-feira",
                "Quarta-feira",
                "Quinta-feira",
                "Sexta-feira",
                "Sábado"
            ],
            dayNamesShort: [ "Dom","Seg","Ter","Qua","Qui","Sex","Sáb" ],
            dayNamesMin: [ "Dom","Seg","Ter","Qua","Qui","Sex","Sáb" ],
            weekHeader: "Sm",
            dateFormat: "dd/mm/yy",
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: "" };
        $.datepicker.setDefaults($.datepicker.regional[ "pt-BR" ] );
    });
</script>
</html>

