<?php
$activePage = isset($activePage) ? $activePage : '';
$adminBase  = defined('SITE_URL') ? SITE_URL . '/admin/' : '/nirajindustries/admin/';

function sbActive(string $key, string $active, array $also = []): string {
    return ($active === $key || in_array($active, $also, true))
        ? ' class="active"' : '';
}

function sbParent(string $prefix, string $active): string {
    return ' class="submenu"';
}

function sbOpen(string $prefix, string $active): string {
    return str_starts_with($active, $prefix) ? 'block' : 'none';
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

                <?php if (canAccess('blogs')): ?>
                <li<?= sbParent('blogs', $activePage) ?>>
                    <a href="#">
                        <i class="fe fe-edit"></i> <span>Blogs</span>  <!-- ✅ fixed -->
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

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->