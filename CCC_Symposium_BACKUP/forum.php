
<script type="text/javascript">
    /*$.noConflict();*/
    $(document).ready(function () {

      //SETUP TOPIC VARIABLES THAT DEFINED IN MAIN PROGRAM PAGE
      var topic1 = <?php if(isset($topicIds['0'])) {echo  " '$topicIds[0]' ";} else echo ''; ?>;
      var topic2 = <?php if(isset($topicIds['1'])) {echo  " '$topicIds[1]' ";} else echo ''; ?>;
      var topic3 = <?php if(isset($topicIds['2'])) {echo  " '$topicIds[2]' ";} else echo ''; ?>;

       // Responds to click next previous section event
      $( ".accred_reqs" ).click(function() {
          
          var target = $(this).attr( "title" );
          window.parent.showTab(target);
          
      });

     //Make a general chain for toggle sections and switch the id of the clicked item.
      $( "#toggle_post_BMS_107_topic_01, #toggle_post_BMS_107_topic_02, #toggle_post_BMS_107_topic_03, #toggle_comments_BMS_107_topic_01, #toggle_comments_BMS_107_topic_02, #toggle_comments_BMS_107_topic_03" ).click(function() {
         var clickedItem = $(this).attr( "id" );
         var toogleItem = '';
       
         switch (clickedItem)
         {
         case 'toggle_post_BMS_107_topic_01':
           toogleItem="#BMS_107_topic_01_form";
           break;
         case 'toggle_post_BMS_107_topic_02':
           toogleItem="#BMS_107_topic_02_form";
           break;
         case 'toggle_post_BMS_107_topic_03':
           toogleItem="#BMS_107_topic_03_form";
           break;
         case 'toggle_comments_BMS_107_topic_01':
           toogleItem="#comments_BMS_107_topic_01";
           break;
         case 'toggle_comments_BMS_107_topic_02':
           toogleItem="#comments_BMS_107_topic_02";
           break;
         case 'toggle_comments_BMS_107_topic_03':
           toogleItem="#comments_BMS_107_topic_03";
           break;
         }

          //Toggle the item
         $(toogleItem).toggle( "slow", function() {
         });

      });

      //Submit form listeners
     $( "#BMS_107_topic_01_form, #BMS_107_topic_02_form, #BMS_107_topic_03_form" ).submit(function( event ) {

          var submittedForm = $(this).attr( "id" );
          var comment = '';
          var topic = '';

          // customize Parsley errors class to append the errorwraper ul inside the container div specified
          $( '#' + submittedForm ).parsley( {
              errors: {
                  container: function (element) {
                      var $container = element.parent().find(".parsley-container");
                      if ($container.length === 0) {
                          $container = $("<div class='parsley-container forum'></div>").insertBefore(element);
                      }
                      return $container;
                  }
              }
          } );

          //since the form is submitted using jQuery event, bind the form with Parsley.
          var form_valid = $( '#' + submittedForm ).parsley( 'validate' );
          
          //prevent form submission if parsley returns false
          if ( !form_valid )
          {
              event.preventDefault();
          }
          
          else{

            //Swith the form that was submitted and set comment and topic id to be sent through Ajax
            switch (submittedForm)
            {
               case 'BMS_107_topic_01_form':
                 comment = $('textarea#comment_BMS_107_topic_01').val();
                 topic = topic1;
                 break;
                case 'BMS_107_topic_02_form':
                 comment = $('textarea#comment_BMS_107_topic_02').val();
                 topic = topic2;
                 break;
                case 'BMS_107_topic_03_form':
                 comment = $('textarea#comment_BMS_107_topic_03').val();
                 topic = topic3;
                 break;
               default:
                 comment="";
                 topic="";
            }

          forum_submitted = { "topic":topic, "comment":comment, "submit_comment":1}; 
          target = "/programs/lib/php/forum_topics.php";
          
          // make an ajax call to save answers in the database
          $.ajax({
              url: target,
              cache: false,
              type: "POST",
              dataType: "html",
              data: forum_submitted
            }) 

          .done(function( data ) {
              if (data === "posted"){
                  document.location.reload(true); //reload page in order to update access to post-test form
              }

              if (data === "failed"){
                    $( ".parsley-container" ).html( "<ul style='width:562px;font-weight:bold;'> <li>There was an error posting your comment. Try again. </li></ul>" );
                    $( ".parsley-container" ).show();
                    $("html, body").animate({
                          scrollTop: 0
                    }, 500);    
              }

          })
          .fail(function() {
                    $( ".parsley-container" ).html( "<ul style='width:562px;font-weight:bold;'> <li>There was an error posting your comment. Try again. </li></ul>" );
                    $( ".parsley-container" ).show();
                    $("html, body").animate({
                          scrollTop: 0
                    }, 500);    
          }); //ajax call
        
        }//end else
        
          event.preventDefault();

      }); //click function   


     /*--------------------------LOAD TOPIC 1-------------------------------------------------   */

     $("#BMS_107_topic_01").load("/programs/lib/php/forum_topics.php?action=get_rows&topic_id=" + topic1);

      //This is called the first time the document loads
      $.get("/programs/lib/php/forum_topics.php?action=row_count&topic_id=" + topic1, function(data) {
        $("#page_count_BMS_107_topic_01").val(Math.ceil(data / 10)); //Sets hidden input field with the number of pages (total rows/10)
        generateRows(1, topic1);
      });

      /*--------------------------LOAD TOPIC 2-------------------------------------------------   */

      $("#BMS_107_topic_02").load("/programs/lib/php/forum_topics.php?action=get_rows&topic_id=" + topic2);

      //This is called the first time the document loads
      $.get("/programs/lib/php/forum_topics.php?action=row_count&topic_id=" + topic2, function(data) {
        $("#page_count_BMS_107_topic_02").val(Math.ceil(data / 10)); //Sets hidden input field with the number of pages (total rows/10)
        generateRows(1, topic2);
      });

      /*--------------------------LOAD TOPIC 3-------------------------------------------------   */

      $("#BMS_107_topic_03").load("/programs/lib/php/forum_topics.php?action=get_rows&topic_id=" + topic3);

      //This is called the first time the document loads
      $.get("/programs/lib/php/forum_topics.php?action=row_count&topic_id=" + topic3, function(data) {
        $("#page_count_BMS_107_topic_03").val(Math.ceil(data / 10)); //Sets hidden input field with the number of pages (total rows/10)
        generateRows(1, topic3);
      });

  });//end document.ready

function generateRows(selected, topicId) {
  var pages = $("#page_count_" + topicId).val();  //number of pages in the hidden input field
  //selected is the field passed to this function (number of pages)
  
  if (pages <= 5) {
    //inserts all numbers after content
    $("#" + topicId).after("<div id='paginator_" + topicId + "'><ul class='pagor_group'><li class='pagor_" + topicId + " selected'>1</li><li class='pagor_" + topicId + "'>2</li><li  class='pagor_" + topicId + "'>3</li><li  class='pagor_" + topicId + "'>4</li><li  class='pagor_" + topicId + "'>5</li><div style='clear:both;'></div></ul></div>");
    //inserts rows based on the index of the number
    $(".pagor_" + topicId).click(function() {
      var index = $(".pagor_" + topicId).index(this);
      $("#" + topicId).load("/programs/lib/php/forum_topics.php?action=get_rows&topic_id=" + topicId + "&start=" + index);
      $(".pagor_" + topicId).removeClass("selected");
      $(this).addClass("selected");
    });   
  } else {
    if (selected < 5) {  
      // Draw the first 5 then have ... link to last
      var pagers = "<div id='paginator_" + topicId + "'><ul class='pagor_group'>";
      for (i = 1; i <= 5; i++) {
        if (i == selected) {
          pagers += "<li class='pagor_" + topicId + " selected'>" + i + "</li>";
        } else {
          pagers += "<li class='pagor_" + topicId + "'>" + i + "</li>";
        }       
      }
      //last number should be 5 with ... before
      pagers += "<div style='float:left;padding-left:6px;padding-right:6px;'>...</div><li class='pagor_" + topicId + "'>" + Number(pages) + "</li><div style='clear:both;'></div></ul></div>";
      
      $("#paginator_" + topicId + "").remove();
      $("#" + topicId).after(pagers);
      $(".pagor_" + topicId).click(function(  ) {
        updatePage(this, topicId);
      });
    } else if (selected > (Number(pages) - 4)) {
      // Draw ... link to first then have the last 5
      var pagers = "<div id='paginator_" + topicId + "'><ul class='pagor_group'><li class='pagor_" + topicId + "'>1</li><div style='float:left;padding-left:6px;padding-right:6px;'>...</div>";
      for (i = (Number(pages) - 4); i <= Number(pages); i++) {
        if (i == selected) {
          pagers += "<li class='pagor_" + topicId + " selected'>" + i + "</li>";
        } else {
          pagers += "<li class='pagor_" + topicId + "'>" + i + "</li>";
        }       
      }     
      pagers += "<div style='clear:both;'></div></ul></div>";
      
      $("#paginator_" + topicId + "").remove();
      $("#" + topicId).after(pagers);
      $(".pagor_" + topicId).click(function( ) {
        updatePage(this, topicId);
      });   
    } else {
      // Draw the number 1 element, then draw ... 2 before and two after and ... link to last
      var pagers = "<div id='paginator_" + topicId + "'><ul class='pagor_group'><li class='pagor_" + topicId + "'>1</li><div style='float:left;padding-left:6px;padding-right:6px;'>...</div>";
      for (i = (Number(selected) - 2); i <= (Number(selected) + 2); i++) {
        if (i == selected) {
          pagers += "<li class='pagor_" + topicId + " selected'>" + i + "</li>";
        } else {
          pagers += "<li class='pagor_" + topicId + "'>" + i + "</li>";
        }
      }
      pagers += "<div style='float:left;padding-left:6px;padding-right:6px;'>...</div><li class='pagor_" + topicId + "'>" + pages + "</li><div style='clear:both;'></div></ul></div>";
      
      $("#paginator_" + topicId + "").remove();
      $("#" + topicId).after(pagers);
      $(".pagor_" + topicId).click(function( ) {
        updatePage(this, topicId);
      });     
    }
  }
}

function updatePage(elem, topicId) {
  // Retrieve the number stored and position elements based on that number
  var selected = $(elem).text();

  // First update 
  $("#" + topicId).load("/programs/lib/php/forum_topics.php?action=get_rows&topic_id=" + topicId + "&start=" + (selected - 1));
  
  // Then update links
  generateRows(selected, topicId);
}
</script>
<table border="0" cellspacing="0">
<tr valign="top">
<td style="padding:0;width:620px;">
<div id="intro">
<h2 style="margin:0 0 15px 0;">Discussion Forum</h2>
<h3 style="line-height:25px;">You must post a comment on at least 1 topic in this program’s Discussion Forum before accreditation is granted and your certificate is made available. To receive your certificate please <span class="accred_reqs" title="tab7">click here</span>. Note, if you have any unmet accreditation requirements, you will be directed to a list of documents that need to be completed in order to receive your certificate.
</h3>
<hr/>
<?php if(isset($_SESSION['posted']) && $_SESSION['posted']) { echo "<h3 id='assessment'>Thank you for your participation in this program’s Discussion Forum.</h3>"; unset($_SESSION['posted']); }?>
<div class="parsley-container" style="display:none;"> </div>
<div class="question forum" ><p>1) What are the strengths and weaknesses of real-world data compared to data from randomized controlled trials?</p>
</div>

<!-- THIS SECTION IS A TOGGLE -->
<div class="toggle" >
    <p id="toggle_post_BMS_107_topic_01" ><sub style="font-size:15px;">&#8618;</sub> Add your comment</p> 
    <p id="toggle_comments_BMS_107_topic_01">&nbsp;&nbsp;<sub style="font-size:15px;">&#8618;</sub> View comments </p>
</div>
<!-- THIS SECTION IS A TOGGLE -->

<!-- THIS SECTION IS A FORM -->
<form class="jotform-form" action="" method="POST" data-ajax="false" name="BMS_107_topic_01_form" id="BMS_107_topic_01_form" accept-charset="utf-8" style="display:none;">
  <div class="program_evaluation" style="width:600px;">
    <ul class="form-section">
      <li class="form-line" style="margin:0;padding:0;">
          <textarea class="form-textarea" name="comment" parsley-required="true" parsley-error-message="Please type a comment (Max number of characters 500)" parsley-maxlength="500" id="comment_BMS_107_topic_01" rows="5" style="width: 600px;max-width: 600px;margin:0;padding:0;"></textarea>
          <div class="form-textarea-limit-indicator"><span class="comment_BMS_107_topic_01">Max number of characters 500</span>
              </div>
      </li>
      <li id="BMS_107_topic_01_actions">
          <div style="padding:10px 0 15px 0;" class="form-buttons-wrapper">
            <button id="submit_BMS_107_topic_01_form" type="submit" class="form-submit-button-cool_grey_rounded" >Post</button>
            <button id="reset_BMS_107_topic_01_form" type="reset" class="form-submit-button-cool_grey_rounded">Clear</button>
          </div>
      </li>
    </ul>
  </div>
</form>
<!-- THIS SECTION IS A FORM -->

<!-- THIS SECTION IS A PAGINATION -->
<div class="pagination" id="comments_BMS_107_topic_01" style="display:none;">
    <div id="BMS_107_topic_01"></div>
  <input type="hidden" name="page_count_BMS_107_topic_01" id="page_count_BMS_107_topic_01" />
</div>
<!-- THIS SECTION IS A PAGINATION -->

<div class="question forum">
<p>2) When presented with a NVAF patient, which risk scoring system do you use for determining whether or not to offer OAC therapy for stroke prevention? Please explain why. </p>
</div>

<!-- THIS SECTION IS A TOGGLE -->
<div class="toggle" ><p id="toggle_post_BMS_107_topic_02" ><sub style="font-size:15px;">&#8618;</sub> Add your comment</p> <p id="toggle_comments_BMS_107_topic_02">&nbsp;&nbsp;<sub style="font-size:15px;">&#8618;</sub> View comments </p></div>
<!-- THIS SECTION IS A TOGGLE -->

<!-- THIS SECTION IS A FORM -->
<form class="jotform-form" action="" method="POST" data-ajax="false" name="BMS_107_topic_02_form" id="BMS_107_topic_02_form" accept-charset="utf-8" style="display:none;">
  <div class="program_evaluation" style="width:600px;">
    <ul class="form-section">
      <li class="form-line" style="margin:0;padding:0;">
          <textarea class="form-textarea" name="comment" parsley-required="true" parsley-error-message="Please type a comment (Max number of characters 500)" parsley-maxlength="500" id="comment_BMS_107_topic_02" rows="5" style="width: 600px;max-width: 600px;margin:0;padding:0;"></textarea>
          <div class="form-textarea-limit-indicator"><span class="comment_BMS_107_topic_02" >Max number of characters 500</span>
              </div>
      </li>
      <li id="BMS_107_topic_02_actions">
          <div style="padding:10px 0 15px 0;" class="form-buttons-wrapper">
            <button id="submit_BMS_107_topic_02_form" type="submit" class="form-submit-button-cool_grey_rounded" >Post</button>
            <button id="reset_BMS_107_topic_02_form" type="reset" class="form-submit-button-cool_grey_rounded">Clear</button>
          </div>
      </li>
    </ul>
  </div>
</form>
<!-- THIS SECTION IS A FORM -->

<!-- THIS SECTION IS A PAGINATION -->
<div class="pagination" id="comments_BMS_107_topic_02" style="display:none;">
    <div id="BMS_107_topic_02"></div>
  <input type="hidden" name="page_count_BMS_107_topic_02" id="page_count_BMS_107_topic_02" />
</div>
<!-- THIS SECTION IS A PAGINATION -->

<div class="question forum">
<p>3) In terms of efficacy, which DOACs would you recommend for use in a patient with AF with a high risk of stroke? Please explain why.</p>
</div>

<!-- THIS SECTION IS A TOGGLE -->
<div class="toggle" ><p id="toggle_post_BMS_107_topic_03" ><sub style="font-size:15px;">&#8618;</sub> Add your comment</p> <p id="toggle_comments_BMS_107_topic_03"> &nbsp;&nbsp;<sub style="font-size:15px;">&#8618;</sub> View comments </p></div>
<!-- THIS SECTION IS A TOGGLE -->

<!-- THIS SECTION IS A FORM -->
<form class="jotform-form" action="" method="POST" data-ajax="false" name="BMS_107_topic_03_form" id="BMS_107_topic_03_form" accept-charset="utf-8" style="display:none;">
  <div class="program_evaluation" style="width:600px;">
    <ul class="form-section">
      <li class="form-line" style="margin:0;padding:0;">
          <textarea class="form-textarea" name="comment" parsley-required="true" parsley-error-message="Please type a comment (Max number of characters 500)" parsley-maxlength="500" id="comment_BMS_107_topic_03" rows="5" style="width: 600px;max-width: 600px;margin:0;padding:0;"></textarea>
          <div class="form-textarea-limit-indicator"><span class="comment_BMS_107_topic_03" >Max number of characters 500</span>
              </div>
      </li>
      <li id="BMS_107_topic_03_actions">
          <div style="padding:10px 0 15px 0;" class="form-buttons-wrapper">
            <button id="submit_BMS_107_topic_03_form" type="submit" class="form-submit-button-cool_grey_rounded" >Post</button>
            <button id="reset_BMS_107_topic_03_form" type="reset" class="form-submit-button-cool_grey_rounded">Clear</button>
          </div>
      </li>
    </ul>
  </div>
</form>
<!-- THIS SECTION IS A FORM -->

<!-- THIS SECTION IS A PAGINATION -->
<div class="pagination" id="comments_BMS_107_topic_03" style="display:none;">
    <div id="BMS_107_topic_03"></div>
  <input type="hidden" name="page_count_BMS_107_topic_03" id="page_count_BMS_107_topic_03" />
</div>
<!-- THIS SECTION IS A PAGINATION -->


</td>
  </tr>
</table>
