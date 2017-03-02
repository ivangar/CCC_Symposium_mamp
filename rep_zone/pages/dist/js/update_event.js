$(function () {
    $("html, body").animate({ scrollTop: 0 }, 500); 

    $("#COI").uploadFile({
        url:"../lib/upload.php?update=true&file=COI&folderID="+folderId+'&moderatorName='+moderatorName,
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"COI",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: true,
        showDownload:false,  //SET TRUE IF YOU WANT TO DISPLAY THE DOWNLOAD BUTTON (IT IS ALREADY FUNCTIONAL)
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
                    $( ".ajax-file-upload" ).show();
                }
                else{
                    for(var i=0;i<data.length;i++)
                    { 
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }
                    $( ".ajax-file-upload" ).hide();
                    //$( "#COI" ).css("display", "none");                  
                }
            })
            .fail(function() {
                $( ".ajax-file-upload" ).show();
            }); //end Ajax call

        },         
        deleteCallback: function (data, pd) {
            path = folderId + '/' + 'COI';  /* THE CHILD DIRECTORY SHOULD BE REPLACED IN EACH INSTANCE */
            for (var i = 0; i < data.length; i++) {
                $.post("../lib/delete.php", {op: "delete",name: data[i], subdirectory: path} );
            }
            pd.statusbar.hide();
            $( ".ajax-file-upload" ).show();
        },
        downloadCallback:function(filename,pd){
            location.href="../lib/download.php?filename="+filename+"&folderID="+folderId+"&form=COI";
        }
    });


    $("#honorarium").uploadFile({
        url:"../lib/upload.php?update=true&file=honorarium&folderID="+folderId+'&moderatorName='+moderatorName,
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"honorarium",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: true,
        showDownload:false,  //SET TRUE IF YOU WANT TO DISPLAY THE DOWNLOAD BUTTON (IT IS ALREADY FUNCTIONAL)
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
                    $( ".ajax-file-upload" ).show();
                }
                else{
                    for(var i=0;i<data.length;i++)
                    { 
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }
                    $( ".ajax-file-upload" ).hide();
                    //$( "#honorarium" ).css("display", "none");              
                }
            })
            .fail(function() {
                $( ".ajax-file-upload" ).show();
            }); //end Ajax call

        },  
        deleteCallback: function (data, pd) {
            path = folderId + '/' + 'honorarium';  /* THE CHILD DIRECTORY SHOULD BE REPLACED IN EACH INSTANCE */
            for (var i = 0; i < data.length; i++) {
                $.post("../lib/delete.php", {op: "delete",name: data[i], subdirectory: path} );
            }
            pd.statusbar.hide(); //You choice.
            $( ".ajax-file-upload" ).show();
        },
        downloadCallback:function(filename,pd){
            location.href="../lib/download.php?filename="+filename+"&folderID="+folderId+"&form=honorarium";
        }
    });

    $("#signin").uploadFile({
        url:"../lib/upload.php?update=true&file=signin&folderID="+folderId+'&moderatorName='+moderatorName,
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"signin",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: true,
        showDownload:false,  //SET TRUE IF YOU WANT TO DISPLAY THE DOWNLOAD BUTTON (IT IS ALREADY FUNCTIONAL)
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
                    $( ".ajax-file-upload" ).show();
                }
                else{
                    for(var i=0;i<data.length;i++)
                    { 
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }
                    $( ".ajax-file-upload" ).hide(); 
                    //$( "#signin" ).css("display", "none");                 
                }
            })
            .fail(function() {
                $( ".ajax-file-upload" ).show();
            }); //end Ajax call

        },          
        deleteCallback: function (data, pd) {
            path = folderId + '/' + 'signin';  /* THE CHILD DIRECTORY SHOULD BE REPLACED IN EACH INSTANCE */
            for (var i = 0; i < data.length; i++) {
                $.post("../lib/delete.php", {op: "delete",name: data[i], subdirectory: path} );
            }
            pd.statusbar.hide(); //You choice.
            $( ".ajax-file-upload" ).show();
        },
        downloadCallback:function(filename,pd){
            location.href="../lib/download.php?filename="+filename+"&folderID="+folderId+"&form=signin";
        }
    });

    $("#evaluation").uploadFile({
        url:"../lib/upload.php?update=true&file=evaluation&folderID="+folderId+'&moderatorName='+moderatorName,
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"evaluation",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: true,
        showDownload:false,  //SET TRUE IF YOU WANT TO DISPLAY THE DOWNLOAD BUTTON (IT IS ALREADY FUNCTIONAL)
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
                    $( ".ajax-file-upload" ).show();
                }
                else{
                    for(var i=0;i<data.length;i++)
                    { 
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }
                    $( ".ajax-file-upload" ).hide();
                    //$( "#evaluation" ).css("display", "none");                     
                }
            })
            .fail(function() {
                $( ".ajax-file-upload" ).show();
            }); //end Ajax call

        },          
        deleteCallback: function (data, pd) {
            path = folderId + '/' + 'evaluation';  /* THE CHILD DIRECTORY SHOULD BE REPLACED IN EACH INSTANCE */            
            for (var i = 0; i < data.length; i++) {
                $.post("../lib/delete.php", {op: "delete",name: data[i], subdirectory: path} );
            }
            pd.statusbar.hide(); //You choice.
            $( ".ajax-file-upload" ).show();
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

    $('#event_form').validator().on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            e.preventDefault();
    
            var form = document.getElementById("event_form");
            var jsonData = {};

            for (i = 0; i < form.length ;i++) { 
                var columnName = form.elements[i].name;
                jsonData[columnName] = form.elements[i].value;
            } 

            ajax_submit = { "update": 1, "eventID": eventId, "agendaID":agendaId, "moderatorID":moderatorId, "addressID": addressId, "fields":jsonData}; 

            $.ajax({
                url: "../lib/update_event.php",
                cache: false,
                type: "POST",
                dataType: "html",
                data: ajax_submit 
              }) 
            .done(function( data ) {
                var response = data.trim(); //Trim the extra space!
                
                if (response === "submitted") {
                    document.location.reload(true);
                }
                 
                else {
                    var scroll_height = $( "div#event-container" ).height();
                    $("html, body").animate({ scrollTop: scroll_height }, 500);   
                    $("#error_message").html(data);
                    $("#error").css("margin-top", "25px");
                    $( "#error" ).show( "slow", function() {});

                }
                
            })
            .fail(function() {
                alert( "Error, can't connect right now.");
            }); //end Ajax call

        }
    })

});	
