<?php 
include "config/connection.php";
include "library/app.php";

$app = new App();

$table = 'product';
$date = date('Y-m-d');
$redirect = "?menu=product";
@$fileLocation = "images";
@$params = "product_id = $_GET[id]";

if(isset($_POST['create'])){
    $image = $_FILES['image'];
    $upload = $app->upload($image, $fileLocation);
    @$field = array(
                'name' => @$_POST['product_name'],
                'type_id' => @$_POST['type_id'],
                'image' => $image['name'],
                'date_added' => $date,
                'note' => @$_POST['note']
            );
    $app->create($connect, $table, $field, $redirect);
}

if(isset($_GET['delete'])){
	$app->delete($connect, $table, $params, $redirect);
}

// if(isset($_GET['detail'])){
// 	$sql = "SELECT product .*, jenis FROM product
// 			INNER JOIN jenis on product.jenisID = jenis.jenisID
// 			WHERE $where";
// 	$jalan = mysqli_query($con, $sql);
// 	$edit = mysqli_fetch_assoc($jalan);
// }

if(isset($_POST['update'])){
	$image = $_FILES['image'];
    $upload = $app->upload($image, $fileLocation);
    $updateParams = "product_id = $_POST[id]";

    if(strlen($image['name']) === 0){
        @$field = array('name' => @$_POST['product_name'],
                        'type_id' => @$_POST['type_id'],
                        'date_added' => $date,
                        'note' => @$_POST['note']
                    );
        $app->update($connect, $table, $field, $updateParams, $redirect);
    }else{
        @$field = array('name' => @$_POST['product_name'],
                        'type_id' => @$_POST['type_id'],
                        'image' => $image['name'],
                        'date_added' => $date,
                        'note' => @$_POST['note']
                    );
        $app->update($connect, $table, $field, $updateParams, $redirect);
    }
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

<div class="d-flex justify-content-start"  >
    <div data-target="#createProductModal" data-toggle="modal" class="btn btn-primary mt-3 my-3" id="create-button">Create New Product</div>
</div>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Product Name</th>
            <th>Type</th>
            <th>Image</th>
            <th>Date Added</th>
            <th>Note</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $index = 0;
            $query = "SELECT * FROM product
                INNER JOIN types on product.type_id = types.type_id";
            $execute = mysqli_query($connect, $query);
            while ($data = mysqli_fetch_assoc($execute)) {
                $index++
        ?>
            <tr id="product-row-<?= $data['product_id'] ?>">
                <td><?= $index ?></td>
                <td><?= $data['name'] ?></td>
                <td><?= $data['type'] ?></td>
                <td><img src="images/<?= $data['image'] ?>" width="100"></td>
                <td><?= $data['date_added'] ?></td>
                <td><?= $data['note'] ?></td>
                <td>
                    <a href="?menu=product&delete&id=<?= $data['product_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <a href="#" onclick='showProductEditModal(<?= $data["product_id"] ?>, <?= $data["type_id"] ?>)' >Edit</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<!--create-->
<div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product-name" class="col-form-label">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product-name" required>
                </div>
                <div class="form-group">
                    <label for="type">Product Type</label>
                    <select class="form-control" name="type_id" id="type">
                        <?php 
                            $productTypeTable = 'types';
                            $types = $app->get($connect, $productTypeTable); 

                            if($data === ""){
                                echo "";
                            } else {
                                foreach($types as $type) {
                        ?>
                        <option value=<?= $type['type_id'] ?>><?= $type['type'] ?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" accept=".jpg,.png,.jpeg" name="image">
                </div>
                <div class="form-group">
                    <label for="note">Notes</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
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

<!--update-->
<div class="modal fade" id="updateProductModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="product-id">

                <div class="form-group">
                    <label for="product-name" class="col-form-label">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="update-product-name" required>
                </div>
                <div class="form-group">
                    <label for="type">Product Type</label>
                    <select class="form-control" name="type_id" id="update-type">
                        <?php 
                            $productTypeTable = 'types';
                            $types = $app->get($connect, $productTypeTable); 

                            if($data === ""){
                                echo "";
                            } else {
                                foreach($types as $type) {
                        ?>
                        <option class="options" value=<?= $type['type_id'] ?>><?= $type['type'] ?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" style="color:transparent;" onchange="this.style.color = 'black';" id="update-image" accept=".jpg,.png,.jpeg" name="image">
                </div>
                <div class="form-group">
                    <label for="note">Notes</label>
                    <textarea class="form-control" id="update-note" name="note" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="update">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
