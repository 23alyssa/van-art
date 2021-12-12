$(document).ready(function(){
    // alert("hello"); //check is jquery library is working
    
    $(".heart.fa").click(function() {
        $(this).toggleClass("fa-heart fa-heart-o");
      });

      $(".upvote.far").click(function() {
        console.log("vote");
        $(this).toggleClass("fas far");
      });
});