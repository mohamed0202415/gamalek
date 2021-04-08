<nav class="navbar navbar-static-top bg-maroon" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" style="background-color: #d81b60" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-maroon">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        <p>
                            <?php echo $_SESSION['name']; ?>
                            <small><?php echo $_SESSION['username']; ?></small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-right">
                            <a href="user.php?id=<?php echo $_SESSION['user_id']; ?>" class="btn btn-default btn-flat">الملف
                                الشخصي</a>
                        </div>
                        <div class="pull-left">
                            <a href="logout.php" class="btn btn-default btn-flat">خروج</a>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->

        </ul>
    </div>
</nav>