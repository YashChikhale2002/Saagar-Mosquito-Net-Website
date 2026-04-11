<?php
$activePage = isset($activePage) ? $activePage : '';
$adminBase  = defined('SITE_URL') ? SITE_URL . '/admin/' : '/Saagar-Mosquito-Net-Website/admin/';

function sbActive(string $key, string $active, array $also = []): string {
    return ($active === $key || in_array($active, $also, true))
        ? ' class="active"' : '';
}

function sbParent(string $prefix, string $active): string {
    return ' class="submenu"';
}

// ✅ PHP 7 compatible — str_starts_with() hata diya
function sbOpen(string $prefix, string $active): string {
    return (strpos($active, $prefix) === 0) ? 'block' : 'none';
}
?>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title"><span>Main</span></li>

                <li<?= sbActive('dashboard', $activePage) ?>>
                    <a href="<?= $adminBase ?>">
                        <i class="fe fe-home"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Manage</span></li>

                <!-- ── Users ─────────────────────────────────────────────── -->
                <?php if (canAccess('users')): ?>
                <li<?= sbParent('users', $activePage) ?>>
                    <a href="#">
                        <i class="fe fe-users"></i> <span>Users</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="display:<?= sbOpen('users', $activePage) ?>;">
                        <li<?= sbActive('users-index', $activePage, ['users-edit']) ?>>
                            <a href="<?= $adminBase ?>users/">All Users</a>
                        </li>
                        <?php if (hasRole(['superadmin', 'admin'])): ?>
                        <li<?= sbActive('users-add', $activePage) ?>>
                            <a href="<?= $adminBase ?>users/add">Add User</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ── Products ──────────────────────────────────────────── -->
                <?php if (canAccess('products')): ?>
                <li<?= sbParent('products', $activePage) ?>>
                    <a href="#">
                        <i class="fa fa-box"></i> <span>Products</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="display:<?= sbOpen('products', $activePage) ?>;">
                        <li<?= sbActive('products-index', $activePage, ['products-edit']) ?>>
                            <a href="<?= $adminBase ?>products/">All Products</a>
                        </li>
                        <?php if (!hasRole('viewer')): ?>
                        <li<?= sbActive('products-add', $activePage) ?>>
                            <a href="<?= $adminBase ?>products/add">Add Product</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ── Blogs ─────────────────────────────────────────────── -->
                <?php if (canAccess('blogs')): ?>
                <li<?= sbParent('blogs', $activePage) ?>>
                    <a href="#">
                        <i class="fe fe-edit"></i> <span>Blogs</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="display:<?= sbOpen('blogs', $activePage) ?>;">
                        <li<?= sbActive('blogs-index', $activePage, ['blogs-edit']) ?>>
                            <a href="<?= $adminBase ?>blogs/">All Blogs</a>
                        </li>
                        <?php if (!hasRole('viewer')): ?>
                        <li<?= sbActive('blogs-add', $activePage) ?>>
                            <a href="<?= $adminBase ?>blogs/add">Add Blog</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ── Services ──────────────────────────────────────────── -->
                <?php if (canAccess('services')): ?>
                <li<?= sbParent('services', $activePage) ?>>
                    <a href="#">
                        <i class="fa fa-concierge-bell"></i> <span>Services</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="display:<?= sbOpen('services', $activePage) ?>;">
                        <li<?= sbActive('services-index', $activePage, ['services-edit']) ?>>
                            <a href="<?= $adminBase ?>services/">All Services</a>
                        </li>
                        <?php if (!hasRole('viewer')): ?>
                        <li<?= sbActive('services-add', $activePage) ?>>
                            <a href="<?= $adminBase ?>services/add">Add Service</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ── Account ───────────────────────────────────────────── -->
                <li class="menu-title"><span>Account</span></li>

                <li<?= sbActive('profile', $activePage) ?>>
                    <a href="<?= $adminBase ?>profile">
                        <i class="fa fa-user-circle"></i> <span>My Profile</span>
                    </a>
                </li>

                <?php if (canAccess('settings')): ?>
                <li<?= sbActive('settings', $activePage) ?>>
                    <a href="<?= $adminBase ?>settings/">
                        <i class="fe fe-settings"></i> <span>Settings</span>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->

<?php
// ── Role-filtered menu for JS search ─────────────────────────────────────────
$_base = defined('SITE_URL') ? SITE_URL . '/admin/' : '/Saagar-Mosquito-Net-Website/admin/';
$_menuItems = [];

// Dashboard (everyone)
$_menuItems[] = ['section' => 'Main', 'icon' => 'fe fe-home', 'label' => 'Dashboard', 'url' => $_base];

// Users
if (canAccess('users')) {
    $_menuItems[] = ['section' => 'Users', 'icon' => 'fe fe-users', 'label' => 'All Users', 'url' => $_base . 'users/'];
    if (hasRole(['superadmin', 'admin']))
        $_menuItems[] = ['section' => 'Users', 'icon' => 'fe fe-users', 'label' => 'Add User', 'url' => $_base . 'users/add'];
}

// Products
if (canAccess('products')) {
    $_menuItems[] = ['section' => 'Products', 'icon' => 'fe fe-box', 'label' => 'All Products', 'url' => $_base . 'products/'];
    if (!hasRole('viewer'))
        $_menuItems[] = ['section' => 'Products', 'icon' => 'fe fe-box', 'label' => 'Add Product', 'url' => $_base . 'products/add'];
}

// Blogs
if (canAccess('blogs')) {
    $_menuItems[] = ['section' => 'Blogs', 'icon' => 'fe fe-file-text', 'label' => 'All Blogs', 'url' => $_base . 'blogs/'];
    if (!hasRole('viewer'))
        $_menuItems[] = ['section' => 'Blogs', 'icon' => 'fe fe-file-text', 'label' => 'Add Blog', 'url' => $_base . 'blogs/add'];
}

// ── Services ──────────────────────────────────────────────────────────────────
if (canAccess('services')) {
    $_menuItems[] = ['section' => 'Services', 'icon' => 'fa fa-concierge-bell', 'label' => 'All Services', 'url' => $_base . 'services/'];
    if (!hasRole('viewer'))
        $_menuItems[] = ['section' => 'Services', 'icon' => 'fa fa-concierge-bell', 'label' => 'Add Service', 'url' => $_base . 'services/add'];
}

// Profile (always)
$_menuItems[] = ['section' => 'Account', 'icon' => 'fa fa-user-circle', 'label' => 'My Profile', 'url' => $_base . 'profile'];
?>
<script>
window.ADMIN_MENU = <?= json_encode($_menuItems, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>