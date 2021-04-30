<?php

include "config/connection.php";
include "library/app.php";

$app = new App();
$table = 'users';

$field = array(
    'username' => @$_POST['username'],
    'password' => base64_encode(@$_POST['password'])
);

$redirect = "?menu=user";
@$params = "id = $_GET[id]";

if (isset($_POST['create'])) {
    $app->create($connect, $table, $field, $redirect);
}

if (isset($_POST['update'])) {
    @$params = "id = $_POST[id]";  
    $app->update($connect, $table, $field, $params, $redirect);
}

if (isset($_GET['delete'])) {
    $app->delete($connect, $table, $params, $redirect);
}

?>

<div class="alert alert-dismissible alert-success mt-4 d-none" id="alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>OK</strong> data <a href="#" class="alert-link">successfully</a> stored.
</div>

<div class="alert alert-dismissible alert-danger d-none" id="alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Error</strong> <a href="#" class="alert-link">failed</a> to store data.
</div>

<div class="d-flex justify-content-start" data-toggle="modal" data-target="#createModal">
    <div class="btn btn-primary mt-3 my-3" id="create-button">Create New User</div>
</div>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $usersData = $app->get($connect, $table);
            $index = 0;

            if($data === ""){
                echo "<tr><td colspan='4'>No Data</td></tr>";
            } else {
                foreach($usersData as $user) {
                    $index++
        ?>
                    <tr id="row-<?= $user['id'] ?>">
                        <td><?= $index; ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= base64_decode($user['password']) ?></td>
                        <td>
                            <a href="?menu=user&delete&id=<?php echo $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            <a class="btn-link" onclick="showEditModal(<?php echo $user['id'] ?>)">Edit</a>
                        </td>
                    </tr>
        <?php  } } ?>
    </tbody>
</table>

<!--create-->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="user-name" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Password</label>
                    <input type="text" class="form-control" name="password"  id="user-password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="create">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--edit-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST">
                <input type="hidden" name="id" id="user-id">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="edit-user-name" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Password</label>
                    <input type="text" class="form-control" name="password"  id="edit-user-password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="update">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>