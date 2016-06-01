<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no;">
    <meta name="keywords" content="app, doutorvox, vox, doutor, advocacia, advogados" />
    <title>Doutor Vox</title>

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

    <div id="section-cadastro" class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="titulo-texto">CADASTRO DE PARCEIRO</h1>
                </div>
            </div>
            <form name="cadastro" id="cadastro" class="row">
                <ul class="list-unstyled col-xs-12">
                    <li>
                        <a href="" class="btn btn-vermelho-rounded active"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Pessoa Física</a>
                    </li>
                    <li>
                        <a href="" class="btn btn-vermelho-rounded"><i class="fa fa-suitcase fa-fw" aria-hidden="true"></i>Advogado</a>
                    </li>
                </ul>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf">
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <h1 class="titulo-texto">Informações de contato</h1>
                </div>
                <div class="form-group col-sm-6 col-md-4">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone">
                </div>
                <div class="form-group col-sm-6 col-md-4">
                    <label for="comercial">Comercial</label>
                    <input type="text" class="form-control" id="tel-comercial">
                </div>
                <div class="form-group col-sm-6 col-md-4">
                    <label for="residencial">Residêncial</label>
                    <input type="text" class="form-control" id="tel-residencial">
                </div>
                <div class="form-group col-sm-6 col-md-6">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco">
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label for="endereco">Cidade</label>
                    <select class="form-control" id="cidade">
                        <option>1</option>
                    </select>
                </div>
                <div class="form-group col-sm-4 col-md-3">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" id="cep">
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <h1 class="titulo-texto">Plano de Assinatura</h1>
                </div>
                <div id="plano1" class="form-group col-xs-12 col-sm-6 col-md-3 mtop15">
                    <div class="pricing-item">
                        <div class="pricing-head">
                            <h3>Gratuito</h3>
                            <p>Lorem ipsum dolor</p>
                        </div>
                        <div class="pricing-content">
                            <div class="pi-price">
                                <strong><span>R$</span><em>0</em>,00</strong>
                                <p>Mensal</p>
                            </div>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a class="btn btn-vermelho-rounded btn-block" href="">Selecionar</a>
                        </div>
                    </div>
                </div>
                <div id="plano2" class="form-group col-xs-12 col-sm-6 col-md-3 mtop15">
                    <div class="pricing-item">
                        <div class="pricing-head">
                            <h3>Plano 1</h3>
                            <p>Lorem ipsum dolor</p>
                        </div>
                        <div class="pricing-content">
                            <div class="pi-price">
                                <strong><span>R$</span><em>9</em>,90</strong>
                                <p>Mensal</p>
                            </div>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a class="btn btn-vermelho-rounded btn-block" href="">Selecionar</a>
                        </div>
                    </div>
                </div>
                <div id="plano3" class="form-group col-xs-12 col-sm-6 col-md-3 mtop15">
                    <div class="pricing-item">
                        <div class="pricing-head">
                            <h3>Plano 2</h3>
                            <p>Lorem ipsum dolor</p>
                        </div>
                        <div class="pricing-content">
                            <div class="pi-price">
                                <strong><span>R$</span><em>19</em>,90</strong>
                                <p>Mensal</p>
                            </div>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a class="btn btn-vermelho-rounded btn-block" href="">Selecionar</a>
                        </div>
                    </div>
                </div>
                <div id="plano4" class="form-group col-xs-12 col-sm-6 col-md-3 mtop15">
                    <div class="pricing-item">
                        <div class="pricing-head">
                            <h3>Plano 3</h3>
                            <p>Lorem ipsum dolor</p>
                        </div>
                        <div class="pricing-content">
                            <div class="pi-price">
                                <strong><span>R$</span><em>29</em>,90</strong>
                                <p>Mensal</p>
                            </div>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                                <li><i class="fa fa-circle"></i> Lorem ipsum dolor</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a class="btn btn-vermelho-rounded btn-block active" href="">Selecionar</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6 col-xs-12">
                    <a href="" class="no-btn pull-left"><i class="fa fa-fw fa-times" aria-hidden="true"></i>
                        Cancelar</a>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <a href="" class="btn btn-vermelho pull-right"><i class="fa fa-fw fa-thumbs-o-up" aria-hidden="true"></i>
                        Cadastrar</a>
                </div>
            </form>
        </div>
    </div>
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

</html>
