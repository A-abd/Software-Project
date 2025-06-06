<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo-container">
            <div class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </div>
            <div class="logo">
                <h1>LuckyNest</h1>
            </div>
        </div>
    </nav>

    <div class="overlay" id="overlay"></div>

    <aside class="sidebar sidebar-hidden" id="sidebar">
        <ul class="sidebar-menu">
            <li class="menu-category">Main</li>
            <li class="menu-item active">
                <a href="../admin/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>

            <li class="menu-category">User Management</li>

            <li class="menu-item">
                <a href="../admin/users"><i class="fas fa-users"></i> Guests</a>
            </li>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'owner'): ?>
                <li class="menu-item">
                    <a href="../admin/admins"><i class="fas fa-user-shield"></i> Admin Users</a>
                </li>
            <?php endif; ?>

            <li class="menu-item">
                <a href="../admin/create_users"><i class="fas fa-user-plus"></i> Create An Account</a>
            </li>

            <li class="menu-category">Property Management</li>
            <li class="menu-item">
                <a href="../admin/rooms"><i class="fas fa-door-open"></i> All Rooms</a>
            </li>
            <li class="menu-item">
                <a href="../admin/room_types"><i class="fas fa-bed"></i> Room Types</a>
            </li>
            <li class="menu-category">Operations</li>
            <li class="menu-item">
                <a href="../admin/bookings"><i class="fas fa-calendar-check"></i> All Bookings</a>
            </li>

            <li class="menu-item has-dropdown" onclick="window.LuckyNest.toggleSubmenu(this)">
                <span><i class="fas fa-money-bill-wave"></i> Payments</span>
                <i class="fas fa-chevron-down"></i>
            </li>
            <ul class="submenu">
                <a href="../admin/invoices">
                    <li class="submenu-item"><i class="fas fa-file-invoice"></i> Invoices</li>
                </a>
                <a href="../admin/deposits">
                    <li class="submenu-item"><i class="fas fa-piggy-bank"></i> Security Deposits</li>
                </a>
            </ul>

            <li class="menu-item has-dropdown" onclick="window.LuckyNest.toggleSubmenu(this)">
                <span><i class="fas fa-utensils"></i> Food Services</span>
                <i class="fas fa-chevron-down"></i>
            </li>
            <ul class="submenu">
                <a href="../admin/meals">
                    <li class="submenu-item"><i class="fas fa-clipboard-list"></i> Food Menu</li>
                </a>
                <a href="../admin/meal_plans">
                    <li class="submenu-item"><i class="fas fa-carrot"></i> Meal Plans</li>
                </a>
                <a href="../admin/meal_assignment">
                    <li class="submenu-item"><i class="fas fa-clipboard"></i> Assign Meals to Meal Plan</li>
                </a>
                <a href="../admin/meal_custom_view">
                    <li class="submenu-item"><i class="fas fa-concierge-bell"></i> View Special Requests</li>
                </a>
            </ul>

            <li class="menu-item has-dropdown" onclick="window.LuckyNest.toggleSubmenu(this)">
                <span><i class="fas fa-cog"></i> Other Services</span>
                <i class="fas fa-chevron-down"></i>
            </li>
            <ul class="submenu">
                <a href="../admin/laundry">
                    <li class="submenu-item"><i class="fas fa-tshirt"></i> Laundry</li>
                </a>
                <a href="../admin/view_maintenance">
                    <li class="submenu-item"><i class="fas fa-wrench"></i> View Maintenance Requests</li>
                </a>
            </ul>

            <li class="menu-item">
                <a href="../admin/visitors"><i class="fas fa-clipboard-user"></i> Log Visitors</a>
            </li>

            <li class="menu-category">Communication</li>
            <li class="menu-item">
                <a href="../admin/announcements"><i class="fas fa-bullhorn"></i> Announcements</a>
            </li>

            <!-- New Ratings Section -->
            <li class="menu-category">Ratings & Reviews</li>
            <li class="menu-item">
                <a href="../admin/ratings"><i class="fas fa-comment"></i> Individual Reviews</a>
            </li>
            <li class="menu-item">
                <a href="../admin/ratings_overall"><i class="fas fa-star"></i> Overall Rating</a>
            </li>

            <li class="menu-category">Reports</li>
            <li class="menu-item has-dropdown" onclick="window.LuckyNest.toggleSubmenu(this)">
                <span><i class="fas fa-chart-bar"></i> Reports & Analytics</span>
                <i class="fas fa-chevron-down"></i>
            </li>
            <ul class="submenu">
                <a href="../admin/financials">
                    <li class="submenu-item"><i class="fas fa-dollar-sign"></i> Revenue & Expense Reports</li>
                </a>
                <a href="../admin/report_occupancy">
                    <li class="submenu-item"><i class="fas fa-percentage"></i> Room Occupancy Reports</li>
                </a>
                <a href="../admin/report_pg">
                    <li class="submenu-item"><i class="fas fa-percentage"></i> PG Occupany Reports</li>
                </a>
                <a href="../admin/report_food">
                    <li class="submenu-item"><i class="fas fa-hamburger"></i> Food Consumption</li>
                </a>
            </ul>

            <li class="menu-category">Settings</li>
            <li class="menu-item">
                <a href="../admin/settings"><i class="fas fa-shield-alt"></i> Security Settings</a>
            </li>
            <li class="menu-item">
                <a href="../authentication/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </aside>

    <div id="mainContent" class="main-content expanded">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.LuckyNest.initSidebar();
        });
    </script>
</body>

</html>