<?php
// <!-- functions.php -->

// <!-- browse.php - functions -->

// this function opens the tag for the form
function form_start() {
    echo "<div>";
    // echo "<div class='container-fluid'>";
    // echo "<div class='row mb-3'>";
}

//this function creates the checkbox for filtering
function form_check($label,$varname,$options,$texts, $get, $id) {
    global $$varname;
	echo "<div class=\"form-group mt-4\">";
    echo"<label for=\"$varname\">$label</label><div>";
    
    $i = 0;
    foreach($options as $opt) 
        form_check_option($texts[$i++],$varname, $opt, $get, $id);
        
	echo "</div>";
}

//this function populates the information for the checkbox
function form_check_option($text, $varname, $opt, $get, $id) {
    global $$varname;
    echo"<div class=\"form-check\">";
    echo "<input class=\"form-check-input art_check\" type=\"checkbox\" name=\"$varname\" id=\"$id\" value=\"$opt\" ";
    //check if the get variable is set, then loop through the checkbox array
    // for each item in the get array check if it is equal to the current option - if yes then it has been selected
    if(isset($get)) {
        foreach($get as $item) {
            if($item == $opt) {
                echo "checked='checked'";
            }
        }
    }
    echo ">$text\n";
    echo "</div>";
}

// this function creates the dropdown menu according to the options 
function form_dropdown($label,$varname,$options,$texts, $get) {
    global $$varname;
    echo "<div class=\"form-group mt-4\">";
    echo "<label for=\"$varname\">$label</label>";
    echo "<select class=\"form-select\" name=\"$varname\"";
    echo ">\n";
    echo "<option value=\"\" disabled selected>Select your option</option>";

    $i = 0;
    foreach($options as $opt) 
        dropdown_option($texts[$i++],$varname, $opt, $get);
    echo "</select></div>";
}


// this function populates the dropdown with different options - is used within the form_dropdown function
function dropdown_option($text,$varname, $opt, $get) {
    global $$varname;
    echo "<option value=\"$opt\" ";
     //store the selected option after submitting form
    if(isset($get)) {
        if($get == $opt) {
            echo "selected='selected'";
        }
    }
    // if (!empty($$varname) && $$varname==$opt ) echo "selected"; 
    echo ">$text</option>\n";
}

// this function ends the form and creates a submit button
function form_end() {  
    echo "</div>";
	echo "<div class=\"form-group mt-4\">"; 
    // echo "<input class=\"btn btn-primary btn-lg\" type=\"submit\" name=\"submit-filter\" value=\"Filter Art\">";
    echo "</div></div></div>";
    // echo "</form>";
}

?>

<?php function createCard(array $row) { ?>
    <!-- <div class="col-4"> -->

        <div class="card col-sm-8 col-md-5 col-lg-4 col-xl-3 m-1">
        <a class="text-decoration-none" <?php echo "href=\"artwork-details.php?RegistryID=$row[0]\" "?> >
            <img height="250"
                 width="250"
                 class="card-img-top2"
                 
                 <?php 
                 echo "src=\"";
                 if (count($row)>=0){
                    if($row[1] == ""){
                        echo "assets/no-image.png\"";
                    } else if($row[1] != "") {
                        echo $row[1];
                        echo "\"";
                    }
                }
                 ?>
            >
            <div class="card-body">
                <h5 class="text-body card-title"><?= $row[0] ?></h5>
                <p class="text-body line-height-card card-text"><?= $row[2] ?></p>
                <p class="text-body card-text"><?= $row[3]?>...</p>
                <a <?php echo "href=\"artwork-details.php?RegistryID=$row[0]\" "?> class="card-link">Read More</a>
            </div>
            </a>
        </div>
    <!-- </div> -->
<?php } ?>

<?php function paging($page, $number_of_page, $curPage) { ?>
    <nav aria-label="Browse additional pages" class="table-responsive mt-5">
        <ul class="pagination justify-content-center flex-wrap">
            <li class="page-item">
            <a class="page-link" 
            <?php 
                    $prev = $curPage-1;
                    echo "href = \"browse.php?page=$prev\" ";
            ?> 
            aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
            </li>
            <?php 

                //display the link of the pages in URL  
                for($page = 1; $page<= $number_of_page; $page++) {  
                    echo "<li class=\"page-item\"><a class=\"page-link\" href = \"browse.php?page=$page\">$page</a></li>";   
                }  
                 
            ?>
            <a class="page-link" 
                <?php 
                    $next = $curPage+1;
                    echo "href = \"browse.php?page=$next\"";
                ?> 
            aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
            </li>
        </ul>
    </nav>

<?php } ?>


<?php 

?>

<?php
// <!-- carosel -->
// this function opens the tag for the form
// function make_query($connect) {
//  $query = "SELECT PhotoURL, Neighbourhood FROM `public_art` LIMIT 5;";
//  $result = mysqli_query($connect, $query);
//  return $result;
// }

// function make_slide_indicators($connect) {
//     $output = ''; 
//     $count = 0;
//     $result = make_query($connect);
//     while($row = mysqli_fetch_array($result)) {
//         if($count == 0) {
//              $output .= '<li data-target="#dynamic_slide_show" data-slide-to="'.$count.'" class="active"></li>';
//         } else {
//             $output .= ' <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'"></li>';
//         }
//         $count = $count + 1;
//     }
//     return $output;
// }

// function make_slides($connect) {
//     $output = '';
//     $count = 0;
//     $result = make_query($connect);
//     while($row = mysqli_fetch_array($result)) {
//         if($count == 0) {
//             $output .= '<div class="item active">';
//         } else {
//             $output .= '<div class="item">';
//         }
//         $output .= '<img src='.$row["PhotoURL"].' alt='.$row["Neighbourhood"].' /> <div class="carousel-caption"><h3>'.$row["Neighbourhood"].'</h3></div></div>';
//         $count = $count + 1;
//     }
//  return $output;
// }



?>