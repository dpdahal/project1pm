<?php

if ($_SESSION['AUTH_USER']['user_type'] == 'user') {
    $id = $_SESSION['AUTH_USER']['aid'];
    $query = "SELECT * FROM admins WHERE aid=" . $id;
    $adminData = mysqli_query($connection, $query);

} else {
    $query = "SELECT * FROM admins ORDER BY aid DESC";
    $adminData = mysqli_query($connection, $query);

}


/*
 * ===========Delete Record ===================
 */

if (!empty($_POST) && isset($_POST['delete_users'])) {
    $id = $_POST['criteria'];
//    select users
    $sql = "SELECT * FROM admins WHERE aid=" . $id;
    $response = mysqli_query($connection, $sql);
    $user = mysqli_fetch_assoc($response);
    $file = $user['image'];
    $filePath = root_path('public/uploads/admin/' . $file);
    if (file_exists($filePath) && is_file($filePath)) {
        unlink($filePath);
    }

    $delQuery = "DELETE FROM admins WHERE aid=" . $id;
    $res = mysqli_query($connection, $delQuery);
    if ($res) {
        $_SESSION['success'] = 'Data was deleted';
        redirect_back();

    } else {
        $_SESSION['error'] = 'Data was not deleted';
        redirect_back();
    }


}

/*
 * ===========End Delete Record ===================
 */

/*
 * ===============Update Status ==============
 */

if (!empty($_POST) && isset($_POST['active'])) {
    $id = $_POST['criteria'];
//    select users
    $statusValue = 0;
    $sql = "UPDATE admins SET status='$statusValue' WHERE aid='$id'";
    $response = mysqli_query($connection, $sql);
    if ($response) {
        $_SESSION['success'] = 'Status was inactive';
        redirect_back();
    } else {
        $_SESSION['error'] = 'Errors';
        redirect_back();
    }

}

if (!empty($_POST) && isset($_POST['inactive'])) {
    $id = $_POST['criteria'];
//    select users
    $statusValue = 1;
    $sql = "UPDATE admins SET status='$statusValue' WHERE aid='$id'";
    $response = mysqli_query($connection, $sql);
    if ($response) {
        $_SESSION['success'] = 'Status was active';
        redirect_back();
    } else {
        $_SESSION['error'] = 'Errors';
        redirect_back();
    }

}


/*
 * ===============End Update Status ==============
 */


/*
 * ===============Update admin ==============
 */

if (!empty($_POST) && isset($_POST['admin'])) {
    $id = $_POST['criteria'];
//    select users
    $type = 'user';
    $sql = "UPDATE admins SET user_type='$type' WHERE aid='$id'";
    $response = mysqli_query($connection, $sql);
    if ($response) {
        $_SESSION['success'] = 'admin was user';
        redirect_back();
    } else {
        $_SESSION['error'] = 'Errors';
        redirect_back();
    }

}

if (!empty($_POST) && isset($_POST['user'])) {
    $id = $_POST['criteria'];
//    select users
    $type = 'admin';
    $sql = "UPDATE admins SET user_type='$type' WHERE aid='$id'";
    $response = mysqli_query($connection, $sql);
    if ($response) {
        $_SESSION['success'] = 'user was admin ';
        redirect_back();
    } else {
        $_SESSION['error'] = 'Errors';
        redirect_back();
    }

}


/*
 * ===============End Update types ==============
 */

?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa fa-eye"></i> Show Admin Users</h1>
                <hr>

                <?= messages(); ?>


            </div>
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>S.n</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>User Types</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($adminData as $key => $admin) : ?>
                        <tr>
                            <td><?= ++$key; ?></td>
                            <td><?= $admin['full_name'] ?></td>
                            <td><?= $admin['username'] ?></td>
                            <td><?= $admin['email'] ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="criteria" value="<?= $admin['aid'] ?>">
                                    <?php if ($admin['user_type'] == 'admin') : ?>
                                        <button name="admin" class="btn-xs btn-success">
                                            admin
                                        </button>
                                    <?php else : ?>
                                        <button name="user" class="btn-xs btn-danger">
                                            user
                                        </button>

                                    <?php endif; ?>
                                </form>
                            </td>
                            <td><?= $admin['gender'] ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="criteria" value="<?= $admin['aid'] ?>">
                                    <?php if ($admin['status'] == 1) : ?>
                                        <button name="active" class="btn-xs btn-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    <?php else : ?>
                                        <button name="inactive" class="btn-xs btn-danger">
                                            <i class="fa fa-times"></i>
                                        </button>

                                    <?php endif; ?>
                                </form>
                            </td>
                            <td>
                                <img src="<?= base_url('public/uploads/admin/' . $admin['image']); ?>"
                                     width="40" alt="">
                            </td>
                            <td>


                                <form action="" method="post">
                                    <input type="hidden" name="criteria" value="<?= $admin['aid'] ?>">
                                    <a href="<?=backend_url('edit-admin-user?criteria='.$admin['aid'])?>" class="btn-xs btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button name="delete_users" class="btn-xs btn-danger">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </td>


                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

