<?php
// this page contains all the funcitons used throughout the entire program 

// this function opens the tag for the form
function form_start() {
    echo "<div>";

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
    echo "</div></div></div>";
    // echo "</form>";
}

?>

<?php function createCard(array $row) { ?>
    <!-- this class is responsible for populating the card information from the public art database -->

    <div class="card col-sm-8 col-md-5 col-lg-4 col-xl-3 m-1">
        <a class="text-decoration-none" <?php echo "href=\"artwork-details.php?RegistryID=$row[0]\" "?> >
            <img height="250"
                 width="250"
                 class="card-img-top2"
                 
                 <?php 
                 //check if the photoURL is empty - display no image
                 //else display the photoURL
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
            <!-- display the card text -->
            <div class="card-body d-flex flex-column justify-content-between">
                <!-- display the year from the array -->
                <p class="text-body line-height-card card-text"><?= $row[2] ?></p>
                <?php 
                    //if description is avaliable display it - or else inform no description
                    if ($row[5]!= ""){
                        echo "<p class=\"text-body card-text\">$row[5]...</p>";
                    } else {
                        echo "<p class=\"text-body card-text\">No description avaliable</p>";
                    }
                ?>
                <div>
                    <!-- create a custom link to the artwork details page that passes in url parameter for the registry id -->
                    <a <?php echo "href=\"artwork-details.php?RegistryID=$row[0]\" "?> class="card-link">Read More</a>
                </div>
            </div>
        </a>
    </div>
<?php } ?>


<!-- this function is responsible for styling, displaying, and creating the page numbers - including the links -->
<?php function paging($page, $number_of_page, $curPage) { ?>
    <nav aria-label="Browse additional pages" class="table-responsive mt-5">
        <!-- pages are organizaed in ul according to bootstrap documentation -->
        <ul class="pagination justify-content-center flex-wrap">
            <li class="page-item">
                <a class="page-link" 
                <?php 
                    //calculate the previous page number dynamically based on your current page
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
            <li class="page-item">
                <a class="page-link" 
                    <?php 
                        //calculate the next page number dynamically based on your current page
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


<!-- this function creates the comment form on the artwork deatils page - only avaliable for members -->
<?php function comment_form($registryID){
        ?>
        <section class="container">
            <div class="row bootstrap snippets bootdeys">
                <div class="col-md-8 col-sm-12">
                    <div class="comment-wrapper">
                        <div class="panel panel-info">
                            <h5 class="panel-heading">
                                <?php 
                                    //check if the user is logged into an account 
                                    //change the heading from login information to member's username
                                    if (!isset($_SESSION['username'])) {
                                        $username = "Please Login to Comment.";
                                    } else {
                                        $username = $_SESSION['username'];
                                    }
                                echo $username;
                                ?>
                            </h5>
                            <div class="panel-body">
                            <!-- create the comment form and add to url to detect the new comment -->
                                <form action="artwork-details.php?RegistryID=<?php echo $registryID ?>" method="post">
                                    <textarea class="form-control" name="comment" type="text" placeholder="Write a comment..." rows="3"></textarea>
                                    <br>
                                    <input type="submit" name="post" value="Post" class="btn btn-primary pull-right">
                                    <div class="clearfix"></div>
                                </form>
        <!-- in order to keep all the comments alligned together ending div blocks have been moved to comment_end() -->
        <?php
    }
?>

<?php 
// this funciton closes the div blocks opened in comment_form()
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
    // this comment is responible for displaying comments from the database  
    // sql query results are passed in the parameters from artwork-details.php
    function comment_display($time, $name, $message, $user, $user_id, $comment_id, $art_id){
        ?>
        <li class="media list-group-item mb-0
            <?php 
                // if the current logged in user is the owner of the comment update the background colour
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
                    // if the current logged in user is the owner of the comment - allow them to edit or delete their comments 
                    //using url re-writing to detect the comments (only if user own the comments)
                    if ($user == $user_id){
                        echo "<a class=\"pull-right m-1 ml-1\" href=\"artwork-details.php?RegistryID=$art_id&id-delete=$comment_id\">Delete</a>";
                        echo "<a class=\"pull-right m-1\" href=\"artwork-details.php?RegistryID=$art_id&id=$comment_id\">Edit</a>";
                     } 
                ?>
            </div>
        </li>
<?php } ?>

<?php 

//this function is responsible for opening a new form for the user to update the message of their original comment
    function comment_edit($registryID, $comment_id, $user, $user_id){
        // double check that the logged in user is the owner of the comment - otherwise they should should not be able to update other peoples comments
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

//this function is responsible for deleting the current selected comment from the database 
    function comment_delete($connection, $idvalue, $comment_id_delete, $user, $user_id){
        // double check the current logged in user owns the comment they was to delete - cannot delete other people's comments
        if ($user == $user_id){
            // if their is an id to delete in the request then only delete it
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
            //refresh the page to see the comment it now gone
            header("Refresh:0");
        }
    }
?>


<?php 
    // Derek's function code
    // checks if the user is logged in or not
    function is_logged_in() {
        if(!isset($_SESSION['username'])) {redirect_to(url_for('/login.php'));}
    }

    // redirect url from previous path
    function url_for($script_path) {
        if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
        }
        return WWW_ROOT . $script_path;
    }

    // gets rid of the special characters
    function h($string="") {
        return htmlspecialchars($string);
    }

    // displays the error
    function error_404() {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        exit();
    }
    
    // displays the error
    function error_500() {
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        exit();
    }
    
    // redirect your file to $location
    function redirect_to($location) {
        header("Location: " . $location);
        exit;
    }
    
    // makes a post request
    function is_post_request() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
    
    // makes a get request
    function is_get_request() {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }
    
    // displays what errors occured
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

    // takes the session username and retrieves the user_id from the session's username
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

    // retrieves the ip address
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

function carousel($connection){
    ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block carousel-size" src="assets/mural.jpg" data-src="holder.js/900x400?theme=social" alt="First slide">
                    </div>
                    <?php 
                        // retrieve art_id from the upvote table of whatever artwork that is upvoted
                        $carouselsql = "SELECT art_id FROM upvote";
                        $result = $connection -> query($carouselsql);
                        $row = mysqli_fetch_assoc($result);

                        // display the art_id if there are still results
                        while ($row = mysqli_fetch_assoc($result)) {
                            // retrieves the PhotoURL from the public art table using the art_id
                            $picsql = "SELECT PhotoURL FROM public_art WHERE RegistryID = '".$row['art_id']."'";
                            $picresult = $connection -> query($picsql);

                            // display a carousel item with the photoURL results
                            echo '<div class="carousel-item">';
                            echo '<img class="d-block carousel-size" src="';
                            if ($picresult->num_rows>0) {
                                while($picrow = $picresult->fetch_assoc()) {
                                    // checks if there is a photoURL, if not do not post.
                                    if ($picrow['PhotoURL'] != "") {
                                        echo $picrow['PhotoURL'];
                                    }
                                    
                                }
                            }
                            echo '" data-src="holder.js/900x400?"></div>';
                        }

                        
                    ?>
            </div>
            <!-- display the directional arrows to navigate the left and right pictures -->
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


?>