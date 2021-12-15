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
function form_dropdown($label,$varname,$options,$texts, $get, $id) {
    global $$varname;
    echo "<div class=\"form-group mt-4\">";
    echo "<label for=\"$varname\">$label</label>";
    echo "<select class=\"form-select art_check\" id=\"$id\" name=\"$varname\"";
    echo ">\n";
    echo "<option value=\"\" disabled selected>Select your option</option>";

    $i = 0;
    foreach($options as $opt) 
        dropdown_option($texts[$i++],$varname, $opt, $get, $id);
    echo "</select></div>";
}


// this function populates the dropdown with different options - is used within the form_dropdown function
function dropdown_option($text,$varname, $opt, $get, $id) {
    global $$varname;
    echo "<option class=\"art_check\" value=\"$opt\" ";
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
            <div class="card-body d-flex flex-column justify-content-between">
                <!-- <div> -->
                    <!-- <h5 class="text-body card-title"><?php // $row[0] ?></h5> -->
                    <p class="text-body line-height-card card-text"><?= $row[2] ?></p>
                    <?php 
                        if ($row[5]!= ""){
                            echo "<p class=\"text-body card-text\">$row[5]...</p>";
                        } else {
                            echo "<p class=\"text-body card-text\">No description avaliable</p>";
                        }
                    ?>
                    <div>
                        <a <?php echo "href=\"artwork-details.php?RegistryID=$row[0]\" "?> class="card-link">Read More</a>
                        <?php
                        // if ($art != 0) {
                            // $_SESSION['favart'] = $row[0];
                            // echo $art;
                            // echo '<form action="" method="post" class="mt-auto">';
                            // echo '<button type="submit" name="fav" id=" $row[2] "" class="btn btn-outline-primary">';
                        //     echo '<i class="bi bi-bookmark-plus-fill card-link"></i> Unfavourite';
                        //     echo '</button></form>';

                        //     require('utilities/db.php');
                        //     $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                        //     $name = $_SESSION['username'];

                        //     $sql = "DELETE FROM favorite WHERE user_id = (SELECT user_id FROM member WHERE username='$name') AND art_id = '".$art."'";
                        //     if ($connection->query($sql) ===  TRUE) {
                        //         echo "Record Deleted successfully";
                        //         // redirect_to("members.php");
                        //     } else {
                        //         echo "error deleting record";
                        //     }
                        // }
                        ?>
                    </div>
                <!-- </div> -->
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
                //add to href
                //jquery a tag page link for loop - take the href attribution
                //page &
                 
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

    function comment_form($registryID){
        ?>
        <section class="container">
            <div class="row bootstrap snippets bootdeys">
                <div class="col-md-8 col-sm-12">
                    <div class="comment-wrapper">
                        <div class="panel panel-info">
                            <h5 class="panel-heading">
                                <?php 
                                    if (!isset($_SESSION['username'])) {
                                        $username = "Please Login to Comment.";
                                    } else {
                                        $username = $_SESSION['username'];
                                    }
                                echo $username;
                                ?>
                            </h5>
                            <div class="panel-body">
                            <form action="artwork-details.php?RegistryID=<?php echo $registryID ?>" method="post">
                                <textarea class="form-control" name="comment" type="text" placeholder="Write a comment..." rows="3"></textarea>
                                <br>
                                <input type="submit" name="post" value="Post" class="btn btn-primary pull-right">
                                <div class="clearfix"></div>
                            </form>
                            <?php 

                            ?>
                        

        <?php
    }
?>

<?php 

    function comment_end(){
    echo"</div>";
    echo"</div>";
    echo"</div>";
    echo"</div>";
    echo"</div>";
    echo"</section>";
    }

?>

<?php 

    function comment_display($time, $name, $message, $user, $user_id, $comment_id, $art_id){
        ?>
        <li class="media list-group-item mb-0
        
        <?php 
            // if (!isset($_SESSION['username'])) {
            //     $user = "";
            // } else {
            //     $user = isset($_SESSION['username']);
            // }
            if ($user == $user_id){
                echo "bg-alt";
            }
                
        ?>
        
        ">
            <div class="media-body">
                <span class="text-muted pull-right">
                    <small class="text-muted"><?php echo $time; ?></small>
                </span>
                <strong class="text-primary"><?php echo $name; ?></strong>
                <p><?php echo $message; ?></p>
                <?php 
                    if ($user == $user_id){
                        echo "<a class=\"pull-right m-1 ml-1\" href=\"artwork-details.php?RegistryID=$art_id&id-delete=$comment_id\">Delete</a>";
                        echo "<a class=\"pull-right m-1\" href=\"artwork-details.php?RegistryID=$art_id&id=$comment_id\">Edit</a>";
                     }
                        
                ?>
            </div>
        </li>
        <?php
    }
?>

<?php 

    function comment_edit($registryID, $comment_id, $user, $user_id){
        if ($user == $user_id){
        ?>
        <li class="media list-group-item mb-0
        <?php 
            if ($user == $user_id){
                echo "bg-primary";
            }     
        ?>
        ">
            <div class="media-body">
            <form action="artwork-details.php?RegistryID=<?php echo $registryID ?>&id=<?php echo $comment_id ?>" method="post">
                        <textarea class="form-control" name="comment-update" type="text" placeholder="Write a comment..." rows="3"></textarea>
                        <br>
                        <a class="text-dark m-1" href="artwork-details.php?RegistryID=<?php echo $registryID ?>">Close</a>
                        <input type="submit" name="update" value="update" class="btn btn-light pull-right">
                    </form>
            </div>
        </li>
        <?php
        }
    }
?>

<?php 

    function comment_delete($connection, $idvalue, $comment_id_delete, $user, $user_id){
        if ($user == $user_id){
            if( isset($_GET[$idvalue])) {
                $sqlCommentDelete = "DELETE FROM comment
                WHERE comment_id = ".$comment_id_delete.";" ;

                if(mysqli_query($connection, $sqlCommentDelete)){
                    echo "<p>Succesfully deleted</p>"; 
                } else {
                    echo "Opps there was an erorr: . " 
                        . mysqli_error($connection);
                }

            }
            header("Refresh:0");
        }
    }
?>


<?php 
    // Derek's function code
    function is_logged_in() {
        if(!isset($_SESSION['username'])) {redirect_to(url_for('/login.php'));}
    }

    function url_for($script_path) {
        // add the leading '/' if not present
        if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
        }
        return WWW_ROOT . $script_path;
    }

    function h($string="") {
        return htmlspecialchars($string);
    }

    function error_404() {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        exit();
    }
    
    function error_500() {
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        exit();
    }
    
    function redirect_to($location) {
        header("Location: " . $location);
        exit;
    }
    
    function is_post_request() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
    
    function is_get_request() {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }
    
    function display_errors($errors=array()) {
        $output = '';
        if(!empty($errors)) {
        $output .= "<div class=\"errors\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach($errors as $error) {
            $output .= "<li>" . h($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
        }
        return $output;
    }

    function get_user_id($connection) {
        if (!isset($_SESSION['username'])) {
            redirect_to("login.php");
        } else {
        $name = $_SESSION['username'];
        $sql = "SELECT user_id FROM member WHERE username='$name'";
        $result = $connection ->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['user_id'];
        }
    }

    function get_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
        {
        return $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
        return $_SERVER['REMOTE_ADDR'];
        }
    }
?>

<?php
// <!-- carosel -->
// this function opens the tag for the form
function make_query($connect) {
 $query = "SELECT PhotoURL, Neighbourhood FROM `public_art` LIMIT 4;";
 $result = mysqli_query($connect, $query);
 return $result;
}

function carousel(){
    ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block carousel-size" src="assets/mural.jpg" data-src="holder.js/900x400?theme=social" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block carousel-size" src="assets/mural.jpg" data-src="holder.js/900x400?theme=industrial" alt="Second slide">
                    </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
            </a>
        </div>
    <?php
}

function make_slide_indicators($connect) {
    $output = ''; 
    $count = 0;
    $result = make_query($connect);
    while($row = mysqli_fetch_array($result)) {
        if($count == 0) {
             $output .= '<li data-target="#dynamic_slide_show" data-slide-to="'.$count.'" class="active"></li>';
        } else {
            $output .= ' <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'"></li>';
        }
        $count = $count + 1;
    }
    return $output;
}

function make_slides($connect) {
    $output = '';
    $count = 0;
    $result = make_query($connect);
    while($row = mysqli_fetch_array($result)) {
        if($count == 0) {
            $output .= '<div class="item active">';
        } else {
            $output .= '<div class="item">';
        }
        $output .= '<img src='.$row["PhotoURL"].' alt='.$row["Neighbourhood"].' /> <div class="carousel-caption"><h3>'.$row["Neighbourhood"].'</h3></div></div>';
        $count = $count + 1;
    }
 return $output;
}



?>