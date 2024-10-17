<?php
@include 'config.php';
session_start();

if (isset($_POST['submit'])) {

   $email = mysqli_real_escape_string($conn, $_POST['email']);

   $pass = md5($_POST['password']);
    

   $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);


        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('location:admin_page.php');
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('location:user_page.php');
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Login Form</title>
</head>

<body>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Login Now</h2>

                    <?php
                    if (isset($error)) {
                        foreach ($error as $error_message) {
                            echo '<div class="alert alert-danger">' . $error_message . '</div>';
                        }
                    }
                    ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Enter your password">
                        </div>
                        <input type="submit" name="submit" value="Login Now" class="btn btn-primary">
                        <p class="mt-3">Don't have an account? <a href="register_form.php">Register now</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
