<?php

$errors = [
    'full_name' => '',
    'username' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => '',
    'gender' => '',
    'image' => '',
];

$oldValue = [
    'full_name' => '',
    'username' => '',
    'email' => '',
    'gender' => ''
];


if (!empty($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

    foreach ($_POST as $key => $value) {
        if (empty($_POST[$key])) {
            $errors[$key] = $key . ' filed is required';
        } else {
            $oldValue[$key] = $value;
        }
    }

    $password = md5($_POST['password']);
    $cPassword = md5($_POST['confirm_password']);
    if ($password != $cPassword) {
        $errors['password'] = "Password not match";
    }

    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Enter validate email";
    }

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $imageName = md5(microtime()) . '.' . $ext;
        $tmpName = $_FILES['image']['tmp_name'];
        $uploadPath = root_path('public/uploads/admin');
        $imgExt = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $imgExt)) {
            $errors['image'] = "Only supported format is: " . implode(',', $imgExt);
        }
        if (!move_uploaded_file($tmpName, $uploadPath . '/' . $imageName)) {
            $errors['image'] = "File upload errors";
        }
    }

// =========Check Username exists===========
    $userName = $_POST['username'];
    $sql = "SELECT * FROM admins WHERE username='$userName'";
    $res = mysqli_query($connection, $sql);
    $totalUsers = mysqli_num_rows($res);

    if ($totalUsers > 0) {
        $errors['username'] = "Username already exists";
    }

    // =========Check email exists===========
    $email = $_POST['email'];
    $sql = "SELECT * FROM admins WHERE email='$email'";
    $res = mysqli_query($connection, $sql);
    $totalUsers = mysqli_num_rows($res);

    if ($totalUsers > 0) {
        $errors['email'] = "email already exists";
    }



    if (!array_filter($errors)) {
        $fullName = $_POST['full_name'];
        $userName = $_POST['username'];
        $email = $_POST['email'];
        $pass = $password;
        $gender = $_POST['gender'];
        $createdAt = date('Y-m-d h-i-s');
        $updateAt = date('Y-m-d h-i-s');
//       Insert Query
        $query = "INSERT INTO admins(full_name,username,email,password,
                   gender,image,created_at,update_at )
                            VALUES('$fullName','$userName','$email','$pass',
                                   '$gender','$imageName','$createdAt','$updateAt')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            $_SESSION['success'] = "Data was inserted";
            redirect_to('backend/show-admin-users');
        } else {
            $_SESSION['error'] = "Data was not inserted";
            redirect_back();
        }


    }
}


?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <i class="fa fa-plus"></i> Add Admin User</h1>

                <?= messages() ?>

                <hr>
            </div>
            <div class="col-md-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name">Full Name:
                                    <a style="color: red;"><?= $errors['full_name']; ?></a>
                                </label>
                                <input type="text" name="full_name" id="full_name"
                                       value="<?= $oldValue['full_name']; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username:
                                    <a style="color: red;"><?= $errors['username']; ?></a>
                                </label>
                                <input type="text" name="username" id="username"
                                       value="<?= $oldValue['username']; ?>" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:
                            <a style="color: red;"><?= $errors['email']; ?></a>
                        </label>
                        <input type="text" name="email" id="email"
                               value="<?= $oldValue['email']; ?>" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password:
                                    <a style="color: red;"><?= $errors['password']; ?></a>
                                </label>
                                <input type="password" name="password" id="password"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:
                                    <a style="color: red;"><?= $errors['confirm_password']; ?></a>
                                </label>
                                <input type="password" name="confirm_password" id="confirm_password"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:
                            <a style="color: red;"><?= $errors['gender']; ?></a>
                        </label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="" readonly>--- Select Gender ---</option>
                            <option <?= $oldValue['gender'] == 'male' ? 'selected' : '' ?> value="male">Male</option>
                            <option <?= $oldValue['gender'] == 'female' ? 'selected' : '' ?> value="female">Female
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Profile Picture:
                            <a style="color: red;"><?= $errors['image'] ?></a>
                        </label>
                        <input type="file" name="image" id="image"
                               class="btn btn-default">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">
                            <i class="fa fa-plus"></i> Add Record
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

