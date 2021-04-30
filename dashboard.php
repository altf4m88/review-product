<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "
    <script>
    document.location.href='index.php'
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/lux/bootstrap.min.css" integrity="sha384-9+PGKSqjRdkeAU7Eu4nkJU8RFaH8ace8HGXnkiKMP9I9Te0GJ4/km3L1Z8tXigpG" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" crossorigin="anonymous">
</head>
<body>
<?php 
    include('navbar.php')
?>
<div class="container">
    <?php 
        if(isset($_GET['menu']) && $_GET['menu'] === 'user') {
            include('user.php');
        } else if (isset($_GET['menu']) && $_GET['menu'] === 'type') {
            include('type.php');
        } else if (isset($_GET['menu']) && $_GET['menu'] === 'product') {
            include('product.php');
        } else {
    ?>
    <div class="jumbotron mt-3">
        <h1 class="display-4">Welcome <?php echo $_SESSION['user']; ?></h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
    </div>
    <?php } ?>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('table.display').DataTable();
    });

    const showEditModal = (userId) => {
        const row = $(`#row-${userId}`).children();
        let username = row[1].outerText;
        let password = row[2].outerText;

        $('#user-id').val(userId);
        $('#edit-user-name').val(username);
        $('#edit-user-password').val(password);

        $('#editModal').modal('show');
    }

    const showTypeEditModal = (typeId) => {

        const row = $(`#type-row-${typeId}`).children();

        let typeName = row[1].outerText;

        $('#type-id').val(typeId);
        $('#edit-type').val(typeName);

        $('#editTypeModal').modal('show');
    }

    const showProductEditModal = (productId, typeId) => {

        const row = $(`#product-row-${productId}`).children();

        $('#updateProductModal').modal('show');

        let productName = row[1].outerText;
        let note = row[5].outerText;

        $('#product-id').val(productId);
        $('#update-product-name').val(productName);
        $('#update-note').val(note);
        $('.options').filter(`[value=${typeId}]`).attr('selected', true);      
    }
</script>



<?php 
    if($_SESSION['is_success'] == 'true'){
?>
<script>
    $("#alert-success").removeClass('d-none');
</script>
<?php 
}?>

<?php 
    if($_SESSION['is_success'] == 'false'){
?>
<script>
    $("#alert-danger").removeClass('d-none');
</script>
<?php 
}?>

</html>
