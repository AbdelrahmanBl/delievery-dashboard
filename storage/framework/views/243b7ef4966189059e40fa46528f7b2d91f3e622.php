<nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                            <li class="header">Main</li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/dashboard'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('dashboard')); ?>"><i class="icon-speedometer"></i><span>Dashboard</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/orders'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('orders')); ?>"><i class="icon-users"></i><span>Taxi Orders</span></a></li>
                            <li class="header">Delievery</li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/delieveryOrders'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('delieveryOrders')); ?>"><i class="icon-wallet"></i><span>Delievery Orders</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/categories'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('categories')); ?>"><i class="icon-wallet"></i><span>Categories</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/categorySearch'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('categorySearch')); ?>"><i class="icon-wallet"></i><span>Category For Search</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/wordSearch'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('wordSearch')); ?>"><i class="icon-wallet"></i><span>Word For Search</span></a></li>
                            <li class="header">Members</li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/users'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('users')); ?>"><i class="icon-wallet"></i><span>Users</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/providers'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('providers')); ?>"><i class="icon-user"></i><span>Providers</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/partners'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('partners')); ?>"><i class="icon-grid"></i><span>Partners</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/clients'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('clients')); ?>"><i class="icon-grid"></i><span>Clients</span></a></li>
                            <li class="header">Payments & Settings</li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/document'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('document')); ?>"><i class="icon-equalizer"></i><span>Documents</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/services'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('services')); ?>"><i class="icon-equalizer"></i><span>Service Types</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/promocodes'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('promocodes')); ?>"><i class="icon-flag"></i><span>Promocodes</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/payroll'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('payroll')); ?>"><i class="icon-credit-card"></i><span>Payroll</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/settings'): ?>class="active open"<?php endif; ?>><a href="<?php echo e(asset('settings')); ?>"><i class="icon-bar-chart"></i><span>Settings</span></a></li>
                        </ul>
            </nav>  <?php /**PATH C:\xampp\htdocs\Admin\resources\views/layouts/Admin/nav.blade.php ENDPATH**/ ?>