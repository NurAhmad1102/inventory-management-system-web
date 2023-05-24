<?php

include 'config.php';


session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

?>








<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Form Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jspdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</head>

<body>

    <?php
    include "sidebar.php";
    ?>
    <div class="content" style="margin-left: 20%;">

        <div class="card container-fluid w-100 p-5" style="background-color: #eee; height:200px">
            <h1>Report</h1>
            <p>Welcome to the admin page. Here you can manage your website content.</p>
        </div>

        <div class="card p-3 text-left m-3" style="height:80vh">
            <section class="items mt-5 mx-4" id="myTable">

                <h1 class="title pb-3"> Items Product</h1>

                <div class="container-users">
                    <div class="search">

                    </div>

                    <!-- <div class="float-right">
                        <div class="input-group  pb-2">
                            <input type="search" class="form-control rounded mr-2" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <button type="button" class="btn btn-outline-primary">search</button>
                        </div>
                    </div> -->
                    <section class="search_date">
                        <form method="post">
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <label class="sr-only" for="start-date">Start Date</label>
                                    <input type="date" class="form-control mb-2" id="start-date" name="start_date" placeholder="Start Date">
                                </div>
                                <div class="col-auto">
                                    <label class="sr-only" for="end-date">End Date</label>
                                    <input type="date" class="form-control mb-2" id="end-date" name="end_date" placeholder="End Date">
                                </div>
                                <div class="col-auto">
                                    <input type="submit" class="btn btn-primary text-center" value="search" name="search">
                                </div>
                            </div>
                        </form>
                    </section>



                    <!-- <button id="jsPDF">Export to PDF</button> -->

                    <table class="table table-hover table-bordered" id="table-to-export">
                        <thead class="border">
                            <tr>
                                <th class="align-top" scope="col" rowspan="2">No</th>
                                <th class="align-top" scope="col" rowspan="2">ID Product</th>
                                <th class="align-top" scope="col" rowspan="2">Product</th>
                                <th scope="col" colspan="2">Supplier</th>
                                <th class="align-top" scope="col" rowspan="2">Stok</th>
                                <th class="align-top" scope="col" rowspan="2">Price</th>
                                <th scope="col" colspan="2">Quantity</th>                                
                            </tr>
                            <tr>
                                <td>IN</td>
                                <td>OUT</td>
                                <td>IN</td>
                                <td>OUT</td>
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



                        if (isset($_POST['search'])) {
                            $start_date = $_POST['start_date'];
                            $end_date = $_POST['end_date'];

                            if (!empty($start_date) && !empty($end_date)) {
                                // Construct the date range using the start and end dates
                                $date_range = "BETWEEN '$start_date' AND '$end_date'";
                            } else {
                                // If no date range is specified, select all rows
                                $date_range = ">= '0000-00-00'";
                            }
                            $select_item = mysqli_query($conn, "SELECT item.*, transaction_in.*,transaction_out.* ,transaction_in.id_supplier as in_supplier, transaction_out.id_supplier as out_supplier
                                    FROM item                                        
                                    INNER JOIN transaction_in ON item.id_product = transaction_in.id_product
                                    INNER JOIN transaction_out ON transaction_in.id_product = transaction_out.id_product
                                    WHERE transaction_in.transaction_in_date BETWEEN '$start_date' AND '$end_date' 
                                    LIMIT " . $first_page . ", " . $limit_per_page)
                                or die("Query failed select: " . mysqli_error($conn));


                            function supplier($cnn, $spl)
                            {
                                // code to be executed
                                $select_supplier = mysqli_query($cnn, "SELECT address FROM user WHERE id_user = $spl") or die("Update query failed: " . mysqli_error($cnn));
                                $supplier_in_address = mysqli_fetch_assoc($select_supplier)['address'];
                                echo $supplier_in_address;
                            }


                            $no = $first_page + 1;
                            while ($fetch_item = mysqli_fetch_assoc($select_item)) {
                                $supplier_in = $fetch_item['in_supplier'];
                                $supplier_out = $fetch_item['out_supplier'];

                        ?>

                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo $no++; ?></th>
                                        <td><?php echo $fetch_item['id_product']; ?></td>
                                        <td><?php echo $fetch_item['product_name']; ?></td>
                                        <td><?php echo supplier($conn, $supplier_in); ?></td>
                                        <td><?php echo supplier($conn, $supplier_out); ?></td>
                                        <td style="display: none;"><?= date('d-F-Y', strtotime($fetch_item['transaction_in_date'])); ?></td>
                                        <td><?php echo $fetch_item['product_qty']; ?></td>
                                        <td><?php echo $fetch_item['product_price']; ?></td>
                                        <td><?php echo $fetch_item['quantity_in']; ?></td>
                                        <td><?php echo $fetch_item['quantity_out']; ?></td>                                        
                                    </tr>
                                </tbody>
                        <?php
                            }
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
           

        </div>
</body>

</html>
