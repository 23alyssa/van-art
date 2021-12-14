$(document).ready(function(){
    // alert("hello"); //check is jquery library is working

    $("#year").on('change', function(){
        // console.log("list item selected");
        var action2 = 'data';
        var year = [];
        year.push($(this).val());    
        console.log(year);

        $.ajax({
            url:'browse-action.php', 
            method: 'GET', 
            data: { action2: action2, year: year},
            success:function(response){

                $("#result").html(response);

            }
        })
    });
      

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
                $('.textChange').text("Filtered Artwork");
                $("#paging").hide();

            }
        })
    });



    // $('.page-link a').ready(function() {
    //     event.preventDefault();
    //     var get = $(this).attr('href');
    //     // alert(get);
    //     console.log(get);    
    // });  

    function get_filter_text(text_id) {
        var filterData = [];
        $('#'+text_id+':checked').each(function(){
            filterData.push($(this).val());
        });
        return filterData;
    }

    function get_filter_select(select_id) {
        var filterData = [];
        $('#'+select_id + ':selected').each(function(){
            filterData.push($(this).val());
        });
        return filterData;
    }
});
