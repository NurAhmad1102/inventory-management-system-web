<?php
include 'config.php';


session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['add_transaction_out'])) {

    $id_supplier = mysqli_real_escape_string($conn, $_POST['id_supplier']);
    $id_product = $_POST['id_product'];
    $date = $_POST['txns_out_date'];
    $quantity_out = $_POST['quantity_out'];
    $desc_out = $_POST['desc_out'];

    $check_id_supplier = mysqli_query($conn, "SELECT id_user, user_type FROM `user` WHERE id_user = '$id_supplier' AND user_type = 'user'") or die('query failed 1');
    $check_id_product = mysqli_query($conn, "SELECT id_product FROM `item` WHERE id_product = '$id_product'") or die('query failed 2');

    if (mysqli_num_rows($check_id_product) > 0 && mysqli_num_rows($check_id_supplier) > 0) {

        $add_transaction_in_query = mysqli_query($conn, "INSERT INTO transaction_out (id_supplier, id_product, quantity_out, transaction_out_date, description_out) 
                                    VALUES ('$id_supplier', '$id_product', '$quantity_out', '$date', '$desc_out')") or die('query failed to insert');

        if ($add_transaction_in_query) {
            $message[] = 'product added successfully!';
        } else {
            $message[] = 'product could not be added!';
        }
    } else {

        $message[] = 'data not exist';

        $result = mysqli_query($conn, "SELECT id_transaction_out FROM transaction_out 
                    WHERE id_product = '$id_product' OR id_supplier ='$id_supplier'");

        //check if the query returned any rows
        if (mysqli_num_rows($result) > 0) {
            //fetch the data from the query result and store it in a variable
            $id_transaction_out = mysqli_fetch_assoc($result)['id_transaction_out'];

            $check_id_product_supplier = mysqli_query($conn, "DELETE FROM `transaction_out` WHERE id_transaction_out = '$id_transaction_out'") or die('query failed 4');
            //do something with the user_id value
            // echo "The user_id is: " . $user_id;
        } else {
            // echo "No matching record found.";
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `transaction_out` WHERE id_transaction_out = '$delete_id'") or die('query failed to delete');
    header('location:transaction_out.php');
}




if (isset($_POST['update_transaction_out'])) {

    $update_p_id = $_POST['update_id_txns_out'];
    $update_id_supplier = $_POST['update_id_supplier'];
    $update_id_product = $_POST['update_id_product'];
    $update_qty = $_POST['update_quantity'];
    $update_date = $_POST['update_date'];
    $update_desc_in = $_POST['update_desc_out'];

    $check_id_supplier = mysqli_query($conn, "SELECT id_user, user_type FROM `user` WHERE id_user = '$update_id_supplier' AND user_type = 'user'") or die('query failed 4');
    $check_id_product = mysqli_query($conn, "SELECT id_product FROM `item` WHERE id_product = '$update_id_product'") or die('query failed 5');


    if (mysqli_num_rows($check_id_product) > 0 && mysqli_num_rows($check_id_supplier) > 0) {

        $result = mysqli_query($conn, "UPDATE transaction_out 
        SET
        id_supplier = '$update_id_supplier',
        id_product = '$update_id_product',
        quantity_out = '$update_qty',
        transaction_out_date = '$update_date',
        description_out = '$update_desc_in'
        WHERE id_transaction_out = '$update_p_id'");

        if (!$result) {
            die("Update query failed: " . mysqli_error($conn));
        }
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    include "sidebar.php";
    ?>
    <div class="content" style="margin-left: 20%;">

        <div class="card container-fluid w-100 p-5 " style="background-color: #eee; height:200px">
            <h1>Manage Transaction Out Product</h1>
            <p>Welcome to the admin page. Here you can manage your website content.</p>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Transaction Out</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="id_supplier">ID_Supplier:</label>
                                    <input type="number" class="form-control" id="id_supplier" name="id_supplier">
                                </div>
                                <div class="form-group">
                                    <label for="id_supplier">ID_Product:</label>
                                    <input type="text" class="form-control" id="id_supplier" name="id_product">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity Out:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity_out">
                                </div>
                                <div class="form-group">
                                    <label for="date_in">Transaction Date Out:</label>
                                    <input type="date" class="form-control" id="date_out" name="txns_out_date">
                                </div>
                                <div class="form-group">
                                    <label for="desc_in">Desc out</label>
                                    <input type="textarea" class="form-control" id="desc_out" name="desc_out">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="add_transaction_out">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <div class="card p-3 text-left m-3" style="height:80vh">

            <div class="container mt-2">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="HideButton">Add</button>
                    </div>
                </div>
            </div>            


            <section class="transaction_out  w-80 mt-5 mx-4" id="myTable">

                <h1 class="title">Transaction Out</h1>

                <div class="container-users">

                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID Txns Out</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity Out</th>
                                <th scope="col">Price</th>
                                <th scope="col">Date</th>
                                <th scope="col">Desc</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php

                        $limit_per_page = 10;
                        $page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
                        $first_page = ($page > 1) ? ($page * $limit_per_page) - $limit_per_page : 0;

                        $previous = $page - 1;
                        $next = $page + 1;

                        $row_item = mysqli_query($conn, "SELECT * FROM transaction_out ");
                        $total_row_item = mysqli_num_rows($row_item);
                        $total_page = ceil($total_row_item / $limit_per_page);

                        $select_item = mysqli_query(
                            $conn,
                            "SELECT 
                                        transaction_out.*, 
                                        item.*, 
                                        user.*
                                    FROM `transaction_out` 
                                    INNER JOIN `item` ON transaction_out.id_product = item.id_product
                                    INNER JOIN `user` ON transaction_out.id_supplier = user.id_user
                                    LIMIT $first_page, $limit_per_page"
                        )
                            or die("Update query failed: " . mysqli_error($conn));


                        $no = $first_page + 1;
                        while ($fetch_item = mysqli_fetch_assoc($select_item)) {
                        ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $no++; ?></th>
                                    <td><?php echo $fetch_item['id_transaction_out']; ?></td>
                                    <td><?php echo $fetch_item['address']; ?></td>
                                    <td><?php echo $fetch_item['product_name']; ?></td>
                                    <td><?php echo $fetch_item['quantity_out']; ?></td>
                                    <td><?php echo $fetch_item['product_price']; ?></td>
                                    <td><?php echo $fetch_item['transaction_out_date']; ?></td>
                                    <td><?php $txns_desc = $fetch_item['description_out'];
                                        if (str_word_count($txns_desc) > 5) {
                                            echo substr($txns_desc, 0, strrpos(substr($txns_desc, 0, 25), ' ')) . '<br>' . substr($txns_desc, strrpos(substr($txns_desc, 0, 25), ' '));
                                        } else {
                                            echo $txns_desc;
                                        } ?></td>
                                    <td>
                                        <a href="transaction_out.php?update=<?php echo $fetch_item['id_transaction_out']; ?>" id="updateBtn" name="update_transaction_out">Update</a>
                                        <a class="delete-btn text-danger" href="transaction_out.php?delete=<?php echo $fetch_item['id_transaction_out']; ?>" onclick="return confirm('delete this item?');">Remove</a>
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
            <div class="edit-product-form" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Transaction Out</h4>
                            <!-- <button type="button" id="close-update">&times;</button> -->
                        </div>
                        <div class="modal-body">


                            <?php
                            if (isset($_GET['update'])) {
                                $update_id = $_GET['update'];
                                $update_query = mysqli_query($conn, "SELECT * FROM `transaction_out` WHERE id_transaction_out = '$update_id'") or die('query failed');
                                if (mysqli_num_rows($update_query) > 0) {
                                    while ($fetch_update = mysqli_fetch_assoc($update_query)) {
                            ?>

                                        <form action="" method="post">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="id_transaction_out" name="update_id_txns_out" value="<?php echo $fetch_update['id_transaction_out']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_supplier">ID_Supplier:</label>
                                                <input type="number" class="form-control" id="id_supplier" name="update_id_supplier" value="<?php echo $fetch_update['id_supplier']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">ID Product:</label>
                                                <input type="text" class="form-control" id="name" name="update_id_product" value="<?php echo $fetch_update['id_product']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity" name="update_quantity" value="<?php echo $fetch_update['quantity_out']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="date">Date:</label>
                                                <input type="date" class="form-control" id="date" name="update_date" value="<?php echo $fetch_update['transaction_out_date']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="desc_in">Desc In</label>
                                                <input type="" class="form-control" id="desc_in" name="update_desc_out" value="<?php echo $fetch_update['description_out']; ?>" required>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-primary text-center" value="update" name="update_transaction_out">
                                                <button type="reset" class="btn btn-secondary text-center" id="close-update">Close</button>
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
        window.location.href = 'transaction_out.php';
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