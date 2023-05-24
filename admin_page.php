<?php
include 'config.php';


session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">


</head>

<body>

    <?php
    include "sidebar.php";
    ?>
    <div class="content" style="margin-left: 20%;">

        <div class="card container-fluid w-100 p-5" style="background-color: #eee; height:200px">
            <h1>Dashboard</h1>
            <p>Welcome to the admin page. Here you can manage your website content.</p>
        </div>

        <div class="card p-3 text-left m-3" style="height:80vh">
            <div class="row row-cols-1 row-cols-md-3 g-4 my-3">
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Supplier</h5>
                            <p class="card-text">
                                <?php
                                $select_orders = mysqli_query($conn, "SELECT * FROM `user` WHERE user_type = 'user'") or die('query failed');
                                $number_of_supplier = mysqli_num_rows($select_orders);
                                ?>
                            <h4><?php echo $number_of_supplier; ?> </h4>
                            <p> Supplier has been registered</p>
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Items</h5>

                            <?php
                            $select_orders = mysqli_query($conn, "SELECT * FROM `item`") or die('query failed');
                            $number_of_item = mysqli_num_rows($select_orders);
                            ?>
                            <h4><?php echo $number_of_item; ?> </h4>
                            <p>Items has been recorded</p>

                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 9 mins ago</small>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Transaction In</h5>
                            <?php
                                $select_orders = mysqli_query($conn, "SELECT * FROM `transaction_in`") or die('query failed');
                                $number_of_trxs_in = mysqli_num_rows($select_orders);
                                ?>
                            <h4><?php echo $number_of_trxs_in; ?> </h4>
                            <p> Transaction in has been recorded</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10 mins ago</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Transaction Out</h5>
                            <?php
                                $select_orders = mysqli_query($conn, "SELECT * FROM `transaction_out`") or die('query failed');
                                $number_of_trxs_out = mysqli_num_rows($select_orders);
                                ?>
                            <h4><?php echo $number_of_trxs_out; ?> </h4>
                            <p> Transaction out has been registered</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 4 mins ago</small>
                        </div>
                    </div>
                </div>                
            </div>
        </div>

    </div>
</body>

</html>