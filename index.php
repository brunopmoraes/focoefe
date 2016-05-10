<!-- index.php -->
<?php
    require_once("classes/banners.class.php");
    $banners = new banners();
    $banners->extras_select = "WHERE 1=1 AND `DT_INICIO` <= SYSDATE()-7  AND `DT_FIM` >= SYSDATE()";
    $banners->selecionaCampos($banners);
    $res = $banners->retornaDados();
?>
    <!DOCTYPE html>
    <html ng-app="scotchApp">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="Página do Ministério Evangélico Foco & Fé">
      <meta name="author" content="Bruno Passos Moraes - bruno@bmoraes.com.br">
      <title>Foco & Fé</title>
      <!-- Favicon -->
  	  <link rel="sortcut icon" type="image/png" href="./img/logo_transparente.png" />
      <!-- CSS -->
      <link rel="stylesheet" href="css/bs/css/bootstrap.css" />
      <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css" />
      <link href="css/style.css" rel="stylesheet" />
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

      <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet" />
    </head>
    <body>

        <!-- HEADER AND NAVBAR -->
        <header>
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
              <div class="container">
                  <div class="navbar-header">
                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="#" onclick="openModal();">
                          <img title="Foco & Fé" width="20" height="20" src="./img/logo_transparente.png">
                      </a>
                  </div>
                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <!--<li><a href="#">Home</a></li>-->
                        <li><a href="#services">Culto Online</a></li>
                        <li><a href="#donate">Contribuir</a></li>
                        <li><a href="#direction">Como Chegar</a></li>
                        <li><a href="#contact">Contato</a></li>
                        <li><a href="https://www.facebook.com/ministeriofocoefe/" target="_blank" class="visible-xs">Facebook</a></li>
                        <li><a href="https://www.youtube.com/channel/UCsJq_6Im1GzehfD2wcbwF_A/videos" target="_blank" class="visible-xs">Youtube</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right hidden-xs">
                      <li class="menuIcon"><a href="https://www.facebook.com/ministeriofocoefe/" target="_blank" class="menuIcon">
                          <i class="fa fa-facebook-official fa-2x" style="color:blue"></i></a></li>
                      <li class="menuIcon"><a href="https://www.youtube.com/channel/UCsJq_6Im1GzehfD2wcbwF_A/videos" target="_blank" class="menuIcon">
                          <i class="fa fa-youtube fa-2x" style="color:red"></i></a></li>
                    </ul>
                  </div>
                </div>
            </nav>
        </header>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                <center><img src="<?php echo $banners->pasta_raiz_modal.$res->imagem ?>" class="img-responsive" data-dismiss="modal"></center>
              </div>
            </div>
          </div>
        </div>

        <!-- MAIN CONTENT AND INJECTED VIEWS -->
        <div id="main" class="container">
             <div ng-view></div>
        </div>
        <!-- FOOTER -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <h6 class="text-muted text-left">Ministério Evangélico Foco & Fé <i class="fa fa-copyright"></i> 2016</h6>
                    </div>
                    <div class="col-lg-6 visible-md-*">
                        <a href="#direction"><h6 class="text-muted text-right">Hotel Quality Faria Lima - Rua Diogo Moreira, 247 - Pinheiros - São Paulo - SP, 05423-010</h6></a>
                    </div>
                </div>
            </div>
        </footer>
      </body>
      <!-- JavaScripts -->
      <script src="js/jquery.min.js"></script>
      <script src="css/bs/js/bootstrap.min.js"></script>
      <script src="js/angular.min.js"></script>
      <script src="js/angular-route.min.js"></script>
      <script src="script.js"></script>
      <script src="api/functions.js"></script>
      <script src="js/angular-animate.min.js"></script>
      <script src="js/ie10-viewport-bug-workaround.js"/></script>
      <script src="js/ui-bootstrap-tpls.min.js"></script>
      <script src="js/custom.js"></script>

      <script type="text/javascript">
          openModal();

          function openModal() {
              <?php if($res != null){ ?>
                   $('#myModal').modal('show');
              <?php } ?>
          }
      </script>
</html>