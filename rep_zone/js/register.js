$(document).ready(function () {

    var email = window.location.search.split("=")[1];  //email var
    $("#inputEmail").val(email);

    $('body').on('click', 'button#registration_button', function(event) {
        event.preventDefault();
        
        var form = document.getElementById("registration_form");
        var jsonData = {};

        for (i = 0; i < form.length ;i++) { 
            var columnName = form.elements[i].name;
            jsonData[columnName] = form.elements[i].value;
        } 
        
        console.log(jsonData);

        $.ajax({
            url: "lib/register.php",
            cache: false,
            type: "POST",
            dataType: "html",
            data: jsonData 
          }) 
        .done(function( data ) {

            var response = data.trim(); //Trime the extra space!

            if (response === "registered") {
                window.location.replace('/programs/CCC_Symposium/rep_zone/pages/');
            }
             
            else {
                $("#error_message").html(data);
                $( "#error" ).show( "slow", function() {});
            } 

        })
        .fail(function() {
            alert( "Error, can't connect right now.");
        }); //end Ajax call


    });
    
    $('form#registration_form').each(function() {
        
        $(this).find('input').keypress(function(e) {
            // Enter pressed?
            if((e.which == 10 || e.which == 13) && (document.getElementById("rep_checked").checked)) {
                
                var form = document.getElementById("registration_form");
                var jsonData = {};

                for (i = 0; i < form.length ;i++) { 
                    var columnName = form.elements[i].name;
                    jsonData[columnName] = form.elements[i].value;
                } 
                
                console.log(jsonData);

                $.ajax({
                    url: "lib/register.php",
                    cache: false,
                    type: "POST",
                    dataType: "html",
                    data: jsonData 
                  }) 
                .done(function( data ) {

                    var response = data.trim(); //Trime the extra space!

                    if (response === "registered") {
                        window.location.replace('/programs/CCC_Symposium/rep_zone/pages/');
                    }
                     
                    else {
                        $("#error_message").html(data);
                        $( "#error" ).show( "slow", function() {});
                    } 

                })
                .fail(function() {
                    alert( "Error, can't connect right now.");
                }); //end Ajax call

            }
        });

    });

});//end document.ready

function parseErrors(obj){
    var alerts = '';

    for (var key in obj) {
      if (obj.hasOwnProperty(key)) {
        alerts += obj[key] + "<br>";
      }
    }

    return alerts;
}