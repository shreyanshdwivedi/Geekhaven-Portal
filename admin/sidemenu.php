<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="index.php">
                    <i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="{% url 'hotel:users_admin' %}">
                    <i class="fa fa-user fa-fw"></i> Users</a>
            </li>
            <li>
                <a href="{% url 'hotel:orders_admin' %}">
                    <i class="fa fa-truck fa-fw"></i> Orders</a>
            </li>
            <li>
                <a href="{% url 'hotel:foods_admin' %}">
                    <i class="fa fa-shopping-cart fa-fw"></i> Foods</a>
            </li>
            <li>
                <a href="{% url 'hotel:sales_admin' %}">
                    <i class="fa fa-list fa-fw"></i> Sales</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->