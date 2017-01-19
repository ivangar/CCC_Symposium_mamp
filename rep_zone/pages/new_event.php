<?php
require_once("../lib/master.php");
/*  This is for the "New Event" page */
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
    <link href="css/uploadfile.css" rel="stylesheet" type="text/css">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Date picker -->
    <link href="../css/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">


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
                            <a class="active" href="new_event.php"><i class="fa fa-plus-circle fa-fw"></i> New Event</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-list-alt fa-fw"></i> List of Events<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <!-- USE collapse in to expand the ul automatically <ul class="nav nav-second-level collapse in"> -->
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
            <div class="container-fluid" id="event-container">
                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <img class="center-block img-responsive" src="/programs/CCC_Symposium/images/bannerE.png" width="1000" height="194" align="center" alt="CCC Banner"/>
                    </div>
                </div>               
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Event Info Sheet</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="alert alert-success fade in" role="alert" id="feedback" style="display:none;" >
                                <h4>Success! Event registered</h4>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Please complete and submit the event information
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-11 col-md-12">
                                        <form id="event_form" enctype="multipart/form-data" name="event_form" method="post" action="" role="form">
                                                <input type='hidden' name='event_submitted' id='event_submitted' value='1'>
                                           <div class="form-group required">
                                                    <label>Date of session:</label>
                                                    <input type="text" class="form-control" id='eventDate' name="eventDate" placeholder="yyyy-mm-dd" data-error="Date event required" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                
                                                <div class="form-group required">
                                                    <label>Time of session:</label>
                                                    <input type="text" class="form-control" id='eventTime' name="eventTime" placeholder="00:00 am" data-error="Time event required" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <!-- //USE THE GLYPH FORM IN CASE NEEDS TO BE OPTIMIZED
                                                <div class="form-group required">
                                                    <label>Date of session:</label>
                                                    <div class='input-group date' id='eventDate'>
                                                        <input type='text' class="form-control" name="eventDate" placeholder="yyyy-mm-dd" data-error="Date event required" required/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>

                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="form-group required">
                                                    <label>Time of session:</label>
                                                    <div class='input-group date' id='eventTime'>
                                                        <input type='text' class="form-control" name="eventTime" placeholder="00:00 am" data-error="Time event required" required/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>

                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                -->
                                                <div class="form-group required">
                                                    <label>Location of session:</label>
                                                    <textarea class="form-control" rows="3" id='eventLocation' name="eventLocation" data-error="Location of session required" required></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="form-group required">
                                                    <label>Expected number of attendees:</label>
                                                    <input type="number" class="form-control" id='attendees' name="attendees" data-error="number of attendees required (please type only the number)" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>       
                                                <div class="well well-lg"> 
                                                    <div class="row"> 
                                                        <div class="col-xs-3">
                                                            <h2 style="margin-top:-10px;"> <small>Agenda:</small> </h2>
                                                        </div>
                                                        <div class="col-xs-9">
                                                            <div class="form-group required">
                                                                <label>Arrivals and meal</label>
                                                                <input type="text" class="form-control" id="arrrival_time" name="arrrival_time" placeholder="00:00 am" data-error="Arrivals and meal time required" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Program start</label>
                                                                <input type="text" class="form-control" id="program_start_time" name="program_start_time" placeholder="00:00 am" data-error="Program start time required" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Discussion</label>
                                                                <input type="text" class="form-control" id="qa_time" name="qa_time" placeholder="00:00 am" data-error="Discussion time required" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Program end</label>
                                                                <input type="text" class="form-control" id="end_time" name="end_time" placeholder="00:00 am" data-error="Program end time required" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>                                                    
                                                </div> 
                                                <div class="well well-lg"> 
                                                    <div class="row"> 
                                                        <div class="col-xs-3">
                                                            <h2 style="margin-top:-10px;"> <small>Moderator:</small> </h2>
                                                        </div>
                                                        <div class="col-xs-9">
                                                            <div class="form-group required">
                                                                <label>Full name:</label>
                                                                <input type="text" class="form-control" id="moderator_name" name="moderator_name" data-error="Moderator's full name required" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Credentials:</label>
                                                                <input type="text" class="form-control" id="moderator_credentials" name="moderator_credentials" data-error="Moderator's credentials required" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Email:</label>
                                                                <input type="email" class="form-control" id="moderator_email" name="moderator_email" placeholder="mail@mail.com" data-error="Moderator's email required (please provide a valid email)" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Institution:</label>
                                                                <input type="text" class="form-control" id="moderator_institution" name="moderator_institution" data-error="Moderator's institution required" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-3">
                                                            <h3 style="margin-top:-10px;"> <small>Correspondence Address:</small> </h3>
                                                        </div>
                                                        <div class="col-xs-9">
                                                            <div class="row">
                                                                <div class="col-xs-9">
                                                                    <div class="form-group required">
                                                                        <label>Address:</label>
                                                                        <input type="text" class="form-control" id="moderator_street" name="moderator_street" data-error="Moderator's full street address required" required>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-3">
                                                                    <div class="form-group">
                                                                        <label>Suite:</label>
                                                                        <input type="text" class="form-control" id="moderator_suite" name="moderator_suite">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="row">
                                                                <div class="col-xs-5">
                                                                    <div class="form-group required">
                                                                        <label>City:</label>
                                                                        <input type="text" class="form-control" id="moderator_city" name="moderator_city" data-error="Moderator's city address required" required>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-4">
                                                                    <div class="form-group required">
                                                                        <label>Province:</label>
                                                                        <select class="form-control" id="moderator_province" name="moderator_province" data-error="Moderator's Province is required" required>
                                                                              <option></option>
                                                                              <option value="Alberta"> Alberta </option>
                                                                              <option value="British Columbia"> British Columbia </option>
                                                                              <option value="Manitoba"> Manitoba </option>
                                                                              <option value="New Brunswick"> New Brunswick </option>
                                                                              <option value="Newfoundland and Labrador"> Newfoundland and Labrador </option>
                                                                              <option value="Nova Scotia"> Nova Scotia </option>
                                                                              <option value="Ontario"> Ontario </option>
                                                                              <option value="Prince Edward Island"> Prince Edward Island </option>
                                                                              <option value="Quebec"> Quebec </option>
                                                                              <option value="Saskatchewan"> Saskatchewan </option>
                                                                        </select>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-3">
                                                                    <div class="form-group required">
                                                                        <label>Postal code:</label>
                                                                        <input type="text" class="form-control" id="moderator_pc" name="moderator_pc" data-error="Moderator's postal code required" required>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <div class="form-group required">
                                                                        <label>Telephone:</label>
                                                                        <input type="text" class="form-control" id="moderator_phone" name="moderator_phone" data-error="Moderator's phone number required" required>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <!--<div class="form-group required">-->
                                                                        <div class="form-group"> 
                                                                        <label>Fax:</label>
                                                                        <input type="text" class="form-control" id="moderator_fax" name="moderator_fax" data-error="Moderator's fax number required"> <!--was required-->
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>                                           
                                                </div>  
                                                <div class="well well-lg"> 
                                                    <div class="row"> 
                                                        <div class="col-xs-3">
                                                            <h2 style="margin-top:-10px;"> <small>Program budget:</small> </h2>
                                                        </div>
                                                        <div class="col-xs-9">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Item</th>
                                                                            <th>Cost</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><div class="form-group required"><label>Catering (per person):</label></div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group required">
                                                                                    <input type="text" class="form-control" id="event_catering" name="event_catering" data-error="Catering amount required" required>
                                                                                    <div class="help-block with-errors"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><div class="form-group"><label>Moderator Honorarium:</label></div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group required">
                                                                                    <input type="text" class="form-control" id="moderator_honorarium" value="$1200" disabled name="moderator_honorarium" data-error="Moderator's fax number required">
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div> 
                                                    </div>                                                     
                                                </div>

                                                <div class="row"> 
                                                    <div class="col-xs-3">
                                                        <h2 style="margin-top:-10px;"> <small>Required forms</small> </h2>
                                                    </div>
                                                    <div class="col-xs-9">
                                                        <div class="form-group required">
                                                            <div class="panel panel-yellow">
                                                                <div class="panel-heading">
                                                                    <div >Valid file formats are Excel, PDF, Word, RTF or PowerPoint.</div>
                                                                </div>
                                                            </div>
                                                        </div>                                                     
                                                    </div> 
                                                    <div class="col-xs-9 col-xs-offset-3">
                                                        <div class="table-responsive table-bordered">
                                                            <table class="table" style="margin-bottom:0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td><div class="text-center" style="padding-bottom:15px;">CCS Conflict of Interest Form</div>
                                                                            <!--<div class="text-center"><img src="/programs/CCC_Symposium/images/COI_thumbnail.png" width="108" height="141" align="center" alt="COI thumbnail" style="padding:1px;border:1px solid #021a40;background-color:#a5be2c;"/></div>-->
                                                                        </td>
                                                                        <td><div id="COI">Upload</div>
                                                                        </td>
                                                                    </tr>                                                                                                                                                                                                 
                                                                </tbody>
                                                            </table>
                                                        </div> 
                                                    </div> 
                                                   
                                                </div> 

                                                <div class="form-group required">                                    
                                                    <div class='alert alert-danger' style="display:none;" id="error"><span id="error_message">&nbsp;</span></div>
                                                    <button class="btn btn-outline btn-default" type="submit" id="submit_event_button" name="button">Submit</button>
                                                </div>
                                        </form>
                                    </div>
                                    <!-- /.col-lg-12 -->
                                </div>
                                <!-- /.row (nested)-->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
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
    <script src="js/main.js"></script>
    <script src="js/event.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.js"></script>
    <script type="text/javascript" src="../js/jquery.uploadfile.js"></script>
</body>

</html>
