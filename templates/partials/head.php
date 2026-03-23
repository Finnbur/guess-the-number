<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess the Number</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
</head>
<body>
<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
                <img width="48" height="48" src="https://img.icons8.com/?size=100&id=116653&format=png&color=FFFFFF" alt="2-circle"/>
            </a>

            <ul class="nav nav-pills col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-1">
                <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Leaderboard</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Profile</a></li>
            </ul>

            <div class="text-end">
                <?php if(!$_SESSION['loggedIn']){ ?>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#registerModal">Sign-up</button>
                <?php }else{ ?>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <button type="submit" name="action" value="logout" class="btn btn-secondary">Logout</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<!-- start of the middle form -->
<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card p-4" style="width: 100%; max-width: 600px;">