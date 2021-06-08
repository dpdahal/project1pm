<?php
require_once "../../config/config.php";
require_once "../../config/connection.php";

$errors = ['username' => '', 'password' => ''];

if (!empty($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
    foreach ($_POST as $key => $item) {
        if (empty($_POST[$key])) {
            $errors[$key] = $key . ' filed is required';
        }
    }

    if (!array_filter($errors)) {
        $userName = $_POST['username'];
        $password = md5($_POST['password']);

        $query = "SELECT * FROM admins WHERE username='$userName' AND password='$password'";
        $response = mysqli_query($connection, $query);
        $totalUsers = mysqli_num_rows($response);
        if ($totalUsers > 0) {
            $getUsers = mysqli_fetch_assoc($response);
            $_SESSION['AUTH_USER'] = $getUsers;
            $_SESSION['is_log_in'] = true;
            redirect_to('backend');

        } else {
            $_SESSION['error'] = "Username & password not match";
            redirect_back();
        }


    }


}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="<?= base_url('public/backend-ui/css/bootstrap.css') ?>" rel="stylesheet"/>
    <!-- FONTAWESOME STYLES-->
    <link href="<?= base_url('public/backend-ui/css/font-awesome.css') ?>" rel="stylesheet"/>
    <!-- MORRIS CHART STYLES-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-top: 100px;">
            <div class="panel panel-primary">
                <div class="panel-heading">Login to dashboard</div>
                <div class="panel-body">
                    <?= messages(); ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">Username:
                                <a style="color: red;"><?= $errors['username'] ?></a>
                            </label>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password
                                <a style="color: red;"><?= $errors['password'] ?></a>
                            </label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">
                                <i class="fa fa-unlock"></i> Login
                            </button>

                            <a href="" class="pull-right">Forgot password</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>

</body>
</html>
