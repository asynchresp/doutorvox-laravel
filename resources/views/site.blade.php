<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no;">
    <meta name="keywords" content="app, doutorvox, vox, doutor, advocacia, advogados" />
    <title>Doutor Vox</title>

    <!-- SuperSlider -->
    <link rel="stylesheet" type="text/css" href="css/superslides.css"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <link href="css/bootstrap-doutor.css" rel="stylesheet" type="text/css" >

    <!--external css-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.6.3/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="fonts/font-face.css"/>

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" type="text/css" href="css/style-responsives.css"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div id="wrap">
    <!-- HEADER -->
    <nav class="navbar navbar-doutor">
        <div class="container" style="height: auto">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-principal" aria-expanded="false">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img src="imagens/logo.png" class="img-responsive" alt="Doutor Vox App" /></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-right" id="menu-principal">
                <a class="btn btn-vermelho" href="cadastro">Cadastrar</a>
                <a class="btn btn-vermelho-rounded" href="login">Login</a>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav> <!-- /HEADER -->

    <!-- SLIDE -->
    <div id="slide-home" class="container-fluid no-padding">
        <div class="slides-container">
            <img src="images/people.jpeg" alt="Cinelli">
            <img src="images/surly.jpeg" width="1024" height="682" alt="Surly">
            <img src="images/cinelli-front.jpeg" width="1024" height="683" alt="Cinelli">
            <img src="images/affinity.jpeg" width="1024" height="685" alt="Affinity">
        </div>
    </div><!-- fim slider -->
</div><!-- FIM WRAP -->

<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <img src="imagens/logo-footer.png" class="img-responsive"/>
                <p>CEP 74400-000</p>
                <p>Goiânia - GO</p>
            </div>
            <div id="footer2" class="col-sm-6 col-xs-12">
                <p>Contato</p>
                <p>+55 (62) 3223-3232</p>
                <p>contato@doutorvox.com.br</p>
            </div>
        </div>
    </div>
</div>

<div id="copy">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <p>Copyright &copy; 2016. Todos Direitos Reservados.</p>
            </div>
        </div>
    </div>
</div>
</body>

<!-- jQuery -->
<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="script/bootstrap.min.js"></script>

<!-- SuperSlider -->
<script type="text/javascript" src="script/superslides/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="script/superslides/jquery.animate-enhanced.min.js"></script>
<script type="text/javascript" src="script/superslides/jquery.superslides.min.js"></script>

<script>
    // SUPER SLIDER
    $(function() {
        $('#slide-home').superslides({
            hashchange: true
        });
    });
</script>
</html>
