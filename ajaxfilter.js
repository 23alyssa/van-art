$(document).ready(function(){
    // alert("hello"); //check is jquery library is working
      

    $(".art_check").click(function(){
        // $("#loader").show();
        
        var action = 'data';
        var types = get_filter_text('types');
        var neighbourhood = get_filter_text('neighbourhood');
        console.log(types);
        console.log(neighbourhood);
        
        $.ajax({
            url:'browse-action.php', 
            method: 'GET', 
            data: {action: action, types: types, neighbourhood: neighbourhood},
            success:function(response){

                $("#result").html(response);
                // $("#loader").hide();
                $("#textChange").text("Filtered Artwork");
                $("#paging").hide();

            }
        })
    });

    $('.page-link a').ready(function() {
        event.preventDefault();
        var get = $(this).attr('href');
        // alert(get);
        console.log(get);    
    });  

    function get_filter_text(text_id) {
        var filterData = [];
        $('#'+text_id+':checked').each(function(){
            filterData.push($(this).val());
        });
        return filterData;
    }
});
