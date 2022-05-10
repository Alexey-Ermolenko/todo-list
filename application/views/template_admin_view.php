<?php
/**
 * @var string $contentView
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TO-DO list | admin</title>

    <!-- Bootstrap core CSS -->
    <link href="/media/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/media/css/style.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>https://code.jquery.com/jquery-3.1.1.min.js -->
    <script type="text/javascript" src="/media/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/media/js/bootstrap.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
</head>
<body>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top navbar-static-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?= env('PROJECT_NAME'); ?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <?php if (Controller::isAuth() === true) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            (<span class="glyphicon glyphicon-user"></span> <?= $_SESSION['user']['name'] ?>) <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/index"><span class="glyphicon"></span> Админка</a></li>
                            <li><a href="/main/logout"><span class="glyphicon glyphicon-log-out"></span> Выйти</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!-- Page content -->
<div class="container">
    <?php include 'application/views/' . $contentView; ?>
</div><!-- /.Page content -->

<div id="footer"><!--Page footer -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="footertime">
                    <p class="footer-time text-muted text-center">
                        <?= date('d-m-Y')?>
                    </p>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div><!-- /.Page footer -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->


</body>
</html>
