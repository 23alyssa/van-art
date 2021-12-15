<html>
<head>
    <!-- link to main style sheet - expanding on bootstrap css -->
    <link href="styles/main.css" rel="stylesheet">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- ajax and jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- font awesome icons -->
    <script src="https://use.fontawesome.com/e11dcbda4a.js"></script>

    <!-- Bootstrap icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />
    
    <title>Vancouver Art</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- responsive navbar -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <!-- landing page -->
            <a class="navbar-brand" href="index.php">Vancouver Art</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <!-- browse page page -->
                <a class="nav-link" href="browse.php">Browse</a>
                </li>
            </ul>
            <form class="d-flex input-group w-auto">
                <div class="p-2">
                <?php
                    // change menu item for loggen in user to access their account
                    if(isset($_SESSION['username'])) {
                        echo '<a class="btn btn-secondary-outline" href="members.php">'.$_SESSION['username'].'</a>';
                        echo '<a class="btn btn-primary" href="logout.php">Log Out</a>';
                    } else {
                        echo '<a class="btn btn-secondary-outline" href="login.php">Login</a>';
                        echo '<a class="btn btn-primary" href="register.php">Sign Up</a>';
                    }
                ?>
                </div>
            </form>

            </div>
        </div>
    </nav>

    <!--header ends here-->