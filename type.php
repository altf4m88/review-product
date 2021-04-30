<?php

include "config/connection.php";
include "library/app.php";

$app = new App();
$table = 'types';

$field = array(
    'type' => @$_POST['type'],
);

$redirect = "?menu=type";
@$params = "type_id = $_GET[id]";

if (isset($_POST['create'])) {
    $app->create($connect, $table, $field, $redirect);
}

if (isset($_POST['update'])) {
    @$params = "type_id = $_POST[id]";  
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
    <div class="btn btn-primary mt-3 my-3" id="create-button">Create New Product Type</div>
</div>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Product Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $types = $app->get($connect, $table);
            $index = 0;

            if($data === ""){
                echo "<tr><td colspan='4'>No Data</td></tr>";
            } else {
                foreach($types as $type) {
                    $index++
        ?>
                    <tr id="type-row-<?= $type['type_id'] ?>">
                        <td><?= $index; ?></td>
                        <td><?= $type['type'] ?></td>
                        <td>
                            <a href="?menu=type&delete&id=<?=$type['type_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            <a class="btn-link" onclick="showTypeEditModal(<?= $type['type_id'] ?>)">Edit</a>
                        </td>
                    </tr>
        <?php  } } ?>
    </tbody>
</table>

<!--create-->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Product Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST">
                <div class="form-group">
                    <label for="type" class="col-form-label">Product Type</label>
                    <input type="text" class="form-control" name="type" id="type" required>
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
<div class="modal fade" id="editTypeModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Update Product Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST">
                <input type="hidden" name="id" id="type-id">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Product Name</label>
                    <input type="text" class="form-control" name="type" id="edit-type" required>
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