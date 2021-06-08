<?php

if (isset($_GET['edit-admin-user']) || !isset($_GET['criteria'])
    || empty($_GET['criteria'])) {
    redirect_to('backend/show-admin-users');
}

$id = $_GET['criteria'];
$selectQuery = "SELECT full_name,username,email,gender,image  FROM admins WHERE aid=" . $id;
$response = mysqli_query($connection, $selectQuery);
$users = mysqli_fetch_assoc($response);

$errors = [
    'full_name' => '',
    'username' => '',
    'email' => '',
    'gender' => '',
    'image' => '',
];


if (!empty($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

    foreach ($_POST as $key => $value) {
        if (empty($_POST[$key])) {
            $errors[$key] = $key . ' filed is required';
        }
    }

    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Enter validate email";
    }

    if (!empty($_FILES['image']['name'])) {

        $sql = "SELECT * FROM admins WHERE aid=" . $id;
        $response = mysqli_query($connection, $sql);
        $user = mysqli_fetch_assoc($response);
        $file = $user['image'];
        $filePath = root_path('public/uploads/admin/' . $file);
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }

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
    $sql = "SELECT * FROM admins WHERE username !='$userName' AND aid='$id'";

    $res = mysqli_query($connection, $sql);
    $totalUsers = mysqli_num_rows($res);

    if ($totalUsers > 0) {
        $errors['username'] = "Username already exists";
    }

    // =========Check email exists===========
    $email = $_POST['email'];
    $sql = "SELECT * FROM admins WHERE email !='$email' AND aid='$id'";
    $res = mysqli_query($connection, $sql);
    $totalUsers = mysqli_num_rows($res);

    if ($totalUsers > 1) {
        $errors['email'] = "email already exists";
    }


    if (!array_filter($errors)) {
        die('test');
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
                    <i class="fa fa-plus"></i> Update User</h1>

                <?= messages() ?>

                <hr>
            </div>

            <div class="col-md-8">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="full_name">Full Name:
                            <a style="color: red;"><?= $errors['full_name']; ?></a>
                        </label>
                        <input type="text" name="full_name" id="full_name"
                               value="<?= $users['full_name']; ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="username">Username:
                            <a style="color: red;"><?= $errors['username']; ?></a>
                        </label>
                        <input type="text" name="username" id="username"
                               value="<?= $users['username']; ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:
                            <a style="color: red;"><?= $errors['email']; ?></a>
                        </label>
                        <input type="text" name="email" id="email"
                               value="<?= $users['email']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:
                            <a style="color: red;"><?= $errors['gender']; ?></a>
                        </label>
                        <select name="gender" id="gender" class="form-control">
                            <option <?= $users['gender'] == 'male' ? 'selected' : '' ?> value="male">Male</option>
                            <option <?= $users['gender'] == 'female' ? 'selected' : '' ?> value="female">Female
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
                        <button class="btn btn-primary">
                            <i class="fa fa-plus"></i> Update Record
                        </button>
                    </div>

                </form>
            </div>
            <div class="col-md-4">
                <img src="<?= base_url('public/uploads/admin/' . $users['image']); ?>"
                     class="img-responsive thumbnail" alt="" style="margin-top: 25px;">
            </div>
        </div>

    </div>
</div>

