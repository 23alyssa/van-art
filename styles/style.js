$(document).ready(function(){
    // alert("hello"); //check is jquery library is working

    $(".heart.fa").click(function() {
        $(this).toggleClass("fa-heart fa-heart-o");
        // create boolean value
        var x = 1;
        var user_id=$("#user_id").val();
        var art_id=$("#art_id").val();

        $.ajax({
          url:'artwork-details.php',
          method:'POST',
          data: {
            user_id:user_id,
            art_id:art_id
          },
          success:function(data) {
            alert(data);
          }
        });
      });

      $(".upvote.far").click(function() {
        console.log("vote");
        $(this).toggleClass("fas far");
      });

      let map;

      function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: -34.397, lng: 150.644 },
          zoom: 8,
        });
      }
      
});