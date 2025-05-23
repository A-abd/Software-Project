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

    <aside class="sidebar sidebar-hidden" id="sidebar">
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="../guest/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>

            <li class="menu-category">Payments</li>
            <li class="menu-item"><a href="../guest/deposits"><i class="fas fa-piggy-bank"></i> Security Deposit</a>
            </li>

            <li class="menu-category">Services</li>
            <li class="menu-item has-dropdown" onclick="window.LuckyNest.toggleSubmenu(this)">
                <span><i class="fas fa-chart-bar"></i> Food Services</span>
                <i class="fas fa-chevron-down"></i>
            </li>
            <ul class="submenu">
                <a href="../guest/meals">
                    <li class="submenu-item"><i class="fas fa-utensils"></i> Meals</li>
                </a>
                <a href="../guest/meal_custom">
                    <li class="submenu-item"><i class="fas fa-concierge-bell"></i> Custom Meal Orders</li>
                </a>
            </ul>
            <li class="menu-item">
                <a href="../guest/laundry"><i class="fas fa-tshirt"></i> Laundry</a>
            </li>
            <li class="menu-item">
                <a href="../guest/maintenance"><i class="fas fa-wrench"></i> Make Maintenance Request</a>
            </li>

            <li class="menu-category">Reports</li>
            <li class="menu-item has-dropdown" onclick="window.LuckyNest.toggleSubmenu(this)">
                <span><i class="fas fa-chart-bar"></i> Reports & Analytics</span>
                <i class="fas fa-chevron-down"></i>
            </li>
            <ul class="submenu">
                <a href="../guest/invoices">
                    <li class="submenu-item"><i class="fas fa-chart-bar"></i> Payment Statistics</li>
                </a>
                <a href="../guest/stats_food">
                    <li class="submenu-item"><i class="fas fa-hamburger"></i> Food Consumption Statistics</li>
                </a>
            </ul>

            <li class="menu-category">Communication</li>
            <li class="menu-item">
                <a href="../guest/view_announcements"><i class="fas fa-bullhorn"></i> Announcements</a>
            </li>

            <li class="menu-category">Settings</li>
            <li class="menu-item">
                <a href="../guest/profile"><i class="fas fa-user"></i> Your Profile</a>
            </li>
            <li class="menu-item">
                <a href="../guest/settings"><i class="fas fa-cog"></i> Settings</a>
            </li>
            <li class="menu-item">
            <a href="../authentication/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </aside>

    <div class="overlay" id="overlay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.LuckyNest.initSidebar();
        });
    </script>
</body>

</html>