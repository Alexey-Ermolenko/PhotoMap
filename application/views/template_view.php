<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="/media/css/scrollup.css" type="text/css" media="screen">
    <script src="/media/js/scrollup.js" type="text/javascript"></script>

    <link rel="shortcut icon" href="/media/ico/favicon.ico">

    <title>Photo search</title>

    <!-- Bootstrap core CSS -->
    <link href="/media/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/media/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/media/css/bootstrap-datetimepicker.min.css"/>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- datetime script -->
    <script type="text/javascript" src="/media/js/TimeDate.js"></script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZkm7IUBM4g19HrxlWOqx0aGczXwwVJcw&callback=initMap"></script>
    <!--<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>https://code.jquery.com/jquery-3.1.1.min.js -->
    <script type="text/javascript" src="/media/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/media/js/bootstrap.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
    <script type="text/javascript" src="/media/js/jquery.json-2.4.min.js"></script>
    <script type="text/javascript" src="/media/js/GoogleMap.js"></script>
    <script type="text/javascript" src="/media/js/modal_vk.js"></script>
    <script type="text/javascript" src="/media/js/JS_functions.js"></script>
    <script type="text/javascript">
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                $.ajax({
                    type: "POST",
                    url: "/main/temperature",
                    data: {lat: position.coords.latitude, lon: position.coords.longitude},
                    success: function (msg) {
                        let arr = JSON.parse(msg);
                        $('#weather_val').html(arr.temp);
                        $('#weather_description').html(arr.weather.description);
                        $('#weather_city').html(arr.city);
                        $('#weather_icon').attr("src", arr.weather.icon);
                    }, error: function () {
                        console.warn("temperature error");
                    }
                });
            }, error => {
                console.error("error");
                console.error(error);
            }, {})
        }
    </script>
</head>
<body>
<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top navbar-static-top" role="navigation">
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
            <a class="navbar-brand" href="/">PhotoMap</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav" id="nav_search">
                <li><a href="/main/contacts"><span class="glyphicon glyphicon-send"></span> Свяжитесь с нами</a></li>
                <li><a href="/main/about"><span class="glyphicon glyphicon-question-sign"></span> Описание</a></li>
            </ul>

            <ul id="weather" class="nav navbar-nav navbar-right">
                <?php if ($_SESSION['user']) {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            (<span class="glyphicon glyphicon-user"></span> <?= $_SESSION['user']['extra_fields']['first_name'] . ' ' . $_SESSION['user']['extra_fields']['last_name'] ?>
                            ) <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/map"><span class="glyphicon glyphicon-map-marker"></span> Перейти к поиску</a>
                            </li>
                            <li><a href="/map/fullScreen"><span class="glyphicon glyphicon-fullscreen"></span> На весь
                                    экран</a></li>
                            <li class="divider"></li>
                            <li><a href="/main/logout"><span class="glyphicon glyphicon-log-out"></span> Выйти</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><span id="weather_val">0</span>&deg;</a>
                    <ul class="dropdown-menu">
                        <li>
                            <img class="img-rounded" id="weather_icon" alt="weather_icon" src="..."><span
                                    id="weather_city"></span>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><span id="weather_description"></span></li>
                    </ul>
                </li>
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
                    <p class="text-muted text-center" id="doc_time"></p>
                    <script type="text/javascript">clock();</script>
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
