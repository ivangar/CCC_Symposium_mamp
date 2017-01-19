

    /*$.noConflict();*/
    $(document).ready(function () {

    	var videos = ["player1", "player2", "player3", "player4"];
    	var video_sources = [
    		"https://player.vimeo.com/video/147124274", 
    		"https://player.vimeo.com/video/190132047", 
    		"https://player.vimeo.com/video/190132178", 
    		"https://player.vimeo.com/video/190132292"
    		];

	    //this global function needs to be accessible to the loaded section in the tab
	    window.showTab = function (tab) {
				$("#v-nav ul li[tab=" + tab + "]").click();
	    }

	    // Bind the event hashchange, using jquery-hashchange-plugin
	    $(window).hashchange(function () {
			showTab(location.hash.replace("#", ""));
	    })

	    // Trigger the event hashchange on page load, using jquery-hashchange-plugin
	    $(window).hashchange();

	    $("html, body").animate({
        	scrollTop: 0
    	}, 400);  

    	$('#v-nav>ul>li').click(function(){
	    	var element = $( this ).attr( "title" );
	    	
	    	if( (element !== undefined) ){
	    		for(var index = 0; index < videos.length; index++){
	    			if(element === videos[index]){
	    				var $frame = $('iframe#' + videos[index]);
	    				$frame.attr('src', video_sources[index]);	    				
	    			}

	    			else{
	    				var $frame = $('iframe#' + videos[index]);
	    				$frame.attr('src', '');		    				
	    			}

			    }
	    	}

	    	else
	    	{
	    		for(var index = 0; index < videos.length; index++){
	    			var $frame = $('iframe#' + videos[index]);
	    			$frame.attr('src','');
			    }

	    	}
	    	
	    });

    	$('li#custom').click(function(){
	    	var element = $( this ).attr( "id" );
	    	
	    	if( (element == "custom") ){
				document.location.href = "https://" + window.location.hostname + "/programs/CCC_Symposium/rep_zone/login.html";
	    	}
	    	
	    });

	    if(section_submitted){
		    $.blockUI({ 
		        message: '\<br\>You have completed \<br\>\<br\>' +  no_sections_completed + ' section(s) out of ' + sections + '\<br\>\<br\>', 
		        fadeIn: 1500, 
		        fadeOut: 1300, 
		        timeout: 3000, 
		        showOverlay: false, 
		        centerY: false, 
		        css: { 
		            width: '300px',
		            height: '150px', 
		            top:  ($(window).height() - 200) /2 + 'px', 
		            left: ($(window).width() - 100) /2 + 'px', 
		            border: 'none', 
		            padding: '5px', 
		            textAlign: 'center',
		            font: '20px Arial,Helvetica,sans-serif',
		            backgroundColor: '#000', 
		            '-moz-border-radius': '10px',
		            '-webkit-border-radius': '10px', 
		            'border-radius': '10px',
		            opacity: .8, 
		            color: '#fff' 
		        } 
	    	}); 
		}

	    //Character limit counter for all text areas
		$('#comment_BMS_107_topic_01, #comment_BMS_107_topic_02, #comment_BMS_107_topic_03, #eval_q_3, #eval_q_4, #eval_q_5, #eval_q_6, #eval_q_7, #eval_q_8').keyup(function () {
			  var max = 500;
			  var len = $(this).val().length;
			  var limit_indicator = '.' + $(this).attr('id');
			  if (len >= max) {
			    $(limit_indicator).text('* you have reached the limit').css({ "color": "#FF0000", "font-weight": "bold", "font-size": "12px"});
			  }
			  else if(len === 0) {
			  	$(limit_indicator).text(' Max number of characters 500').css({ "color": "#666666", "font-weight": "initial", "font-size": "9px", "-webkit-transition": "all 0.5s ease", "-moz-transition": "all 0.5s ease", "-o-transition": "all 0.5s ease", "transition": "all 0.5s ease"});
			  }
			   else {
			    var character = max - len;
			    $(limit_indicator).text(character + ' characters left').css({ "color": "#666666", "font-weight": "initial", "font-size": "9px", "-webkit-transition": "all 0.5s ease", "-moz-transition": "all 0.5s ease", "-o-transition": "all 0.5s ease", "transition": "all 0.5s ease"});
			  }
		});

	    $( "#bias_yes, #bias_no" ).change(function() {
	        var $input = $( this );
	        var my_val = $input.val();

	        //Check that the check property returns true, then disable/enable accordingly
	        if($input.prop( "checked" )){
	          if(my_val === 'yes'){
	            $( "#bias_no" ).prop( "disabled", true );
	          }

	            else{
	              $( "#bias_yes" ).prop( "disabled", true );
	            }
	        }
	          
	        else{
	            $( "#bias_yes" ).prop( "disabled", false );
	            $( "#bias_no" ).prop( "disabled", false );
	        }

      	});

	});//end document.ready
