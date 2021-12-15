$(document).ready(function(){
    // alert("hello"); //check is jquery library is working

    $("#year").on('change', function(){
        // detect if a year in the drop down list has been selected

        //set the data
        var action2 = 'data';
        var year = [];
        year.push($(this).val());    
        // console.log(year);

        $.ajax({
            url:'browse-action.php', 
            method: 'GET', 
            data: { action2: action2, year: year},
            success:function(response){

                //add the years to the results section in browse to update the cards
                $("#result").html(response);

            }
        })
    });
      

    $(".art_check").click(function(){
        //check if a filter was selected 
        //all checkboxes have class .art_check 

        //show the loading gif
        $("#loader").show();
     
        //set the data
        var action = 'data';
        var types = get_filter_text('types');
        var neighbourhood = get_filter_text('neighbourhood');
        // console.log(types);
        // console.log(neighbourhood);
         
        $.ajax({
            url:'browse-action.php', 
            method: 'GET', 
            data: {action: action, types: types, neighbourhood: neighbourhood},
            success:function(response){

                //hide the loader and show the results
                $("#result").html(response);
                $("#loader").hide();
                $('.textChange').text("Filtered Artwork");
                $("#paging").hide();

            }
        })
    }); 

    //function to get the checkbox values
    function get_filter_text(text_id) {
        var filterData = [];
        $('#'+text_id+':checked').each(function(){
            filterData.push($(this).val());
        });
        return filterData;
    }
});
