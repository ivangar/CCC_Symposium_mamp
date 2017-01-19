<?php
require_once("../lib/master.php");
require_once("../lib/user_events.php");
/*  This file is for the "My Events" page */
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home - CCC On-Demand</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Date picker -->
    <link href="../css/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">

    <link href="css/uploadfile.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .ajax-file-upload{
        height: 30px;
    }
    </style>
</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" id="french"><i class="fa fa-comments fa-fw"></i> French</a> 
                        </li>
                        <li class="divider"></li>
                        <li><a href="#" id="logout"><i class="fa fa-power-off fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="forms/Rep-Guide-CCC-On-Demand.pdf" target="_blank"><i class="fa fa-file-pdf-o fa-fw"></i> Rep Guide</a> 
                        </li>
                        <li>
                            <a href="forms/Program-Overview-CCC-On-Demand.pdf" target="_blank"><i class="fa fa-file-pdf-o fa-fw"></i> Program Overview for Moderator</a> 
                        </li>
                        <li>
                            <a href="new_event.php"><i class="fa fa-plus-circle fa-fw"></i> New Event</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-list-alt fa-fw"></i> List of Events<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a  href="my_events.php"><i class="fa fa-list-alt fa-fw"></i> My Events</a>
                                </li>
                                <li>
                                    <a class="active" href="all_events.php"><i class="fa fa-list-alt fa-fw"></i> All Events</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="documents.html"><i class="fa fa-folder-open fa-fw"></i> Required Forms & Documents</a>
                        </li>    
                        <li>
                            <a href="videos.html"><i class="fa fa-video-camera fa-fw"></i> Video Presentations</a>
                        </li>  
                        <li>
                            <a href="contact_us.html"><i class="fa fa-envelope fa-fw"></i> Contact Information</a>
                        </li>                                               
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid" id="event-container">
                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <img class="center-block img-responsive" src="/programs/CCC_Symposium/images/bannerE.png" width="1000" height="194" align="center" alt="CCC Banner"/>
                    </div>
                </div>                  
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">All Group Learning Sessions</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php if($my_events->events_empty) { $my_events->printAlert(); } else { $my_events->setTableContent();  } ?>                   
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    <!-- Moment Js Parse, validate, manipulate, and display dates in javascript -->
    <script type="text/javascript" src="../js/moment.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="../js/jquery.uploadfile.js"></script>
    <script src="../js/jquery.tablesorter.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/all_events.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.js"></script>
</body>

</html>
