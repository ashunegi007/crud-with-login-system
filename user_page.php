<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Page</title>

   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
   <div class="card text-center">
      <div class="card-header">
         <h3>This is the user page.</h3>
      </div>
      <div class="card-body">
         <h1 class="card-title">Welcome, <span><?php echo $_SESSION['user_name']; ?></span></h1>
         <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
      <div class="card-footer text-muted">
         Have a great day!
      </div>
   </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
