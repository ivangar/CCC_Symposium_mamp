<?php
require_once("../lib/master.php");
/*  This file is for the "Event REP Guide " page */
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                                    <a href="my_events.php"><i class="fa fa-list-alt fa-fw"></i> My Events</a>
                                </li>
                                <li>
                                    <a href="all_events.php"><i class="fa fa-list-alt fa-fw"></i> All Events</a>
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
            <div class="container-fluid">
               <div class="row" style="margin-top:20px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <img class="center-block img-responsive" src="/programs/CCC_Symposium/images/ondemand_E_overview.png" width="1000" height="280" align="center" alt="CCC Banner"/>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-sm-12">                    
                        <p><strong>“Innovating, Optimizing and Advancing Antithrombotic Treatment in Atrial Fibrillation”</strong> is an accredited group learning activity that provides presentations in a pre-filmed video format. Focusing on real-world evidence for oral anticoagulation; guidelines on stroke-prevention strategies for atrial fibrillation (AF) patients with CAD, ACS and PCI; and approaches to mitigating the recurrence of stroke in AF patients with renal impairment, the program will allow you to review the latest clinical recommendations, contribute your thoughts, and brainstorm with your colleagues about particular patient cases and challenging questions in treating AF.</p>                     
                    </div>
                    <div class="col-sm-12">
                        <div class="agenda">
                            <span style="font-size:16px;"><strong>Agenda Format</strong></span>
                            <ul>
                                <li><b>Introduction:</b> 5 minutes</li>
                                <li><b>Video(s):</b> 30 minutes</li>
                                <li><b>Discussion:</b> 20 minutes</li>
                                <li><b>Conclusion:</b> 5 minutes</li>
                            </ul>
                        </div>
                    </div>                 
                </div> 
                <div class="row">
                    <div class="col-sm-12">
                        <p style="padding-bottom:15px;">A brief outline of the individual presentations can be found below for the moderators to appropriately choose which presentations they would like to show.</p>
                    </div>  
                </div>
                <div class="panel green_panel"> 
                    <div class="panel-body">
                        <div class="row"> 
                            <div class="col-lg-2 col-md-4">
                                <img class="img-rounded" src="/programs/CCC_Symposium/images/pres1.jpg" width="200" height="148"/>
                            </div> 
                            <div class="col-lg-10 col-md-8"> 
                                <div class="row custom">
                                    <div class="col-sm-12">
                                        <span style="font-size:16px;" class="custom_blue"><strong>Real-world Evidence for Oral Anticoagulation</strong></span><br>
                                    </div>
                                    <div class="col-sm-12">
                                        <p>Using real-world evidence, Professor Lip discusses the effectiveness and safety of oral anticoagulants. He reviews the latest risk-stratification strategies as well as a recommended decision pathway for the treatment of newly diagnosed NVAF. He concludes with the real-world comparison of major bleeding risk among NVAF patients initiated on OACs.</p>
                                    </div>           
                                </div> 
                            </div> 
                        </div>                        
                    </div>
                    <span class="divider"></span>
                    <div class="panel-body">
                        <div class="row"> 
                            <div class="col-lg-2 col-md-4">
                                <img class="img-rounded" src="/programs/CCC_Symposium/images/pres2.jpg" width="200" height="148"/>
                            </div> 
                            <div class="col-lg-10 col-md-8"> 
                                <div class="row custom">
                                    <div class="col-sm-12">
                                        <span style="font-size:16px;" class="custom_blue"><strong>Stroke Prevention in Atrial Fibrillation Patients with CAD/ACS/PCI</strong></span><br>
                                    </div>
                                    <div class="col-sm-12">
                                       <p>Dr. Mitchell discusses stroke-prevention strategies for NVAF patients with CAD, ACS and PCI, highlighting specific guidance from the 2016 Canadian Cardiovascular Society (CCS) updated guidelines for the management of AF. He examines the pros and cons of various antithrombotic therapies, and reviews the CCS algorithms that outline the best choice of treatment for the above AF patient groups.</p>
                                    </div>                 
                                </div> 
                            </div> 
                        </div>                        
                    </div>
                    <span class="divider"></span>
                    <div class="panel-body">
                        <div class="row"> 
                            <div class="col-lg-2 col-md-4">
                                <img class="img-rounded " src="/programs/CCC_Symposium/images/pres3.jpg" width="200" height="148" />
                            </div> 
                            <div class="col-lg-10 col-md-8"> 
                                <div class="row custom">
                                    <div class="col-sm-12">
                                        <span style="font-size:16px;" class="custom_blue"><strong>Complex Case for Stroke Prevention in AF</strong></span><br>
                                    </div>
                                    <div class="col-sm-12">
                                        <p>Dr. Dorian explores the best approaches to mitigating the recurrence of stroke and measuring anticoagulation when treating AF patients with renal impairment. Using a complex case of a patient with permanent AF and kidney disease who is admitted to the hospital with congestive heart failure, he takes viewers through the process of re-evaluating the patient’s DOAC treatment at the point of hospitalization, reviews the most accurate ways of measuring DOAC effect in the event of surgery, and discusses the benefits of DOACs in stroke prevention.</p>
                                    </div>                 
                                </div> 
                            </div> 
                        </div>                        
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-sm-12">&nbsp;</div>  
                </div>
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

    <script src="js/main.js"></script>

</body>

</html>
