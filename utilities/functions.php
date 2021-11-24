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
function form_check($label,$varname,$options,$texts, $get) {
    global $$varname;
	echo "<div class=\"form-group mt-4\">";
    echo"<label for=\"$varname\">$label</label><div>";
    
    $i = 0;
    foreach($options as $opt) 
        form_check_option($texts[$i++],$varname, $opt, $get);
        
	echo "</div>";
}

//this function populates the information for the checkbox
function form_check_option($text,$varname, $opt, $get) {
    global $$varname;
    echo"<div class=\"form-check\">";
    echo "<input class=\"form-check-input\" type=\"checkbox\" name=\"$varname\" value=\"$opt\" ";
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
    echo "<input class=\"btn btn-primary btn-lg\" type=\"submit\" name=\"submit-search\" value=\"Search Orders\">";
    echo "</div></div></div>";
    echo "</form>";
}

?>

<?php function createCard(array $row) { ?>
    <!-- <div class="col-4"> -->
        <div class="card col-sm-8 col-md-5 col-lg-4 col-xl-3 m-1">
        <a class="text-decoration-none" href="#">
            <img height="250"
                 width="250"
                 class="card-img-top2"
                 
                 <?php 
                 echo "src=\"";
                 $i = 0;
                while ($i < count($row)) {
                    if($row[1] == ""){
                        echo "assets/no-image.png\"";
                    } else if($row[1] != "") {
                        echo $row[1];
                        echo "\"";
                    }
                    $i++;
                }
                 ?>
            >
            <div class="card-body">
                <h5 class="text-body card-title"><?= $row[0] ?></h5>
                <p class="text-body line-height-card card-text">Price : <?= $row[2] ?></p>
                <p class="text-body card-text"><?= $row[3]?>...</p>
                <a href="#!" class="card-link">Read More</a>
            </div>
            </a>
        </div>
    <!-- </div> -->
<?php } ?>


<?php 

function paging($query){

    //define total number of results you want per page  
    $results_per_page = 25;  
  
    //find the total number of results stored in the database  
    // $query = "select *from alphabet";  
    $result = mysqli_query($connection, $query);  
    $number_of_result = mysqli_num_rows($result);  
  
    //determine the total number of pages available  
    $number_of_page = ceil ($number_of_result / $results_per_page);  
  
    //determine which page number visitor is currently on  
    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }  
  
    //determine the sql LIMIT starting number for the results on the displaying page  
    $page_first_result = ($page-1) * $results_per_page;  
  
    //retrieve the selected results from database   
    $query = "SELECT *FROM alphabet LIMIT " . $page_first_result . ',' . $results_per_page;  
    $result = mysqli_query($connection, $query);  
      
    //display the retrieved result on the webpage  
    while ($row = mysqli_fetch_array($result)) {  
        echo $row['id'] . ' ' . $row['alphabet'] . '</br>';  
    }  
  
  
    //display the link of the pages in URL  
    for($page = 1; $page<= $number_of_page; $page++) {  
        echo '<a href = "browse.php?page=' . $page . '">' . $page . ' </a>';  
    }  

}

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