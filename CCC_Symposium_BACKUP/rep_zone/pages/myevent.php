<?php
require_once("../lib/master.php");
require_once("../lib/view_event.php");
/*  This file is for the "My Events -> My Event" page */
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home - CCC Live</title>

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
    <script type="text/javascript">
    var eventId = <?php echo "{$myevent->PrintEventId()}";?>;
    var agendaId = <?php $agendaVal = $myevent->PrintAgendaId(); if(!empty($agendaVal)) {echo "{$myevent->PrintAgendaId()}";} else echo "null"; ?>;
    var moderatorId = <?php $moderatorVal = $myevent->PrintModeratorId(); if(!empty($moderatorVal)) {echo "{$myevent->PrintModeratorId()}";} else echo "null"; ?>;
    var addressId = <?php $addressVal = $myevent->PrintAddressId(); if(!empty($addressVal)) {echo "{$myevent->PrintAddressId()}";} else echo "null"; ?>;
    var folderId = <?php $folderVal = $myevent->PrintFolderId(); if(!empty($folderVal)) {echo "'{$myevent->PrintFolderId()}'";} else echo "null"; ?>;
    var upload_notification = "<div class='row'><div class='col-lg-12'><div class='alert alert-danger fade in' role='alert' ><p>Please fill in the information above before uploading the forms.</p></div></div></div>";
    var upload_table = "<div class='table-responsive table-bordered'><table class='table' style='margin-bottom:0;'><tbody><tr><td><div class='text-center'>CCS Conflict of Interest Form</div></td><td><div id='COI'>Upload</div></td></tr><tr><td><div class='text-center'>CCS Honorarium Form</div></td><td><div id='honorarium'>Upload</div></td></tr><tr><td><div class='text-center'>Sign In Sheet</div></td><td><div id='signin'>Upload</div></td></tr><tr><td><div class='text-center'>Evaluation Form</div></td><td><div id='evaluation'>Upload</div></td></tr></tbody></table></div>";
    </script>
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
                            <a href="forms/Disclosure_slides.pptx"><i class="fa fa-file-pdf-o fa-fw"></i> Moderator Disclosure Slides</a> 
                        </li>
                        <li>
                            <a href="new_event.php"><i class="fa fa-plus-circle fa-fw"></i> New Event</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-list-alt fa-fw"></i> List of Events<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse in">
                                <li>
                                    <a class="active" href="my_events.php"><i class="fa fa-list-alt fa-fw"></i> My Events</a>
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
                <?php if(isset($myevent->error_message) && !empty($myevent->error_message) ){ echo $myevent->error_message; } else { ?>
                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <img class="center-block img-responsive" src="/programs/CCC_Symposium/images/bannerE.png" width="1000" height="194" align="center" alt="CCC Banner"/>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Event ID #<?php echo $myevent->PrintEventId();?></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php if(isset($_SESSION['updated']) && $_SESSION['updated']) { unset($_SESSION['updated']); ?>
                        <div class="alert alert-success fade in" role="alert" id="feedback" >
                                <h4>Success! Event updated</h4>
                        </div>
                        <?php } ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Your event information
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-11 col-md-12">
                                        <form id="event_form" enctype="multipart/form-data" name="event_form" method="post" action="" role="form">
                                                <input type='hidden' name='event_submitted' id='event_submitted' value='1'>
                                                <div class="form-group required">
                                                    <label>Date of session:</label>
                                                    <input type="text" class="form-control" id='eventDate' name="eventDate" placeholder="yyyy-mm-dd" data-error="Date event required" required value="<?php echo $myevent->event_info[0]; ?>">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="form-group required">
                                                    <label>Time of session:</label>
                                                    <input type="text" class="form-control" id='eventTime' name="eventTime" placeholder="00:00 am" data-error="Time event required" required value="<?php echo $myevent->event_info[1]; ?>">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="form-group required">
                                                    <label>Location of session:</label>
                                                    <textarea class="form-control" rows="3" id='eventLocation' name="eventLocation" data-error="Location of session required" required><?php echo $myevent->event_info[2]; ?></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="form-group required">
                                                    <label>Expected number of attendees:</label>
                                                    <input type="number" class="form-control" id='attendees' name="attendees" data-error="number of attendees required (please type only the number)" required value="<?php echo $myevent->event_info[3]; ?>">
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
                                                                <input type="text" class="form-control" id="arrrival_time" name="arrrival_time" placeholder="00:00 am" data-error="Arrivals and meal time required" required value="<?php echo $myevent->event_info[4]; ?>">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Q&A</label>
                                                                <input type="text" class="form-control" id="qa_time" name="qa_time" placeholder="00:00 am" data-error="Questions and answers time required" required value="<?php echo $myevent->event_info[5]; ?>">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Program end</label>
                                                                <input type="text" class="form-control" id="end_time" name="end_time" placeholder="00:00 am" data-error="Questions and answers time required" required value="<?php echo $myevent->event_info[6]; ?>">
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
                                                                <input type="text" class="form-control" id="moderator_name" name="moderator_name" data-error="moderator's full name required" required value="<?php echo $myevent->event_info[7]; ?>">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Credentials:</label>
                                                                <input type="text" class="form-control" id="moderator_credentials" name="moderator_credentials" data-error="moderator's credentials required" required value="<?php echo $myevent->event_info[8]; ?>">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Email:</label>
                                                                <input type="email" class="form-control" id="moderator_email" name="moderator_email" placeholder="mail@mail.com" data-error="moderator's email required (please provide a valid email)" required value="<?php echo $myevent->event_info[9]; ?>">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="form-group required">
                                                                <label>Institution:</label>
                                                                <input type="text" class="form-control" id="moderator_institution" name="moderator_institution" data-error="moderator's institution required" required value="<?php echo $myevent->event_info[10]; ?>">
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
                                                                        <input type="text" class="form-control" id="moderator_street" name="moderator_street" data-error="moderator's full street address required" required value="<?php echo $myevent->event_info[11]; ?>">
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-3">
                                                                    <div class="form-group">
                                                                        <label>Suite:</label>
                                                                        <input type="text" class="form-control" id="moderator_suite" name="moderator_suite" value="<?php echo $myevent->event_info[12]; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-9 col-xs-offset-3">
                                                            <div class="row">
                                                                <div class="col-xs-5">
                                                                    <div class="form-group required">
                                                                        <label>City:</label>
                                                                        <input type="text" class="form-control" id="moderator_city" name="moderator_city" data-error="moderator's city address required" required value="<?php echo $myevent->event_info[13]; ?>">
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-4">
                                                                    <div class="form-group required">
                                                                        <label>Province:</label>
                                                                        <select class="form-control" id="moderator_province" name="moderator_province" data-error="moderator's Province is required" required>
                                                                              <?php if( (isset($myevent->provinceList)) && $myevent->provinceList != '') {echo $myevent->provinceList;} else { ?>
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
                                                                             <?php } ?>
                                                                        </select>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-3">
                                                                    <div class="form-group required">
                                                                        <label>Postal code:</label>
                                                                        <input type="text" class="form-control" id="moderator_pc" name="moderator_pc" data-error="moderator's postal code required" required value="<?php echo $myevent->event_info[15]; ?>">
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
                                                                        <input type="text" class="form-control" id="moderator_phone" name="moderator_phone" data-error="moderator's phone number required" required value="<?php echo $myevent->event_info[16]; ?>">
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <div class="form-group required">
                                                                        <label>Fax:</label>
                                                                        <input type="text" class="form-control" id="moderator_fax" name="moderator_fax" data-error="moderator's fax number required" required value="<?php echo $myevent->event_info[17]; ?>">
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
                                                                                    <input type="text" class="form-control" id="event_catering" name="event_catering" data-error="Catering amount required" required value="<?php echo $myevent->event_info[18]; ?>">
                                                                                    <div class="help-block with-errors"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><div class="form-group"><label>Moderator Honorarium:</label></div>
                                                                            </td>
                                                                            <td><div class="form-group"><p>$1200</p></div>
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
                                                        <script type="text/javascript">
                                                            if(!folderId){  document.write(upload_notification); }
                                                            else{ document.write(upload_table); }
                                                        </script>
                                                    </div> 
                                                   
                                                </div> 

                                                <div class="form-group required">                                    
                                                    <div class='alert alert-danger' style="display:none;" id="error"><span id="error_message">&nbsp;</span></div>
                                                    <button class="btn btn-outline btn-default" type="submit" id="submit_event_button" name="button">Update</button>
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
                <?php } //THIS BRACKET CLOSES THE ERROR MESSAGE CONDITION ?>
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
    <script src="js/update_event.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.js"></script>
    <script type="text/javascript" src="../js/jquery.uploadfile.js"></script>
</body>

</html>
