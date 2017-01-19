/*
** This file is used to create a new event
*/
$(function () {

    $("html, body").animate({ scrollTop: 270 }, 1000);  

    $("#COI").uploadFile({
        url:"../lib/upload.php",
        multiple:false,
        dragDrop:false,
        maxFileCount:1,
        fileName:"COI",
        allowedTypes:"pdf,xlsx,csv,xls,docx,pptx,ppt,doc,rtf",
        returnType: "json",
        showDelete: true,
        deletelStr:"Cancel",
        showFileCounter:false,
        statusBarWidth:390,
        maxFileSize:7000000,
        deleteCallback: function (data, pd) {
            for (var i = 0; i < data.length; i++) {
                $.post("../lib/delete.php", {op: "delete",name: data[i], subdirectory: "COI"} );
            }
            pd.statusbar.hide();
        }
    });

    $('#eventDate').datetimepicker({
    	format: 'YYYY-MM-DD'
    });
    $('#eventTime, #arrrival_time, #qa_time, #end_time').datetimepicker({
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

            $.ajax({
                url: "../lib/register_event.php",
                cache: false,
                type: "POST",
                dataType: "html",
                data: jsonData 
              }) 
            .done(function( data ) {
                var response = data.trim(); //Trim the extra space!
                if (response === "submitted") {
                    $( "#event_form" ).wrapInner( "<fieldset disabled></fieldset>");
                    $( ".ajax-file-upload-red" ).css("display", "none");
                    $( "#COI" ).css("display", "none");
                    $( ".ajax-file-upload-progress" ).css("width", "330px"); 
                    $("html, body").animate({ scrollTop: 0 }, 500);                   
                    if( $('#error').is(':visible') ) { $( "#error" ).hide(); }
                    $( "#feedback" ).show( "slow", function() {});
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

/*
    $('body').on('click', 'button#submit_event_button', function(event) {
        event.preventDefault();
        
        var form = document.getElementById("event_form");
        var jsonData = {};

        for (i = 0; i < form.length ;i++) { 
            var columnName = form.elements[i].name;
            jsonData[columnName] = form.elements[i].value;
        } 

        $.ajax({
            url: "../lib/register_event.php",
            cache: false,
            type: "POST",
            dataType: "html",
            data: jsonData 
          }) 
        .done(function( data ) {
            var response = data.trim(); //Trim the extra space!
            if (response === "submitted") {
                $( "#event_form" ).wrapInner( "<fieldset disabled></fieldset>");
                $("html, body").animate({ scrollTop: 0 }, 500);                   
                if( $('#error').is(':visible') ) { $( "#error" ).hide(); }
                $( "#feedback" ).show( "slow", function() {});
            }
             
            else {
                var scroll_height = $( "div#event-container" ).height();
                $("html, body").animate({ scrollTop: scroll_height }, 500);   
                $("#error_message").html(data);
                $( "#error" ).show( "slow", function() {});
            }

        })
        .fail(function() {
            alert( "Error, can't connect right now.");
        }); //end Ajax call
		 

    });
	//button event listener
*/
});	
