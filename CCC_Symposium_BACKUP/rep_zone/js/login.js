$(document).ready(function () {

    $('body').on('click', 'button#login_button', function(event) {
        event.preventDefault();
        
        var form = document.getElementById("login_form");
        var jsonData = {};

        for (i = 0; i < form.length ;i++) { 
            var columnName = form.elements[i].name;
            jsonData[columnName] = form.elements[i].value;
        } 
 
        $.ajax({
            url: "lib/password.php",
            cache: false,
            type: "POST",
            dataType: "html",
            data: jsonData 
          }) 
        .done(function( data ) { 
             if (data === 'continue'){

                $.ajax({
                    url: "lib/login.php",
                    cache: false,
                    type: "POST",
                    dataType: "html",
                    data: jsonData 
                  }) 
                .done(function( data ) { 
                    var response = data.trim(); //Trime the extra space!
                    if (response === 'access'){
                        window.location.replace('/programs/CCC_Symposium/rep_zone/pages/');
                    }
                    else if(response === 'register'){
                        var email = document.getElementById("inputEmail").value;
                        window.location.replace('/programs/CCC_Symposium/rep_zone/register.html?email=' + email);
                    }
                })
                .fail(function() {
                    alert( "Error, can't connect right now. Try again.");
                }); //end Ajax call

             }
             else{
                $("#error_message").text(data);
                $( "#error" ).show( "slow", function() {});
             }

        })
        .fail(function() {
            alert( "Error, can't retrieve password. Please try again.");
        }); //end Ajax call

    });

    $('form#login_form').each(function() {
        
        $(this).find('input').keypress(function(e) {
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                
                var form = document.getElementById("login_form");
                var jsonData = {};

                for (i = 0; i < form.length ;i++) { 
                    var columnName = form.elements[i].name;
                    jsonData[columnName] = form.elements[i].value;
                } 

                $.ajax({
                    url: "lib/password.php",
                    cache: false,
                    type: "POST",
                    dataType: "html",
                    data: jsonData 
                  }) 
                .done(function( data ) { 
                     if (data === 'continue'){

                        $.ajax({
                            url: "lib/login.php",
                            cache: false,
                            type: "POST",
                            dataType: "html",
                            data: jsonData 
                          }) 
                        .done(function( data ) { 
                            var response = data.trim(); //Trime the extra space!
                            if (response === 'access'){
                                window.location.replace('/programs/CCC_Symposium/rep_zone/pages/');
                            }
                            else if(response === 'register'){
                                var email = document.getElementById("inputEmail").value;
                                window.location.replace('/programs/CCC_Symposium/rep_zone/register.html?email=' + email);
                            }
                        })
                        .fail(function() {
                            alert( "Error, can't connect right now. Try again.");
                        }); //end Ajax call

                     }
                     else{
                        $("#error_message").text(data);
                        $( "#error" ).show( "slow", function() {});
                     }

                })
                .fail(function() {
                    alert( "Error, can't retrieve password. Please try again.");
                }); //end Ajax call

            }
        });

    });

});//end document.ready