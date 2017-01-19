$(document).ready(function () {

      //Use body to handle the event for dynamic content
      $('body').on('click', 'a.btn-default', function(event) {
          event.preventDefault();
          event_id = $(this).attr( "id" );
          document.location.href = "https://" + window.location.hostname + "/programs/CCC_Symposium/rep_zone/pages/myevent.php?event_id=" + event_id;
      });

  });//end document.ready
