<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Main</li>
                <li>
                    <a href="index.php" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?php
                if ($_SESSION['role'] == "retailer") {
                ?>
                    <li>
                        <a href="Supplier_list.php" class="waves-effect">
                            <i class="dripicons-document"></i>
                            <span>Supply</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-user-alt"></i>
                            <span>Supplier</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="add_Supplier.php"><i class="fas fa-user-plus"></i>Add Supplier</a></li>
                            <li><a href="manage_Supplier.php"><i class="fas fa-user-cog"></i>Manage Supplier</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-user-alt"></i>
                            <span>Area</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="add_Area.php"><i class="fas fa-user-plus"></i>Add Area</a></li>
                            <li><a href="manage_Area.php"><i class="fas fa-user-cog"></i>Manage Area</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-user-alt"></i>
                            <span>Assign Area</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="add_AssignArea.php"><i class="fas fa-user-plus"></i>Add</a></li>
                            <li><a href="manage_AssignArea.php"><i class="fas fa-user-cog"></i>Manage</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-user-alt"></i>
                            <span>Costumer</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="add_Costumer.php"><i class="fas fa-user-plus"></i>Add Customer</a></li>
                            <li><a href="manage_Costumer.php"><i class="fas fa-user-cog"></i>Manage Customer</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-user-alt"></i>
                            <span>Bill Inquery</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="ViewCustomerBill.php"><i class="fas fa-user-plus"></i>View Customer Bill</a></li>
                        </ul>
                    </li>
                <?php
                } else if ($_SESSION['role'] == 'admin') {
                ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-users"></i>
                            <span>Retailers</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="add_Retailer.php"><i class="fas fa-user-plus"></i>Add</a></li>
                            <li><a href="manage_Retailer.php"><i class="fas fa-user-cog"></i>Manage</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-package"></i>
                            <span>Package</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="add_Package.php"><i class="fas fa-user-plus"></i>Add</a></li>
                            <li><a href="manage_Package.php"><i class="fas fa-user-cog"></i>Manage</a></li>
                        </ul>
                    </li>
                    <li>
                    <a href="payment.php" class="waves-effect">
                        <i class="mdi mdi-bank-transfer"></i>
                        <span>View Payments</span>
                    </a>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<input type="hidden" value="<?php echo $_SESSION['status'] ?>" id="userStatus">
<input type="hidden" value="<?php echo $_SESSION['days'] ?>" id="days">
