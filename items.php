<?php
include 'config.php';


session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}


$query = "SELECT item.id_product, item.product_name, item.product_qty, 
    SUM(transaction_in.quantity_in) AS total_quantity_in, 
    SUM(transaction_out.quantity_out) AS total_quantity_out
          FROM item
          LEFT JOIN transaction_in ON item.id_product = transaction_in.id_product
          LEFT JOIN transaction_out ON item.id_product = transaction_out.id_product
          GROUP BY item.id_product";

// Execute the query
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $total_quantity_in = $row['total_quantity_in'];
    $total_quantity_out = $row['total_quantity_out'];
    $quantity = $row['product_qty'];
    $remain = $total_quantity_in + $quantity - $total_quantity_out;
    // echo "Product ID: " . $row['id_product'] . "<br>";
    // echo "Product Name: " . $row['product_name'] . "<br>";
    // echo "Remaining Quantity: " . $remain . "<br><br>";
}



if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = $_POST['product_price'];
    $date = $_POST['product_date'];
    $quantity = $_POST['product_quantity'];
    // $supplier = $_POST['supplier_option'];


    $select_product_name = mysqli_query($conn, "SELECT product_name FROM `item` WHERE product_name = '$name'") or die('query failed 1');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'product name already added';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO `item` (product_name, product_qty, product_price, date)
    SELECT '$name', '$quantity', '$price', '$date'
    
") or die('query failed 2');


        if ($add_product_query) {
            $message[] = 'product added successfully!';
        } else {
            $message[] = 'product could not be added!';
        }
    }
}



if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `item` WHERE id_product = '$delete_id'") or die('query failed');
    header('location:items.php');
}


if (isset($_POST['update_product'])) {

    $update_p_id = $_POST['update_id_product'];
    $update_name = $_POST['update_product_name'];
    $update_price = $_POST['update_product_price'];
    $update_qty = $_POST['update_product_quantity'];
    $update_date = $_POST['update_product_date'];
    $update_supplier = $_POST['update_supplier_option'];


    $result = mysqli_query($conn, "UPDATE item         
        SET 
            product_name = '$update_name',
            -- item.id_supplier = user.id_user,
            date = '$update_date',
            product_qty = '$update_qty',
            product_price = '$update_price'
        WHERE item.id_product = '$update_p_id'");

    if (!$result) {
        die("Update query failed: " . mysqli_error($conn));
    }
}


// header('location:items.php');



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

        <div class="card container-fluid w-100 p-5" style="background-color: #eee; height:200px">
            <h1>Items Product</h1>
            <p>Welcome to the admin page. Here you can manage your website content.</p>
        </div>

            <!-- Modal -->
            <!-- Input Product -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Item</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="name">Product:</label>
                                    <input type="text" class="form-control" id="name" name="product_name" required>
                                </div>                                
                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" class="form-control" id="quantity" name="product_quantity" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <input type="number" class="form-control" id="price" name="product_price" required>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date:</label>
                                    <input type="date" class="form-control" id="date" name="product_date" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary text-center" name="add_product">save</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeForm()">Close</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        <div class="card p-3 text-left m-3" style="height:80vh">

            <div class="container mt-2" id="HideButton">
                <div class="row">
                    <div class="col-md-3">
                    <button type="button" id="HideButton" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add</button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <!-- Input Product -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Item</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="name">Product:</label>
                                    <input type="text" class="form-control" id="name" name="product_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="supplierSelect">Supplier</label>
                                    <select class="form-control" id="supplierSelect" name="supplier_option">
                                        <option disabled selected> Choose Supplier </option>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT * FROM user WHERE user_type = 'user'");

                                        while ($data = mysqli_fetch_array($sql)) {
                                        ?>
                                            <option value="<?= $data['address'] ?>"><?= $data['address'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" class="form-control" id="quantity" name="product_quantity" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <input type="number" class="form-control" id="price" name="product_price" required>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date:</label>
                                    <input type="date" class="form-control" id="date" name="product_date" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary text-center" name="add_product">save</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeForm()">Close</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        


            <section class="items  w-75 mt-5 mx-4" id="myTable">

                <h1 class="title"> Items Product</h1>

                <div class="container-users">

                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID Product</th>
                                <th scope="col">Product</th>
                                <!-- <th scope="col">Supplier</th> -->
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php

                        $query = "SELECT item.id_product, item.product_name, item.product_qty, 
                        SUM(transaction_in.quantity_in) AS total_quantity_in, 
                        SUM(transaction_out.quantity_out) AS total_quantity_out
                            FROM item
                            LEFT JOIN transaction_in ON item.id_product = transaction_in.id_product
                            LEFT JOIN transaction_out ON item.id_product = transaction_out.id_product
                            GROUP BY item.id_product";

                        // Execute the query
                        $result = mysqli_query($conn, $query);

                        $limit_per_page = 10;
                        $page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
                        $first_page = ($page > 1) ? ($page * $limit_per_page) - $limit_per_page : 0;

                        $previous = $page - 1;
                        $next = $page + 1;

                        $row_item = mysqli_query($conn, "SELECT * FROM item ");
                        $total_row_item = mysqli_num_rows($row_item);
                        $total_page = ceil($total_row_item / $limit_per_page);

                        $select_item = mysqli_query($conn, "SELECT * FROM `item` LIMIT $first_page, $limit_per_page") or die('query failed');
                        $no = $first_page + 1;
                        while ($fetch_item = mysqli_fetch_assoc($select_item)) {

                        ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $no++; ?></th>
                                    <td><?php echo $fetch_item['id_product']; ?></td>
                                    <td><?php echo $fetch_item['product_name']; ?></td>
                                    <!-- <td><?php //echo $fetch_item['address']; ?></td> -->
                                    <td><?php echo $remain; ?></td>
                                    <td><?php echo $fetch_item['product_price']; ?></td>
                                    <td>
                                        <a href="items.php?update=<?php echo $fetch_item['id_product']; ?>" id="updateBtn">Update</a>
                                        <a class="delete-btn text-danger" href="items.php?delete=<?php echo $fetch_item['id_product']; ?>" onclick="return confirm('delete this item?');">Remove</a>
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
            <div class="edit-product-form w-50 center" id="example-form">
                <div class="" role="">
                    <div class="">
                        <div class="">
                            <h4 class="">Update Item</h4>
                            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                        </div>
                        <div class="">


                            <?php
                            if (isset($_GET['update'])) {
                                $update_id = $_GET['update'];
                                $update_query = mysqli_query($conn, "SELECT * FROM `item` WHERE id_product = '$update_id'") or die('query failed');
                                if (mysqli_num_rows($update_query) > 0) {
                                    while ($fetch_update = mysqli_fetch_assoc($update_query)) {
                            ?>

                                        <form action="" method="post">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="id_product" name="update_id_product" value="<?php echo $fetch_update['id_product']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Product:</label>
                                                <input type="text" class="form-control" id="name" name="update_product_name" value="<?php echo $fetch_update['product_name']; ?>" required>
                                            </div>                                            
                                            <div class="form-group">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity" name="update_product_quantity" value="<?php echo $fetch_update['product_qty']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Price:</label>
                                                <input type="number" class="form-control" id="price" name="update_product_price" value="<?php echo $fetch_update['product_price']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="date">Date:</label>
                                                <input type="date" class="form-control" id="date" name="update_product_date" value="<?php echo $fetch_update['date']; ?>" required>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-primary text-center" value="update" name="update_product">
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
        window.location.href = 'items.php';
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