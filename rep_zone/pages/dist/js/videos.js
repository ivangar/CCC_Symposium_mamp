/*$.noConflict();*/
$(document).ready(function () {
    
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'right',
        title: 'Downloading the video may take some time depending on your internet bandwidth.'
    });

	var videos = ["player1", "player2", "player3"];
	var video_sources = [ 
        "https://player.vimeo.com/video/190132047", 
        "https://player.vimeo.com/video/190132178", 
        "https://player.vimeo.com/video/190132292"
		];

    $("html, body").animate({
    	scrollTop: 0
	}, 400);  

	$('button.btn-primary').click(function(){
    	var element = $( this ).attr( "id" );
    	var label = $( this ).attr( "alt" );

    	if( (element !== undefined) ){
    		for(var index = 0; index < videos.length; index++){
    			if(element === videos[index]){
    				
					var frame = "<div class='videoWrapper'><iframe src='"+ video_sources[index] + "' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>"
    				var video_data =  "<div class='row'><div class='col-md-8'><p class='lead'>" + label + "</p></div></div><div class='row'><div class='col-md-8'>" + frame + "</div></div><div class='row'><div class='col-md-8' style='padding-top:25px;padding-bottom:25px;'> <p><button type='button' class='btn btn-outline btn-info btn-lg' id='reload'>Go Back</button></p> </div></div>";

    				$( "#videos" ).empty(); 
    				$( "#videos" ).html( video_data );  
    				var scroll_height = $( "div#video-container" ).height();
                    $("html, body").animate({ scrollTop: scroll_height }, 500);  				
    			}

		    }
    	}
    	
    });

	$('body').on('click', 'button#reload', function(event) {
		document.location.reload(true);
	});
	
});//end document.ready