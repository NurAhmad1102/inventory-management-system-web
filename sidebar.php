<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<div class="bg-dark text-white sidebar" style="width: 20%; min-height: 100vh; position: fixed; left: 0; top: 0;">
  <div class="p-4">
    <h4 class="font-weight-bold mb-4">Menu</h4>
    <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link" href="admin_page.php">Dashboard</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="#">Admin</a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="supplier.php">Supplier</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="items.php">Items</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="transaction_in.php">Transaction In</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="transaction_out.php">Transaction Out</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="report.php">Report</a>
    </li>
  </ul>
  </div>
</div>

<style>
        .sidebar {
            transition: all 0.3s ease;
            z-index: 1;            
        }

        .sidebar:hover {
            transform: translateX(-10px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .sidebar a {
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #969696;
            font-size: 1.5rem;
            padding: 0.5rem 1rem;
        }

        .nav-link {
            padding: 10px 20px;
            color: lightgray;
            font-size: 1.1rem;
        }

        .nav-link:hover {
            /* background-color: #1212; */
            color: #fff;
            width: 100%;
            /* font-size: 1.1em; */
            transition: all 0.2s ease-in-out;
        }
    </style>






