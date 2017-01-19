$(function () {
 
    $('body').on('click', '#logout', function(event) {
        event.preventDefault();

        $.ajax({
            url: "../lib/master.php",
            cache: false,
            method: "POST",
            data: { action: "logout" },
            dataType: "html"
          }) 
        .done(function( data ) {
            window.location.replace('/programs/CCC_Symposium/rep_zone/login.html');
        })
        .fail(function() {
            alert( "Error, can't connect right now.");
        }); //end Ajax call


    });
    
    $('body').on('click', '#french', function(event) {
        event.preventDefault();

        var host = window.location.hostname;
        var path = window.location.pathname;
        var search = window.location.search;

        document.location.href = "https://" + host + "/fr" + path + search;

    });
	//button event listener
 
});	
