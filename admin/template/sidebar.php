<div class="sidebar-wrapper">
    <div class="logo">
        <a href="<?php echo $setting['app_url'] ?>index1.php" class="simple-text">
           <?php  echo $setting['app_name'] ?>
        </a>
    </div>
    <ul class="nav">
        <li class="nav-item ">
            <a class="nav-link" href="<?php echo $setting['app_url'] ?>admin">
                <i class="nc-icon nc-chart-pie-35"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <li>
            <a class="nav-link" href="<?php echo $setting['app_url'] ?>admin/services/">
                <i class="nc-icon nc-bulb-63"></i>
                <p>Services</p>
            </a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo $setting['app_url'] ?>admin/products/">
                <i class="nc-icon nc-paper-2"></i>
                <p>Products</p>
            </a>
        </li>


        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <li>
                <a class="nav-link" href="<?php echo $setting['app_url'] ?>admin/users/">
                    <i class="nc-icon nc-circle-09"></i>
                    <p>Users </p>
                </a>
            </li>
            <li>
                <a class="nav-link" href="<?php echo $setting['app_url'] ?>admin/settings/">
                    <i class="nc-icon nc-atom"></i>
                    <p>Settings</p>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>