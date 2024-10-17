<?php
require_once "config.php";

$name = $email = $user_type = "";
$name_err = $email_err = $user_type_err = "";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];

    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $input_name)) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = $input_email;
    }

    $input_user_type = trim($_POST["user_type"]);
    if (empty($input_user_type)) {
        $user_type_err = "Please select a user type.";
    } elseif (!in_array($input_user_type, ['admin', 'user'])) {
        $user_type_err = "Please select a valid user type (admin, user).";
    } else {
        $user_type = $input_user_type;
    }

    if (empty($name_err) && empty($email_err) && empty($user_type_err)) {
        $sql = "UPDATE user_form SET name=?, email=?, user_type=? WHERE id=?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_email, $param_user_type, $param_id);

            $param_name = $name;
            $param_email = $email;
            $param_user_type = $user_type;
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                header("location: admin_page.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
} else {
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);

        $sql = "SELECT * FROM user_form WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $name = $row["name"];
                    $email = $row["email"];
                    $user_type = $row["user_type"];
                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);

        mysqli_close($conn);
    } else {
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>User Type</label>
                            <select name="user_type" class="form-control <?php echo (!empty($user_type_err)) ? 'is-invalid' : ''; ?>">
                                <option value="admin" <?php echo ($user_type == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="user" <?php echo ($user_type == 'user') ? 'selected' : ''; ?>>User</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $user_type_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
