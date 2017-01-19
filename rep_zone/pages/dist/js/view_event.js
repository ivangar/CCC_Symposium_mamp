$(function () {
    $("html, body").animate({ scrollTop: 0 }, 500); 
    var form_counter = 0;

    $("#COI").uploadFile({
        url:"../lib/upload.php?update=true&file=COI&folderID="+folderId,
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"COI",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: false,
        showDownload:true,  //SET TRUE IF YOU WANT TO DISPLAY THE DOWNLOAD BUTTON (IT IS ALREADY FUNCTIONAL)
        showFileCounter:false,
        statusBarWidth:390,
        maxFileSize:7000000,
        onLoad:function(obj)
           {  
            $( ".ajax-file-upload" ).hide();        
            var form = obj.selector.substring(1);

            $.ajax({
                cache: false,
                type: "POST",
                url: "../lib/load.php",
                dataType: "json",
                data: {"folderID": folderId, "form": form}
              }) 
            .done(function( data ) {
                if(data.length == 0){
                   $( "#COI_row" ).hide();
                   form_counter++;
                   if(form_counter == 4){$( "#forms_table" ).hide();}
                }
                else{
                    for(var i=0;i<data.length;i++)
                    { 
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }                
                }
            })
            .fail(function() {
                $( "#COI_row" ).hide();
                form_counter++;
                if(form_counter == 4){$( "#forms_table" ).hide();}
            }); //end Ajax call
            
        },         
        downloadCallback:function(filename,pd){
            location.href="../lib/download.php?filename="+filename+"&folderID="+folderId+"&form=COI";
        }
    });

    $("#honorarium").uploadFile({
        url:"../lib/upload.php?update=true&file=honorarium&folderID="+folderId,
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"honorarium",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: false,
        showDownload:true,  //SET TRUE IF YOU WANT TO DISPLAY THE DOWNLOAD BUTTON (IT IS ALREADY FUNCTIONAL)
        showFileCounter:false,   
        statusBarWidth:390,    
        maxFileSize:7000000,
        onLoad:function(obj)
           {
            $( ".ajax-file-upload" ).hide(); 
            var form = obj.selector.substring(1);

            $.ajax({
                cache: false,
                type: "POST",
                url: "../lib/load.php",
                dataType: "json",
                data: {"folderID": folderId, "form": form}
              }) 
            .done(function( data ) {
                if(data.length == 0){
                    $( "#honorarium_row" ).hide();
                    form_counter++;
                    if(form_counter == 4){$( "#forms_table" ).hide();}
                }
                else{
                    for(var i=0;i<data.length;i++)
                    { 
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }                   
                }
            })
            .fail(function() {
                 $( "#honorarium_row" ).hide();
                 form_counter++;
                 if(form_counter == 4){$( "#forms_table" ).hide();}
            }); //end Ajax call

            if(form_counter == 4){$( "#forms_table" ).hide();}
        },
        downloadCallback:function(filename,pd){
            location.href="../lib/download.php?filename="+filename+"&folderID="+folderId+"&form=honorarium";
        }
    });

    $("#signin").uploadFile({
        url:"../lib/upload.php?update=true&file=signin&folderID="+folderId,
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"signin",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: false,
        showDownload:true,  //SET TRUE IF YOU WANT TO DISPLAY THE DOWNLOAD BUTTON (IT IS ALREADY FUNCTIONAL)
        showFileCounter:false,   
        statusBarWidth:390,    
        maxFileSize:7000000,
        onLoad:function(obj)
           {
            $( ".ajax-file-upload" ).hide(); 
            var form = obj.selector.substring(1);

            $.ajax({
                cache: false,
                type: "POST",
                url: "../lib/load.php",
                dataType: "json",
                data: {"folderID": folderId, "form": form}
              }) 
            .done(function( data ) {
                if(data.length == 0){
                    $( "#signin_row" ).hide();
                    form_counter++;
                    if(form_counter == 4){$( "#forms_table" ).hide();}
                }
                else{
                    for(var i=0;i<data.length;i++)
                    { 
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }                  
                }
            })
            .fail(function() {
                $( "#signin_row" ).hide();
                form_counter++;
                if(form_counter == 4){$( "#forms_table" ).hide();}
            }); //end Ajax call

            if(form_counter == 4){ $( "#forms_table" ).hide();}
        },
        downloadCallback:function(filename,pd){
            location.href="../lib/download.php?filename="+filename+"&folderID="+folderId+"&form=signin";
        }
    });

    $("#evaluation").uploadFile({
        url:"../lib/upload.php?update=true&file=evaluation&folderID="+folderId,
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"evaluation",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: false,
        showDownload:true,  //SET TRUE IF YOU WANT TO DISPLAY THE DOWNLOAD BUTTON (IT IS ALREADY FUNCTIONAL)
        showFileCounter:false,   
        statusBarWidth:390,    
        maxFileSize:7000000,
        onLoad:function(obj)
           {
            $( ".ajax-file-upload" ).hide(); 
            var form = obj.selector.substring(1);

            $.ajax({
                cache: false,
                type: "POST",
                url: "../lib/load.php",
                dataType: "json",
                data: {"folderID": folderId, "form": form}
              }) 
            .done(function( data ) {
                if(data.length == 0){
                    $( "#evaluation_row" ).hide();
                    form_counter++;
                    if(form_counter == 4){$( "#forms_table" ).hide();}
                }
                else{
                    for(var i=0;i<data.length;i++)
                    { 
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }                   
                }
            })
            .fail(function() {
                $( "#evaluation_row" ).hide();
                form_counter++;
                if(form_counter == 4){$( "#forms_table" ).hide();}
            }); //end Ajax call

            if(form_counter == 4){ console.log(' forms counter is ' + form_counter); $( "#forms_table" ).hide();}
        },
        downloadCallback:function(filename,pd){
            location.href="../lib/download.php?filename="+filename+"&folderID="+folderId+"&form=evaluation";
        }
    });

    $('#eventDate').datetimepicker({
    	format: 'YYYY-MM-DD'
    });
    $('#eventTime, #arrrival_time, #program_start_time, #qa_time, #end_time').datetimepicker({
    	format: 'h:mm a'
    });

    $( "#approved, #pending, #cancelled, #closed" ).click(function() {
        var action = $(this).attr( "id" );

        ajax_submit = {"update_status": true, "action": action, "eventID": eventId}; 

        $.ajax({
            url: "../lib/view_general_event.php",
            cache: false,
            type: "POST",
            dataType: "html",
            data: ajax_submit 
          }) 
        .done(function( data ) {
            document.location.reload(true);
        })
        .fail(function() {
            alert( "Error, can't connect right now.");
        }); //end Ajax call

    });

/*
    $('#event_form').validator().on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            e.preventDefault();

            var form = document.getElementById("event_form");

            for (i = 0; i < form.length ;i++) { 
                var type = form.elements[i].type;
                if (type === "submit"){
                    var action = form.elements[i].id;
                }
            } 

            ajax_submit = {"update_status": true,  "action": action, "eventID": eventId}; 

            $.ajax({
                url: "../lib/view_general_event.php",
                cache: false,
                type: "POST",
                dataType: "html",
                data: ajax_submit 
              }) 
            .done(function( data ) {
                document.location.reload(true);
            })
            .fail(function() {
                alert( "Error, can't connect right now.");
            }); //end Ajax call

        }
    })
*/

});	
