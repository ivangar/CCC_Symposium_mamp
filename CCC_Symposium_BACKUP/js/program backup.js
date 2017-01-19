

    /*$.noConflict();*/
    $(document).ready(function () {

    	var videos = ["player1", "player2", "player3", "player4", "player5", "player6"];
    	var video_sources = [
    		"https://player.vimeo.com/video/147124274", 
    		"https://player.vimeo.com/video/147124339", 
    		"https://player.vimeo.com/video/147124349", 
    		"https://player.vimeo.com/video/147124358",
    		"https://player.vimeo.com/video/147374656",
    		"https://player.vimeo.com/video/147124393"
    		];
/*
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
*/

    	$('#v-nav>ul>li').click(function(){
	    		 document.location.reload(true); 
	    	
	    });

	    if(section_submitted){
		    $.blockUI({ 
		        message: '\<br\>You have completed \<br\>\<br\>' +  no_sections_completed + ' section(s) out of 2 \<br\>\<br\>', 
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
		$('#comment_SPC_topic_01, #comment_SPC_topic_02, #comment_SPC_topic_03, #eval_q_1, #eval_q_2, #eval_q_3, #eval_q_4, #eval_q_7, #eval_q_9').keyup(function () {
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

	    $( "#challenged_yes, #challenged_no" ).change(function() {
	        var $input = $( this );
	        var my_val = $input.val();

	        //Check that the check property returns true, then disable/enable accordingly
	        if($input.prop( "checked" )){
	          if(my_val === 'yes'){
	            $( "#challenged_no" ).prop( "disabled", true );
	          }

	            else{
	              $( "#challenged_yes" ).prop( "disabled", true );
	            }
	        }
	          
	        else{
	            $( "#challenged_yes" ).prop( "disabled", false );
	            $( "#challenged_no" ).prop( "disabled", false );
	        }

      	});

      	$( "#disclosure_notsure, #disclosure_yes, #disclosure_no" ).change(function() {
          var $input = $( this );
          var my_val = $input.val();

          //Check that the check property returns true, then disable/enable accordingly
          if($input.prop( "checked" )){
            if(my_val === "Not sure"){
              $( "#disclosure_yes" ).prop( "disabled", true );
              $( "#disclosure_no" ).prop( "disabled", true );
            }

            else if(my_val === "Yes"){
              $( "#disclosure_notsure" ).prop( "disabled", true );
              $( "#disclosure_no" ).prop( "disabled", true );
            }

            else if(my_val === "No"){
              $( "#disclosure_yes" ).prop( "disabled", true );
              $( "#disclosure_notsure" ).prop( "disabled", true );
            }
          }
          
          else{
            $( "#disclosure_yes" ).prop( "disabled", false );
            $( "#disclosure_notsure" ).prop( "disabled", false );
            $( "#disclosure_no" ).prop( "disabled", false );
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

      	$( "#ethics_yes, #ethics_no" ).change(function() {
	        var $input = $( this );
	        var my_val = $input.val();

	        //Check that the check property returns true, then disable/enable accordingly
	        if($input.prop( "checked" )){
	          if(my_val === 'yes'){
	            $( "#ethics_no" ).prop( "disabled", true );
	          }

	            else{
	              $( "#ethics_yes" ).prop( "disabled", true );
	            }
	        }
	          
	        else{
	            $( "#ethics_yes" ).prop( "disabled", false );
	            $( "#ethics_no" ).prop( "disabled", false );
	        }

      	});


	});//end document.ready
