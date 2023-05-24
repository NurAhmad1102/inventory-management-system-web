<?php
include 'config.php';


session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}



if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE `user`,'item' FROM 'user' JOIN  WHERE id_user = '$delete_id'") or die('query failed');
    header('location:supplier.php');
}


if (isset($_POST['update_supplier'])) {

    $update_p_id = $_POST['update_id'];
    $update_name = $_POST['update_name'];
    $update_address = $_POST['update_address'];
    $update_phone = $_POST['update_phone'];
    // $update_date = $_POST['update_product_date'];
    // $update_supplier = $_POST['update_supplier_option'];


    $result = mysqli_query($conn, "UPDATE user
            SET username = '$update_name', address = '$update_address', phone = '$update_phone'
            WHERE id_user = '$update_p_id';
    ");

    if (!$result) {
        die("Update query failed: " . mysqli_error($conn));
    }
}



?>

<!DOCTYPE html>
<html>

<head>
    <title>Bootstrap Form Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</head>

<body>
    <?php
    include "sidebar.php";
    ?>
    <div class="content" style="margin-left: 20%;">

        <div class="card container-fluid w-100 p-5" style="background-color: #eee; height:200px">
            <h1>Supplier</h1>
            <p>Welcome to the admin page. Here you can manage your website content.</p>
        </div>

        <div class="card p-3 text-left m-3" style="height:80vh">

            <div class="container mt-2" id="HideButton">
                <div class="row">
                    <div class="col-md-3">
                        <a href="register.php" type="button" class="btn btn-primary" id="add-button">Add</a>
                    </div>
                </div>
            </div>

            <section class="items  w-75 mt-5 mx-4">

                <h1 class="title"> Suppliers</h1>

                <div class="container-users" id="myTable">

                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID Supplier</th>
                                <th scope="col">Username</th>
                                <th scope="col">Role</th>
                                <th scope="col">Company</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php

                        $limit_per_page = 10;
                        $page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
                        $first_page = ($page > 1) ? ($page * $limit_per_page) - $limit_per_page : 0;

                        $previous = $page - 1;
                        $next = $page + 1;

                        $row_item = mysqli_query($conn, "SELECT * FROM item ");
                        $total_row_item = mysqli_num_rows($row_item);
                        $total_page = ceil($total_row_item / $limit_per_page);


                        $select_item = mysqli_query($conn, "SELECT * FROM `user` WHERE user_type = 'user' LIMIT $first_page, $limit_per_page") or die('query failed');
                        $no = $first_page + 1;
                        while ($fetch_item = mysqli_fetch_assoc($select_item)) {
                        ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $no++; ?></th>
                                    <td><?php echo $fetch_item['id_user']; ?></td>
                                    <td><?php echo $fetch_item['username']; ?></td>
                                    <td><?php echo $fetch_item['user_type']; ?></td>
                                    <td><?php echo $fetch_item['address']; ?></td>
                                    <td><?php echo $fetch_item['phone']; ?></td>
                                    <td>
                                        <a href="supplier.php?update=<?php echo $fetch_item['id_user']; ?>" id="updateBtn">Update</a>
                                        <a class="delete-btn text-danger" href="supplier.php?delete=<?php echo $fetch_item['id_user']; ?>" onclick="return confirm('delete this item?');">Remove</a>
                                    </td>
                                </tr>
                            </tbody>
                        <?php
                        };
                        ?>
                    </table>

                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" <?php if ($page > 1) {
                                                            echo "href='?page_no=$previous'";
                                                        } ?>>Previous</a>
                            </li>
                            <?php
                            for ($x = 1; $x <= $total_page; $x++) {
                            ?>
                                <li class="page-item"><a class="page-link" href="?page_no=<?php echo $x ?>"><?php echo $x; ?></a></li>
                            <?php
                            }
                            ?>
                            <li class="page-item">
                                <a class="page-link" <?php if ($page < $total_page) {
                                                            echo "href='?page_no=$next'";
                                                        } ?>>Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </section>


            <!-- UPDATE PRODUCT -->
            <div class="edit-product-form" id="example-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Item</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">


                            <?php
                            if (isset($_GET['update'])) {
                                $update_id = $_GET['update'];
                                $update_query = mysqli_query($conn, "SELECT * FROM `user` WHERE id_user = '$update_id'") or die('query failed');
                                if (mysqli_num_rows($update_query) > 0) {
                                    while ($fetch_update = mysqli_fetch_assoc($update_query)) {
                            ?>

                                        <form action="" method="post">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="id_product" name="update_id" value="<?php echo $fetch_update['id_user']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Username:</label>
                                                <input type="text" class="form-control"  name="update_name" value="<?php echo $fetch_update['username']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Company:</label>
                                                <input type="text" class="form-control" name="update_address" value="<?php echo $fetch_update['address']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Phone:</label>
                                                <input type="text" class="form-control" id="name" name="update_phone" value="<?php echo $fetch_update['phone']; ?>" required>
                                            </div>                                            
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-primary text-center" value="update" name="update_supplier">
                                                <button type="reset" class="btn btn-danger text-center" id="close-update">Cancel</button>
                                            </div>
                                        </form>
                        </div>

            <?php
                                    }
                                }
                            } else {
                                echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
                            }
            ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>

<script>
    document.querySelector('#close-update').onclick = () => {
        document.querySelector('.edit-product-form').style.display = 'none';
        window.location.href = 'supplier.php';
    }

    $(document).ready(function() {
        // hide the table on page load
        $("#myTable").hide();
        $("#HideButton").hide();

        // show/hide the table when button is clicked
        $("#updateBtn").click(function() {
            $("#myTable").toggle();
            $("#HideButton").toggle();
        });
    });    
</script>